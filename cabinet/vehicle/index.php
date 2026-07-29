<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет - Автомобиль");
if ( !$cab::checkauth() ) header('Location: /cabinet/login/');
if ( !$GLOBALS['CABINET_USER']['INFO']['Status'] ) header('Location: /cabinet/verify/');
?>
<?php
if ( !!$user['PROPERTY_CHANGE_PASSWD_VALUE'] ) header('Location: /cabinet/me/#cabinet-me-passwd');
?>
<?php
    $vehicle = explode('/', $_SERVER['REQUEST_URI'])[3];
    if ( $vehicle ) {
        $data = json_decode( file_get_contents('https://apps.yug-avto.ru/API/get/cis/vehicle/used/'.$vehicle.'/?token=ef6541490c8bb9d481d37020b6a1953e&site=yug-avto-expert.ru'), true );
    }
?>
<script>let AppRes = <?= json_encode($data);?>;</script>
<?php
    switch ( explode('/', $_SERVER['REQUEST_URI'])[4] ) {
        case 'history':
            $APPLICATION->AddChainItem($data['brand']['name'].' '.$data['model']['name'].' '.$data['general'][4]['value'].' г.в.', '/cabinet/vehicle/'.$vehicle.'/');
            include __DIR__.'/history.php'; 
            break;
        case 'offers': 
            $APPLICATION->AddChainItem($data['brand']['name'].' '.$data['model']['name'].' '.$data['general'][4]['value'].' г.в.', '/cabinet/vehicle/'.$vehicle.'/');
            include __DIR__.'/offers.php'; 
            break;
        case 'docs': 
            $APPLICATION->AddChainItem($data['brand']['name'].' '.$data['model']['name'].' '.$data['general'][4]['value'].' г.в.', '/cabinet/vehicle/'.$vehicle.'/');
            include __DIR__.'/docs.php'; 
            break;
        default: 
            $APPLICATION->AddChainItem($data['brand']['name'].' '.$data['model']['name'].' '.$data['general'][4]['value'].' г.в.', '');
            include __DIR__.'/main.php'; 
            break;
    }
?>

<script type="text/javascript"  src="/cabinet/script.js?1"></script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>