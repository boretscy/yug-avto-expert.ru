<?php 
	if ( preg_match('#/page-1/?($|\?)#', $_SERVER['REQUEST_URI']) ) {
		$cleanUri = preg_replace('#/page-1/?($|\?)#', '/$1', $_SERVER['REQUEST_URI']);
		$cleanUri = preg_replace('#//+#', '/', $cleanUri);
		header("HTTP/1.1 301 Moved Permanently"); 
		header("Location: ".$cleanUri); 
		exit();
	}
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
<?php if ( $data['meta']['meta']['level'] == 'vehicle' ) { 
    $brandName = trim($data['brand']['name'] ?? $data['meta']['meta']['brand'] ?? '');
    $modelName = trim($data['model']['name'] ?? '');
    $prodYear = $data['general'][4]['value'] ?? $data['year'] ?? '';
    
    $cleanTitle = trim($brandName . ' ' . $modelName);
    if ($prodYear) {
        $cleanTitle .= ' ' . $prodYear . ' года';
    }

    $imagesList = [];
    if (!empty($data['images']) && is_array($data['images'])) {
        foreach ($data['images'] as $imgItem) {
            $urlStr = '';
            if (is_string($imgItem)) {
                $urlStr = $imgItem;
            } elseif (is_array($imgItem)) {
                $urlStr = $imgItem['src'] ?? $imgItem['url'] ?? $imgItem[0] ?? '';
            }
            if ($urlStr && is_string($urlStr)) {
                $imagesList[] = explode('?', $urlStr)[0];
            }
        }
    }
    if (empty($imagesList) && !empty($data['meta']['meta']['image']) && is_string($data['meta']['meta']['image'])) {
        $imagesList[] = explode('?', $data['meta']['meta']['image'])[0];
    }
    if (empty($imagesList)) {
        $imagesList[] = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg';
    }

    $descText = trim($data['meta']['meta']['description'] ?? '');
    if (!empty($data['general']) && is_array($data['general'])) {
        $specs = [];
        foreach ($data['general'] as $spec) {
            if (!empty($spec['name']) && !empty($spec['value'])) {
                $specs[] = $spec['name'] . ': ' . $spec['value'];
            }
        }
        if (!empty($specs)) {
            $descText .= "\n\nХарактеристики:\n• " . implode("\n• ", $specs);
        }
    }

    $schemaData = [
        "@context" => "https://schema.org/",
        "@type" => "Product",
        "name" => $cleanTitle ?: htmlspecialchars($data['meta']['meta']['title'] ?? ''),
        "description" => $descText,
        "image" => count($imagesList) === 1 ? $imagesList[0] : $imagesList,
        "brand" => [
            "@type" => "Brand",
            "name" => $brandName
        ],
        "offers" => [
            "@type" => "Offer",
            "priceCurrency" => "RUB",
            "price" => (float)($data['min_price'] ?? $data['price'] ?? $data['meta']['meta']['price'] ?? 0),
            "url" => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
            "availability" => ($data['status']['id'] == 1 || !isset($data['status']['id'])) ? "https://schema.org/InStock" : "https://schema.org/OutOfStock",
            "itemCondition" => "https://schema.org/UsedCondition",
            "seller" => [
                "@type" => "AutoDealer",
                "name" => "ООО «Юг-Авто Эксперт»",
                "url" => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST']
            ]
        ]
    ];
    if ($prodYear) {
        $schemaData['productionDate'] = (string)$prodYear;
    }
?>
<script type='application/ld+json'>
<?= json_encode($schemaData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
</script>
<?php } else { 
    $offerList = [];
    $lowPrice = 0;
    $highPrice = 0;

    if (!empty($data['items']) && is_array($data['items'])) {
        $prices = [];
        foreach (array_slice($data['items'], 0, 24) as $item) {
            $itemPrice = (float)($item['min_price'] ?? $item['price'] ?? 0);
            if ($itemPrice > 0) {
                $prices[] = $itemPrice;
            }

            $itemImg = '';
            if (!empty($item['images']) && is_array($item['images'])) {
                $firstImg = $item['images'][0]['preview'] ?? $item['images'][0]['preview_large'] ?? $item['images'][0]['src'] ?? '';
                if (is_string($firstImg)) {
                    $itemImg = explode('?', $firstImg)[0];
                }
            }
            if (!$itemImg && !empty($item['body']['code'])) {
                $itemImg = "https://" . YApp::GO_API_DOMAIN . "/upload/Cis/bodies/" . $item['body']['code'] . "_sm.webp";
            }

            $brandName = trim($item['brand']['name'] ?? '');
            $modelName = trim($item['model']['name'] ?? '');
            $year = $item['year'] ?? '';
            $itemName = trim($brandName . ' ' . $modelName);
            if ($year) {
                $itemName .= ' ' . $year;
            }

            $cityAlias = '';
            if ($filter['city'] && !is_array($filter['city'])) {
                $cityAlias = $app->getCityAlias($filter['city']);
            }
            $itemUrl = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'] . $app->Conf()['baseUrl'] . '/' . (($cityAlias)?$cityAlias.'/':'') . ($item['brand']['code'] ?? '') . '/' . ($item['model']['code'] ?? '') . '/' . ($item['id'] ?? '') . '/';

            $offerList[] = [
                "@type" => "Offer",
                "name" => $itemName ?: "Автомобиль с пробегом",
                "price" => $itemPrice,
                "priceCurrency" => "RUB",
                "url" => $itemUrl,
                "availability" => ($item['status']['id'] == 1 || !isset($item['status']['id'])) ? "https://schema.org/InStock" : "https://schema.org/OutOfStock",
                "itemCondition" => "https://schema.org/UsedCondition",
                "image" => $itemImg ?: null
            ];
        }

        if (!empty($prices)) {
            $lowPrice = min($prices);
            $highPrice = max($prices);
        }
    }

    $listSchema = [
        "@context" => "https://schema.org/",
        "@type" => "Product",
        "name" => htmlspecialchars_decode($data['meta']['meta']['title'] ?? 'Автомобили с пробегом'),
        "description" => htmlspecialchars_decode($data['meta']['meta']['description'] ?? ''),
        "offers" => [
            "@type" => "AggregateOffer",
            "offerCount" => (int)($data['filter']['totalCount'] ?? count($data['items'] ?? [])),
            "priceCurrency" => "RUB",
            "lowPrice" => $lowPrice,
            "highPrice" => $highPrice,
            "offers" => $offerList
        ]
    ];
?>
<script type='application/ld+json'>
<?= json_encode($listSchema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT); ?>
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
            $dealershipJson = file_get_contents('https://'.$_SERVER['HTTP_HOST'].'/api/dealership?code='.$data['dealership']['id']);
            if ($dealershipJson) {
                $dealershipJson = preg_replace('/^\xEF\xBB\xBF/', '', $dealershipJson);
                $data['_dealership'] = json_decode($dealershipJson, true);
            }
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


