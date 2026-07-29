<?php

$rs = CIBlockElement::GetList(
    [],
    [
        'IBLOCK_ID' => YApp::IBLOCK_FORM_SETTINGS,
        'CODE' => $arResult['WEB_FORM_NAME']
    ],
    false, false,
    ['ID', 'IBLOCK_ID', 'NAME', 'DETAIL_TEXT', 'PREVIEW_PICTURE', 'DETAIL_PICTURE', 'PROPERTY_TITLE', 'PROPERTY_BACKGROUND', 'PROPERTY_IMAGE', 'PROPERTY_SEMIBLUE']
);
while ( $ob = $rs->GetNextElement() ) $arResult['SETTINGS'] = $ob->GetFields();

if ( array_key_exists('DEALERSHIP', $arResult['arQuestions']) ) {
    
    $dsFilter = [
        'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
        'ACTIVE' => 'Y'
    ];
    if ( $GLOBALS['DEALERSHIP'] ) $dsFilter['ID'] = $GLOBALS['DEALERSHIP']; 
    if ( $_GET['dealership'] ) $dsFilter['CODE'] = $_GET['dealership']; 
    $rs = CIBlockElement::GetList(
        [],
        $dsFilter,
        false, false,
        ['ID', 'NAME']
    );
    while ( $ob = $rs->GetNextElement() ) $arResult['DEALERSHIPS'][] = $ob->GetFields();
}

// YApp::sp( $arResult );