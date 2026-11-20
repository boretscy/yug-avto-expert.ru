<?php

	use Bitrix\Main\Loader;
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    Loader::includeModule("iblock");
	
	class Cabinet {

        ////////////////////////////////////////////////////////////////
		// Contst  /////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

		const TEST = true;
		const TEST_GUID = '22122f48-bbd5-11f0-a166-00155dca01c6';

		const METHOD_GET = 'GET';
        const METHOD_POST = 'POST';
        const METHOD_PATCH = 'PATCH';
        const METHOD_PUT = 'PUT';
        const METHOD_DELETE = 'DELETE';
		
		const API_SSL = true;
		const API_HOST = '1cweb.yug-avto.ru';
		// const API_HOST = '10.7.7.209';
		const API_BASE = '/tradeexpert';
		const API_BASE_T = '/tradeexpert_andreev';
		const API_URI = '/hs/PersonalAccountExpert';
		const API_USER = 'WebService';
		const API_PASS = '7895123';
		const API_RETRIES = 2;

		// substr( md5('https://yug-avto-expert.ru/cabinet/'), 0, -10);
		const HASH_SALT = '762f28d9322ae1799ac89a'; 
		const LOGIN_ATTEMPTS = 5;
		const CODE_TIMEOUT = 600;
		const IBLOCK_USERS = 20;

		const SMS_USER = 'KRD_Yug_Avto1.2';
		const SMS_PASSWD = 'wfy7dHn@';
		const SMS_SENDER = 'Y-A_Expert';

		private static $config = null;

		////////////////////////////////////////////////////////////////
		// Init  ///////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
        
        public function __construct( $arConf ) {
            
			$this->Conf = $arConf;
			static::$config = $arConf;
        }
		public function Conf() {

			return $this->Conf;
		}

		public static function getConfig( $key = null, $default = null ) {
			if ( static::$config === null ) {
				$cfgPath = __DIR__.'/Config.php';
				static::$config = file_exists($cfgPath) ? require $cfgPath : [];
			}
			if ( $key === null ) {
				return static::$config;
			}
			$parts = explode('.', $key);
			$val = static::$config;
			foreach ($parts as $p) {
				if ( !is_array($val) || !isset($val[$p]) ) {
					return $default;
				}
				$val = $val[$p];
			}
			return $val;
		}


		////////////////////////////////////////////////////////////////
		// Request  ////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

		private static function buildHeaders() {

            return [
                'Content-Type: application/json; charset=utf-8',
                'Accept: application/json'
            ];
        }
		private static function makeBaseURI() {

			$apiSsl = static::getConfig('api.ssl', static::API_SSL);
			$apiHost = static::getConfig('api.host', static::API_HOST);
			$isTest = static::getConfig('test', static::TEST);
			$apiBaseTest = static::getConfig('api.base_test', static::API_BASE_T);
			$apiBase = static::getConfig('api.base', static::API_BASE);
			$apiUri = static::getConfig('api.uri', static::API_URI);

			$uri = 'http';
			$uri .= ( $apiSsl ) ? 's' : '';
			$uri .= '://';
			$uri .= $apiHost;
			$uri .= ( $isTest ) ? $apiBaseTest : $apiBase;
			$uri .= $apiUri;

			return $uri;
		}
		private static function makeRequest( $endpoint = false, $method = false, $data = [], $params = [], $query = [] ) {
			
			if ( $endpoint ) {

				$uri = static::makeBaseURI();
				$uri .= '/'.$endpoint;
				if ( $params ) $uri .= '/'.implode('/', $params);
				if ( $query ) $uri .= '?'.http_build_query( $query );

				// YApp::sp($uri, false, 'URI');
				// if ( $method ) YApp::sp($method, false, 'METHOD');
				// if ( $data ) YApp::sp($data, false, 'BODY');
				// if ( $data ) YApp::sp(json_encode($data), false, 'BODY JSON');
				// if ( $params ) YApp::sp($params, false, 'PARAMS');
				// if ( $query ) YApp::sp($query, false, 'QUERY');
				
				$ch = curl_init($uri);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, static::buildHeaders());
				$timeout = (int)static::getConfig('api.timeout', 5);
				curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
				$apiUser = static::getConfig('api.user', static::API_USER);
				$apiPass = static::getConfig('api.pass', static::API_PASS);
				curl_setopt($ch, CURLOPT_USERPWD, $apiUser.':'.$apiPass);

				switch ( $method ) {
					case static::METHOD_GET: 	curl_setopt($ch, CURLOPT_HTTPGET, 1); break;
					case static::METHOD_POST: 	curl_setopt($ch, CURLOPT_POST, 1);curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data); break;
					case static::METHOD_PATCH: 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data); break;
					case static::METHOD_PUT: 	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data);break;
					case static::METHOD_DELETE: curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');curl_setopt($ch, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data); break;
					default: break;
				}

				$attempt = 0;
				$response = false;

				try {

					while ($attempt < static::API_RETRIES) {
						$response = curl_exec($ch);
						$err_code = curl_errno($ch);

						if ($response !== false) {
							break;
						}

						if ($err_code === CURLE_OPERATION_TIMEDOUT) {
							$attempt++;
							sleep(1);
							continue;
						}

						error_log("Cabinet 1C cURL error: " . curl_error($ch));
						break;
					}

					if ($response === false) throw new \RuntimeException(curl_error($ch), curl_errno($ch));

					$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					if ( $httpCode !== 200 && $httpCode !== 204 ) return false;

					$result = json_decode($response, true);

				} catch (\RuntimeException $e) {
					error_log(sprintf('Cabinet 1C error (%d): %s', $e->getCode(), $e->getMessage()));
				} finally {
					curl_close($ch);
				}
			}
			
			return $result;
		}


		////////////////////////////////////////////////////////////////
		// User  ///////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

		private static function makeUserData( $POST = [] ) {
			/*
			FIO						ФИО клиента*
			Phone					Телефон (+7...)*
			Series					Серия паспорта (опционально)
			Number					Номер паспорта (опционально)
			ProcessPersonalData		Согласие на обработку СОПД пользователя*
			*/
			$res = [];
			if ( !empty($POST['GUID']) ) $res['GUID'] = $POST['GUID'];
			if ( !empty($POST['NAME']) ) $res['FIO'] = $POST['NAME'];
			if ( !empty($POST['PHONE']) ) $res['Phone'] = YApp::phoneIn($POST['PHONE']);
			if ( !empty($POST['EMAIL']) ) $res['Email'] = $POST['EMAIL'];
			if ( !empty($POST['PASSPORT_SERIES']) ) $res['Series'] = $POST['PASSPORT_SERIES'];
			if ( !empty($POST['PASSPORT_NUMBER']) ) $res['Number'] = $POST['PASSPORT_NUMBER'];
			if ( isset($POST['PERSONAL']) ) $res['ProcessPersonalData'] = true;
			return $res;
		}
		public static function getUserByGUID( $guid = '' ) {
			
			$res = static::makeRequest(
				'User', 
				'GET',  
				[], 
				[], 
				[
					'GUID' => $guid
				]
			);
			return $res;
		}
		public static function regsterUser( $user = [] ) {

			$res = static::makeRequest( 
				'User', 
				'POST', 
				static::makeUserData($user)
			);
			return $res;
		}
		public static function patchUser( $user = [] ) {

			if ( $user['GUID'] ) {

				$res = static::makeRequest( 
					'User', 
					'PATCH', 
					static::makeUserData($user), 
					[],
					[
						'GUID' => $user['GUID']
					]
				);
				return $res;
			}
			return false;
		}

		public static function getCabUserBySSID( $ssid ) {
			if ( empty($ssid) ) return false;

			// 1. Поиск по текущей сессии Битрикса
			if ( is_object($GLOBALS['USER']) && $GLOBALS['USER']->IsAuthorized() ) {
				$curUserId = (int)$GLOBALS['USER']->GetID();
				$by = 'id'; $order = 'asc';
				$dbUser = \CUser::GetList($by, $order, ['ID' => $curUserId], ['SELECT' => ['UF_*']]);
				if ( $u = $dbUser->Fetch() ) {
					return [
						'ID' => $u['ID'],
						'NAME' => $u['LOGIN'],
						'PROPERTY_GUID_VALUE' => $u['UF_CAB_GUID'] ?? '',
						'PROPERTY_SSID_VALUE' => $ssid,
						'PROPERTY_CODE_VALUE' => $u['UF_CAB_CODE'] ?? '',
						'PROPERTY_CODE_TIMEOUT_VALUE' => $u['UF_CAB_CODE_TIMEOUT'] ?? 0,
						'PROPERTY_CHANGE_PASSWD_VALUE' => $u['UF_CAB_CHANGE_PASSWD'] ?? 0,
						'B_USER_ID' => (int)$u['ID'],
					];
				}
			}

			// 2. Поиск в b_user по совпадению SSID хэша от GUID
			$by = 'id'; $order = 'asc';
			$dbUsers = \CUser::GetList($by, $order, ['!UF_CAB_GUID' => false], ['SELECT' => ['UF_*']]);
			while ( $u = $dbUsers->Fetch() ) {
				$userSsid = md5( substr( md5('https://yug-avto-expert.ru/cabinet/'), 0, -10) . ($u['UF_CAB_GUID'] ?? '') );
				if ( $userSsid === $ssid ) {
					return [
						'ID' => $u['ID'],
						'NAME' => $u['LOGIN'],
						'PROPERTY_GUID_VALUE' => $u['UF_CAB_GUID'] ?? '',
						'PROPERTY_SSID_VALUE' => $ssid,
						'PROPERTY_CODE_VALUE' => $u['UF_CAB_CODE'] ?? '',
						'PROPERTY_CODE_TIMEOUT_VALUE' => $u['UF_CAB_CODE_TIMEOUT'] ?? 0,
						'PROPERTY_CHANGE_PASSWD_VALUE' => $u['UF_CAB_CHANGE_PASSWD'] ?? 0,
						'B_USER_ID' => (int)$u['ID'],
					];
				}
			}

			// 3. Fallback: поиск в ИБ 20
			$res = false;
			$rs = CIBlockElement::GetList(
				[], 
				[
					'IBLOCK_ID' => static::IBLOCK_USERS,
					'PROPERTY_SSID' => $ssid,
					'ACTIVE' => 'Y'
				], 
				false, false, 
				['ID','NAME','PROPERTY_GUID','PROPERTY_SSID', 'PROPERTY_CODE', 'PROPERTY_CODE_TIMEOUT', 'PROPERTY_CHANGE_PASSWD']
			);
			while( $ob = $rs->GetNextElement() ) $res = $ob->GetFields();
			return $res;
		}
		public static function getCabUserByName( $name ) {
			$cleanPhone = YApp::phoneIn($name);
			if ( empty($cleanPhone) ) return false;

			// 1. Поиск в штатной таблице b_user
			$by = 'id'; $order = 'asc';
			$dbUser = \CUser::GetList($by, $order, ['LOGIN_EQUAL_EXACT' => $cleanPhone], ['SELECT' => ['UF_*']]);
			if ( $u = $dbUser->Fetch() ) {
				$guid = $u['UF_CAB_GUID'] ?? '';
				$ssid = md5( substr( md5('https://yug-avto-expert.ru/cabinet/'), 0, -10) . $guid );
				return [
					'ID' => $u['ID'],
					'NAME' => $u['LOGIN'],
					'PROPERTY_GUID_VALUE' => $guid,
					'PROPERTY_SSID_VALUE' => $ssid,
					'PROPERTY_CODE_VALUE' => $u['UF_CAB_CODE'] ?? '',
					'PROPERTY_CODE_TIMEOUT_VALUE' => $u['UF_CAB_CODE_TIMEOUT'] ?? 0,
					'PROPERTY_CHANGE_PASSWD_VALUE' => $u['UF_CAB_CHANGE_PASSWD'] ?? 0,
					'B_USER_ID' => (int)$u['ID'],
				];
			}

			// 2. Fallback: поиск в ИБ 20
			$res = false;
			$rs = CIBlockElement::GetList(
				[], 
				[
					'IBLOCK_ID' => static::IBLOCK_USERS,
					'NAME' => $cleanPhone,
					'ACTIVE' => 'Y'
				], 
				false, false, 
				['ID','NAME','PROPERTY_GUID','PROPERTY_SSID', 'PROPERTY_CODE', 'PROPERTY_CODE_TIMEOUT', 'PROPERTY_CHANGE_PASSWD']
			);
			while( $ob = $rs->GetNextElement() ) $res = $ob->GetFields();
			return $res;
		}
		private static function getPasswdHashByGUID( $guid ) {

			$res = false;
			$rs = CIBlockElement::GetList(
				[], 
				[
					'IBLOCK_ID' => static::IBLOCK_USERS,
					'PROPERTY_GUID' => $guid,
					'ACTIVE' => 'Y'
				], 
				false, false, 
				['ID','NAME','PROPERTY_PASSWD']
			);
			while( $ob = $rs->GetNextElement() ) $res = $ob->GetFields()['PROPERTY_PASSWD_VALUE'];
			return $res;

		}
		public static function setCabUser( $POST = [] ) {
			
			$res = false;
			if ( !empty($POST['PHONE']) ) {
				$user = static::getCabUserByName( $POST['PHONE'] );
				if ( $user ) return ['status'=>false, 'description'=>'Такой пользователь уже зарегистрирован'];
				$passwd = static::newPasswd();
				$cleanPhone = YApp::phoneIn( $POST['PHONE'] );
				$guid = $POST['GUID'] ?? '';
				$ssid = md5( substr( md5('https://yug-avto-expert.ru/cabinet/'), 0, -10) . $guid );

				// Регистрация в b_user
				$userObj = new \CUser;
				$resGroup = \CGroup::GetList($by = "c_sort", $order = "asc", ["STRING_ID" => 'CABINET_USERS'])->Fetch();
				$cabGroupId = $resGroup ? (int)$resGroup['ID'] : 2;

				$userObj->Add([
					'LOGIN' => $cleanPhone,
					'NAME' => $POST['NAME'] ?? $cleanPhone,
					'EMAIL' => !empty($POST['EMAIL']) ? $POST['EMAIL'] : "{$cleanPhone}@yug-avto-expert.ru",
					'PASSWORD' => $passwd,
					'CONFIRM_PASSWORD' => $passwd,
					'ACTIVE' => 'Y',
					'GROUP_ID' => [2, $cabGroupId],
					'PERSONAL_PHONE' => $cleanPhone,
					'UF_CAB_GUID' => $guid,
					'UF_CAB_CHANGE_PASSWD' => 1,
				]);

				// Сохранение в ИБ 20 для обратной совместимости
				$arIns = [
					'IBLOCK_ID' => static::IBLOCK_USERS,
					'MODIFIED_BY' => 1,
					'NAME' => $cleanPhone,
					'ACTIVE' => 'Y',
					'PROPERTY_VALUES' => [
						'GUID' => $guid,
						'CHANGE_PASSWD' => 1,
						'PASSWD' => password_hash( $passwd, PASSWORD_DEFAULT ),
						'SSID' => $ssid,
					]
				];
				$el = new CIBlockElement;
				if ( $PRODUCT_ID = $el->Add($arIns) ) {
					static::sendSMS([
						'text' => 'Временный пароль: '.$passwd,
						'phone' => $cleanPhone
					]);
					return [
						'status' => true,
						'description' => $passwd
					];
				} else {
					error_log("Cabinet setCabUser error: " . $el->LAST_ERROR);
				}
			}
			return $res;
		}


		public static function checkAUth() {
			
			return ( !empty($_SESSION['CABINET_SSID']) ) ? true : false;
		}
		public static function unAUth() {
			
			unset( $_SESSION['CABINET_SSID'] );
			unset( $_SESSION['CABINET_USER_INFO'] );
			unset( $_SESSION['CABINET_USER_INFO_TIME'] );
			if ( is_object($GLOBALS['USER']) && $GLOBALS['USER']->IsAuthorized() ) {
				$GLOBALS['USER']->Logout();
			}
		}
		public static function AUth($user) {
			
			$res = false;
			$userData = static::getCabUserByName( $user['NAME'] ?? '' );
			if ( !empty($userData) ) {
				$ssid = $userData['PROPERTY_SSID_VALUE'] ?? md5( substr( md5('https://yug-avto-expert.ru/cabinet/'), 0, -10) . ($userData['PROPERTY_GUID_VALUE'] ?? '') );
				$_SESSION['CABINET_SSID'] = $ssid;

				// Авторизуем в штатном Битриксе
				if ( !empty($userData['B_USER_ID']) && is_object($GLOBALS['USER']) ) {
					$GLOBALS['USER']->Authorize($userData['B_USER_ID']);
				}
				$res = true;
			}
			return $res;
		}
		public static function getAUthSSID() {
			return ( $_SESSION['CABINET_SSID'] ) ?: false;
		}
		public static function passwdVerify( $value = '', $guid = null ) {
			
			$res = false;
			if ( $guid ) {
				$passwd_hash = static::getPasswdHashByGUID( $guid );
				$res = password_verify( $value, $passwd_hash);
			}
			return $res;
		}
		public static function passwdRecovery( $name ) {

			$user = static::getCabUserByName( $name );
			if ( $user ) {
				$passwd = static::newPasswd();
				$cleanPhone = YApp::phoneIn($name);

				// Обновление в b_user
				if ( !empty($user['B_USER_ID']) ) {
					$uObj = new \CUser;
					$uObj->Update($user['B_USER_ID'], [
						'PASSWORD' => $passwd,
						'CONFIRM_PASSWORD' => $passwd,
						'UF_CAB_CHANGE_PASSWD' => 1,
					]);
				}

				// Обновление в ИБ 20
				if ( !empty($user['ID']) && empty($user['B_USER_ID']) || !empty($user['ID']) ) {
					CIBlockElement::SetPropertyValuesEx(
						$user['ID'], 
						static::IBLOCK_USERS,
						[
							'CHANGE_PASSWD' => 1,
							'PASSWD' => password_hash( $passwd, PASSWORD_DEFAULT ),
						]
					);
				}

				static::sendSMS([
					'text' => 'Временный пароль: '.$passwd,
					'phone' => $cleanPhone
				]);
				return $passwd;
			}
			return false;
		}
		public static function setPasswd( $name, $passwd ) {

			$user = static::getCabUserByName( $name );
			if ( $user ) {
				// Обновление в b_user
				if ( !empty($user['B_USER_ID']) ) {
					$uObj = new \CUser;
					$uObj->Update($user['B_USER_ID'], [
						'PASSWORD' => $passwd,
						'CONFIRM_PASSWORD' => $passwd,
						'UF_CAB_CHANGE_PASSWD' => 0,
					]);
				}

				// Обновление в ИБ 20
				if ( !empty($user['ID']) ) {
					CIBlockElement::SetPropertyValuesEx(
						$user['ID'], 
						static::IBLOCK_USERS,
						[
							'CHANGE_PASSWD' => 0,
							'PASSWD' => password_hash( $passwd, PASSWORD_DEFAULT )
						]
					);
				}
				return true;
			}
			return false;
		}
		public static function getSMSCodeByName( $name ) {

			$res = false;
			$user = static::getCabUserByName( $name );
			if ( $user ) {
				$res = mt_rand(123456, 987654);
				$timeout = time() + static::CODE_TIMEOUT;

				// Обновление в b_user
				if ( !empty($user['B_USER_ID']) ) {
					$uObj = new \CUser;
					$uObj->Update($user['B_USER_ID'], [
						'UF_CAB_CODE' => (string)$res,
						'UF_CAB_CODE_TIMEOUT' => $timeout,
					]);
				}

				// Обновление в ИБ 20
				if ( !empty($user['ID']) ) {
					CIBlockElement::SetPropertyValuesEx(
						$user['ID'], 
						static::IBLOCK_USERS,
						[
							'CODE' => $res,
							'CODE_TIMEOUT' => $timeout
						]
					);
				}

				static::sendSMS([
					'text' => 'Проверочный код: '.$res,
					'phone' => YApp::phoneIn($name)
				]);
			}
			return $res;
		}
		private static function newPasswd( $length = 8 ) {
	
			$chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP!@#$%^&*';
			
			$size = strlen($chars) - 1;
			
			$i = $length; $pass = '';
			while ($i--) $pass .= $chars[rand(0, $size)];

			while ( !static::checkPasswd($pass) ) {
				
				$i = $length; $pass = '';
				while ($i--) $pass .= $chars[rand(0, $size)];
			}

			return $pass;
		}
		private static function checkPasswd( $passwd ) {

			return preg_match('/(?=.*[0-9])(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z])/', $passwd);
		}
		public static function passportIn( $q ) {
			
			// 1111 111111-> 1111111111
			
			$q = preg_replace('/[^0-9]/', '', $q);
			$q = mb_substr($q, 0, 10);
			
			return $q;
		}
		public static function passportOut( $q ) {
			$q = self::passportIn( $q );
			$len = mb_strlen((string)$q);
			if ($len < 10) {
				return (string)$q;
			}
			return mb_substr($q, 0, 4) . ' ' . mb_substr($q, 4, 6);
		}



		public static function sendform( $POST ) {
			require_once __DIR__.'/../../../api/vendor/phpmailer/phpmailer/src/Exception.php';
			require_once __DIR__.'/../../../api/vendor/phpmailer/phpmailer/src/PHPMailer.php';

			$mail = new PHPMailer(true);
			$mail->LE = "\r\n";
			$mail->Body = '';

			$name = !empty($POST['NAME']) ? \Bitrix\Main\Text\HtmlFilter::encode($POST['NAME']) : '';
			$phone = !empty($POST['PHONE']) ? \Bitrix\Main\Text\HtmlFilter::encode($POST['PHONE']) : '';
			$comment = !empty($POST['COMMENT']) ? \Bitrix\Main\Text\HtmlFilter::encode($POST['COMMENT']) : '';

			if ( $name ) $mail->Body .= 'Имя: '.$name.'<br />';
			if ( $phone ) $mail->Body .= 'Телефон: '.$phone.'<br />';
			if ( $comment ) $mail->Body .= 'Комментарий: '.$comment.'<br />';

			try {
				$sender = !empty($POST['SENDER']) ? \Bitrix\Main\Text\HtmlFilter::encode($POST['SENDER']) : 'Формы кабинета yug-avto-expert.ru';
				$mail->setFrom('cabinet_formsender@yug-avto-expert.ru', $sender);
				$mail->isHTML(true);
				$mail->CharSet = 'utf-8';
				$mail->addAddress('anton.boreckiy@yug-avto.ru');
				$mail->send();
				return true;
			} catch (Exception $e) {
				error_log("Cabinet sendform Mailer Error: " . $mail->ErrorInfo);
				return false;
			}
		}


		public static function sendSMS( $POST ) {
			$cfg = static::getConfig();
			$smsUser = $cfg['sms']['user'] ?? '';
			$smsPass = $cfg['sms']['pass'] ?? '';
			$smsSender = $cfg['sms']['sender'] ?? '';

			$SMS = new SMS($smsUser, $smsPass);
			$r = $SMS->post_message($POST['text'], $POST['phone'], $smsSender);

			if (is_array($r) && isset($r['status']) && $r['status'] !== 'ok') {
				error_log('Cabinet sendSMS error: ' . json_encode($r, JSON_UNESCAPED_UNICODE));
			}

			return true;
		}

		////////////////////////////////////////////////////////////////
		// Vehicles  ///////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////

		public static function getMyCars( $guid = '' ) {

			$res = static::makeRequest( 
				'MyCars', 
				'POST', 
				[], 
				[], 
				[
					'GUID' => $guid
				]
			);
			return $res;
		}
		public static function getCarInfo( $guid = '', $vin = '' ) {

			$res = static::makeRequest( 
				'CarInfo', 
				'GET', 
				[], 
				[
					'GUID' => $guid,
					'VIN' => $vin
				]
			);
			return $res;
		}
		public static function getPriceChangeHistory( $guid = '', $vin = '' ) {

			$res = static::makeRequest( 
				'PriceChangeHistory', 
				'GET', 
				[], 
				[
					'GUID' => $guid,
					'VIN' => $vin
				]
			);
			return $res;
		}
		public static function getOffersForCarRevaluation( $guid = '', $vin = '' ) {

			$res = static::makeRequest( 
				'OffersForCarRevaluation', 
				'GET', 
				[], 
				[
					'GUID' => $guid,
					'VIN' => $vin
				]
			);
			return $res;
		}
		
		public static function postOffersForCarRevaluation( $POST ) {

			$res = false;
			if ( $POST['GUID'] ) {

				$res = static::makeRequest( 
					'OffersForCarRevaluation', 
					'POST', 
					[
						'GUIDDoc' => $POST['DOC'],
						'Status' => ( $POST['ACTION'] == 'accept') ? true : false
					], 
					[
						'GUID' => $POST['GUID'],
						'VIN' => $POST['VIN']
					]
				);
			}

			return $res;
		}


		public static function getGenerateADocument ( $guid = '', $vin = '', $doc = '' ) {

			$res = static::makeRequest( 
				'GenerateADocument', 
				'GET', 
				[], 
				[
					'GUID' => $guid,
					'VIN' => $vin
				],
				[
					'NumDoc' => $doc
				]
			);
			return $res;
		}
	}
