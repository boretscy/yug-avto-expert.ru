<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Text\HtmlFilter;

$data = $arResult["CIS_DATA"] ?? [];
$vehicleId = $arResult["VEHICLE_ID"] ?? '';
$carInfo = $arResult["CAR_INFO"] ?? [];
$offers = $arResult["OFFERS"] ?? [];
$priceC = $arResult["PRICE_C"] ?? 0;
$price = $arResult["PRICE"] ?? 0;

$calls = 0; $visits = 0; $internet = 0;
if (!empty($carInfo['HistoryAppeals']) && is_array($carInfo['HistoryAppeals'])) {
    foreach ($carInfo['HistoryAppeals'] as $h) {
        if (!empty($h['Call'])) $calls += (int)$h['Call'];
        if (!empty($h['Visit'])) $visits += (int)$h['Visit'];
        if (!empty($h['Internet'])) $internet += (int)$h['Internet'];
    }
}

$offersCount = 0;
if (!empty($offers['Current']) && is_array($offers['Current'])) {
    $offersCount = count($offers['Current']);
}

$commDate = !empty($carInfo['CommissionServicesStart']) ? date('d.m.Y', strtotime($carInfo['CommissionServicesStart'])) : '—';
?>

<div class="py-3 bg-yablue c-yawhite vehicle-title">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1 class="h3 fw-bold mt-3">
                    <?= HtmlFilter::encode($data['brand']['name'] ?? '');?> 
                    <?= HtmlFilter::encode($data['model']['name'] ?? '');?> 
                    <?= HtmlFilter::encode($data['equipment'] ?? '');?> 
                    <?= HtmlFilter::encode($data['generation_name'] ?? '');?> 
                    <?= HtmlFilter::encode($data['modification_name'] ?? '');?>
                </h1>
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
                                <?php if (!empty($data['_images']) && is_array($data['_images'])) { ?>
                                    <?php foreach ($data['_images'] as $k => $item) { ?>
                                    <div class="swiper-slide">
                                        <a 
                                            data-fancybox="gallery-<?= HtmlFilter::encode($data['id'] ?? '');?>"
                                            data-src="<?= HtmlFilter::encode($item['detail'] ?? '');?>"
                                            data-width="1522"
                                            data-height="1200"
                                            role="not-cover"
                                            class="vehicle-full-image"
                                        ><img src="<?= HtmlFilter::encode($item['detail'] ?? '');?>" class="b-radius-yaradius-25" title="<?= HtmlFilter::encode(($data['brand']['name'] ?? '') . ' ' . ($data['model']['name'] ?? ''));?>" <?= ($k === 0 ? 'itemprop="image"' : '');?> /></a>
                                    </div>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="vehicle-swiper-next b-radius-c-yaradius b-yawhite d-flex justify-content-center align-items-center position-absolute"><img src="/cars/used/assets/images/svg/arrow-white.svg?2" alt="" /></div>
                            <div class="vehicle-swiper-prev b-radius-c-yaradius b-yawhite d-flex justify-content-center align-items-center position-absolute"><img src="/cars/used/assets/images/svg/arrow-white.svg?2" class="rotate-180" alt="" /></div>
                        </div>
                        <div class="swiper vehicle-swiper-thumbs mt-4">
                            <div class="swiper-wrapper">
                                <?php if (!empty($data['_images']) && is_array($data['_images'])) { ?>
                                    <?php foreach ($data['_images'] as $item) { ?>
                                    <div class="swiper-slide">
                                        <img src="<?= HtmlFilter::encode($item['preview'] ?? '');?>" class="b-radius-yaradius-15" alt="" />
                                    </div>
                                    <?php } ?>
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
                                <a href="/cabinet/vehicle/<?= HtmlFilter::encode($vehicleId);?>/history/" class="c-yadarkgray b-yagray b-radius-yaradius-7 text-decoration-none px-2 py-1 d-flex justify-content-between align-items-center">
                                    <img src="/cabinet/images/icon-clock.svg" class="me-1" alt="" />
                                    <span>История</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-12 d-flex justify-content-between align-items-center">
                            <div>
                                <div class="h2"><?= number_format($priceC, 0, '.', ' ');?> ₽ <span class="c-yamiddlegray h6">Вы получите</span></div>
                                <div class="c-yamiddlegray"><?= number_format($price, 0, '.', ' ');?> ₽ Цена продажи</div>
                            </div>
                            <a href="/cabinet/vehicle/<?= HtmlFilter::encode($vehicleId);?>/offers/" class="c-yadarkgray b-yagray b-radius-yaradius-7 text-decoration-none px-2 py-1 d-flex justify-content-between align-items-center">
                                <span>Предложения</span>
                                <?php if ($offersCount > 0) { ?>
                                <span class="cabinet-vehicle-offers-count bg-yadarkgreen c-yawhite b-radius-c-yaradius ms-1 d-flex justify-content-center align-items-center"><?= $offersCount;?></span>
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
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">VIN:</span><span class="text-end"><?= HtmlFilter::encode($data['vin'] ?? '');?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Год выпуска:</span><span class="text-end"><?= HtmlFilter::encode($data['general'][4]['value'] ?? '');?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Пробег:</span><span class="text-end"><?= number_format((float)($data['general'][5]['value'] ?? 0), 0, '.', ' ');?> км</span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Модификация:</span><span class="text-end"><?= HtmlFilter::encode($data['modification_name'] ?? '');?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Тип КПП:</span><span class="text-end"><?= HtmlFilter::encode($data['transmission']['name'] ?? '');?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Тип двигателя:</span><span class="text-end"><?= HtmlFilter::encode($data['engine']['name'] ?? '');?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Привод:</span><span class="text-end"><?= HtmlFilter::encode($data['drive']['name'] ?? '');?></span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-3 b-yalightgray b-radius-yaradius-15 mb-4">
                                <div class="h5">Комиссионная продажа</div>
                                <div class="c-yagray text-minus">Статистика:</div>
                                <ul class="list-unstyled text-minus-minus mt-4">
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Начало комиссионных услуг:</span><span><?= HtmlFilter::encode($commDate);?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span class="c-yadarkgray">Дата публикации:</span><span><?= HtmlFilter::encode($commDate);?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span><img src="/cabinet/images/vehicle-user.svg" class="me-2" alt="" />Визиты</span><span class="c-yablue"><?= $visits;?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span><img src="/cabinet/images/vehicle-phone.svg" class="me-2" alt="" />Звонки</span><span class="c-yablue"><?= $calls;?></span></li>
                                    <hr class="my-2" />
                                    <li class="d-flex justify-content-between"><span><img src="/cabinet/images/vehicle-globe.svg?2" class="me-2" alt="" />Интернет обращения</span><span class="c-yablue"><?= $internet;?></span></li>
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
                                        <a href="/cabinet/vehicle/<?= HtmlFilter::encode($vehicleId);?>/docs/?doc=1" target="_blank" class="c-yadarkgray c-h-yadarkgray d-flex justify-content-start align-items-start w-100"><img src="/cabinet/images/vehicle-download.svg" class="me-3" alt="" /> Договор комиссии</a>
                                    </li>
                                    <li class="d-flex justify-content-start c-yadarkgray mb-2">
                                        <a href="/cabinet/vehicle/<?= HtmlFilter::encode($vehicleId);?>/docs/?doc=2" target="_blank" class="c-yadarkgray c-h-yadarkgray d-flex justify-content-start align-items-start w-100"><img src="/cabinet/images/vehicle-download.svg" class="me-3" alt="" /> Дополнительное соглашение</a>
                                    </li>
                                    <li class="d-flex justify-content-start c-yadarkgray mb-2">
                                        <a href="/cabinet/vehicle/<?= HtmlFilter::encode($vehicleId);?>/docs/?doc=3" target="_blank" class="c-yadarkgray c-h-yadarkgray d-flex justify-content-start align-items-start w-100"><img src="/cabinet/images/vehicle-download.svg" class="me-3" alt="" /> Соглашение на обработку персональных данных</a>
                                    </li>
                                    <li class="d-flex justify-content-start c-yadarkgray mb-2">
                                        <a href="/cabinet/vehicle/<?= HtmlFilter::encode($vehicleId);?>/docs/?doc=4" target="_blank" class="c-yadarkgray c-h-yadarkgray d-flex justify-content-start align-items-start w-100"><img src="/cabinet/images/vehicle-download.svg" class="me-3" alt="" /> Соглашение на использование ПЭП</a>
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

<script src="/cabinet/script.js?2"></script>
