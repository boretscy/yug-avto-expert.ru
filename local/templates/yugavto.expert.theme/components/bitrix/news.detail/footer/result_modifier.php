<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

$arResult['BRANDS'] = YApp::getCache('footer', 'brands', 3600);
if (empty($arResult['BRANDS'])) {
    $rawBrands = YApp::httpGet('https://apps.yug-avto.ru/API/get/cis/footerbrands/used/?token=ef6541490c8bb9d481d37020b6a1953e');
    $brands = !empty($rawBrands) ? json_decode($rawBrands, true) : [];
    if (!empty($brands) && is_array($brands)) {
        array_multisort(array_column($brands, 'vehicles'), SORT_DESC, SORT_NUMERIC, $brands);
        $chunks = array_chunk($brands, 16);
        $arResult['BRANDS'] = $chunks[0] ?? [];
        if (!empty($arResult['BRANDS'])) {
            YApp::setCache('footer', 'brands', $arResult['BRANDS']);
        }
    } else {
        $arResult['BRANDS'] = [];
    }
}
