<?php

use Bitrix\Main\Loader;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Cabinet\Client\OneCClient;
use Cabinet\Services\AuthService;
use Cabinet\Services\VehicleService;
use Cabinet\Services\SmsService;

class Cabinet
{
    const TEST = true;
    const TEST_GUID = '22122f48-bbd5-11f0-a166-00155dca01c6';

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_PATCH = 'PATCH';
    const METHOD_PUT = 'PUT';
    const METHOD_DELETE = 'DELETE';

    const HASH_SALT = '762f28d9322ae1799ac89a';
    const LOGIN_ATTEMPTS = 5;
    const CODE_TIMEOUT = 600;

    private static $config = null;
    private static $oneCClient = null;
    private static $authService = null;
    private static $vehicleService = null;
    private static $smsService = null;

    public $Conf = [];

    public function __construct($arConf = [])
    {
        $this->Conf = $arConf;
        static::$config = $arConf;
    }

    public function Conf()
    {
        return $this->Conf;
    }

    public static function getConfig($key = null, $default = null)
    {
        if (static::$config === null) {
            $cfgPath = __DIR__ . '/Config.php';
            static::$config = file_exists($cfgPath) ? require $cfgPath : [];
        }
        if ($key === null) {
            return static::$config;
        }
        $parts = explode('.', $key);
        $val = static::$config;
        foreach ($parts as $p) {
            if (!is_array($val) || !isset($val[$p])) {
                return $default;
            }
            $val = $val[$p];
        }
        return $val;
    }

    // Lazy getters для сервисов
    public static function getOneCClient(): OneCClient
    {
        if (static::$oneCClient === null) {
            static::$oneCClient = new OneCClient(static::getConfig());
        }
        return static::$oneCClient;
    }

    public static function getAuthService(): AuthService
    {
        if (static::$authService === null) {
            static::$authService = new AuthService(static::getSmsService());
        }
        return static::$authService;
    }

    public static function getVehicleService(): VehicleService
    {
        if (static::$vehicleService === null) {
            static::$vehicleService = new VehicleService(static::getOneCClient());
        }
        return static::$vehicleService;
    }

    public static function getSmsService(): SmsService
    {
        if (static::$smsService === null) {
            static::$smsService = new SmsService(static::getConfig());
        }
        return static::$smsService;
    }

    ////////////////////////////////////////////////////////////////
    // Request  ////////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    public static function makeRequest($endpoint = false, $method = false, $data = [], $params = [], $query = [])
    {
        if (!$endpoint) return false;
        return static::getOneCClient()->request($endpoint, $method ?: 'GET', $data, $params, $query);
    }

    ////////////////////////////////////////////////////////////////
    // User / 1C  //////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    private static function makeUserData($POST = [])
    {
        $res = [];
        if (!empty($POST['GUID'])) $res['GUID'] = $POST['GUID'];
        if (!empty($POST['NAME'])) $res['FIO'] = $POST['NAME'];
        if (!empty($POST['PHONE'])) $res['Phone'] = YApp::phoneIn($POST['PHONE']);
        if (!empty($POST['EMAIL'])) $res['Email'] = $POST['EMAIL'];
        if (!empty($POST['PASSPORT_SERIES'])) $res['Series'] = $POST['PASSPORT_SERIES'];
        if (!empty($POST['PASSPORT_NUMBER'])) $res['Number'] = $POST['PASSPORT_NUMBER'];
        if (isset($POST['PERSONAL'])) $res['ProcessPersonalData'] = true;
        return $res;
    }

    public static function getUserByGUID($guid = '')
    {
        if (empty($guid)) return false;
        return static::getOneCClient()->request('User', 'GET', [], [], ['GUID' => $guid]);
    }

    public static function regsterUser($user = [])
    {
        return static::getOneCClient()->request('User', 'POST', static::makeUserData($user));
    }

