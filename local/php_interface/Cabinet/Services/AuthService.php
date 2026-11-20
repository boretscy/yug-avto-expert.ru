<?php

namespace Cabinet\Services;

use CUser;
use CGroup;
use Bitrix\Main\Security\Password;

class AuthService
{
    private const GROUP_CODE = 'CABINET_USERS';
    private const HASH_SALT = '762f28d9322ae1799ac89a';

    private $smsService;

    public function __construct(SmsService $smsService = null)
    {
        $this->smsService = $smsService ?? new SmsService();
    }

    /**
     * Поиск пользователя по номеру телефона в b_user
     */
    public function getUserByPhone(string $phone): ?array
    {
        $cleanPhone = preg_replace('/\D+/', '', $phone);
        if (empty($cleanPhone)) {
            return null;
        }

        $by = 'id'; $order = 'asc';
        $dbUser = CUser::GetList($by, $order, ['LOGIN_EQUAL_EXACT' => $cleanPhone], ['SELECT' => ['UF_*']]);
        if ($u = $dbUser->Fetch()) {
            $guid = $u['UF_CAB_GUID'] ?? '';
            return [
                'ID' => (int)$u['ID'],
                'NAME' => $u['LOGIN'],
                'LOGIN' => $u['LOGIN'],
                'EMAIL' => $u['EMAIL'],
                'FIO' => $u['NAME'],
                'PHONE' => $u['PERSONAL_PHONE'] ?? $u['LOGIN'],
                'PROPERTY_GUID_VALUE' => $guid,
                'PROPERTY_SSID_VALUE' => md5(self::HASH_SALT . $guid),
                'PROPERTY_CODE_VALUE' => $u['UF_CAB_CODE'] ?? '',
                'PROPERTY_CODE_TIMEOUT_VALUE' => (int)($u['UF_CAB_CODE_TIMEOUT'] ?? 0),
                'PROPERTY_CHANGE_PASSWD_VALUE' => (int)($u['UF_CAB_CHANGE_PASSWD'] ?? 0),
                'PROPERTY_SMS_ATTEMPTS' => (int)($u['UF_CAB_SMS_ATTEMPTS'] ?? 0),
                'PROPERTY_LAST_SMS' => (int)($u['UF_CAB_LAST_SMS'] ?? 0),
                'B_USER_ID' => (int)$u['ID'],
            ];
        }

        return null;
    }

    /**
     * Регистрация нового комитента в b_user
     */
    public function register(array $post, string $guid): array
    {
        $cleanPhone = preg_replace('/\D+/', '', $post['PHONE'] ?? '');
        if (empty($cleanPhone)) {
            return ['status' => false, 'description' => 'Не указан номер телефона.'];
        }

        if ($this->getUserByPhone($cleanPhone) !== null) {
            return ['status' => false, 'description' => 'Пользователь с таким номером уже зарегистрирован.'];
        }

        $passwd = $this->generatePassword();
        $name = !empty($post['NAME']) ? trim($post['NAME']) : $cleanPhone;
        $email = !empty($post['EMAIL']) ? trim($post['EMAIL']) : "{$cleanPhone}@yug-avto-expert.ru";

        $resGroup = CGroup::GetList($by = "c_sort", $order = "asc", ["STRING_ID" => self::GROUP_CODE])->Fetch();
        $cabGroupId = $resGroup ? (int)$resGroup['ID'] : 2;

        $userObj = new CUser;
        $newUserId = $userObj->Add([
            'LOGIN' => $cleanPhone,
            'NAME' => $name,
            'EMAIL' => $email,
            'PASSWORD' => $passwd,
            'CONFIRM_PASSWORD' => $passwd,
            'ACTIVE' => 'Y',
            'GROUP_ID' => [2, $cabGroupId],
            'PERSONAL_PHONE' => $cleanPhone,
            'UF_CAB_GUID' => $guid,
            'UF_CAB_CHANGE_PASSWD' => 1,
            'UF_CAB_LAST_SMS' => time(),
            'UF_CAB_SMS_ATTEMPTS' => 0,
        ]);

        if ($newUserId) {
            $this->smsService->send($cleanPhone, 'Временный пароль для входа в кабинет: ' . $passwd);
            return [
                'status' => true,
                'user_id' => $newUserId,
                'description' => $passwd
            ];
        }

        error_log("Cabinet AuthService: User registration failed: " . $userObj->LAST_ERROR);
        return [
            'status' => false,
            'description' => $userObj->LAST_ERROR
        ];
    }

