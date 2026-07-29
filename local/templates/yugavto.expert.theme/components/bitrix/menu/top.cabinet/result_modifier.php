<?php 

$res['MENU'] = $arResult;

foreach ( $res['MENU'] as $k => $item ) {

    if ( file_exists($_SERVER['DOCUMENT_ROOT'].$item['LINK'].'.top_menu_items.menu.php') ) {
        
        include $_SERVER['DOCUMENT_ROOT'].$item['LINK'].'.top_menu_items.menu.php';
        $res['MENU'][$k]['SUBMENU'] = $aMenuLinks;
    }
    if ( $item['LINK'] == '/cabinet/contacts/' ) {
        $res['MENU'][$k]['SUBMENU'][1][1] = 'tel:'.YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);
        $res['MENU'][$k]['SUBMENU'][1][0] = '<img src=\'/local/templates/yugavto.expert.theme/components/bitrix/menu/top.cabinet/images/phone.svg\' /> '.YApp::phoneOut($GLOBALS['itemHl']['UF_VALUE']);
    }
}

$arResult = $res;

