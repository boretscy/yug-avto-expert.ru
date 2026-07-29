<?php

    if ( $arResult['PROPERTIES']['VIDEO']['VALUE'] ) {

        foreach ( explode('&', parse_url($arResult['PROPERTIES']['VIDEO']['VALUE'])['query']) as $item ) {

            $tmp = explode('=', $item);
            if ( $tmp[0] == 'v' ) $arResult['VIDEO_REVIEW_CODE'] = $tmp[1];
        }
    }
?>