    /**
     * Вход пользователя
     */
    public function login(string $phone, string $password): bool
    {
        $user = $this->getUserByPhone($phone);
        if (!$user) {
            return false;
        }

        if ($this->verifyPassword($password, $user['PROPERTY_GUID_VALUE'])) {
            $this->authorizeUser($user);
            return true;
        }

        return false;
    }

    /**
     * Проверка пароля пользователя
     */
    public function verifyPassword(string $password, string $guid): bool
    {
        if (empty($guid) || empty($password)) {
            return false;
        }

        $by = 'id'; $order = 'asc';
        $dbUser = CUser::GetList($by, $order, ['UF_CAB_GUID' => $guid], ['FIELDS' => ['ID', 'PASSWORD']]);
        if ($u = $dbUser->Fetch()) {
            $hash = $u['PASSWORD'];
            if (Password::equals($hash, $password) || password_verify($password, $hash)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Авторизация в сессии Битрикса
     */
    public function authorizeUser(array $user): void
    {
        if (!empty($user['B_USER_ID']) && is_object($GLOBALS['USER'])) {
            $GLOBALS['USER']->Authorize($user['B_USER_ID'], true);
        }
        $_SESSION['CABINET_SSID'] = $user['PROPERTY_SSID_VALUE'] ?? md5(self::HASH_SALT . ($user['PROPERTY_GUID_VALUE'] ?? ''));
    }

    /**
     * Завершение сессии
     */
    public function logout(): void
    {
        unset($_SESSION['CABINET_SSID']);
        unset($_SESSION['CABINET_USER_INFO']);
        unset($_SESSION['CABINET_USER_INFO_TIME']);

        if (is_object($GLOBALS['USER']) && $GLOBALS['USER']->IsAuthorized()) {
            $GLOBALS['USER']->Logout();
        }
    }

    /**
     * Смена пароля
     */
    public function changePassword(int $userId, string $newPassword): bool
    {
        if ($userId <= 0 || mb_strlen($newPassword) < 8) {
            return false;
        }

        $userObj = new CUser;
        return (bool)$userObj->Update($userId, [
            'PASSWORD' => $newPassword,
            'CONFIRM_PASSWORD' => $newPassword,
            'UF_CAB_CHANGE_PASSWD' => 0,
        ]);
    }

    /**
     * Запрос восстановления пароля
     */
    public function requestPasswordRecovery(string $phone): bool
    {
        $user = $this->getUserByPhone($phone);
        if (!$user) {
            return false;
        }

        $newPass = $this->generatePassword();
        $userObj = new CUser;
        $updated = $userObj->Update($user['B_USER_ID'], [
            'PASSWORD' => $newPass,
            'CONFIRM_PASSWORD' => $newPass,
            'UF_CAB_CHANGE_PASSWD' => 1,
            'UF_CAB_LAST_SMS' => time(),
            'UF_CAB_SMS_ATTEMPTS' => 0,
        ]);

        if ($updated) {
            return $this->smsService->send($user['LOGIN'], 'Новый временный пароль для входа: ' . $newPass);
        }

        return false;
    }

    private function generatePassword(int $length = 8): string
    {
        $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP!@#$%^&*';
        $size = strlen($chars) - 1;

        do {
            $pass = '';
            for ($i = 0; $i < $length; $i++) {
                $pass .= $chars[random_int(0, $size)];
            }
        } while (!preg_match('/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])/', $pass));

        return $pass;
    }
}
