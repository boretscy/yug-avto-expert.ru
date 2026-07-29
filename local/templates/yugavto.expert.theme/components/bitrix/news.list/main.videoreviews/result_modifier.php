<?php

    foreach ($arResult['ITEMS'] as $k => $arItem)
        $arResult['ITEMS'][$k]['VIDEO_REVIEW_CODE'] = explode(
            '=',
            explode(
                '&',
                parse_url($arItem['PROPERTIES']['VIDEO']['VALUE'])['query']
            )[0]
        )[1];