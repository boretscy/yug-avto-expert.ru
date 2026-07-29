<?php
// 404
if ( empty($arResult['ITEMS']) ) {

    CHTTP::SetStatus("404 Not Found");
    @define("ERROR_404","Y");
}


// get TAGS for FILTER
$arResult['vuefilter']['items']['tag']['title'] = 'Теги';
$rs = CIBlockPropertyEnum::GetList(
    ['sort'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_OFFERS,
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
$arResult['vuefilter']['items']['brand']['title'] = 'Марка';
$rs = CIBlockElement::GetList(
    ['name'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_BRANDS,
        'ACTIVE' => 'Y'
    ],
    false, false,
    ['ID', 'NAME', 'CODE', 'PREVIEW_PICTURE']  
);
while ( $ob = $rs->GetNextElement() ) {

    $tmp = $ob->GetFields();
    if ( $tmp['CODE'] != 'greatwall' ) {
        
        $arResult['vuefilter']['items']['brand']['items'][] = [
            'id' => $tmp['ID'],
            'code' => $tmp['CODE'], 
            'name' => $tmp['NAME'],
            'selected' => ( in_array($tmp['CODE'], explode(',', str_replace('`', '', $_GET['brand']))) ) ? true : false
        ];
    }
}

// get DEALERSHIPS for FILTER
$arResult['vuefilter']['items']['dealership']['title'] = 'Автосалон';
$rs = CIBlockElement::GetList(
    ['name'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'ACTIVE' => 'Y',
        'ID' => CIBlockElement::SubQuery(
            'PROPERTY_DEALERSHIP',
            [
                'IBLOCK_ID' => YApp::IBLOCK_OFFERS,
                'ACTIVE' => 'Y',
                '!PROPERTY_DEALERSHIP_VALUE' => false
            ]
        )
    ],
    false, false,
    ['ID', 'NAME', 'CODE', 'PROPERTY_BRAND']  
);
while ( $ob = $rs->GetNextElement() ) {

    $tmp = $ob->GetFields();

    foreach ( $arResult['vuefilter']['items']['brand']['items'] as $item ) if ( (string)$tmp['PROPERTY_BRAND_VALUE'] == $item['id'] ) $relation = $item['code'];
    $arResult['vuefilter']['items']['dealership']['items'][] = [
        'code' => $tmp['CODE'], 
        'name' => $tmp['NAME'], 
        'relation' => $relation,
        'selected' => ( in_array($tmp['CODE'], explode(',', str_replace('`', '', $_GET['dealership']))) ) ? true : false
    ];
}

$FILTER = $_GET;
unset($FILTER['brand'],$FILTER['dealership'],$FILTER['tag']);
$arResult['vuefilter']['clearlink'] = '/offers/?'.http_build_query($FILTER);

$arResult['vuefilter']['get'] = $_GET;
unset($arResult['vuefilter']['get']['brand'],$arResult['vuefilter']['get']['dealership'],$arResult['vuefilter']['get']['tag']);
$arResult['vuefilter']['baseurl'] = '/offers/';

$arResult['vuefilter']['items']['city'] = [
    'items' => null,
    'title' => null
];
$arResult['vuefilter']['items']['mode'] = [
    'items' => null,
    'title' => null
];

$arResult['vuefilter']['view'] = [
    'city' => false,
    'brand' => false,
    'dealership' => true,
    'tag' => true,
    'mode' => false
];

?>