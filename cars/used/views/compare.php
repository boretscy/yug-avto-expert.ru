<div class="bg-yablue py-4">
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h1 fw-normal c-yawhite">Сравнение автомобилей</h1></div>
		</div>
	</div>
</div>
<?php if ( !empty($data['items']) ) { ?>
<div class="container my-5">
    <div class="row">
        <div class="col-4 col-lg-2 d-flex align-items-center">
            <span class="ms-1 b-radius-yaradius-7 bg-yayellow vehicle-card-discount-item me-2"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/compare.svg" /></span>
            Сравнение 
            <span class="c-yayellow ms-2"><?= count($data['items']);?></span>
        </div>
        <div class="col-4 col-lg-2 d-flex align-items-center">
            <a href="?action=clear" class="c-yalightblack c-h-yalightblack text-decoration-none">
                <span class="ms-1 b-radius-yaradius-7 bg-yawhite vehicle-card-discount-item me-2"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/trash.svg" /></span>
                Удалить 
            </a>
        </div>
        <div class="col-4 col-lg  d-flex justify-content-end align-items-center">
            <span class="compare-nav compare-nav-prev b-radius-yaradius-7 b-yayellow ms-2 d-flex justify-content-center align-items-center"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/compare-arrow.svg" class="w-auto rotate-180" /></span>
            <span class="compare-nav compare-nav-next b-radius-yaradius-7 b-yayellow ms-2  d-flex justify-content-center align-items-center"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/compare-arrow.svg" class="w-auto" /></span>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row vehicle-list">
        <div class="col-md-5 col-lg-4 col-xl-3 d-none d-md-block">
            <div class="bg-yalightgray b-radius-yaradius-25 p-3">
                <div class="compare-head text-center d-flex justify-content-center align-items-center">
                    <a href="<?= $app->Conf()['baseUrl'];?>/" class="c-yadarkgray c-h-yadarkgray text-decoration-none">
                        <div class="add">+</div>
                        Добавить авто
                    </a>
                </div>
                <hr />
                <p class="fw-bold" style="min-height: 80px;">Бренд, модель, комплектация</p>
                <p class="fw-bold">Стоимость</p>
                <hr />
                <div class="compare-body mb-4 pb-3">
                    <div class="compare-body-title d-flex justify-content-between align-items-center" data-index="0">
                        <span>Технические параметры</span>
                        <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/corner.svg" class="rotate-180" />
                    </div>
                    <ul class="list-unstyled compare-body-items text-minus c-yadarkgray" data-index="0">
                        <li class="py-2">Кузов</li>
                        <li class="py-2">Цвет кузова</li>
                        <li class="py-2">Масса</li>
                        <li class="py-2">Мощность</li>
                        <li class="py-2">Тип двигателя</li>
                        <li class="py-2">Расход топлива</li>
                        <li class="py-2">Максимальная скорость</li>
                        <li class="py-2">Год выпуска</li>
                    </ul>
                    <hr />
                    <div class="compare-body-title d-flex justify-content-between align-items-center" data-index="1">
                        <span>Размеры</span>
                        <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/corner.svg" class="rotate-180"/>
                    </div>
                    <ul class="list-unstyled compare-body-items text-minus c-yadarkgray" data-index="1">
                        <li class="py-2">Длина</li>
                        <li class="py-2">Ширина</li>
                        <li class="py-2">Высота</li>
                    </ul>
                    <hr />
                </div>
            </div>
        </div>
        <div class="col-md-7 col-lg-8 col-xl-9">
            <div class="swiper-compare overflow-hidden position-relative" style="cursor: ew-resize;">
                <div class="swiper-wrapper">
                    <?php foreach ($data['items'] as $item) { ?>
                    <div class="swiper-slide vehicle-list-item">
                        <?php if ( $item['type'] == 'vehicle' ) { ?>
                            <?php include __DIR__.'/vehicles/compare_vehicle.php'; ?>
                        <?php } ?>
                    </div>
                    <?php } ?>
                </div>
                <div class="swiper-scrollbar"></div>
            </div>
        </div>
        <div class="col-12 d-md-none">
            <div class="bg-yalightgray b-radius-yaradius-25 p-3">
                <div class="compare-head text-center d-flex justify-content-center align-items-center">
                    <a href="<?= $app->Conf()['baseUrl'];?>/" class="c-yadarkgray c-h-yadarkgray text-decoration-none">
                        <div class="add">+</div>
                        Добавить авто
                    </a>
                </div>
            </div>
        </div>
        
    </div>
</div>
<?php } else { ?>
<div class="container my-5">
    <div class="row text-center">
        <div class="col-12 mb-5">
            <h2 class="h2">Вы еще не добавили к сравнению ни одного автомобиля</h1>
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