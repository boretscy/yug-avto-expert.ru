<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>

<div id="CISMAinBlock" data='<?= json_encode($arResult['SHOWROOMS']);?>' style="min-height: 150px;"></div>

<?php 
	foreach ( glob($_SERVER['DOCUMENT_ROOT'].'/local/vue-apps/vue-used-cis-block-on-main/dist/js/*.js') as $file ) {

		$arF = explode('/', $file);
		$this->addExternalJS('/local/vue-apps/vue-used-cis-block-on-main/dist/js/'.$arF[count($arF)-1]);
	}
?>