<div class="py-3 bg-yablue c-yawhite vehicle-title" itemscope itemtype="https://schema.org/Product">
    <meta itemprop="brand" content="<?= htmlspecialchars($data['brand']['name'] ?? '');?>" />
    <meta itemprop="model" content="<?= htmlspecialchars($data['model']['name'] ?? '');?>" />
    <link itemprop="url" href="<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" />
    <div class="container">
        <div class="row">
            <div class="col-md-7 col-xl-7">
                <h1 class="h3 fw-bold" itemprop="name"><?= $data['brand']['name'];?> <?= $data['model']['name'];?> <?= $data['general'][4]['value'];?> года с пробегом <?= number_format($data['general'][5]['value'], 0, '.', ' ');?> км</h1>
                <ul class="list-inline my-1 d-md-block">
                    <li class="list-inline-item position-relative me-3 text-uppercase"><?= $data['status']['name'];?></li>
                    <li class="list-inline-item position-relative me-3"><?= $data['dealership']['name'];?></li>
                    <li class="list-inline-item position-relative me-3">
                        <a href="tel:+<?= $app->phoneIn($data['dealership']['phone']);?>" class="c-yawhite c-h-yawhite" role="not-cover"><?= $app->phoneOut($data['dealership']['phone']);?></a>
                    </li>
                    <li class="list-inline-item position-relative me-3">Обновлено <?= $data['_updated'];?></li>
                </ul>
            </div>
            <div class="col-md-5 col-xl-2 text-md-end" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
                <div class="h3 <?= (($data['price']-$data['min_price']==0)?'vehicle-title-price':'');?>" role="min-price">
                    <meta itemprop="price" content="<?= $data['min_price'];?>">
                    <meta itemprop="priceCurrency" content="RUB">
                    <?php if ($data['status']['id'] == 1) { ?>
                    <link itemprop="availability" href="https://schema.org/InStock">
                    <?php } else { ?>
                    <link itemprop="availability" href="https://schema.org/OutOfStock">
                    <?php } ?>
                    <link itemprop="url" href="<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>" />
                    <?= number_format($data['min_price'], 0, '.', ' ');?> ₽
                </div>
                <?php if ( $data['price'] - $data['min_price'] > 0 ) { ?>
                <div class="text-decoration-line-through">
                    <?= number_format($data['price'], 0, '.', ' ');?> ₽
                </div>
                <?php } ?>
                <a
                    href="#"
                    class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase text-center b-radius-yaradius-15 bg-yayellow vehicle-title-button d-block d-xl-none mt-3 mt-xl-0"
                    data-remodal-target="offer-modal"
                    role="not-cover"
                    >Получить предложение</a>
            </div>
            <div class="col-xl-3 d-none d-xl-block">
                <a
                    href="#"
                    class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow vehicle-title-button <?= (($data['price']-$data['min_price']==0)?'without-discount':'');?>"
                    data-remodal-target="offer-modal"
                    role="not-cover"
                    >Получить предложение</a>
            </div>
        </div>
    </div>
</div>
<div class="container my-4 vehicle">
    <div class="row">
        <div class="col">
            <div class="row vehicle">
                <?php include __DIR__.'/vehicle/vehicle.php'; ?>
            </div>
        </div>
    </div>
</div>
<div class="container my-5 vehicle-recomended">
    <div class="row mb-3">
        <div class="col">
            <div class="h2">Рекомендованные автомобили</div>
        </div>
    </div>
    <div class="row">
        <div class="col position-relative">
            <div class="swiper vehicle-recomended-swiper text-start">
                <div class="swiper-wrapper">
                    <?php foreach ($data['recomended'] as $item) { ?>
                    <?php $item['_general'] = $item['general']; ?>
                    <?php $item['id'] = $item['ext_id']; ?>
                    <?php $item['offer_link'] = true; ?>
                    <div class="swiper-slide">
                        <?php include __DIR__.'/vehicles/recomended_vehicle.php'; ?>
                    </div>
                    <?php } ?>
                </div>
            </div>
            <div class="vehicle-recomended-swiper-next b-radius-c-yaradius b-yayellow d-flex justify-content-center align-items-center position-absolute"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/arrow-yellow.svg?2" /></div>
            <div class="vehicle-recomended-swiper-prev b-radius-c-yaradius b-yayellow d-flex justify-content-center align-items-center position-absolute"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/arrow-yellow.svg?2" class="rotate-180" /></div>
        </div>
    </div>
