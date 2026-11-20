<?php

namespace Cabinet\Client;

use Bitrix\Main\Web\HttpClient;
use Bitrix\Main\Data\Cache;
use Cabinet\Config;

class OneCClient
{
    private const CONNECT_TIMEOUT = 2;
    private const SOCKET_TIMEOUT = 3;
    private const CB_FAIL_THRESHOLD = 3;
    private const CB_OPEN_DURATION = 180; // 3 минуты
    private const SOFT_TTL = 600;         // 10 минут
    private const HARD_TTL = 86400;       // 24 часа

    private $config;
    private $isTest;
    private $baseUri;

    public function __construct(array $config = [])
    {
        if (empty($config)) {
            $cfgPath = dirname(__DIR__) . '/Config.php';
            $this->config = file_exists($cfgPath) ? require $cfgPath : [];
        } else {
            $this->config = $config;
        }

        $this->isTest = !empty($this->config['test']);
        $ssl = !empty($this->config['api']['ssl']);
        $host = $this->config['api']['host'] ?? '1cweb.yug-avto.ru';
        $base = $this->isTest 
            ? ($this->config['api']['base_test'] ?? '/tradeexpert_andreev') 
            : ($this->config['api']['base'] ?? '/tradeexpert');
        $uri = $this->config['api']['uri'] ?? '/hs/PersonalAccountExpert';

        $this->baseUri = ($ssl ? 'https://' : 'http://') . $host . $base . $uri;
    }

    /**
     * Выполнение запроса к 1С с защитой Circuit Breaker и Soft/Hard кэшем
     */
    public function request(string $endpoint, string $method = 'GET', $data = [], array $params = [], array $query = [], int $customTtl = null)
    {
        $method = strtoupper($method);
        $fullUri = $this->buildUri($endpoint, $params, $query);
        $cacheKey = md5($method . '_' . $fullUri . '_' . (is_array($data) ? serialize($data) : (string)$data));

        // Для GET-запросов проверяем кэш Soft TTL
        if ($method === 'GET') {
            $softCache = $this->getCache($cacheKey, 'soft');
            if ($softCache !== false) {
                return $softCache;
            }
        }

        // Проверяем Circuit Breaker
        if ($this->isCircuitBreakerOpen()) {
            error_log("Cabinet 1C Circuit Breaker is OPEN. Skipping network call to: {$fullUri}");
            // Пытаемся вернуть данные из Hard TTL
            $hardCache = $this->getCache($cacheKey, 'hard');
            if ($hardCache !== false) {
                return $hardCache;
            }
            return false;
        }

        // Выполняем сетевой запрос
        $result = $this->executeHttp($fullUri, $method, $data);

        if ($result !== false) {
            $this->recordSuccess();
            if ($method === 'GET') {
                $ttl = $customTtl ?? self::SOFT_TTL;
                $this->setCache($cacheKey, $result, $ttl);
            }
            return $result;
        }

        // Сбой запроса
        $this->recordFailure();

        // Пробуем вернуть страховочный Hard TTL кэш
        if ($method === 'GET') {
            $hardCache = $this->getCache($cacheKey, 'hard');
            if ($hardCache !== false) {
                error_log("Cabinet 1C fallback to Hard TTL cache for {$fullUri}");
                return $hardCache;
            }
        }

        return false;
    }

    private function executeHttp(string $url, string $method, $data)
    {
        $httpClient = new HttpClient([
            'socketTimeout' => self::SOCKET_TIMEOUT,
            'streamTimeout' => self::CONNECT_TIMEOUT,
            'redirect' => true,
            'redirectMax' => 2,
            'waitResponse' => true,
            'disableSslVerification' => true,
        ]);

        $httpClient->setHeader('Content-Type', 'application/json; charset=utf-8');
        $httpClient->setHeader('Accept', 'application/json');

        $body = null;
        if (!empty($data)) {
            $body = is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE) : (string)$data;
        }

