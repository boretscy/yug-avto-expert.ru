<?php

    $arResult['CITIES'] = ['all'=>'Все'];
    foreach ( $arResult['ITEMS'] as $arItem ) {

        $arResult['CITIES'][$arItem['PROPERTIES']['CITY']['VALUE_XML_ID']] = $arItem['PROPERTIES']['CITY']['VALUE'];
        $arResult['MAP'][$arItem['PROPERTIES']['CITY']['VALUE_XML_ID']]['ITEMS'][] = [
            'NAME' => $arItem['NAME'],
            'COORDS' => [
                'LAT' => (float)$arItem['PROPERTIES']['COORDS_LAT']['VALUE'],
                'LON' => (float)$arItem['PROPERTIES']['COORDS_LON']['VALUE']
            ],
            'BALLOON' => [
                'TITLE' => $arItem['NAME'],
                'CONTENT' => '<p>Адрес: '.$arItem['PROPERTIES']['ADDRESS']['VALUE'].'</p><ul><li>'.((is_countable($arItem['PROPERTIES']['SERVICES']['VALUE']))?implode('</li><li>', $arItem['PROPERTIES']['SERVICES']['VALUE']):$arItem['PROPERTIES']['SERVICES']['VALUE']).'</li></ul>',
                'FOOTER' => '<a href="https://yandex.ru/maps/?pt='.(float)$arItem['PROPERTIES']['COORDS_LON']['VALUE'].','.(float)$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].'&z=15&l=map" target="_blank" alt="'.$arItem['NAME'].'">Построить маршрут</a>'
            ]
        ];
        $arResult['MAP']['all']['ITEMS'][] = [
            'NAME' => $arItem['NAME'],
            'COORDS' => [
                'LAT' => (float)$arItem['PROPERTIES']['COORDS_LAT']['VALUE'],
                'LON' => (float)$arItem['PROPERTIES']['COORDS_LON']['VALUE']
            ],
            'BALLOON' => [
                'TITLE' => $arItem['NAME'],
                'CONTENT' => '<p>Адрес: '.$arItem['PROPERTIES']['ADDRESS']['VALUE'].'</p><ul><li>'.((is_countable($arItem['PROPERTIES']['SERVICES']['VALUE']))?implode('</li><li>', $arItem['PROPERTIES']['SERVICES']['VALUE']):$arItem['PROPERTIES']['SERVICES']['VALUE']).'</li></ul>',
                'FOOTER' => '<a href="https://yandex.ru/maps/?pt='.(float)$arItem['PROPERTIES']['COORDS_LON']['VALUE'].','.(float)$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].'&z=15&l=map" target="_blank" alt="'.$arItem['NAME'].'">Построить маршрут</a>'
            ]
        ];
    }
    $arResult['MAP']['all']['CENTER'] = [45.348370, 39.393297];
    $arResult['MAP']['all']['ZOOM'] = 6.2;
    $arResult['MAP']['krd']['CENTER'] = [45.017730, 39.089559];
    $arResult['MAP']['krd']['ZOOM'] = 10;
    $arResult['MAP']['yabl']['CENTER'] = [44.976065, 38.944735];
    $arResult['MAP']['yabl']['ZOOM'] = 15;
    $arResult['MAP']['mkp']['CENTER'] = [44.615059, 40.067709];
    $arResult['MAP']['mkp']['ZOOM'] = 14;
    $arResult['MAP']['nvr']['CENTER'] = [44.786325, 37.675018];
    $arResult['MAP']['nvr']['ZOOM'] = 16;
    $arResult['MAP']['sochi']['CENTER'] = [43.607409, 39.739869];
    $arResult['MAP']['sochi']['ZOOM'] = 16;
    $arResult['MAP']['rostov']['CENTER'] = [47.215419, 39.612874];
    $arResult['MAP']['rostov']['ZOOM'] = 16;


    $arResult['MAP']['all']['ITEMS'] = $arResult['MAP']['all']['ITEMS'] ?? [];
    if (isset($arResult['MAP']['all']['ITEMS'][9])) {
        unset($arResult['MAP']['all']['ITEMS'][9]);
    }
    if (!empty($arResult['MAP']['all']['ITEMS']) && is_array($arResult['MAP']['all']['ITEMS'])) {
        sort($arResult['MAP']['all']['ITEMS']);
    }
    unset($arResult['MAP']['stavropol']);

    unset( $arResult['CITIES']['stavropol'] );

    // YApp::sp($arResult['CITIES'], true);
?>