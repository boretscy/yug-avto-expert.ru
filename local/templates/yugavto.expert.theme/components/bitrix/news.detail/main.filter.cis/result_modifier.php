<?php

    $filter = [
        'token' => 'ef6541490c8bb9d481d37020b6a1953e',
        'site' => $_SERVER['HTTP_HOST'],
        'city' => explode(',',YApp::setCityCookie())
    ];
    $url = 'https://apps.yug-avto.ru/API/get/cis/filter/used/?'.http_build_query($filter);
    // Yapp::sp($url);
    $arResult['FILTER'] = json_decode( file_get_contents($url), true );
    // while ( $arResult['FILTER'] == null ) $arResult['FILTER'] = json_decode( file_get_contents($url), true );

    $tmp =  $arResult['FILTER']['dropLists']['brands'];
    array_multisort(array_column($tmp, 'vehicles'), SORT_DESC, SORT_NUMERIC, $tmp);
    $arResult['FILTER']['BRANDS'] =  array_chunk($tmp, 18)[0];
?>