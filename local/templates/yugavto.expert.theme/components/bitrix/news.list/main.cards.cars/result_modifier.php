<?php
    $url = 'https://apps.yug-avto.ru/API/get/cis/count/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&!dealership=1489&city='.YApp::setCityCookie();
    $arResult['COUNTS']['PASS'] = file_get_contents($url);
    $url = 'https://apps.yug-avto.ru/API/get/cis/count/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&dealership=1489&city='.YApp::setCityCookie();
    $arResult['COUNTS']['COMM'] = file_get_contents($url);

    // YApp::sp($arResult['ITEMS'], true);