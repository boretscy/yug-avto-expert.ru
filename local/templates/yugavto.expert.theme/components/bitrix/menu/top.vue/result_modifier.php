<?php 

$res['MENU'] = $arResult;

$rs = CIBlockPropertyEnum::GetList(
    ['sort'=>'asc'],
    [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'CODE' => 'CITY'
    ]
);
while ( $ob = $rs->Fetch() ) $res['CITIES'][] = ['code'=>$ob['XML_ID'],'name'=>$ob['VALUE']];
unset(
    $res['CITIES'][3],
    $res['CITIES'][4],
    $res['CITIES'][5],
    $res['CITIES'][6]
);

foreach ( $res['MENU'] as $k => $item ) {

    if ( file_exists($_SERVER['DOCUMENT_ROOT'].$item['LINK'].'.top_menu_items.menu.php') ) {
        
        include $_SERVER['DOCUMENT_ROOT'].$item['LINK'].'.top_menu_items.menu.php';
        $res['MENU'][$k]['SUBMENU'] = $aMenuLinks;
    }
    if ( $item['LINK'] == '/cars/' ) $res['MENU'][$k]['LINK'] = '/cars/used/';
}


$arResult = $res;

