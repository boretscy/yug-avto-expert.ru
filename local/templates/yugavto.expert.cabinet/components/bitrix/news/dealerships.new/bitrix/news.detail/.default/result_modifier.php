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

$arResult['VEHICLES'] = json_decode(
    file_get_contents('https://apps.yug-avto.ru/API/get/cis/limit/'.$arResult['MODE'].'/?token=34b5ac8b71018c0bc7e5c050ed90b243&dealership='.$arResult['PROPERTIES']['EXTERNAL_CODE']['VALUE'].(($arResult['MODE']=='new')?'&brand='.$arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['CODE']:'').'&limit=12'),
    true
);

$arResult['COUNT'] = json_decode(
    file_get_contents('https://apps.yug-avto.ru/API/get/cis/count/'.$arResult['MODE'].'/?token=34b5ac8b71018c0bc7e5c050ed90b243&dealership='.$arResult['PROPERTIES']['EXTERNAL_CODE']['VALUE'].(($arResult['MODE']=='new')?'&brand='.$arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['BRAND']['VALUE']]['CODE']:'')),
    true
);

//YApp::sp($arResult['PROPERTIES']['ADDRESS'], true);

?>