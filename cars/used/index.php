<?php 
	$p = explode('/', $_SERVER['REQUEST_URI']);
	if ( !!$p[4] && $p[3] == $p[4] ) {
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: ".implode('/', array_slice($p, 0, 4))); 
	}
    if ( $p[3] == 'maykop' || $p[3] == 'novorossiysk' ) {
        unset($p[3]);
        header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: ".implode('/', $p)); 
    }
?>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Page\Asset;
$Asset = Asset::getInstance();

$APPLICATION->SetTitle("Title");
?>
<?php

$conf = require __DIR__.'/vendor/Config.php';
require __DIR__.'/vendor/YApp.Showroom.class.php';
$app = new YAppShowroom($conf);

$Asset->addCss($app->Conf()['baseUrl'].'/assets/css/libs/hint.min.css');
$Asset->addCss($app->Conf()['baseUrl'].'/assets/css/libs/jquery.fancybox.min.css');
$Asset->addCss($app->Conf()['baseUrl'].'/assets/css/app.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['baseUrl'].'/assets/css/app.css'));
$Asset->addJs($app->Conf()['baseUrl'].'/assets/js/libs/jquery.fancybox.min.js');
$Asset->addJs($app->Conf()['baseUrl'].'/assets/js/libs/share.js');
$Asset->addJs($app->Conf()['baseUrl'].'/assets/js/app.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['baseUrl'].'/assets/js/app.js'));

$filter = $app->makeFilter(CURRENT_URL, $_GET);
if ( !$filter['city'] || $filter['city'] == 'Майкоп' || $filter['city'] == 'Новороссийск' ) $filter['city'] = $app->getCityCookie();
// YApp::sp($filter, true);

$data = json_decode( file_get_contents($app->makeApiUrl($filter, (($filter['vehicle'])?'vehicle':'vehicles'))), true );
// YApp::sp($app->makeApiUrl($filter, (($filter['vehicle'])?'vehicle':'vehicles')), true);

if ( $data['force_404'] ) {
	CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404","Y");
	if ($APPLICATION->RestartWorkarea()) {
		require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
		die();
	}
}

$GLOBALS['META'] = $data['meta'];
if ( (!$filter['vehicle'] && $data['items'] == NULL)  ) {
    // if ( !$filter['vehicle'] && !$filter['model'] && $filter['brand'] ) {
	// 	unset($filter['brand']);
	// } elseif ( !$filter['vehicle'] && $filter['model'] ) {
	// 	unset($filter['model']);
	// } elseif ( $filter['vehicle'] ) {
	// 	unset($filter['vehicle']);
	// }
    // unset($filter['price'], $filter['dealership'], $filter['transmission'], $filter['engine'], $filter['drive'], $filter['body'], $filter['color'], $filter['volume'], $filter['power'], $filter['year']);
	// header("HTTP/1.1 301 Moved Permanently"); 
	// header("Location: ".$app->makeFilterUrl($filter));
	// exit();
    CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404","Y");
	if ($APPLICATION->RestartWorkarea()) {
		require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
		die();
	}
} elseif ( ($filter['vehicle'] && $data == NULL) ) {
	$GLOBALS['CIS_FILTER'] = $filter;
	CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404","Y");
	if ($APPLICATION->RestartWorkarea()) {
		require(\Bitrix\Main\Application::getDocumentRoot()."/404Cis.php");
		die();
	}
}
// Yapp::sp($GLOBALS['META'], true);

$data['FAVORITES'] = ( json_decode($_COOKIE['CIS_FAVORITES'], true) ) ?: [];
$data['COMPARE'] = ( json_decode($_COOKIE['CIS_COMPARE'], true) ) ?: [];

if ( !$filter['vehicle'] ) {    
    $data['filter'] = json_decode( file_get_contents($app->makeApiUrl($filter, 'filter')), true );
    $data['filter']['dropLists']['brands'] = $data['brands'] = json_decode( file_get_contents($app->makeApiUrl($filter, 'brands')), true )['dropLists']['brands'];
    $data['current_page'] = ($_GET['page'] ) ? (int)$_GET['page'] : 1;
    array_multisort(array_column($data['brands'], 'vehicles'), SORT_DESC, SORT_NUMERIC, $data['brands']);
} 

if ( $data['meta']['status'] === '404_vehicles' || $data['meta']['status'] === 404 || ( !$filter['vehicle'] && !$data['items'] ) ) {
	CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404","Y");
	if ($APPLICATION->RestartWorkarea()) {
		require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
		die();
	}
}

$data['OnWay'] = false;
$data['InStock'] = false;
$data['Discount'] = false;
?>
<?php if ( $data['meta']['meta']['level'] == 'vehicle' ) { ?>
<script type='application/ld+json'>
{
	"@context": "http://schema.org/",
	"@type": "Product",
	"name": "<?= htmlspecialchars($data['meta']['meta']['title']);?>",
	"description": "<?= htmlspecialchars($data['meta']['meta']['description']);?>",
	"image": "<?= (($data['meta']['meta']['image'])?explode('?', $data['meta']['meta']['image'])[0]:$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg');?>",
	"brand": {
		"@type": "Brand",
		"name": "<?= htmlspecialchars($data['meta']['meta']['brand']);?>"
	},
	"offers": {
		"@type": "Offer",
		"priceCurrency": "RUB",
		"price": "<?= $data['meta']['meta']['price'];?>",
		"url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>",
		"availability": "https://schema.org/InStock",
		"itemCondition": "https://schema.org/UsedCondition"
	}
}
</script>
<?php } else { ?>
<script type='application/ld+json'>
{
	"@context": "http://schema.org/",
	"@type": "ItemList",
	"name": "<?= htmlspecialchars($data['meta']['meta']['title']);?>",
	"description": "<?= htmlspecialchars($data['meta']['meta']['description']);?>",
	"url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>"
}
</script>
<?php } ?>

<div id="YappsShowroom" class="position-relative">
    <div class="cover bg-yawhite position-absolute w-100 h-100 d-none"></div>
    <?php 
        if ( $filter['vehicle'] ) {
            $APPLICATION->SetPageProperty("description", $data['meta']['meta']['description']);
            $APPLICATION->SetPageProperty('title', $data['meta']['meta']['title']);
            $APPLICATION->SetPageProperty('image', explode('?', $data['meta']['meta']['image'])[0]);
            $APPLICATION->SetPageProperty("canonical", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].explode('?', $_SERVER['REQUEST_URI'])[0]);
            $Asset->addJs('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU');
            $data['_dealership'] = json_decode( file_get_contents('https://yug-avto-expert.ru/api/dealership?code='.$data['dealership']['id']), true );
            foreach ( $app->makeVehicleBreadcrumbs($data) as $item ) $APPLICATION->AddChainItem($item['text'], $item['link']);
            include __DIR__.'/views/vehicle.php';
        } else {
            $APPLICATION->SetPageProperty("description", $data['meta']['meta']['description']);
            $APPLICATION->SetPageProperty('title', $data['meta']['meta']['title']);
            $APPLICATION->SetPageProperty('image', explode('?', $data['meta']['meta']['image'])[0]);

            if ( $filter['page'] ) {
                $pfilter = $filter;
                unset($pfilter['page']);
                $c_url = parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$app->makeFilterUrl($pfilter, []));
                $canonical = $c_url['scheme'].'://'.$c_url['host'].$c_url['path'];
                // YApp::sp($c_url, true);
            } else {
                $canonical = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            }
            $APPLICATION->SetPageProperty("canonical", $canonical);


            if ( $_SERVER['REQUEST_URI'] == '/cars/used/krasnodar/' ) $APPLICATION->SetPageProperty("canonical", 'https://yug-avto-expert.ru/cars/used/');
            foreach ( $app->makeFilterBreadcrumbs($filter, $data['filter']) as $item ) $APPLICATION->AddChainItem($item['text'], $item['link']);
            include __DIR__.'/views/filter.php';
            include __DIR__.'/views/vehicles.php';
        }

        include __DIR__.'/views/forms/offer-modal.php';
        include __DIR__.'/views/forms/credit-modal.php';
        include __DIR__.'/views/forms/trade-in-modal.php';
        include __DIR__.'/views/forms/sell-modal.php';
    ?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>


