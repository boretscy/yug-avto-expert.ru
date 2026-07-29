<?php
if ( (!$_GET['mode'] && !$_COOKIE['MODE']) || (!$_GET['mode'] && $_COOKIE['MODE'] == 'list') ) {

    setcookie('MODE', 'list', 0, '/');
    $arResult['MODE'] = 'list';

} elseif ( !$_GET['mode'] && $_COOKIE['MODE'] == 'map' ) {

    setcookie('MODE', 'map', 0, '/');
    $arResult['MODE'] = 'map';

} elseif ( $_GET['mode'] == 'list' ) {
    
    setcookie('MODE', 'list', 0, '/');
    $arResult['MODE'] = 'list';

} elseif ( $_GET['mode'] == 'map' ) {

    setcookie('MODE', 'map', 0, '/');
    $arResult['MODE'] = 'map';
}

$brands = [];
foreach ( $arResult['ITEMS'] as $k => $arItem ) {

    $arLinks = [];
    $rs = CIBlockElement::GetProperty(
        YApp::IBLOCK_BRANDS,
        $arItem['PROPERTIES']['BRAND']['VALUE'],
        [],
        ['CODE'=>'LINK']
    );
    while ( $ob = $rs->GetNext() ) $arLinks[] = ['LINK'=>$ob['VALUE'], 'CITY'=>$ob['DESCRIPTION']];

    $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['LINK'] = $arLinks[0]['LINK'];
    foreach ( $arLinks as $arLink ) if ( $arLink['CITY'] == $arItem['PROPERTIES']['CITY']['VALUE'] )  $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['LINK'] = $arLink['LINK'];

    $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['PICTURE'] = CFile::GetPath( $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['PREVIEW_PICTURE'] );
    $arResult['ITEMS'][$k]['PROPERTIES']['BRAND']['TITLE'] = $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['NAME'];

    if ( !array_key_exists($arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE'], $brands) ) {
        
        $brands[$arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE']] = [
            'CODE' => $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE'],
            'NAME' => $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['NAME']
        ];
    }
        

    $rs = CIBlockElement::GetList(
        ['IBLOCK_SECTION_ID' => 'DESC'],
        [
            'IBLOCK_ID' => YApp::IBLOCK_HISTORY,
            'ACTIVE' => 'Y',
            'PROPERTY_DEALERSHIP' => $arItem['ID']
        ],
        false, ['nTopCount' => 4],
        ['ID', 'IBLOCK_ID', 'NAME', 'SECTION_ID']
    );
    while ( $ob = $rs->GetNextElement() ) {
        
        $tmp = $ob->GetFields();
        $tmp['SECTION'] = CIBlockSection::GetByID($tmp['IBLOCK_SECTION_ID'])->GetNext()['NAME'];
        $arResult['ITEMS'][$k]['HISTORY'][] = $tmp;
    }
}

foreach ( $arResult['ITEMS'] as $arItem ) $brands[$arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['BRAND']['VALUE']]['CODE']]['RELATION'][] = $arItem['PROPERTIES']['CITY']['VALUE_XML_ID'];

// get CITIES for FILTER
$rs = CIBlockPropertyEnum::GetList(
    ['sort'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'CODE' => 'CITY'
    ]
);
while ( $ob = $rs->Fetch() ) {

    $arResult['vuefilter']['items']['city']['items'][] = [
        'code' => $ob['XML_ID'], 
        'name' => $ob['VALUE'], 
        'selected' => ( in_array($ob['VALUE'], explode(',', str_replace('`', '', $_GET['city']))) ) ? true : false
    ];
}
unset(
    // $arResult['vuefilter']['items']['city']['items'][4],
    $arResult['vuefilter']['items']['city']['items'][6],
    // $arResult['vuefilter']['items']['city']['items'][6]
);
sort( $arResult['vuefilter']['items']['city']['items']);
$arResult['vuefilter']['items']['city']['title'] = count($arResult['vuefilter']['items']['city']['items']).' '.YApp::getWorld(count($arResult['vuefilter']['items']['city']['items']), 'c');

// get TAGS for FILTER
$rs = CIBlockPropertyEnum::GetList(
    ['sort'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'CODE' => 'TAG'
    ]
);
while ( $ob = $rs->Fetch() ) {

    $arResult['vuefilter']['items']['tag']['items'][] = [
        'code' => $ob['XML_ID'], 
        'name' => $ob['VALUE'], 
        'selected' => ( in_array($ob['XML_ID'], explode(',', $_GET['tag']))) ? true : false
    ];
}

// get BRANDS for FILTER
foreach ( $brands as $item ) {

    $arResult['vuefilter']['items']['brand']['items'][] = [
        'code' => $item['CODE'], 
        'name' => $item['NAME'],
        'relation' => array_unique($item['RELATION']),
        'selected' => ( in_array($item['CODE'], explode(',', str_replace('`', '', $_GET['brand']))) ) ? true : false
    ];
}
$arResult['vuefilter']['items']['brand']['title'] = count($arResult['vuefilter']['items']['brand']['items']).' '.YApp::getWorld(count($arResult['vuefilter']['items']['brand']['items']), 'b');

// get MODES for FILTER
$arResult['vuefilter']['items']['mode']['items'][] = [
    'code' => 'map', 
    'name' => 'На карте',
    'selected' => (  $arResult['MODE'] == 'map') ? true : false
];
$arResult['vuefilter']['items']['mode']['items'][] = [
    'code' => 'list', 
    'name' => 'Списком',
    'selected' => (  $arResult['MODE'] == 'list') ? true : false
];


$FILTER = $_GET;
unset($FILTER['brand'],$FILTER['dealership'],$FILTER['tag'],$FILTER['city']);
$arResult['vuefilter']['clearlink'] = '/dealerships/?'.http_build_query($FILTER);

$arResult['vuefilter']['get'] = $_GET;
unset($arResult['vuefilter']['get']['brand'],$arResult['vuefilter']['get']['city'],$arResult['vuefilter']['get']['tag']);
$arResult['vuefilter']['baseurl'] = '/dealerships/';

$arResult['vuefilter']['items']['dealership'] = [
    'items' => null,
    'title' => null
];

$arResult['vuefilter']['view'] = [
    'city' => true,
    'brand' => true,
    'dealership' => false,
    'tag' => true,
    'mode' => true
];
$arResult['MAP_ZOOM'] = 6.2;
    $arResult['MAP_CENTER'] = [45.348370, 39.393297];

//  FOR MAP
// foreach ( $arResult['ITEMS'] as $item ) $cc[] = $item['PROPERTIES']['CITY']['VALUE'];
// if ( in_array('Сочи', $cc) && in_array('Ростов-на-Дону', $cc) )  {
//     $arResult['MAP_ZOOM'] = 6.2;
//     $arResult['MAP_CENTER'] = [45.348370, 39.393297];
// } elseif ( in_array('Ростов-на-Дону', $cc) && in_array('Майкоп', $cc) )  {
//     $arResult['MAP_ZOOM'] = 7;
//     $arResult['MAP_CENTER'] = [46.033612, 39.854723];
// }


// YApp::sp( $cc, true );
?>