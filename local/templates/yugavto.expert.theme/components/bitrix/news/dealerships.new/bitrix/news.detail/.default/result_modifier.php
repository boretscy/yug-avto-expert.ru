<?php

$GLOBALS['DEALERSHIP'] = $arResult['PROPERTIES']['EXTERNAL_CODE']['VALUE'];


$arLinks = [];
$rs = CIBlockElement::GetProperty(
    YApp::IBLOCK_BRANDS,
    $arResult['PROPERTIES']['BRAND']['VALUE'],
    [],
    ['CODE'=>'LINK']
);
while ( $ob = $rs->GetNext() ) $arLinks[] = ['LINK'=>$ob['VALUE'], 'CITY'=>$ob['DESCRIPTION']];

$arResult['PROPERTIES']['BRAND']['LINK'] = $arLinks[0]['LINK'];
foreach ( $arLinks as $arLink ) if ( $arLink['CITY'] == $arResult['PROPERTIES']['CITY']['VALUE'] )  $arResult['PROPERTIES']['BRAND']['LINK'] = $arLink['LINK'];

$arResult['PROPERTIES']['BRAND']['PICTURE'] = CFile::GetPath( $arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['PREVIEW_PICTURE'] );

$rs = CIBlockElement::GetList(
    ['active_from' => 'desc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_NEWS,
        'ACTIVE' => 'Y',
        'ACTIVE_DATE' => 'Y',
        'PROPERTY_DEALERSHIP' => $arResult['ID']
    ],
    false,
    ['nTopCount' => 12],
    ['ID', 'IBLOCK_ID', 'NAME', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PREVIEW_TEXT', 'ACTIVE_FROM']
);
while ( $ob = $rs->GetNextElement() ) $arResult['NEWS'][] = $ob->GetFields();

$rs = CIBlockElement::GetList(
    ['IBLOCK_SECTION_ID' => 'DESC'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_HISTORY,
        'ACTIVE' => 'Y',
        'PROPERTY_DEALERSHIP' => $arResult['ID']
    ],
    false, false,
    ['ID', 'IBLOCK_ID', 'NAME', 'SECTION_ID']
);
while ( $ob = $rs->GetNextElement() ) {
    
    $tmp = $ob->GetFields();
    $tmp['SECTION'] = CIBlockSection::GetByID($tmp['IBLOCK_SECTION_ID'])->GetNext()['NAME'];
    $arResult['HISTORY'][] = $tmp;
}

$arResult['MODE'] = ( $arResult['PROPERTIES']['IS_NEW']['VALUE'] == 'Да' ) ? 'new' : 'used';

$apiToken = '34b5ac8b71018c0bc7e5c050ed90b243';
$apiBase = 'https://' . (class_exists('YApp') ? YApp::API_DOMAIN : 'apps.yug-avto.ru') . '/API/get/cis';
$brandParam = ($arResult['MODE'] == 'new' && isset($arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['CODE']))
    ? '&brand=' . $arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['CODE']
    : '';

$randomVehicles = YApp::safeJsonGet(
    $apiBase . '/random_new/' . $arResult['MODE'] . '/?token=' . $apiToken . '&dealership=' . $arResult['PROPERTIES']['EXTERNAL_CODE']['VALUE'] . $brandParam . '&limit=12',
    []
);
$arResult['VEHICLES'] = $randomVehicles['items'] ?? [];

$arResult['COUNT'] = YApp::safeJsonGet(
    $apiBase . '/count/' . $arResult['MODE'] . '/?token=' . $apiToken . '&dealership=' . $arResult['PROPERTIES']['EXTERNAL_CODE']['VALUE'] . $brandParam,
    0
);

?>