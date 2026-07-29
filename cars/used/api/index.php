<?php

$conf = require __DIR__.'/../vendor/Config.php';
require __DIR__.'/../vendor/YApp.Showroom.class.php';
$app = new YAppShowroom($conf);

if ( $_POST ) {
    $data = json_decode(file_get_contents($_POST['url'].'&page='.$_POST['next']), true);
    $data['FAVORITES'] = ( json_decode($_COOKIE['CIS_FAVORITES'], true) ) ?: [];
    $data['COMPARE'] = ( json_decode($_COOKIE['CIS_COMPARE'], true) ) ?: [];
    ?>
        <?php foreach ($data['items'] as $item) { ?>
        <div class="col-md-6 col-lg-4 col-xl-3 vehicle-list-item">
            <?php if ( $item['type'] == 'vehicle' ) { ?>
                <?php include __DIR__.'/../views/vehicles/item_vehicle.php'; ?>
            <?php } elseif ( $item['type'] == 'random_cta' ) { ?>
                <?php include __DIR__.'/../views/vehicles/item_cta.php'; ?>
            <?php } ?>
        </div>
        <?php } ?>
    <?php
} 