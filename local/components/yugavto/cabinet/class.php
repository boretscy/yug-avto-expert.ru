<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;
use Bitrix\Main\Context;
use Bitrix\Main\Text\HtmlFilter;
use Bitrix\Main\Engine\Contract\Controllerable;
use Bitrix\Main\Engine\ActionFilter;
use Bitrix\Main\AccessDeniedException;
use Cabinet\Services\VehicleService;
use Cabinet\Services\SmsService;

class YugavtoCabinetComponent extends \CBitrixComponent implements Controllerable
{
    private $vehicleService;
    private $smsService;

    public function onPrepareComponentParams($arParams)
    {
        $arParams["SEF_MODE"] = ($arParams["SEF_MODE"] ?? "Y") === "Y" ? "Y" : "N";
        $arParams["SEF_FOLDER"] = $arParams["SEF_FOLDER"] ?? "/cabinet/";
        return $arParams;
    }

    public function configureActions(): array
    {
        return [
            'checkVerificationStatus' => [
                'prefilters' => [
                    new ActionFilter\Authentication(),
                    new ActionFilter\Csrf(),
                ],
            ],
            'sendOfferSms' => [
                'prefilters' => [
                    new ActionFilter\Authentication(),
                    new ActionFilter\Csrf(),
                ],
            ],
            'confirmOffer' => [
                'prefilters' => [
                    new ActionFilter\Authentication(),
                    new ActionFilter\Csrf(),
                ],
            ],
        ];
    }

    private function getVehicleService(): VehicleService
    {
        if ($this->vehicleService === null) {
            $this->vehicleService = new VehicleService();
        }
        return $this->vehicleService;
    }

    private function getSmsService(): SmsService
    {
        if ($this->smsService === null) {
            $this->smsService = new SmsService();
        }
        return $this->smsService;
    }

    /**
     * AJAX Action: Проверка статуса верификации пользователя в 1С
     */
    public function checkVerificationStatusAction(): array
    {
        if (!\Cabinet::checkAuth()) {
            return ['success' => false, 'error' => 'not_authorized', 'message' => 'Требуется авторизация.'];
        }

        $userGuid = $GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'] ?? '';
        if (empty($userGuid)) {
            return ['success' => false, 'error' => 'no_guid', 'message' => 'Не найден идентификатор GUID пользователя.'];
        }

        $info1C = \Cabinet::getUserByGUID($userGuid);
        if (!empty($info1C['Status'])) {
            $GLOBALS['CABINET_USER']['INFO']['Status'] = true;
            if (!empty($_SESSION['CABINET_USER'])) {
                $_SESSION['CABINET_USER']['INFO']['Status'] = true;
            }
            return [
                'success' => true,
                'verified' => true,
                'message' => 'Учетная запись успешно верифицирована.'
            ];
        }

        return [
            'success' => true,
            'verified' => false,
            'message' => 'Статус пока не подтвержден в системе 1С. Пожалуйста, обратитесь к сотруднику автосалона.'
        ];
    }

    /**
     * AJAX Action: Отправка SMS-кода для подтверждения решения по оферу
     */
    public function sendOfferSmsAction(string $vin): array
    {
        if (!\Cabinet::checkAuth()) {
            return ['success' => false, 'error' => 'not_authorized', 'message' => 'Требуется авторизация.'];
        }

        $userGuid = $GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'] ?? '';
        $userPhone = $GLOBALS['CABINET_USER']['NAME'] ?? '';
        $userId = (int)($GLOBALS['USER']->GetID());

        try {
            $this->getVehicleService()->assertVehicleOwnership($userGuid, $vin);
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'forbidden', 'message' => $e->getMessage()];
        }

        $code = $this->getSmsService()->sendVerificationCode($userId, $userPhone);
        if ($code === null) {
            return [
                'success' => false,
                'error' => 'rate_limit',
                'message' => 'Слишком частые запросы SMS. Пожалуйста, подождите 60 секунд.'
            ];
        }

