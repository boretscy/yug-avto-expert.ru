<?php
#!/usr/bin/php

$dd = '/var/www/admin/data/www/yug-avto-expert.ru';
require_once $dd.'/local/php_interface/vendor/autoload.php';

$url = 'https://apps.yug-avto.ru/API/get/cis/vehicles/used?token=34b5ac8b71018c0bc7e5c050ed90b243';
$vehicles = json_decode( file_get_contents($url), true)['items'];
$google = []; $log = [];

if ( is_countable($vehicles) && count($vehicles) ) {
    
    // yml
    $yml .= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.PHP_EOL;
    $yml .= '<yml_catalog date="'.date('Y-m-d H:s').'">'.PHP_EOL;
    $yml .= '<shop>'.PHP_EOL;
    $yml .= '<name>Юг-Авто Эксперт</name>'.PHP_EOL;
    $yml .= '<company>ООО "Юг-Авто Эксперт"</company>'.PHP_EOL;
    $yml .= '<url>https://yug-avto-expert.ru/</url>'.PHP_EOL;
    $yml .= '<currencies><currency rate="1" id="RUR"/></currencies>'.PHP_EOL;
    $yml .= '<categories>'.PHP_EOL;
    $yml .= '<category id="9999999998">Автомобили с пробегом Юг-Авто Эксперт</category>'.PHP_EOL;

    $cats = [];
    foreach ( $vehicles as $v ) {
        if ( $v['brand']['code'] && $v['model']['code'] ) {
            if ( !in_array($v['brand']['code'], array_keys($cats)) ) {
                $cats[$v['brand']['code']] = [
                    'name' => $v['brand']['name'],
                    'id' => $v['brand']['ext_id'],
                    'cats' => []
                ];
            }
            if ( !in_array($v['model']['code'],  array_keys($cats[$v['brand']['code']]['cats'])) ) {
                $cats[$v['brand']['code']]['cats'][$v['model']['code']] = [
                    'name' => $v['model']['name'],
                    'id' => $v['model']['ext_id'],
                ];
            }
        }
    }
    foreach ( $cats as $b) {
        $yml .= '<category id="'.$b['id'].'" parentId="9999999998">'.$b['name'].'</category>'.PHP_EOL;
        foreach ( $b['cats'] as $m ) {
            $yml .= '<category id="'.$m['id'].'" parentId="'.$b['id'].'">'.$m['name'].'</category>'.PHP_EOL;
        }
    }

    $yml .= '</categories>'.PHP_EOL;
    $yml .= '<sets>'.PHP_EOL;
    $yml .= '<set id="premium"><name>Премиум</name><url>https://yug-avto-expert.ru/cars/used/?dealership=1502</url></set>'.PHP_EOL;
    $yml .= '<set id="business"><name>Для бизнеса</name><url>https://yug-avto-expert.ru/cars/used/?dealership=1489</url></set>'.PHP_EOL;
    $yml .= '<set id="bigfamily"><name>Для больших семей</name><url>https://yug-avto-expert.ru/cars/used/?body=minivan</url></set>'.PHP_EOL;
    $yml .= '<set id="offroad"><name>Покорители бездорожья</name><url>https://yug-avto-expert.ru/cars/used/?body=suv&amp;drive=full</url></set>'.PHP_EOL;
    $yml .= '<set id="city"><name>Для города</name><url>https://yug-avto-expert.ru/cars/used/?body=sedan,hatchback,liftback</url></set>'.PHP_EOL;
    $yml .= '</sets>'.PHP_EOL;
    $yml .= '<offers>'.PHP_EOL;
    
    foreach ( $vehicles as $v ) {
        // yml
        if ( $v['type'] == 'vehicle' && in_array($v['dealership']['id'], [1364,1367,1489,1492,1499,1502,1533]) ) {

            $yml .= '<offer id="'.$v['id'].'" available="true">'.PHP_EOL;
            $yml .= '<url>https://yug-avto-expert.ru/cars/used/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/</url>'.PHP_EOL;
            $yml .= '<picture>'.$v['image'].'</picture>'.PHP_EOL;
            $yml .= '<name>'.$v['brand']['name'].' '.$v['model']['name'].' '.(($v['equipment'])?str_replace('&', '-', $v['equipment']):'').' '.(($v['_general'][2])?:'').'</name>'.PHP_EOL;
            $yml .= '<price>'.$v['min_price'].'</price>'.PHP_EOL;
            $yml .= '<vendor>'.$v['brand']['name'].'</vendor>'.PHP_EOL;
            $yml .= '<categoryId>'.$v['model']['ext_id'].'</categoryId>'.PHP_EOL;
            $yml .= '<currencyId>RUR</currencyId>'.PHP_EOL;
    
            $sets = [];
            if ( $v['dealership']['id'] == 1502 ) $sets[] = 'premium';
            if ( $v['dealership']['id'] == 1489 ) $sets[] = 'business';
            if ( $v['body']['code'] == 'minivan' ) $sets[] = 'bi-family';
            if ( $v['body']['code'] == 'suv' && $v['drive']['code'] == 'full' ) $sets[] = 'offroad';
            if ( in_array($v['body']['code'], explode(',','sedan,hatchback,liftback')) ) $sets[] = 'city';
            if ( !empty($sets) ) $yml .= '<set-ids>'.implode(', ', $sets).'</set-ids>'.PHP_EOL;
    
            $yml .= '<param name="Конверсия">'.(mt_rand(1000001,9999999)/1000000).'</param>';
    
            if ($v['_general'][3]) $yml .= '<param name="Двигатель">'.$v['_general'][3].'</param>'.PHP_EOL;
            if ($v['_general'][4]) $yml .= '<param name="Трансмиссия">'.$v['_general'][4].'</param>'.PHP_EOL;
            if ($v['_general'][5]) $yml .= '<param name="Привод">'.$v['_general'][5].'</param>'.PHP_EOL;
            if ($v['color']['code']!='none') $yml .= '<param name="Цвет">'.$v['color']['name'].'</param>'.PHP_EOL;
            if ($v['color']['body']!='none') $yml .= '<param name="Кузов">'.$v['body']['name'].'</param>'.PHP_EOL;
            if ($v['_general'][0]) $yml .= '<param name="Год выпуска">'.$v['_general'][0].'</param>'.PHP_EOL;
            if ($v['general'][5]['value']) $yml .= '<param name="Пробег">'.$v['general'][5]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][0]['value']) $yml .= '<param name="Макс. скорость">'.$v['specifications'][0]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][5]['value']) $yml .= '<param name="Объем бака">'.$v['specifications'][5]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][6]['value']) $yml .= '<param name="Объем багажника">'.$v['specifications'][6]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][7]['value']) $yml .= '<param name="Масса">'.$v['specifications'][7]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][8]['value']) $yml .= '<param name="Длина">'.$v['specifications'][8]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][9]['value']) $yml .= '<param name="Ширина">'.$v['specifications'][9]['value'].'</param>'.PHP_EOL;
            if ($v['specifications'][10]['value']) $yml .= '<param name="Высота">'.$v['specifications'][10]['value'].'</param>'.PHP_EOL;
            $yml .= '<delivery>false</delivery>'.PHP_EOL;
            $yml .= '</offer>'.PHP_EOL;
        }
    }

    // yml
    $yml .= '</offers>'.PHP_EOL;
    $yml .= '</shop>'.PHP_EOL;
    $yml .= '</yml_catalog>';
    file_put_contents($dd.'/used-vehicles.xml', $yml);
}