</div>
<div class="bg-yalightgray my-5 py-5">
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <div class="h3">Автомобиль в наличии: <a href="<?= $data['_dealership']['DETAIL_PAGE_URL'];?>" class="c-yadarkgray c-h-yadarkgray"><?= $data['_dealership']['NAME'];?></a></div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 col-xl-3">
                <picture class="w-100 b-radius-yaradius-25">
                    <source srcset="<?= $data['_dealership']['PIC_MOBILE_PREVIEW'];?>" media="(max-width:500px)">
                	<source srcset="<?= $data['_dealership']['PIC_TABLET_PREVIEW'];?>" media="(max-width:768px)">
                    <img src="<?= $data['_dealership']['PIC_DESKTOP_PREVIEW'];?>" alt="<?= $data['_dealership']['NAME'];?>" class="w-100 b-radius-yaradius-25">
                </picture>
            </div>
            <div class="col-md-6 col-xl-4 pt-3 pt-md-0">
                <div class="h4 fw-bold"><?= $data['_dealership']['NAME'];?></div>
                <p class=""><?= $data['_dealership']['PROPERTY_ADDRESS_VALUE'];?></p>
                <p class="text-minus">
                    <a 
                        href="https://yandex.ru/maps/?ll=<?= $data['_dealership']['PROPERTY_COORDS_LON_VALUE'];?>,<?= $data['_dealership']['PROPERTY_COORDS_LAT_VALUE'];?>&z=15&mode=routes&rtext=~<?= $data['_dealership']['PROPERTY_COORDS_LAT_VALUE'];?>,<?= $data['_dealership']['PROPERTY_COORDS_LON_VALUE'];?>&rtt=auto&ruri=~" 
                        target="_blank" 
                        role="not-cover"
                        alt="<?= $data['_dealership']['NAME'];?>"
                        class="c-yablue c-h-yablue"
                        >Построить маршрут</a>
                </p>
                <div class="row">
                    <?php foreach ( $data['_dealership']['WORK'] as $item ) { ?>
                    <div class="col-6 mb-3">
                        <div class="c-yadarkgray text-minus"><?= $item['DESCRIPTION'];?></div>
                        <?= $item['VALUE'];?>
                    </div>
                    <?php } ?>
                </div>
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="c-yadarkgray text-minus">Сайт:</div>
                        <a href="<?= $data['_dealership']['SITE'];?>" class="c-yalightblack c-h-yalightblack"><?= parse_url($data['_dealership']['SITE'])['host'];?></a>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="c-yadarkgray text-minus">Телефон:</div>
                        <a href="tel:+<?= $app->phoneIn($data['_dealership']['PROPERTY_PHONE_VALUE']);?>" class="c-yalightblack c-h-yalightblack"><?= $app->phoneOut($data['_dealership']['PROPERTY_PHONE_VALUE']);?></a>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <a 
							href="#FORM_CALLBACK" 
							data-form="FORM_CALLBACK"
                            role="not-cover"
							class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow vehicle-card-button"
							role="setDealership"
							data-dealership="<?= $data['_dealership']['PROPERTY_EXTERNAL_CODE_VALUE'];?>"
							><span>Заказать звонок</span></a>
                    </div>
                </div>
            </div>
            <div class="col-xl-5 mt-4 mt-xl-0">
                <div class="vehicle-map b-radius-yaradius-25" id="vehicleMap"></div>
            </div>
        </div>
    </div>
</div>
<?php include __DIR__.'/forms/reserv.php'; ?>

<script>
var vehicleMap;
ymaps.ready(vehicleMapInit);

function vehicleMapInit () {
	
    vehicleMap = new ymaps.Map('vehicleMap', {

        center: [<?= $data['_dealership']['PROPERTY_COORDS_LAT_VALUE'];?>, <?= $data['_dealership']['PROPERTY_COORDS_LON_VALUE'];?>],
        zoom: 15
    }, {
        searchControlProvider: 'yandex#search'
    });
	vehicleMap.behaviors.disable('scrollZoom');
	vehicleMap.geoObjects.add(new ymaps.Placemark(
		[<?= $data['_dealership']['PROPERTY_COORDS_LAT_VALUE'];?>, <?= $data['_dealership']['PROPERTY_COORDS_LON_VALUE'];?>],
		{balloonContent: "<?= $data['_dealership']['NAME'];?>", iconCaption: "<?= $data['_dealership']['NAME'];?>"},
		{preset: "islands#darkBlueDotIconWithCaption"}
	))
}
</script>