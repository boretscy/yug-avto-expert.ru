<?php

$defaultConfig = [
    'test' => true,
    'api' => [
        'ssl' => true,
        'host' => '1cweb.yug-avto.ru',
        'base' => '/tradeexpert',
        'base_test' => '/tradeexpert_andreev',
        'uri' => '/hs/PersonalAccountExpert',
        'user' => 'WebService',
        'pass' => '',
        'retries' => 1,
        'timeout' => 3,
    ],
    'sms' => [
        'user' => '',
        'pass' => '',
        'sender' => 'Y-A_Expert',
    ],
    'cis' => [
        'token' => '',
    ],
    'security' => [
        'hash_salt' => '762f28d9322ae1799ac89a',
        'login_attempts' => 5,
        'code_timeout' => 600,
        'code_max_attempts' => 3,
        'sms_cooldown' => 60,
    ]
];

$localConfigPath = __DIR__ . '/config.local.php';
if (file_exists($localConfigPath)) {
    $localConfig = require $localConfigPath;
    if (is_array($localConfig)) {
        return array_replace_recursive($defaultConfig, $localConfig);
    }
}

return $defaultConfig;
