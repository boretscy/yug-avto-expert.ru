<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$GLOBALS['SHOWROOM_MODE'] = 'used';
$CISMeta = YApp::getCISMeta();
$GLOBALS['META'] = $CISMeta;
Yapp::sp( $CISMeta, true );
$GLOBALS['SHOWROOM_LEVEL'] = $CISMeta['level'];
if ( $CISMeta['status'] === '404_vehicles' ) {
	if ($APPLICATION->RestartWorkarea()) {
		require(\Bitrix\Main\Application::getDocumentRoot()."/404_.php");
		die();
	}
} 
if ( $CISMeta['status'] === 404 ) {
	CHTTP::SetStatus("404 Not Found");
	@define("ERROR_404","Y");
	if ($APPLICATION->RestartWorkarea()) {
		require(\Bitrix\Main\Application::getDocumentRoot()."/404.php");
		die();
	}
}
?>
<script type='application/ld+json'>
    {
		<?php if ( $CISMeta['level'] == 'vehicle' ) { ?>
		"@context": "http://schema.org/",
		"@type": "Product",
        "name": "<?= $CISMeta['meta']['title'];?>",
        "image": "<?= (($CISMeta['meta']['image'])?:SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg');?>",
        "description": "<?= $CISMeta['meta']['description'];?>",
		"brand": {
			"@type": "Brand",
			"name": "<?= $CISMeta['meta']['brand'];?>"
		},
		"offers": {
			"@type": "Offer",
			"priceCurrency": "RUB",
			"price": "<?= $CISMeta['meta']['price'];?>",
			"url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>",
			"availability": "https://schema.org/InStock",
			"itemCondition": "https://schema.org/NewCondition"
		}
		<?php } else { ?>
		"@context": "http://www.schema.org",
        "@type": "Organization",
        "name": "<?= $CISMeta['meta']['title'];?>",
        "url": "<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>",
        "image": "<?= (($CISMeta['meta']['image'])?:SITE_TEMPLATE_PATH.'/assets/images/logo-25.jpg');?>",
        "description": "<?= $CISMeta['meta']['description'];?>"
		<?php } ?>
    }
</script>
<?php

$APPLICATION->SetPageProperty("description", $CISMeta['meta']['description']);
$APPLICATION->SetPageProperty('title', $CISMeta['meta']['title']);
$APPLICATION->SetPageProperty('image', $CISMeta['meta']['image']);
$APPLICATION->SetPageProperty("canonical", $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
?>

<?$APPLICATION->IncludeComponent(
	"bitrix:news.detail", 
	"showroom", 
	array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_ELEMENT_CHAIN" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"BROWSER_TITLE" => "-",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "A",
		"CHECK_DATES" => "Y",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_CODE" => "",
		"ELEMENT_ID" => "256",
		"FIELD_CODE" => array(
			0 => "",
			1 => "",
		),
		"IBLOCK_ID" => "15",
		"IBLOCK_TYPE" => "settings",
		"IBLOCK_URL" => "",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"MESSAGE_404" => "",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Страница",
		"PROPERTY_CODE" => array(
			0 => "DETAIL_OFFERS",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "Y",
		"SET_CANONICAL_URL" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "Y",
		"SET_META_KEYWORDS" => "Y",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "Y",
		"SHOW_404" => "N",
		"STRICT_SECTION_CHECK" => "N",
		"USE_PERMISSIONS" => "N",
		"USE_SHARE" => "N",
		"COMPONENT_TEMPLATE" => "showroom",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO"
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>