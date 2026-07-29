<?php

$rs = CIBlockElement::GetList(
    [],
    [
        'IBLOCK_ID' => YApp::IBLOCK_SEO,
        'PROPERTY_PATH' => Yapp::getSEOPath($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])
    ],
    false, false,
    ['ID', 'DETAIL_TEXT']
);
while ( $ob = $rs->GetNextElement() ) $arResult['SEO_TEXT'] = $ob->GetFields()['DETAIL_TEXT'];
if ( !$arResult['SEO_TEXT'] && $GLOBALS['META']['meta']['seo_text'] ) $arResult['SEO_TEXT'] = '<h2 class="fw-normal">'.$GLOBALS['META']['meta']['seo_title'].'</h2><p>'.$GLOBALS['META']['meta']['seo_text'].'</p>';

$arResult['BRANDS'] = YApp::getCache('footer', 'brands', 3600);
if ( !$arResult['BRANDS'] ) {
    $brands = json_decode( file_get_contents('https://apps.yug-avto.ru/API/get/cis/footerbrands/used/?token=34b5ac8b71018c0bc7e5c050ed90b243'), true );
    array_multisort(array_column($brands, 'vehicles'), SORT_DESC, SORT_NUMERIC, $brands);
    $arResult['BRANDS'] = array_chunk($brands, 16)[0];
    YApp::setCache('footer', 'brands', $arResult['BRANDS']);
}
?>