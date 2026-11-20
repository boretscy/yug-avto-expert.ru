<?php

namespace Cabinet\Services;

use Cabinet\Client\OneCClient;
use Bitrix\Main\AccessDeniedException;

class VehicleService
{
    private $client;

    public function __construct(OneCClient $client = null)
    {
        $this->client = $client ?? new OneCClient();
    }

    /**
     * Защита от BOLA / IDOR (CWE-639): проверка принадлежности автомобиля комитенту
     */
    public function assertVehicleOwnership(string $userGuid, string $vin): bool
    {
        if (empty($userGuid) || empty($vin)) {
            throw new AccessDeniedException("Не указан идентификатор пользователя или VIN.");
        }

        $myCars = $this->getMyCars($userGuid);
        $cleanVin = strtoupper(trim($vin));

        $isOwner = false;
        if (!empty($myCars) && is_array($myCars)) {
            // В ответе 1С автомобили могут быть в MassAvto или в корне массива
            $carsList = $myCars['MassAvto'] ?? $myCars;
            if (is_array($carsList)) {
                foreach ($carsList as $car) {
                    $carVin = strtoupper(trim($car['VIN'] ?? ($car['Avto'] ?? '')));
                    if ($carVin === $cleanVin) {
                        $isOwner = true;
                        break;
                    }
                }
            }
        }

        if (!$isOwner) {
            error_log(sprintf("BOLA/IDOR Violation blocked: User GUID %s attempted access to vehicle VIN %s", $userGuid, $vin));
            throw new AccessDeniedException("Доступ к автомобилю запрещен: автомобиль не принадлежит вашему аккаунту.");
        }

        return true;
    }

    /**
     * Получение списка автомобилей комитента
     */
    public function getMyCars(string $userGuid): array
    {
        if (empty($userGuid)) {
            return [];
        }

        $res = $this->client->request('MyCars', 'POST', [], [], ['GUID' => $userGuid]);
        return is_array($res) ? $res : [];
    }

    /**
     * Получение детальной статистики по автомобилю (с проверкой прав владения)
     */
    public function getCarInfo(string $userGuid, string $vin): array
    {
        $this->assertVehicleOwnership($userGuid, $vin);

        $res = $this->client->request('CarInfo', 'GET', [], ['GUID' => $userGuid, 'VIN' => $vin]);
        return is_array($res) ? $res : [];
    }

    /**
     * История изменения цены
     */
    public function getPriceHistory(string $userGuid, string $vin): array
    {
        $this->assertVehicleOwnership($userGuid, $vin);

        $res = $this->client->request('PriceChangeHistory', 'GET', [], ['GUID' => $userGuid, 'VIN' => $vin]);
        return is_array($res) ? $res : [];
    }

    /**
     * Предложения по переоценке
     */
    public function getOffers(string $userGuid, string $vin): array
    {
        $this->assertVehicleOwnership($userGuid, $vin);

        $res = $this->client->request('OffersForCarRevaluation', 'GET', [], ['GUID' => $userGuid, 'VIN' => $vin]);
        return is_array($res) ? $res : [];
    }

    /**
     * Согласование или отказ от переоценки (строго через проверку прав)
     */
    public function postOfferDecision(string $userGuid, string $vin, string $docGuid, bool $accept)
    {
        $this->assertVehicleOwnership($userGuid, $vin);

        if (empty($docGuid)) {
            return false;
        }

        $payload = [
            'GUIDDoc' => $docGuid,
            'Status' => $accept,
        ];

        return $this->client->request(
            'OffersForCarRevaluation',
            'POST',
            $payload,
            ['GUID' => $userGuid, 'VIN' => $vin]
        );
    }

    /**
     * Получение сгенерированного PDF документа
     */
    public function getDocument(string $userGuid, string $vin, string $numDoc): array
    {
        $this->assertVehicleOwnership($userGuid, $vin);

        $res = $this->client->request(
            'GenerateADocument',
            'GET',
            [],
            ['GUID' => $userGuid, 'VIN' => $vin],
            ['NumDoc' => $numDoc]
        );

        return is_array($res) ? $res : [];
    }
}
