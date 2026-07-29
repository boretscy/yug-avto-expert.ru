<?php

    $rs = CIBlockElement::GetList(
        [],
        [
            'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
            'ID' => $arResult['PROPERTIES']['DEALERSHIP']['VALUE'],
            'ACTIVE' => 'Y'
        ],
        false, false,
        ['ID', 'PROPERTY_ADDRESS', 'PROPERTY_BRAND']
    );
    while ( $ob = $rs->GetNextElement() ) {

        $arResult['DEALERSHIP'] = $ob->GetFields();
        $arResult['DEALERSHIP']['LOGO'] = CFile::GetPath( CIBlockElement::GetByID( $arResult['DEALERSHIP']['PROPERTY_BRAND_VALUE'] )->GetNext()['PREVIEW_PICTURE'] );
    }

// Вывод телефона из highloadblock

?>