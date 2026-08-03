<?php 

header('Content-type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE,HEAD,OPTIONS");
header("Access-Control-Allow-Headers: Origin,Content-Type,Accept,Authorization");  

use Bitrix\Main\Loader;


define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('NO_AGENT_CHECK', true);
define('DisableEventsCheck', true);
define('NOT_CHECK_PERMISSIONS', true);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

include __DIR__.'/vendor/YAApi.php';

// CIS API proxy — forward /api/v1/cis/* to Go API
$route = YAApi::Route();
if ($route['entity'] === 'v1' && $route['id'] === 'cis') {
    $path = $_SERVER['REQUEST_URI'];
    $goUrl = 'https://' . YApp::GO_API_DOMAIN . $path;
    $ch = curl_init($goUrl);
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 15,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false,
    ]);
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, file_get_contents('php://input'));
    }
    $resp = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    http_response_code($httpCode);
    echo $resp !== false ? $resp : '{"error":"proxy error"}';
    return;
}

switch ( YAApi::Route()['id'] ) {

    case 'render':
        switch ( YAApi::Route()['entity'] ) {

            case 'vehicles': $apiRes = YAApi::apiRenderVehicles( YAApi::Route()['data'] ); break;
            case 'main_filter_select': $apiRes = YAApi::apiRenderMainFilterSelect( $_POST ); break;
            case 'main_filter_button': $apiRes = YAApi::apiRenderMainFilterLink( $_POST ); break;
            case 'main_filter_brands': $apiRes = YAApi::apiRenderMainFilterBrands( $_POST ); break;
            case 'main_compilations': $apiRes = YAApi::apiRenderMainCompilations( $_POST ); break;
        
            default: $apiRes = '';
        }
        echo $apiRes;
        break;
    
    default:
        switch ( YAApi::Route()['entity'] ) {
            case 'offers': $apiRes = YAApi::apiGetOffers( YAApi::Route()['data'] ); break;
            case 'dealership': $apiRes = YAApi::apiGetDealership( YAApi::Route()['data'] ); break;
            case 'dealerships': $apiRes = YAApi::apiGetDealerships( YAApi::Route()['data'] ); break;
            case 'brands': $apiRes = YAApi::apiGetBrands( YAApi::Route()['data'] ); break;
            case 'models': $apiRes = YAApi::apiGetModels( YAApi::Route()['data'] ); break;
            case 'send': $apiRes = YAApi::apiSendform( $_POST ); break;
            case 'main_filter': $apiRes = YAApi::apiMainFilter( $_POST ); break;
            case 'main_cards_links': $apiRes = YAApi::apiMainCardsLinks( $_POST ); break;


            case 'cabinet':
                switch ( YAApi::Route()['id'] ) {
                    case 'AUTH': break;
                }
                break;


            default: $apiRes = ['error' => 404, 'description' => 'Неверный запрос'];
        }
        echo json_encode($apiRes);
        break;

    

    
}



?>