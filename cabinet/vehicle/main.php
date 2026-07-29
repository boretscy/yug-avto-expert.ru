<?php 
$GLOBALS['CABINET_USER']['CAR_INFO'] = $cab::getCarInfo($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'], $data['vin']);
if ( $GLOBALS['CABINET_USER']['CAR_INFO']['Request'] ) $GLOBALS['CABINET_USER']['CAR_INFO']['OFFERS'] = $cab::getOffersForCarRevaluation($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'], $data['vin']);
$calls = 0; $visits = 0; $internet = 0;
foreach ( $GLOBALS['CABINET_USER']['CAR_INFO']['HistoryAppeals'] as $h ) {
    if ( $h['Call'] ) $calls += $h['Call'] ;
    if ( $h['Visit'] ) $visits += $h['Visit'];
    if ( $h['Internet'] ) $internet += $h['Internet'];
}
// YApp::sp($GLOBALS['CABINET_USER']['CAR_INFO']);
// $calls = mt_rand(5,99);
// $visits = mt_rand(5,99);
// $internet = mt_rand(5,99);
?>
<div class="py-3 bg-yablue c-yawhite vehicle-title">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3 fw-bold mt-3"><?= $data['brand']['name'];?> <?= $data['model']['name'];?> <?= (($data['equipment'])?:'');?> <?= (($data['generation_name'])?:'');?> <?= (($data['modification_name'])?:'');?></h1>
            </div>
        </div>
    </div>
</div>
<div class="container my-4 vehicle">
    <div class="row">
        <div class="col">
            <div class="row vehicle">
                <div class="col-xl-6">
                    <div class="sticky-top" style="top: 7rem;">
                        <div class="swiper vehicle-swiper position-relative">
                            <div class="swiper-wrapper">
                                <?php foreach ( $data['_images'] as $k => $item ) { ?>
                                <div class="swiper-slide">
                                    <a 
                                        data-fancybox="gallery-<?= $data['id'];?>"
                                        data-src="<?= $item['detail'];?>"
                                        data-width="1522"
                                        data-height="1200"
                                        role="not-cover"
                                        class="vehicle-full-image"
                                        ><img src="<?= $item['detail'];?>" class="b-radius-yaradius-25" title="<?= $data['brand']['name'];?> <?= $data['model']['name'];?> <?= (($data['equipment'])?:'');?>" <?= (($k==0)?'itemprop="image"':'');?> /></a>
                                </div>
                                <?php } ?>
                            </div>
                            <div class="vehicle-swiper-next b-radius-c-yaradius b-yawhite d-flex justify-content-center align-items-center position-absolute"><img src="/cars/used/assets/images/svg/arrow-white.svg?2" /></div>
                            <div class="vehicle-swiper-prev b-radius-c-yaradius b-yawhite d-flex justify-content-center align-items-center position-absolute"><img src="/cars/used/assets/images/svg/arrow-white.svg?2" class="rotate-180" /></div>
                        </div>
                        <div class="swiper vehicle-swiper-thumbs mt-4">
                            <div class="swiper-wrapper">
                                <?php foreach ( $data['_images'] as $item ) { ?>
                                <div class="swiper-slide">
                                    <img src="<?= $item['preview'];?>" class="b-radius-yaradius-15" />
                                </div>
                                <?php } ?>
                            </div>
                            <div class="vehicle-swiper-thumbs-next"></div>
                            <div class="vehicle-swiper-thumbs-prev"></div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="row mb-4">
                        <div class="col-12 mb-4">
                            <div class="d-inline-block">
                                <a href="/cabinet/vehicle/<?= $vehicle;?>/history/" class="c-yadarkgray b-yagray b-radius-yaradius-7 text-decoration-none px-2 py-1 d-flex justify-content-between align-items-center">
                                    <img src="/cabinet/images/icon-clock.svg" class="me-1" />
                                    <span>История</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="h2"><?= number_format($GLOBALS['CABINET_USER']['INFO']['MassAvto'][0]['PriceC'], 0, '.', ' ');?> ₽ <span class="c-yamiddlegray h6">Вы получите</span></div>
                                <div class="c-yamiddlegray"><?= number_format($GLOBALS['CABINET_USER']['INFO']['MassAvto'][0]['Price'], 0, '.', ' ');?> ₽ Цена продажи</div>
                            </div>
                            <a href="/cabinet/vehicle/<?= $vehicle;?>/offers/" class="c-yadarkgray b-yagray b-radius-yaradius-7 text-decoration-none px-2 py-1 d-flex justify-content-between align-items-center">
                                <span>Предложения</span>
                                <?php if ( $GLOBALS['CABINET_USER']['CAR_INFO']['Request'] ) { ?>
                                <span class="cabinet-vehicle-offers-count bg-yadarkgreen c-yawhite b-radius-c-yaradius ms-1 d-flex justify-content-center align-items-center"><?= count($GLOBALS['CABINET_USER']['CAR_INFO']['OFFERS']['Current']);?></span>
                                <?php } ?>
                            </a>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-md-6">
                            <div class="p-3 b-yalightgray b-radius-yaradius-15 mb-4">
                                <div class="h5">Основные характеристики</div>
                                <div class="c-yagray text-minus">Информация:</div>
                                <ul class="list-unstyled text-minus-minus mt-4">
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">VIN:</span><span class="text-end"><?= $data['vin'];?></span></li>
                                    <hr class="my-2" />
                                    <?php /*
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Гос. номер:</span><span>Не указан</span></li>
                                    <hr class="my-2" />
                                    */ ?>
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Год выпуска:</span><span class="text-end"><?= $data['general'][4]['value'];?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Пробег:</span><span class="text-end"><?= number_format($data['general'][5]['value'], 0, '.', ' ');?> км</span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Модификация:</span><span class="text-end"><?= $data['modification_name'];?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Тип КПП:</span><span class="text-end"><?= $data['transmission']['name'];?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Тип двигателя:</span><span class="text-end"><?= $data['engine']['name'];?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Привод:</span><span class="text-end"><?= $data['drive']['name'];?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 b-yalightgray b-radius-yaradius-15 mb-4">
                                <div class="h5">Комиссионная продажа</div>
                                <div class="c-yagray text-minus">Статистика:</div>
                                <ul class="list-unstyled text-minus-minus mt-4">
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Начало комиссионных услуг:</span><span><?= date( 'd.m.Y', strtotime($GLOBALS['CABINET_USER']['CAR_INFO']['CommissionServicesStart']));?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Дата публикации:</span><span><?= date( 'd.m.Y', strtotime($GLOBALS['CABINET_USER']['CAR_INFO']['CommissionServicesStart']));?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span><img src="/cabinet/images/vehicle-user.svg" class="me-2" />Визиты</span><span class="c-yablue"><?= $visits;?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span><img src="/cabinet/images/vehicle-phone.svg" class="me-2" />Звонки</span><span class="c-yablue"><?= $calls;?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span><img src="/cabinet/images/vehicle-globe.svg?2" class="me-2" />Интернет обращения</span><span class="c-yablue"><?= $internet;?></span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-12">
                            <div class="p-3 b-yalightgray b-radius-yaradius-15 mb-4">
                                <div class="h5">Документы:</div>
                                <ul class="list-unstyled text-minus-minus cabinet-vehicle-documents mt-4">
                                    <li class="d-flex justify-content-start c-yadarkgray mb-2">
                                        <a href="/cabinet/vehicle/<?= $vehicle;?>/docs/?doc=1" target="_blank" class="c-yadarkgray c-h-yadarkgray d-flex justify-content-start align-items-start w-100"><img src="/cabinet/images/vehicle-download.svg" class="me-3" /> Договор комиссии</a>
                                    </li>
                                    <li class="d-flex justify-content-start c-yadarkgray mb-2">
                                        <a href="/cabinet/vehicle/<?= $vehicle;?>/docs/?doc=2" target="_blank" class="c-yadarkgray c-h-yadarkgray d-flex justify-content-start align-items-start w-100"><img src="/cabinet/images/vehicle-download.svg" class="me-3" /> Дополнительное соглашение</a>
                                    </li>
                                    <li class="d-flex justify-content-start c-yadarkgray mb-2">
                                        <a href="/cabinet/vehicle/<?= $vehicle;?>/docs/?doc=3" target="_blank" class="c-yadarkgray c-h-yadarkgray d-flex justify-content-start align-items-start w-100"><img src="/cabinet/images/vehicle-download.svg" class="me-3" /> Соглашение на обработку персональных данных</a>
                                    </li>
                                    <li class="d-flex justify-content-start c-yadarkgray mb-2">
                                        <a href="/cabinet/vehicle/<?= $vehicle;?>/docs/?doc=4" target="_blank" class="c-yadarkgray c-h-yadarkgray d-flex justify-content-start align-items-start w-100"><img src="/cabinet/images/vehicle-download.svg" class="me-3" /> Соглашение на использование ПЭП</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
            </div>
        </div>
    </div>
</div>
