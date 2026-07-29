<?php
#!/usr/bin/php

$dd = '/var/www/admin/data/www/yug-avto-expert.ru';

$url = 'https://apps.yug-avto.ru/API/get/cis/vehicles/used?token=34b5ac8b71018c0bc7e5c050ed90b243';
$vehicles = json_decode( file_get_contents($url), true)['items'];

// yml
$yml .= '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'.PHP_EOL;
$yml .= '<yml_catalog date="'.date('Y-m-d H:s:i').'">'.PHP_EOL;
$yml .= '<name>Юг-Авто Эксперт</name>'.PHP_EOL;
$yml .= '<company>ООО "Юг-Авто Эксперт"</company>'.PHP_EOL;
$yml .= '<currencies><currency rate="1" id="RUR"/></currencies>'.PHP_EOL;
$yml .= '<categories><category id="1">Автомобили с пробегом Юг-Авто Эксперт</category></categories>'.PHP_EOL;
$yml .= '<url>https://yug-avto-expert.ru/cars/used/</url>'.PHP_EOL;
$yml .= '<sets>'.PHP_EOL;
$yml .= '<set id="less2000000"><name>До 2 000 000 ₽</name><url>https://yug-avto-expert.ru/cars/used/?price=0,2000000</url></set>'.PHP_EOL;
$yml .= '<set id="less3year"><name>Не старше 3 лет</name><url>https://yug-avto-expert.ru/cars/used/?year=2020,2023</url></set>'.PHP_EOL;

$yml .= '<set id="premium"><name>Премиум</name><url>https://yug-avto-expert.ru/cars/used/?dealership=1502</url></set>'.PHP_EOL;
$yml .= '<set id="business"><name>Для бизнеса</name><url>https://yug-avto-expert.ru/cars/used/?dealership=1489</url></set>'.PHP_EOL;
$yml .= '<set id="big-family"><name>Для больших семей</name><url>https://yug-avto-expert.ru/cars/used/?body=minivan</url></set>'.PHP_EOL;
$yml .= '<set id="off-road"><name>Покорители бездорожья</name><url>https://yug-avto-expert.ru/cars/used/?body=suv&drive=full</url></set>'.PHP_EOL;
$yml .= '<set id="city"><name>Для города</name><url>https://yug-avto-expert.ru/cars/used/?body=sedan,hatchback,liftback</url></set>'.PHP_EOL;
$yml .= '</sets>'.PHP_EOL;
$yml .= '<offers>'.PHP_EOL;
foreach ( $vehicles as $v ) {
    
    if ( $v['type'] == 'vehicle' && in_array($v['dealership']['id'], [1364,1367,1489,1492,1499,1502,1533]) ) {

        $yml .= '<offer id="'.$v['id'].'" available="true">'.PHP_EOL;
        $yml .= '<url>https://yug-avto-expert.ru/cars/used/'.$v['brand']['code'].'/'.$v['model']['code'].'/'.$v['id'].'/</url>'.PHP_EOL;
        $yml .= '<picture>'.$v['image'].'</picture>'.PHP_EOL;
        $yml .= '<name>'.$v['brand']['name'].' '.$v['model']['name'].' '.(($v['equipment'])?str_replace('&', '-', $v['equipment']):'').' '.(($v['_general'][2])?:'').'</name>'.PHP_EOL;
        $yml .= '<price>'.$v['min_price'].'</price>'.PHP_EOL;
        $yml .= '<vendor>'.$v['brand']['name'].'</vendor>'.PHP_EOL;
        $yml .= '<categoryId>1</categoryId>'.PHP_EOL;
        $yml .= '<currencyId>RUR</currencyId>'.PHP_EOL;

        $sets = [];
        if ( $v['dealership']['id'] == 1502 ) $sets[] = 'premium';
        if ( $v['dealership']['id'] == 1489 ) $sets[] = 'business';
        if ( $v['body']['code'] == 'minivan' ) $sets[] = 'big-family';
        if ( $v['body']['code'] == 'suv' && $v['drive']['code'] == 'full' ) $sets[] = 'off-road';
        if ( in_array($v['body']['code'], explode(',','sedan,hatchback,liftback')) ) $sets[] = 'city';
        if ( !empty($sets) ) $yml .= '<set-ids>'.implode(', ', $sets).'</set-ids>'.PHP_EOL;

        $yml .= '<param name="Конверсия">2.01711</param>';

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
        $yml .= '<description></description>'.PHP_EOL;
        $yml .= '<delivery>false</delivery>'.PHP_EOL;
        $yml .= '</offer>'.PHP_EOL;
    }
}
$yml .= '</offers>'.PHP_EOL;
$yml .= '</yml_catalog>';

file_put_contents($dd.'/used-vehicles.xml', $yml);

?>