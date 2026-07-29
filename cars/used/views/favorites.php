<div class="bg-yablue py-4">
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h1 fw-normal c-yawhite">Избранные автомобили</h1></div>
		</div>
	</div>
</div>
<?php if ( !empty($data['items']) ) { ?>
<div class="container my-5">
    <div class="row">
        <div class="col-6 col-lg-2">
            <span class="ms-1 b-radius-yaradius-7 bg-yayellow vehicle-card-discount-item me-2"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/favorites.svg" /></span>
            Избранное 
            <span class="c-yayellow"><?= count($data['items']);?></span>
        </div>
        <div class="col-6 col-lg-2">
            <a href="?action=clear" class="c-yalightblack c-h-yalightblack text-decoration-none">
                <span class="ms-1 b-radius-yaradius-7 bg-yawhite vehicle-card-discount-item me-2"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/trash.svg" /></span>
                Удалить 
            </a>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row vehicle-list">
        <?php foreach ($data['items'] as $item) { ?>
        <div class="col-md-6 col-lg-4 col-xl-3 vehicle-list-item">
            <?php if ( $item['type'] == 'vehicle' ) { ?>
                <?php include __DIR__.'/vehicles/favorites_vehicle.php'; ?>
            <?php } elseif ( $item['type'] == 'random_cta' ) { ?>
                <?php include __DIR__.'/vehicles/item_cta.php'; ?>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>
<?php } else { ?>
<div class="container my-5">
    <div class="row text-center">
        <div class="col-12 mb-5">
            <h2 class="h2">Вы еще не добавили в избранное ни одного автомобиля</h1>
        </div>
        <div class="col-md"></div>
        <div class="col-md-6 col-lg-4 col-xl-3">
            <a href="<?= $app->Conf()['baseUrl'];?>/" class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow form-button"><span>К СПИСКУ МОДЕЛЕЙ</span></a>
        </div>
        <div class="col-md"></div>
    </div>
</div>
<?php } ?>
<?php $data['filter']['dropLists']['dealerships'] = json_decode( file_get_contents('https://yug-avto-expert.ru/api/dealerships?city='.$filter['city']), true ); ?>
<?php include __DIR__.'/forms/consult.php'; ?>