        return [
            'success' => true,
            'message' => 'Код подтверждения успешно отправлен в SMS.'
        ];
    }

    /**
     * AJAX Action: Подтверждение или отклонение офера по автомобилю
     */
    public function confirmOfferAction(string $vin, string $docGuid, string $action, string $code): array
    {
        if (!\Cabinet::checkAuth()) {
            return ['success' => false, 'error' => 'not_authorized', 'message' => 'Требуется авторизация.'];
        }

        $userGuid = $GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'] ?? '';
        $userId = (int)($GLOBALS['USER']->GetID());

        try {
            $this->getVehicleService()->assertVehicleOwnership($userGuid, $vin);
        } catch (\Exception $e) {
            return ['success' => false, 'error' => 'forbidden', 'message' => $e->getMessage()];
        }

        $isValid = $this->getSmsService()->verifyCode($userId, trim($code));
        if (!$isValid) {
            return [
                'success' => false,
                'error' => 'invalid_code',
                'message' => 'Неверный проверочный код или истек срок его действия.'
            ];
        }

        $payload = [
            'GUID' => $userGuid,
            'VIN' => $vin,
            'DOC' => $docGuid,
            'ACTION' => ($action === 'accept') ? 'accept' : 'refuse',
        ];

        $res = $this->getVehicleService()->postOfferDecision($payload);
        if (!empty($res)) {
            return [
                'success' => true,
                'data' => $res,
                'message' => ($action === 'accept') ? 'Предложение успешно принято.' : 'Предложение отклонено.'
            ];
        }

        return [
            'success' => false,
            'error' => '1c_error',
            'message' => 'Не удалось зафиксировать решение в системе 1С. Пожалуйста, повторите позже.'
        ];
    }

    public function executeComponent()
    {
        global $APPLICATION, $USER;

        // 1. Проверка авторизации
        if (!\Cabinet::checkAuth()) {
            LocalRedirect('/cabinet/login/');
            return;
        }

        // 2. Инициализация глобального контекста пользователя кабинета
        if (empty($GLOBALS['CABINET_USER']) && is_object($USER) && $USER->IsAuthorized()) {
            $phone = $USER->GetLogin();
            $GLOBALS['CABINET_USER'] = \Cabinet::getCabUserByName($phone);
        }

        // 3. SEF Маршрутизация
        $defaultUrlTemplates404 = [
            "cars" => "",
            "vehicle" => "vehicle/#VEHICLE_ID#/",
            "vehicle_history" => "vehicle/#VEHICLE_ID#/history/",
            "vehicle_offers" => "vehicle/#VEHICLE_ID#/offers/",
            "vehicle_docs" => "vehicle/#VEHICLE_ID#/docs/",
            "profile" => "me/",
            "verify" => "verify/",
        ];

        $arVariables = [];
        $componentPage = "";

        if ($this->arParams["SEF_MODE"] === "Y") {
            $urlTemplates = \CComponentEngine::makeComponentUrlTemplates($defaultUrlTemplates404, $this->arParams["SEF_URL_TEMPLATES"] ?? []);
            $engine = new \CComponentEngine($this);
            $componentPage = $engine->guessComponentPath($this->arParams["SEF_FOLDER"], $urlTemplates, $arVariables);
            \CComponentEngine::initComponentVariables($componentPage, ["VEHICLE_ID"], [], $arVariables);
        }

        // Fallback определение страницы по URI, если guessComponentPath не сработал
        if (empty($componentPage)) {
            $requestUri = Context::getCurrent()->getRequest()->getRequestUri();
            $parsedPath = parse_url($requestUri, PHP_URL_PATH);
            $trimmed = trim(str_replace('/cabinet', '', $parsedPath), '/');

            if ($trimmed === '' || $trimmed === 'index.php') {
                $componentPage = 'cars';
            } elseif ($trimmed === 'me' || strpos($trimmed, 'me/') === 0) {
                $componentPage = 'profile';
            } elseif ($trimmed === 'verify' || strpos($trimmed, 'verify/') === 0) {
                $componentPage = 'verify';
            } elseif (preg_match('#^vehicle/([^/]+)/history#', $trimmed, $m)) {
                $componentPage = 'vehicle_history';
                $arVariables['VEHICLE_ID'] = $m[1];
            } elseif (preg_match('#^vehicle/([^/]+)/offers#', $trimmed, $m)) {
                $componentPage = 'vehicle_offers';
                $arVariables['VEHICLE_ID'] = $m[1];
            } elseif (preg_match('#^vehicle/([^/]+)/docs#', $trimmed, $m)) {
                $componentPage = 'vehicle_docs';
                $arVariables['VEHICLE_ID'] = $m[1];
            } elseif (preg_match('#^vehicle/([^/]+)#', $trimmed, $m)) {
                $componentPage = 'vehicle';
                $arVariables['VEHICLE_ID'] = $m[1];
            } else {
                $componentPage = 'cars';
            }
        }

        $this->arResult["COMPONENT_PAGE"] = $componentPage;
        $this->arResult["VARIABLES"] = $arVariables;
        $this->arResult["USER"] = $GLOBALS['CABINET_USER'] ?? [];
        $this->arResult["USER_GUID"] = $GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'] ?? '';
        $this->arResult["USER_PHONE"] = $GLOBALS['CABINET_USER']['NAME'] ?? '';
        $this->arResult["IS_VERIFIED"] = !empty($GLOBALS['CABINET_USER']['INFO']['Status']);

        // 4. Guard checks (защитные редиректы строго до вывода)
        if (!empty($GLOBALS['CABINET_USER']['PROPERTY_CHANGE_PASSWD_VALUE']) && $componentPage !== 'profile') {
            LocalRedirect('/cabinet/me/#cabinet-me-passwd');
            return;
        }

        if (!$this->arResult["IS_VERIFIED"] && !in_array($componentPage, ['profile', 'verify'], true)) {
            LocalRedirect('/cabinet/verify/');
            return;
        }

        // 5. Подготовка данных для конкретной страницы
        switch ($componentPage) {
            case 'cars':
                $this->prepareCars();
                break;
            case 'vehicle':
                $this->prepareVehicle($arVariables['VEHICLE_ID'] ?? '');
                break;
            case 'vehicle_history':
                $this->prepareVehicleHistory($arVariables['VEHICLE_ID'] ?? '');
                break;
            case 'vehicle_offers':
                $this->prepareVehicleOffers($arVariables['VEHICLE_ID'] ?? '');
                break;
            case 'vehicle_docs':
                $this->prepareVehicleDocs($arVariables['VEHICLE_ID'] ?? '');
                return; // docs завершает выполнение отдачей потока
            case 'profile':
                $this->prepareProfile();
                break;
            case 'verify':
                $this->prepareVerify();
                break;
            default:
                $componentPage = 'cars';
                $this->prepareCars();
                break;
        }

        // 6. Подключение шаблона
        $this->includeComponentTemplate($componentPage);
    }

    private function prepareCars(): void
    {
        global $APPLICATION;
        $APPLICATION->SetTitle("Личный кабинет - Мои автомобили");

        $massAvto = $this->arResult["USER"]['INFO']['MassAvto'] ?? [];
        if (!empty($massAvto) && is_array($massAvto)) {
            foreach ($massAvto as $k => $item) {
                $vin = $item['Avto'] ?? ($item['VIN'] ?? '');
                if (!empty($vin)) {
                    $rawCis = \YApp::httpGet('https://apps.yug-avto.ru/API/get/cis/vehicles/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&vin=' . urlencode($vin));
                    $decodedCis = !empty($rawCis) ? json_decode($rawCis, true) : null;
                    $massAvto[$k]['CIS'] = $decodedCis['items'][0] ?? null;

                    try {
                        $massAvto[$k]['CarInfo'] = $this->getVehicleService()->getCarInfo($this->arResult["USER_GUID"], $vin);
                    } catch (\Exception $e) {
                        $massAvto[$k]['CarInfo'] = [];
                    }
                }
            }
        }
        $this->arResult["VEHICLES"] = $massAvto;
    }

    private function loadVehicleCisData(string $vehicleId): ?array
    {
        if (empty($vehicleId)) return null;
        $raw = \YApp::httpGet('https://apps.yug-avto.ru/API/get/cis/vehicle/used/' . urlencode($vehicleId) . '/?token=ef6541490c8bb9d481d37020b6a1953e&site=yug-avto-expert.ru');
        return !empty($raw) ? json_decode($raw, true) : null;
    }

    private function prepareVehicle(string $vehicleId): void
    {
        global $APPLICATION;
        $cisData = $this->loadVehicleCisData($vehicleId);
        if (empty($cisData) || empty($cisData['vin'])) {
            LocalRedirect('/cabinet/');
            return;
        }

        $vin = $cisData['vin'];
        // Проверка BOLA/IDOR
        $this->getVehicleService()->assertVehicleOwnership($this->arResult["USER_GUID"], $vin);

        $title = trim(($cisData['brand']['name'] ?? '') . ' ' . ($cisData['model']['name'] ?? ''));
        $year = $cisData['general'][4]['value'] ?? '';
        $fullTitle = $title . ($year ? ' ' . $year . ' г.в.' : '');

        $APPLICATION->SetTitle("Личный кабинет - " . $fullTitle);
        $APPLICATION->AddChainItem($fullTitle, '/cabinet/vehicle/' . $vehicleId . '/');

        $carInfo = [];
        try {
            $carInfo = $this->getVehicleService()->getCarInfo($this->arResult["USER_GUID"], $vin);
        } catch (\Exception $e) {}

        $offers = [];
        if (!empty($carInfo['Request'])) {
            try {
                $offers = $this->getVehicleService()->getOffers($this->arResult["USER_GUID"], $vin);
            } catch (\Exception $e) {}
        }

        // Поиск в MassAvto актуальных цен
        $currentCar = null;
        $massAvto = $this->arResult["USER"]['INFO']['MassAvto'] ?? [];
        if (!empty($massAvto) && is_array($massAvto)) {
            foreach ($massAvto as $car) {
                $carVin = strtoupper($car['VIN'] ?? ($car['Avto'] ?? ''));
                if ($carVin === strtoupper($vin)) {
                    $currentCar = $car;
                    break;
                }
            }
        }

        $this->arResult["VEHICLE_ID"] = $vehicleId;
        $this->arResult["CIS_DATA"] = $cisData;
        $this->arResult["CAR_INFO"] = $carInfo;
        $this->arResult["OFFERS"] = $offers;
        $this->arResult["PRICE_C"] = (float)($currentCar['PriceC'] ?? ($massAvto[0]['PriceC'] ?? 0));
        $this->arResult["PRICE"] = (float)($currentCar['Price'] ?? ($massAvto[0]['Price'] ?? 0));
    }

    private function prepareVehicleHistory(string $vehicleId): void
    {
        global $APPLICATION;
        $this->prepareVehicle($vehicleId);

        $APPLICATION->SetTitle("История автомобиля - " . ($this->arResult["CIS_DATA"]['brand']['name'] ?? ''));
        $APPLICATION->AddChainItem('История автомобиля', '');

        $vin = $this->arResult["CIS_DATA"]['vin'] ?? '';
        $hA = [];
        $timestamp_from = !empty($_GET['date_from']) ? strtotime($_GET['date_from']) : (strtotime(date('Y-m-d')) - 14 * 86400);
        $timestamp_to = !empty($_GET['date_to']) ? strtotime($_GET['date_to']) : strtotime(date('Y-m-d 23:59:59'));

        $historyAppeals = $this->arResult["CAR_INFO"]['HistoryAppeals'] ?? [];
        if (!empty($historyAppeals) && is_array($historyAppeals)) {
            foreach ($historyAppeals as $i) {
                $itemTime = !empty($i['Date']) ? strtotime($i['Date']) : 0;
                if ($itemTime >= $timestamp_from && $itemTime <= $timestamp_to) {
                    $hA[] = $i;
                }
            }
        }

        $this->arResult["FILTERED_HISTORY_APPEALS"] = $hA;
        $this->arResult["HISTORY_PRICE"] = $this->arResult["CAR_INFO"]['HistoryPrice'] ?? [];
    }

    private function prepareVehicleOffers(string $vehicleId): void
    {
        global $APPLICATION;
        $this->prepareVehicle($vehicleId);

        $APPLICATION->SetTitle("Предложения - " . ($this->arResult["CIS_DATA"]['brand']['name'] ?? ''));
        $APPLICATION->AddChainItem('Предложения', '');

        $vin = $this->arResult["CIS_DATA"]['vin'] ?? '';
        $userGuid = $this->arResult["USER_GUID"];
        $userId = (int)($GLOBALS['USER']->GetID());

        $status = 'offer_start';
        $timeout = false;
        $error = false;
        $confim = false;
        $notice = '';

        // Поддержка стандартного POST сабмита для обратной совместимости
        if (($_POST['FORM'] ?? '') === 'CONFIM_OFFER') {
            if (!check_bitrix_sessid()) {
                $error = true;
                $status = 'offer_code';
                $notice = 'Срок действия сессии истек.';
            } else {
                $code = trim($_POST['CODE'] ?? '');
                if (!empty($code)) {
                    $isValid = $this->getSmsService()->verifyCode($userId, $code);
                    if ($isValid) {
                        $payload = [
                            'GUID' => $userGuid,
                            'VIN' => $vin,
                            'DOC' => $_POST['DOC'] ?? '',
                            'ACTION' => $_POST['ACTION'] ?? 'accept',
                        ];
                        $confim = $this->getVehicleService()->postOfferDecision($payload);
                        $status = 'offer_send';
                    } else {
                        $error = true;
                        $status = 'offer_code';
                        $notice = 'Неверный код или истек срок действия.';
                    }
                } else {
                    $status = 'offer_code';
                    $this->getSmsService()->sendVerificationCode($userId, $this->arResult["USER_PHONE"]);
                }
            }
        }

        // Обновляем список оферов после возможного сабмита
        $offers = $this->getVehicleService()->getOffers($userGuid, $vin);
        $this->arResult["OFFERS"] = $offers;
        $this->arResult["OFFER_STATUS"] = $status;
        $this->arResult["OFFER_NOTICE"] = $notice;
        $this->arResult["OFFER_CONFIM"] = $confim;
    }

    private function prepareVehicleDocs(string $vehicleId): void
    {
        global $APPLICATION;
        $cisData = $this->loadVehicleCisData($vehicleId);
        if (empty($cisData) || empty($cisData['vin'])) {
            ShowError('Автомобиль не найден.');
            return;
        }

        $vin = $cisData['vin'];
        $userGuid = $this->arResult["USER_GUID"];
        $numDoc = (string)($_GET['doc'] ?? '1');

        // BOLA check
        $this->getVehicleService()->assertVehicleOwnership($userGuid, $vin);

        $rawResponse = $this->getVehicleService()->generateDocument($userGuid, $vin, $numDoc);
        if (empty($rawResponse['Doc'])) {
            ShowError('Не удалось сформировать документ в системе 1С.');
            return;
        }

        $binary = base64_decode($rawResponse['Doc'], true);
        if (empty($binary)) {
            ShowError('Ошибка декодирования содержимого документа.');
            return;
        }

        while (ob_get_level()) {
            ob_end_clean();
        }

        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="document_' . urlencode($numDoc) . '.pdf"');
        header('Content-Length: ' . strlen($binary));
        echo $binary;
        exit;
    }

    private function prepareProfile(): void
    {
        global $APPLICATION;
        $APPLICATION->SetTitle("Личный кабинет - Мои данные");

        $result = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!check_bitrix_sessid()) {
                $result = [
                    'error' => true,
                    'description' => 'Истек срок действия сессии. Пожалуйста, обновите страницу.'
                ];
            } else {
                $formType = $_POST['FORM'] ?? '';
                if ($formType === 'CHANGE_PASSWD') {
                    $oldPass = $_POST['PASSWD'] ?? '';
                    $newPass = $_POST['NEWPASSWD'] ?? '';
                    $confirmPass = $_POST['CONFIMPASSWD'] ?? '';

                    if (\Cabinet::passwdVerify($oldPass, $this->arResult["USER_GUID"])) {
                        if (!empty($newPass) && $newPass === $confirmPass) {
                            if (mb_strlen($newPass) >= 8) {
                                \Cabinet::setPasswd($this->arResult["USER_PHONE"], $newPass);
                                $result = [
                                    'success' => true,
                                    'description' => 'Вы успешно изменили пароль.'
                                ];
                            } else {
                                $result = [
                                    'error' => true,
                                    'description' => 'Пароль должен содержать минимум 8 символов.'
                                ];
                            }
                        } else {
                            $result = [
                                'error' => true,
                                'description' => 'Введенные новые пароли не совпадают.'
                            ];
                        }
                    } else {
                        $result = [
                            'error' => true,
                            'description' => 'Неверно указан текущий пароль.'
                        ];
                    }
                } elseif ($formType === 'DELETE_ACCOUNT') {
                    $reason = trim(($_POST['REASON'] ?? '') . ' ' . ($_POST['CUSTOM_REASON'] ?? ''));
                    $advice = trim($_POST['ADVICE'] ?? '');

                    \Cabinet::sendform([
                        'SENDER' => 'Запрос на удаление аккаунта комитента',
                        'NAME' => $this->arResult["USER"]['INFO']['FIO'] ?? $this->arResult["USER_PHONE"],
                        'PHONE' => $this->arResult["USER_PHONE"],
                        'COMMENT' => "Причина: {$reason}\nПожелания: {$advice}\nGUID: {$this->arResult["USER_GUID"]}"
                    ]);

                    $result = [
                        'success' => true,
                        'description' => 'Ваш запрос на удаление аккаунта принят. Менеджер свяжется с вами для подтверждения.'
                    ];
                }
            }
        }

        $this->arResult["FORM_RESULT"] = $result;
    }

    private function prepareVerify(): void
    {
        global $APPLICATION;
        $APPLICATION->SetTitle("Личный кабинет - Верификация учетной записи");

        $notice = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && (($_POST['ACTION'] ?? '') === 'CHECK_STATUS')) {
            if (!check_bitrix_sessid()) {
                $notice = 'Срок сессии истек. Пожалуйста, обновите страницу.';
            } else {
                $info1C = \Cabinet::getUserByGUID($this->arResult["USER_GUID"]);
                if (!empty($info1C['Status'])) {
                    $GLOBALS['CABINET_USER']['INFO']['Status'] = true;
                    if (!empty($_SESSION['CABINET_USER'])) {
                        $_SESSION['CABINET_USER']['INFO']['Status'] = true;
                    }
                    $this->arResult["IS_VERIFIED"] = true;
                } else {
                    $notice = 'Статус пока не подтвержден в системе 1С. Пожалуйста, обратитесь к сотруднику дилерского центра.';
                }
            }
        }

        $this->arResult["VERIFY_NOTICE"] = $notice;
        $this->arResult["QR_PAYLOAD"] = json_encode(['GUID' => $this->arResult["USER_GUID"]], JSON_UNESCAPED_SLASHES);
    }
}
