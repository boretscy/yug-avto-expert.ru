<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->IncludeComponent(
    "yugavto:cabinet",
    ".default",
    [
        "SEF_MODE" => "Y",
        "SEF_FOLDER" => "/cabinet/",
        "SEF_URL_TEMPLATES" => [
            "cars" => "",
            "vehicle" => "vehicle/#VEHICLE_ID#/",
            "vehicle_history" => "vehicle/#VEHICLE_ID#/history/",
            "vehicle_offers" => "vehicle/#VEHICLE_ID#/offers/",
            "vehicle_docs" => "vehicle/#VEHICLE_ID#/docs/",
            "profile" => "me/",
            "verify" => "verify/",
        ],
        "VARIABLE_ALIASES" => [
            "VEHICLE_ID" => "VEHICLE_ID",
        ],
    ],
    false
);

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
