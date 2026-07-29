<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

/**
 * @global CMain $APPLICATION
 */

global $APPLICATION;

//delayed function must return a string
if(empty($arResult))
	return "";

$arResult = array_merge(
	[[
		'TITLE' => 'Главная',
		'LINK' => '/'
	]],
	$arResult
);

$strReturn = '<div class="container mt-3 mb-2 breadcrumbs" itemscope itemtype="http://schema.org/BreadcrumbList"><div class="row"><div class="col text-minus">';

$itemSize = count($arResult);
for($index = 0; $index < $itemSize; $index++)
{
	if ($arResult[$index]["LINK"]!='/cabinet/vehicle/') {
		$title = htmlspecialcharsex($arResult[$index]["TITLE"]);
		$arrow = '';
		if ( $index > 0 ) $arrow = '<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#arrow-left"></use></svg>';

		if($arResult[$index]["LINK"] <> "" && $index != $itemSize-1)
		{
			
			$strReturn .= '
				<div class="breadcrumbs-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					'.$arrow.'
					<a href="'.$arResult[$index]["LINK"].'" title="'.$title.'" itemprop="item" class="text-decoration-none c-yamiddlegray c-h-yablue">
						<span itemprop="name">'.$title.'</span>
					</a>
					<meta itemprop="position" content="'.($index + 1).'" />
				</div>';
		}
		else
		{
			$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . ($_SERVER['HTTP_HOST'] ?? '') . ($_SERVER['REQUEST_URI'] ?? '');
			$strReturn .= '
				<div class="breadcrumbs-item" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
					'.$arrow.'
					<span itemprop="name">'.$title.'</span>
					<meta itemprop="item" content="'.$currentUrl.'" />
					<meta itemprop="position" content="'.($index + 1).'" />
				</div>';
		}
	}
}

$strReturn .= '</div></div></div>';

if ( $arResult[1]['LINK'] == '/c/' ) {
	$arResult[1]['LINK'] = '/c/used/';
	// $strReturn = "<div id=\"YAppsBreadcrumbs\" items='".json_encode($arResult)."'></div>";
	// foreach ( glob($_SERVER['DOCUMENT_ROOT'].'/local/vue-apps/vue-breadcrumbs/dist/js/*.js') as $file ) {

	// 	$arF = explode('/', $file);
	// 	$strReturn .= '<script  src="/local/vue-apps/vue-breadcrumbs/dist/js/'.$arF[count($arF)-1].'"></script>';
	// }
}

return $strReturn;
