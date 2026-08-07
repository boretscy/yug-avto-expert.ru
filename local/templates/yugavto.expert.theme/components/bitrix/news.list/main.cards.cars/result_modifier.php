<?php
    $url = 'https://apps.yug-avto.ru/API/get/cis/count/used/?token=ef6541490c8bb9d481d37020b6a1953e&city='.YApp::setCityCookie();
    $arResult['COUNTS']['PASS'] = file_get_contents($url);
    $arResult['COUNTS']['COMM'] = $arResult['COUNTS']['PASS'];

    // YApp::sp($arResult['ITEMS'], true);