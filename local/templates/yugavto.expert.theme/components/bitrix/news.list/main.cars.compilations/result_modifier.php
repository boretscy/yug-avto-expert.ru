<?php
$cities = ( json_decode($_COOKIE['SELECTED_CITY'], true) ) ?: [];
foreach ( $cities as $c ) $res[] = YApp::getCityName($c);

$arResult['VEHICLES'] = json_decode(
    YApp::httpGet('https://apps.yug-avto.ru/API/get/cis/limit/used/?token=ef6541490c8bb9d481d37020b6a1953e&limit=12'.((!empty($res))?'&city='.implode(',',$res):'')),
    true
);

// YApp::sp( $res, true );
// YApp::sp( 'https://apps.yug-avto.ru/API/get/cis/limit/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&limit=12'.((!empty($res))?'&city='.implode(',',$res):''), true );
?>