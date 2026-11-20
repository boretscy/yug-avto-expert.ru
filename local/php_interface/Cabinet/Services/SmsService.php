<?php

namespace Cabinet\Services;

use SMS;
use CUser;

class SmsService
{
    private const SMS_COOLDOWN = 60; // 60 секунд кулдаун
    private const CODE_TIMEOUT = 600; // 10 минут время жизни кода
    private const MAX_ATTEMPTS = 3;  // максимум 3 попытки

    private $smsUser;
    private $smsPass;
    private $smsSender;

    public function __construct(array $config = [])
    {
        if (empty($config)) {
            $cfgPath = dirname(__DIR__) . '/Config.php';
            $config = file_exists($cfgPath) ? require $cfgPath : [];
        }

        $this->smsUser = $config['sms']['user'] ?? 'KRD_Yug_Avto1.2';
        $this->smsPass = $config['sms']['pass'] ?? 'wfy7dHn@';
        $this->smsSender = $config['sms']['sender'] ?? 'Y-A_Expert';
    }

    /**
     * Отправка произвольного SMS-сообщения
     */
    public function send(string $phone, string $text): bool
    {
        $cleanPhone = preg_replace('/\D+/', '', $phone);
        if (empty($cleanPhone)) {
            return false;
        }

        if (!class_exists('SMS')) {
            require_once dirname(__DIR__, 2) . '/YApp/BEESMS.class.php';
        }

        $sms = new SMS($this->smsUser, $this->smsPass);
        $res = $sms->post_message($text, $cleanPhone, $this->smsSender);

        if (is_array($res) && isset($res['status']) && $res['status'] !== 'ok') {
            error_log(sprintf("Cabinet SmsService Error for %s: %s", $cleanPhone, json_encode($res, JSON_UNESCAPED_UNICODE)));
            return false;
        }

        return true;
    }

    /**
     * Генерация и отправка проверочного кода с защитой от флуда
     */
    public function sendVerificationCode(int $userId, string $phone): ?int
    {
        $cleanPhone = preg_replace('/\D+/', '', $phone);
        if ($userId <= 0 || empty($cleanPhone)) {
            return null;
        }

        // Проверяем кулдаун по b_user
        $dbUser = CUser::GetList($by = 'id', $order = 'asc', ['ID' => $userId], ['SELECT' => ['UF_CAB_LAST_SMS']]);
        if ($u = $dbUser->Fetch()) {
            $lastSms = (int)($u['UF_CAB_LAST_SMS'] ?? 0);
            if ($lastSms > 0 && (time() - $lastSms < self::SMS_COOLDOWN)) {
                error_log("Cabinet SmsService: Rate limit triggered for user {$userId} (cooldown active)");
                return null;
            }
        }

        $code = random_int(100000, 999999);
        $timeout = time() + self::CODE_TIMEOUT;

        $userObj = new CUser;
        $userObj->Update($userId, [
            'UF_CAB_CODE' => (string)$code,
            'UF_CAB_CODE_TIMEOUT' => $timeout,
            'UF_CAB_SMS_ATTEMPTS' => 0,
            'UF_CAB_LAST_SMS' => time(),
        ]);

        $sent = $this->send($cleanPhone, 'Код подтверждения: ' . $code);
        if ($sent) {
            return $code;
        }

        return null;
    }

    /**
     * Проверка введённого SMS-кода с защитой от брутфорса
     */
    public function verifyCode(int $userId, string $inputCode): bool
    {
        if ($userId <= 0 || empty($inputCode)) {
            return false;
        }

        $dbUser = CUser::GetList($by = 'id', $order = 'asc', ['ID' => $userId], [
            'SELECT' => ['UF_CAB_CODE', 'UF_CAB_CODE_TIMEOUT', 'UF_CAB_SMS_ATTEMPTS']
        ]);
        $u = $dbUser->Fetch();
        if (!$u) {
            return false;
        }

        $savedCode = (string)($u['UF_CAB_CODE'] ?? '');
        $timeout = (int)($u['UF_CAB_CODE_TIMEOUT'] ?? 0);
        $attempts = (int)($u['UF_CAB_SMS_ATTEMPTS'] ?? 0);

        // Проверка времени жизни
        if (time() > $timeout || empty($savedCode)) {
            return false;
        }

        // Проверка совпадения кода (тайминг-безопасная)
        if (hash_equals($savedCode, trim($inputCode))) {
            // Успех: сбрасываем код и счетчик
            $userObj = new CUser;
            $userObj->Update($userId, [
                'UF_CAB_CODE' => '',
                'UF_CAB_SMS_ATTEMPTS' => 0,
            ]);
            return true;
        }

        // Неверный код: инкрементируем попытки
        $attempts++;
        $userObj = new CUser;
        if ($attempts >= self::MAX_ATTEMPTS) {
            // Превышен лимит: блокируем код
            $userObj->Update($userId, [
                'UF_CAB_CODE' => '',
                'UF_CAB_SMS_ATTEMPTS' => 0,
            ]);
            error_log("Cabinet SmsService: User {$userId} exceeded max verification attempts, code invalidated");
        } else {
            $userObj->Update($userId, [
                'UF_CAB_SMS_ATTEMPTS' => $attempts,
            ]);
        }

        return false;
    }
}
