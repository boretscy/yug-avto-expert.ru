<?php
    $url = 'https://apps.yug-avto.ru/API/get/cis/count/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&city='.YApp::setCityCookie();
    $arResult['COUNTS']['PASS'] = file_get_contents($url);
    $arResult['COUNTS']['COMM'] = $arResult['COUNTS']['PASS'];

    // YApp::sp($arResult['ITEMS'], true);