<?php

    // Percent DATE_ACTIVE_TO 
    // $arResult['DATE_ACTIVE_PERCENT'] = intval( (int)explode(
    //     ' ',
    //     FormatDate(
    //         'ddiff', 
    //         time(), 
    //         MakeTimeStamp($arResult['DATE_ACTIVE_TO'])+24*60*60
    //     )
    // )[0] / (int)explode(
    //     ' ', 
    //     FormatDate(
    //         'ddiff', 
    //         MakeTimeStamp($arResult['ACTIVE_FROM']), 
    //         MakeTimeStamp($arResult['DATE_ACTIVE_TO'])+24*60*60
    //     )
    // )[0] * 100 );
    
    if ( !empty($arResult['PROPERTIES']['DEALERSHIP']['VALUE']) ) $GLOBALS['DEALERSHIP'] = $arResult['PROPERTIES']['DEALERSHIP']['VALUE'];
    if ( !empty($arResult['PROPERTIES']['BRAND']['VALUE']) ) $GLOBALS['BRAND'] = $arResult['PROPERTIES']['BRAND']['VALUE'];

    $arResult['TIMER'] = YApp::getTimer( time(), strtotime($arResult['DATE_ACTIVE_TO']) );

    if ( $arResult['PROPERTIES']['DEALERSHIP']['VALUE'] ) {

        $arResult['MODE'] = 'used';
        $rs = CIBlockElement::GetList(
            ['NAME'=>'ASC'],
            [
                'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
                'ID' => $arResult['PROPERTIES']['DEALERSHIP']['VALUE'],
                'ACTIVE' => 'Y'
            ],
            false, false,
            ['ID', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_EXTERNAL_CODE', 'PROPERTY_IS_NEW', 'PROPERTY_EXTERNAL_CODE' ]
        );
        while ( $ob = $rs->GetNextElement() ) {

            $tmp = $ob->GetFields();
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_ADDRESS'] = $tmp['PROPERTY_ADDRESS_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_PHONE'] = $tmp['PROPERTY_PHONE_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_COORDS_LAT'] = $tmp['PROPERTY_COORDS_LAT_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_COORDS_LON'] = $tmp['PROPERTY_COORDS_LON_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_EXTERNAL_CODE'] = $tmp['PROPERTY_EXTERNAL_CODE_VALUE'];
            $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$tmp['ID']]['PROPERTY_IS_NEW'] = $tmp['PROPERTY_IS_NEW_VALUE'];

            $arResult['DCs'][] = $tmp['PROPERTY_EXTERNAL_CODE_VALUE'];
            if ( $tmp['PROPERTY_IS_NEW_VALUE'] ) $arResult['MODE'] = 'new';
        }
    }

    $arResult['MODE'] = ( !in_array('service', $arResult['PROPERTIES']['TAG']['VALUE_XML_ID']) ) ? 'new' : 'used';
    if ( !in_array('service', $arResult['PROPERTIES']['TAG']['VALUE_XML_ID']) ) {

        $arResult['VEHICLES'] = json_decode(
            file_get_contents('https://apps.yug-avto.ru/API/get/cis/limit/'.$arResult['MODE'].'/?token=34b5ac8b71018c0bc7e5c050ed90b243&limit=12'.(($arResult['DCs'])?'&dealership='.implode(',', $arResult['DCs']):'')),
            true
        );
    }
    // YApp::sp( $arResult['DCs'], true );
    
?>