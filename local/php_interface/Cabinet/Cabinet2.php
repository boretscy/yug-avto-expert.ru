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

		////////////////////////////////////////////////////////////////
		// Init  ///////////////////////////////////////////////////////
		////////////////////////////////////////////////////////////////
        
        public function __construct( $arConf ) {
            
			$this->Conf = $arConf;
        }
		public function Conf() {

			return $this->Conf;
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

			$uri = 'http';
			$uri .= ( static::API_SSL ) ? 's' : '';
			$uri .= '://';
			$uri .= static::API_HOST;
			$uri .= ( static::TEST ) ? static::API_BASE_T : static::API_BASE;
			$uri .= static::API_URI;

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
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
				curl_setopt($ch, CURLOPT_HTTPHEADER, static::buildHeaders());
				curl_setopt($ch, CURLOPT_TIMEOUT, 10);
				curl_setopt($ch, CURLOPT_USERPWD, static::API_USER.':'.static::API_PASS);

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
				$result = false;

				try {
					// $response = curl_exec($ch);

					while ($attempt < static::API_RETRIES) {
						$response = curl_exec($ch);
						$err_code = curl_errno($ch);

						if ($response !== false) {
							// Успех — выходим из цикла
							break;
						}

						if ($err_code === CURLE_OPERATION_TIMEDOUT) {
							$attempt++;
							// echo "Попытка $attempt не удалась по таймауту. Повтор...\n";
							sleep(1); // Пауза перед повтором
							continue;
						}

						// Если ошибка не связана с таймаутом (например, 404), прерываем цикл
					error_log("Критическая ошибка cURL: " . curl_error($ch));
						break;
					}

					// 1. Проверка на ошибки соединения/транспорта
					if ($response === false) throw new \RuntimeException(curl_error($ch), curl_errno($ch));

					// 2. Проверка HTTP-статуса (например, 404 или 500)
					$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
					// if ( $httpCode !== 200 && $httpCode !== 204 ) throw new Exception(sprintf('Curl error http code: (%s) %s uri: %s', $httpCode, $response, $uri), $httpCode);
					if ( $httpCode !== 200 && $httpCode !== 204 ) return false;
					// if ( $httpCode !== 200 && $httpCode !== 204 ) {
					// 	echo $httpCode.PHP_EOL.PHP_EOL;
					// 	echo $response;
					// 	die;
					// };

					// Успешная обработка
					$result = json_decode($response, true);
					// $result = $response;

				} catch (\RuntimeException $e) {
					// Обработка ошибок (логирование)
				error_log(sprintf('Curl error (%d): %s uri: %s', $e->getCode(), $e->getMessage(), $uri));
					// Ресурс должен быть закрыт всегда
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
			Series					Серия паспорта*
			Number					Номер паспорта*
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

			$res = false;
			$rs = CIBlockElement::GetList(
				[], 
				[
					'IBLOCK_ID' => static::IBLOCK_USERS,
					'PROPERTY_SSID' => $ssid,
					'ACTIVE' => 'Y'
				], 
				false, ['nTopCount' => 1], 
				['ID','NAME','PROPERTY_GUID','PROPERTY_SSID', 'PROPERTY_CODE', 'PROPERTY_CODE_TIMEOUT', 'PROPERTY_CHANGE_PASSWD']
			);
			while( $ob = $rs->GetNextElement() ) $res = $ob->GetFields();
			return $res;
		}
		public static function getCabUserByName( $name ) {

			$res = false;
			$rs = CIBlockElement::GetList(
				[], 
				[
					'IBLOCK_ID' => static::IBLOCK_USERS,
					'NAME' => YApp::phoneIn($name),
					'ACTIVE' => 'Y'
				], 
				false, ['nTopCount' => 1], 
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
				false, ['nTopCount' => 1], 
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
				$arIns = [
					'IBLOCK_ID' => static::IBLOCK_USERS,
					'MODIFIED_BY' => 1,
					'NAME' => YApp::phoneIn( $POST['PHONE'] ),
					'ACTIVE' => 'Y',
					'PROPERTY_VALUES' => [
						'GUID' => $POST['GUID'],
						'CHANGE_PASSWD' => 1,
						'PASSWD' => password_hash( $passwd, PASSWORD_DEFAULT ),
						'SSID' => md5( substr( md5('https://yug-avto-expert.ru/cabinet/'), 0, -10).$POST['GUID'] ),
					]
				];
				$el = new CIBlockElement;
				if ( $PRODUCT_ID = $el->Add($arIns) ) {
					return [
						'status' => true,
						'description' => $passwd
					];
				} else {
					error_log('Cabinet::setCabUser Error: '.$el->LAST_ERROR);
				}
			}
			return $res;
		}


		public static function checkAUth() {
			
			return !empty($_SESSION['CABINET_SSID']) ? true : false;
		}
		public static function unAUth() {
			
			unset( $_SESSION['CABINET_SSID'] );
		}
		public static function AUth($user) {
			
			$res = false;
			if ( !empty($user['NAME']) ) {
				$user = static::getCabUserByName( YApp::phoneIn($user['NAME']) );
				if ( !empty($user['PROPERTY_SSID_VALUE']) ) {
					$_SESSION['CABINET_SSID'] = $user['PROPERTY_SSID_VALUE'];
					$res = true;
				}
			}
			return $res;
		}
		public static function getAUthSSID() {
			return !empty($_SESSION['CABINET_SSID']) ? $_SESSION['CABINET_SSID'] : false;
		}
		public static function passwdVerify( $value = '', $guid = null ) {
			
			$res = false;
			if ( !empty($guid) && !empty($value) ) {
				$passwd_hash = static::getPasswdHashByGUID( $guid );
				if ( $passwd_hash ) {
					$res = password_verify( $value, $passwd_hash);
				}
			}
			return $res;
		}
		public static function passwdRecovery( $name ) {

			$user = static::getCabUserByName( $name );
			if ( $user ) {
				$passwd = static::newPasswd();
				CIBlockElement::SetPropertyValuesEx(
					$user['ID'], 
					static::IBLOCK_USERS,
					[
						'CHANGE_PASSWD' => 1,
						'PASSWD' => password_hash( $passwd, PASSWORD_DEFAULT ),
					]
				);
				static::sendSMS([
					'text' => 'Временный пароль: '.$passwd,
					'phone' => $name
				]);
				return $passwd;
			}
			return false;
		}
		public static function setPasswd( $name, $passwd ) {

			$user = static::getCabUserByName( $name );
			if ( $user ) {
				CIBlockElement::SetPropertyValuesEx(
					$user['ID'], 
					static::IBLOCK_USERS,
					[
						'CHANGE_PASSWD' => 0,
						'PASSWD' => password_hash( $passwd, PASSWORD_DEFAULT )
					]
				);
				return true;
			}
			return false;
		}
		public static function getSMSCodeByName( $name ) {

			$res = false;
			$user = static::getCabUserByName( $name );
			if ( $user ) {
				$res = mt_rand(123456, 987654);
				CIBlockElement::SetPropertyValuesEx(
					$user['ID'], 
					static::IBLOCK_USERS,
					[
						'CODE' => $res,
						'CODE_TIMEOUT' => time() + static::CODE_TIMEOUT
					]
				);
				static::sendSMS([
					'text' => 'Проверочный код: '.$res,
					'phone' => $name
				]);
			}
			return $res;
		}
		private static function newPasswd( $length = 8 ) {
	
			$chars = 'qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP!@#$%^&*';
			$size = strlen($chars) - 1;
			
			$pass = '';
			do {
				$pass = '';
				for ($i = 0; $i < $length; $i++) {
					$pass .= $chars[random_int(0, $size)];
				}
			} while ( !static::checkPasswd($pass) );

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
			return substr($q, 0, 4) . ' ' . substr($q, 4, 6);
		}



		public static function sendform( $POST ) {
          

            $mail = new PHPMailer(true);
			$mail->Body = '';


            if ( !empty($POST['NAME']) ) $mail->Body .= 'Имя: '.$POST['NAME'].'<br />';
			if ( !empty($POST['PHONE']) ) $mail->Body .= 'Телефон: '.$POST['PHONE'].'<br />';
			if ( !empty($POST['COMMENT']) ) $mail->Body .= 'Комментарий: '.$POST['COMMENT'].'<br />';

			try {
                
                $mail->setFrom('cabinet_formsender@yug-avto-expert.ru', (($_POST['SENDER'])?:'Формы кабинета yug-avto-expert.ru'));
                $mail->isHTML(true);
                $mail->CharSet = 'utf-8';
                $mail->addAddress('anton.boreckiy@yug-avto.ru');
                $mail->send();
                return true;

            } catch (Exception $e) {

                error_log("Cabinet::sendform - Mailer Error: {$mail->ErrorInfo}");
				return false;
            }
            
        }


		public static function sendSMS( $POST ) {
            
            if ( empty($POST['text']) || empty($POST['phone']) ) {
                error_log('Cabinet::sendSMS - Missing required parameters');
                return false;
            }
            
            $SMS = new SMS(static::SMS_USER, static::SMS_PASSWD);
			$r = $SMS->post_message($POST['text'], $POST['phone'], static::SMS_SENDER);
            
            return $r ? true : false;
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