        $response = false;
        try {
            switch ($method) {
                case 'GET':
                    $response = $httpClient->get($url);
                    break;
                case 'POST':
                    $response = $httpClient->post($url, $body);
                    break;
                case 'PATCH':
                case 'PUT':
                case 'DELETE':
                    $httpClient->query($method, $url, $body);
                    $response = $httpClient->getResult();
                    break;
                default:
                    error_log("Cabinet OneCClient: Unsupported HTTP method {$method}");
                    return false;
            }

            $status = $httpClient->getStatus();
            if ($status !== 200 && $status !== 204) {
                error_log(sprintf("Cabinet 1C HTTP Error: Status %d for %s", $status, $url));
                return false;
            }

            if (empty($response)) {
                return [];
            }

            $decoded = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                error_log("Cabinet 1C JSON decode error: " . json_last_error_msg());
                return false;
            }

            return $decoded;
        } catch (\Throwable $e) {
            error_log("Cabinet 1C Connection Exception: " . $e->getMessage());
            return false;
        }
    }

    private function buildUri(string $endpoint, array $params, array $query): string
    {
        $uri = $this->baseUri . '/' . ltrim($endpoint, '/');
        if (!empty($params)) {
            $uri .= '/' . implode('/', array_map('urlencode', $params));
        }
        if (!empty($query)) {
            $uri .= '?' . http_build_query($query);
        }
        return $uri;
    }

    // Circuit Breaker логика на Bitrix Cache
    private function isCircuitBreakerOpen(): bool
    {
        $cache = Cache::createInstance();
        if ($cache->initCache(self::CB_OPEN_DURATION, 'cb_state_open', '/cabinet/circuit_breaker/')) {
            return true;
        }
        return false;
    }

    private function recordSuccess(): void
    {
        $cache = Cache::createInstance();
        $cache->clean('cb_fails_count', '/cabinet/circuit_breaker/');
    }

    private function recordFailure(): void
    {
        $cache = Cache::createInstance();
        $fails = 0;
        if ($cache->initCache(self::CB_OPEN_DURATION, 'cb_fails_count', '/cabinet/circuit_breaker/')) {
            $fails = (int)$cache->getVars();
        }
        $fails++;

        if ($fails >= self::CB_FAIL_THRESHOLD) {
            error_log(sprintf("Cabinet 1C Circuit Breaker TRIPPED to OPEN for %d seconds (%d consecutive fails)", self::CB_OPEN_DURATION, $fails));
            if ($cache->initCache(self::CB_OPEN_DURATION, 'cb_state_open', '/cabinet/circuit_breaker/')) {
                // Уже в кэше
            } elseif ($cache->startDataCache()) {
                $cache->endDataCache(['open' => true, 'timestamp' => time()]);
            }
            $cache->clean('cb_fails_count', '/cabinet/circuit_breaker/');
        } else {
            if ($cache->startDataCache()) {
                $cache->endDataCache($fails);
            }
        }
    }

    // Двухуровневый кэш (Soft / Hard)
    private function getCache(string $key, string $type)
    {
        $cache = Cache::createInstance();
        $ttl = ($type === 'hard') ? self::HARD_TTL : self::SOFT_TTL;
        $dir = '/cabinet/1c_' . $type . '/';

        if ($cache->initCache($ttl, $key, $dir)) {
            return $cache->getVars();
        }
        return false;
    }

    private function setCache(string $key, $data, int $softTtl): void
    {
        // 1. Soft cache
        $soft = Cache::createInstance();
        if ($soft->startDataCache($softTtl, $key, '/cabinet/1c_soft/')) {
            $soft->endDataCache($data);
        }

        // 2. Hard cache (страховочный на 24 часа)
        $hard = Cache::createInstance();
        if ($hard->startDataCache(self::HARD_TTL, $key, '/cabinet/1c_hard/')) {
            $hard->endDataCache($data);
        }
    }

    public function clearCache(): void
    {
        Cache::createInstance()->cleanDir('/cabinet/1c_soft/');
    }
}
