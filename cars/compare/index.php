<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Page\Asset;
$Asset = Asset::getInstance();
?>
<?php
 define('ENTITY', 'CIS_COMPARE');
if ( $_GET['action'] == 'clear' ) {
    unset($_COOKIE[ENTITY]);
    setcookie(ENTITY, json_encode([]), 3600*24*14, '/');
    $items = [];
}
if ( $_GET['action'] == 'delete' ) {
    $items = ( json_decode($_COOKIE[ENTITY], true) ) ?: [];
    $indx = array_search( (int)$_GET['vehicle'], $items );
    if ( $indx !== false ) unset( $items[$indx] );
    sort($items);
    setcookie(ENTITY, json_encode($items), time()+3600*24*14, '/');
}

if ( !$items) $items = ( json_decode($_COOKIE[ENTITY], true) ) ?: [];

$conf = require __DIR__.'/../used/vendor/Config.php';
require __DIR__.'/../used/vendor/YApp.Showroom.class.php';
$app = new YAppShowroom($conf);

$Asset->addCss($app->Conf()['baseUrl'].'/assets/css/libs/hint.min.css');
$Asset->addCss($app->Conf()['baseUrl'].'/assets/css/app.css?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['baseUrl'].'/assets/css/app.css'));
$Asset->addJs($app->Conf()['baseUrl'].'/assets/js/app.js?'.md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['baseUrl'].'/assets/js/app.js'));

$filter = $app->makeFilter(CURRENT_URL, $_GET);
$filter['id'] = implode(',', $items);
unset( $filter['action'], $filter['vehicle'] );

if ( !empty($items) ) {
	$data = json_decode( file_get_contents($app->makeApiUrl($filter, (($filter['vehicle'])?'vehicle':'vehicles'))), true );
	foreach ( $data['items'] as $item ) $cur_items[] = $item['id'];
	foreach ( $items as $k => $item ) if ( !in_array( $item, $cur_items ) ) unset( $items[$k] );
	sort($items);
    setcookie(ENTITY, json_encode($items), time()+3600*24*14, '/');
}
$GLOBALS['META'] = $data['meta'] = json_decode( file_get_contents('https://apps.yug-avto.ru/API/get/cis/meta/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&site=yug-avto-expert.ru&entity=used&brand=compare'), true );
?>
<script type='application/ld+json'>
    {
		<?php if ( $data['meta']['level'] == 'vehicle' ) { ?>
		"@context": "http://schema.org/",
		"@type": "Product",
        "name": "<?= $data['meta']['meta']['title'];?>",
        "image": "<?= (($data['meta']['meta']['image'])?:SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg');?>",
        "description": "<?= $data['meta']['meta']['description'];?>",
		"brand": {
			"@type": "Brand",
			"name": "<?= $data['meta']['meta']['brand'];?>"
		},
		"offers": {
			"@type": "Offer",
			"priceCurrency": "RUB",
			"price": "<?= $data['meta']['meta']['price'];?>",
			"url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>",
			"availability": "https://schema.org/InStock",
			"itemCondition": "https://schema.org/NewCondition"
		}
		<?php } else { ?>
		"@context": "http://www.schema.org",
        "@type": "Organization",
        "name": "<?= $data['meta']['meta']['title'];?>",
        "url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>",
        "image": "<?= (($data['meta']['meta']['image'])?:SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg');?>",
        "description": "<?= $data['meta']['meta']['description'];?>"
		<?php } ?>
    }
</script>

<div id="YappsShowroom">
    <div class="cover bg-yawhite position-absolute w-100 h-100 d-none"></div>
    <?php 
        
        $APPLICATION->SetPageProperty("description", $data['meta']['meta']['description']);
        $APPLICATION->SetPageProperty('title', $data['meta']['meta']['title']);
        $APPLICATION->SetPageProperty('image', $data['meta']['meta']['image']);
        $APPLICATION->SetPageProperty("canonical", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
        include __DIR__.'/../used/views/compare.php';

        include __DIR__.'/../used/views/forms/offer-modal.php';
        include __DIR__.'/../used/views/forms/credit-modal.php';
        include __DIR__.'/../used/views/forms/trade-in-modal.php';
        include __DIR__.'/../used/views/forms/sell-modal.php';
    ?>
</div>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>


