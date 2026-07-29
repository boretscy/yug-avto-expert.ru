<?php
#!/usr/bin/php

use Bitrix\Main\Loader;


define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', 'Y');
define('NO_AGENT_STATISTIC','Y');
define('NO_AGENT_CHECK', true);
define('DisableEventsCheck', true);
define('NOT_CHECK_PERMISSIONS', true);

require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

Loader::includeModule("iblock");
Loader::includeModule("cfile");

$brands = json_decode( file_get_contents('https://apps.yug-avto.ru/API/get/cis/brandsmodels/new/?token=34b5ac8b71018c0bc7e5c050ed90b243'), true);

foreach ( $brands as $brand ) {

    $b_id = null;
    $ss = CIBlockSection::GetList(
        [],
        [  
            'IBLOCK_ID' => YApp::IBLOCK_PAGES,
            'CODE' => $brand['code']
        ],
        false,
        ['ID'],
        false
    );
    while ( $ob = $ss->GetNext() ) $b_id = $ob['ID'];

    if ( !$b_id ) {

        $bs = CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => YApp::IBLOCK_BRANDS,
                'CODE' => $brand['code']
            ],
            false, false,
            ['ID']
        );
        while ( $ob = $bs->GetNextElement() ) $br_id = $ob->GetFields()['ID'];

        $bs = new CIBlockSection;
        $arIns = [
            'ACTIVE' => 'Y',
            'IBLOCK_ID' => YApp::IBLOCK_PAGES,
            'NAME' => $brand['name'],
            'CODE' => $brand['code'],
            'UF_PAGES_BRAND' => $br_id
        ];
        $b_id = $bs->Add($arIns);
    }

    foreach ( $brand['_models'] as $model ) {

        $m_id = null;
        $rs = CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => YApp::IBLOCK_PAGES,
                'IBLOCK_SECTION_ID' => $b_id,
                'CODE' => $model['code']
            ],
            false,false,
            ['ID']
        );
        while ( $ob = $rs->GetNextElement() ) $m_id = $ob->GetFields()['ID'];
        
        if ( !$m_id ) {

            $el = new CIBlockElement;
            $arIns = [
                'IBLOCK_ID' => YApp::IBLOCK_PAGES,
                'IBLOCK_SECTION_ID' => $b_id,
                'ACTIVE' => 'Y',
                'NAME' => $model['name'],
                'CODE' => $model['code'],
                'PROPERTY_VALUES' => [
                    'EXTERNAL_PICTURE' => $model['image'],
                    'EXTERNAL_CODE' => $model['ext_id']
                ]
            ];
            $m_id = $el->Add($arIns);
        }

    }

}

YApp::sp( $brands[2] );
