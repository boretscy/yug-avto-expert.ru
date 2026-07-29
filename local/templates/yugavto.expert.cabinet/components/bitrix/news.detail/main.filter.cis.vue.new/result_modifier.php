<?php
    $arResult['SHOWROOMS']['baseURL'] = $arResult['PROPERTIES']['BASE_URL']['VALUE'];
    $arResult['SHOWROOMS']['blueMode'] = 'semi';
    $arResult['SHOWROOMS']['bodies'] = false;

    for ( $i = 1; $i <= 5; $i++ ) {
        if ( $arResult['PROPERTIES']['ITEM_'.(($i<10)?'0':'').$i]['VALUE'] ) {
            $tmp = [
                'code' => $arResult['PROPERTIES']['ITEM_'.(($i<10)?'0':'').$i]['DESCRIPTION'],
                'name' => $arResult['PROPERTIES']['ITEM_'.(($i<10)?'0':'').$i]['VALUE']
            ];
            foreach ( $arResult['PROPERTIES']['ITEM_'.(($i<10)?'0':'').$i.'_PARAMS']['VALUE'] as $k => $p ) $tmp['params'][$p] = $arResult['PROPERTIES']['ITEM_'.(($i<10)?'0':'').$i.'_PARAMS']['DESCRIPTION'][$k];
            $arResult['SHOWROOMS']['items'][] = $tmp;
        }
    }
?>