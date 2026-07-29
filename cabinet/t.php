<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет");

$test_guid = '77deac4c-16f6-11f1-a166-00155dca01c6';

// YApp::sp( password_hash( 'Wn^uWt9D', PASSWORD_DEFAULT ) );
// YApp::sp( md5( substr( md5('https://yug-avto-expert.ru/cabinet/'), 0, -10).$test_guid ) );

// YApp::sp( $cab::getCabUserBySSID('412d816bd99a5cd07da95fcbc5081246') );
// YApp::sp( json_encode(['qwe'=>'qweqwe', 'bool_true'=>true, 'bool_false'=>false]) );

YApp::sp( $cab::getUserByGUID($test_guid) );
// YApp::sp( $cab::getCarInfo($test_guid, 'LE4LG5EBXRL062267') );



require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>