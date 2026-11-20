<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arComponentParameters = [
    "PARAMETERS" => [
        "VARIABLE_ALIASES" => [
            "VEHICLE_ID" => ["NAME" => "ID автомобиля"],
        ],
        "SEF_MODE" => [
            "cars" => [
                "NAME" => "Список автомобилей",
                "DEFAULT" => "",
                "VARIABLES" => [],
            ],
            "vehicle" => [
                "NAME" => "Детальная страница автомобиля",
                "DEFAULT" => "vehicle/#VEHICLE_ID#/",
                "VARIABLES" => ["VEHICLE_ID"],
            ],
            "vehicle_history" => [
                "NAME" => "История обращений и цен автомобиля",
                "DEFAULT" => "vehicle/#VEHICLE_ID#/history/",
                "VARIABLES" => ["VEHICLE_ID"],
            ],
            "vehicle_offers" => [
                "NAME" => "Предложения по переоценке",
                "DEFAULT" => "vehicle/#VEHICLE_ID#/offers/",
                "VARIABLES" => ["VEHICLE_ID"],
            ],
            "vehicle_docs" => [
                "NAME" => "Формирование документов",
                "DEFAULT" => "vehicle/#VEHICLE_ID#/docs/",
                "VARIABLES" => ["VEHICLE_ID"],
            ],
            "profile" => [
                "NAME" => "Профиль пользователя",
                "DEFAULT" => "me/",
                "VARIABLES" => [],
            ],
            "verify" => [
                "NAME" => "Верификация учетной записи",
                "DEFAULT" => "verify/",
                "VARIABLES" => [],
            ],
        ],
    ],
];