    public static function patchUser($user = [])
    {
        if (!empty($user['GUID'])) {
            return static::getOneCClient()->request('User', 'PATCH', static::makeUserData($user), [], ['GUID' => $user['GUID']]);
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////
    // User / b_user & Auth  ///////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    public static function getCabUserBySSID($ssid)
    {
        if (empty($ssid)) return false;

        $user = static::getAuthService()->getUserByPhone(
            (is_object($GLOBALS['USER']) && $GLOBALS['USER']->IsAuthorized()) 
                ? $GLOBALS['USER']->GetLogin() 
                : ''
        );

        if ($user) {
            return $user;
        }

        // Поиск по хэшу GUID в b_user
        $by = 'id'; $order = 'asc';
        $dbUsers = CUser::GetList($by, $order, ['!UF_CAB_GUID' => false], ['SELECT' => ['UF_*']]);
        while ($u = $dbUsers->Fetch()) {
            $guid = $u['UF_CAB_GUID'] ?? '';
            $userSsid = md5(static::HASH_SALT . $guid);
            if ($userSsid === $ssid) {
                return static::getAuthService()->getUserByPhone($u['LOGIN']);
            }
        }

        return false;
    }

    public static function getCabUserByName($name)
    {
        return static::getAuthService()->getUserByPhone($name);
    }

    public static function setCabUser($POST = [])
    {
        $guid = $POST['GUID'] ?? '';
        return static::getAuthService()->register($POST, $guid);
    }

    public static function checkAuth()
    {
        if (is_object($GLOBALS['USER']) && $GLOBALS['USER']->IsAuthorized()) {
            return true;
        }
        return (!empty($_SESSION['CABINET_SSID']));
    }

    public static function unAuth()
    {
        static::getAuthService()->logout();
    }

    public static function AUth($user)
    {
        $userData = static::getCabUserByName($user['NAME'] ?? ($user['LOGIN'] ?? ''));
        if (!empty($userData)) {
            static::getAuthService()->authorizeUser($userData);
            return true;
        }
        return false;
    }

    public static function getAUthSSID()
    {
        return ($_SESSION['CABINET_SSID']) ?: false;
    }

    public static function passwdVerify($value = '', $guid = null)
    {
        return static::getAuthService()->verifyPassword($value, $guid ?: '');
    }

    public static function passwdRecovery($name)
    {
        $user = static::getCabUserByName($name);
        if (!$user) return false;

        $lastSms = (int)($user['PROPERTY_LAST_SMS'] ?? 0);
        if ($lastSms > 0 && (time() - $lastSms < 60)) {
            return false;
        }

        $chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP!@#$%^&*';
        $size = strlen($chars) - 1;
        do {
            $pass = '';
            for ($i = 0; $i < 8; $i++) $pass .= $chars[random_int(0, $size)];
        } while (!preg_match('/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])/', $pass));

        $uObj = new CUser;
        $uObj->Update($user['B_USER_ID'], [
            'PASSWORD' => $pass,
            'CONFIRM_PASSWORD' => $pass,
            'UF_CAB_CHANGE_PASSWD' => 1,
            'UF_CAB_LAST_SMS' => time(),
            'UF_CAB_SMS_ATTEMPTS' => 0,
        ]);

        static::sendSMS([
            'text' => 'Новый временный пароль для входа: ' . $pass,
            'phone' => YApp::phoneIn($name)
        ]);

        return $pass;
    }

    public static function setPasswd($name, $passwd)
    {
        $user = static::getCabUserByName($name);
        if ($user && !empty($user['B_USER_ID'])) {
            return static::getAuthService()->changePassword($user['B_USER_ID'], $passwd);
        }
        return false;
    }

    public static function getSMSCodeByName($name)
    {
        $user = static::getCabUserByName($name);
        if ($user && !empty($user['B_USER_ID'])) {
            return static::getSmsService()->sendVerificationCode($user['B_USER_ID'], $name);
        }
        return false;
    }

    ////////////////////////////////////////////////////////////////
    // SMS & Forms  ////////////////////////////////////////////////
    ////////////////////////////////////////////////////////////////

    public static function sendSMS($POST)
    {
        $phone = $POST['phone'] ?? '';
        $text = $POST['text'] ?? '';
        return static::getSmsService()->send($phone, $text);
    }

    public static function sendform($POST)
    {
        require_once __DIR__ . '/../../../api/vendor/phpmailer/phpmailer/src/Exception.php';
        require_once __DIR__ . '/../../../api/vendor/phpmailer/phpmailer/src/PHPMailer.php';

        $mail = new PHPMailer(true);
        $mail->LE = "\r\n";
        $mail->Body = '';

        $name = !empty($POST['NAME']) ? \Bitrix\Main\Text\HtmlFilter::encode($POST['NAME']) : '';
        $phone = !empty($POST['PHONE']) ? \Bitrix\Main\Text\HtmlFilter::encode($POST['PHONE']) : '';
        $comment = !empty($POST['COMMENT']) ? \Bitrix\Main\Text\HtmlFilter::encode($POST['COMMENT']) : '';

        if ($name) $mail->Body .= 'Имя: ' . $name . '<br />';
        if ($phone) $mail->Body .= 'Телефон: ' . $phone . '<br />';
        if ($comment) $mail->Body .= 'Комментарий: ' . $comment . '<br />';

        try {
            $sender = !empty($POST['SENDER']) ? \Bitrix\Main\Text\HtmlFilter::encode($POST['SENDER']) : 'Формы кабинета yug-avto-expert.ru';
            $mail->setFrom('cabinet_formsender@yug-avto-expert.ru', $sender);
            $mail->isHTML(true);
            $mail->CharSet = 'utf-8';
            $mail->addAddress('anton.boreckiy@yug-avto.ru');
            $mail->send();
            return true;
        } catch (\Throwable $e) {
            error_log("Cabinet sendform Mailer Error: " . $mail->ErrorInfo);
            return false;
        }
    }

    public static function passportIn($q)
    {
        $q = preg_replace('/[^\d]+/', '', $q);
        return $q;
    }

    public static function passportOut($q)
    {
        $q = self::passportIn($q);
        $len = mb_strlen((string)$q);
        if ($len < 10) {
            return (string)$q;
        }
        return mb_substr($q, 0, 4) . ' ' . mb_substr($q, 4, 6);
    }

    ////////////////////////////////////////////////////////////////
    // Vehicles (BOLA/IDOR protected)  /////////////////////////////
    ////////////////////////////////////////////////////////////////

    public static function getMyCars($guid = '')
    {
        return static::getVehicleService()->getMyCars($guid);
    }

    public static function getCarInfo($guid = '', $vin = '')
    {
        return static::getVehicleService()->getCarInfo($guid, $vin);
    }

    public static function getPriceChangeHistory($guid = '', $vin = '')
    {
        return static::getVehicleService()->getPriceHistory($guid, $vin);
    }

    public static function getOffersForCarRevaluation($guid = '', $vin = '')
    {
        return static::getVehicleService()->getOffers($guid, $vin);
    }

    public static function postOffersForCarRevaluation($POST)
    {
        $guid = $POST['GUID'] ?? '';
        $vin = $POST['VIN'] ?? '';
        $doc = $POST['DOC'] ?? '';
        $accept = (($POST['ACTION'] ?? '') === 'accept');

        return static::getVehicleService()->postOfferDecision($guid, $vin, $doc, $accept);
    }

    public static function getGenerateADocument($guid = '', $vin = '', $doc = '')
    {
        return static::getVehicleService()->getDocument($guid, $vin, $doc);
    }
}
