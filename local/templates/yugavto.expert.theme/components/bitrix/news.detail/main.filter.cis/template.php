<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<div class="main-cis-filter form">
    <div class="container">
        <div class="row form-card">
            <div class="col">
                <form class="p-3 p-md-5 b-radius-yaradius-25 bg-yablue">
                    <div class="row mb-3">
                        <div class="col-md-6 h4 fw-normal c-yawhite">Найти автомобиль</div>
                        <div class="col-md-6 text-md-end">
                            <ul class="list-inline text-minus-minus pt-0 pt-md-2 mb-0">
                                <li class="list-inline-item ms-md-3 me-3 me-md-0 py-3 <?php // = (($arResult['FILTER']['counts']['pass'])?'':'disabled');?>" data-param="!dealership=1489" role="toggle" data-section="pass">
                                    <a href="#" class="text-uppercase text-decoration-none fw-bold py-2 c-yawhite c-h-yawhite">Легковые</a>
                                </li>
                                <?php /*
                                <li class="list-inline-item ms-md-3 me-3 me-md-0 py-3 <?= (($arResult['FILTER']['counts']['comm'])?'':'disabled');?>" data-param="dealership=1489" role="toggle" data-section="comm">
                                    <a href="#" class="text-uppercase text-decoration-none fw-bold py-2 <?= (($arResult['FILTER']['counts']['comm'])?'c-yalightblack c-h-yalightblack':'c-yagray c-h-yagray');?>">Коммерческие</a>
                                </li>
                                */ ?>
                                <li class="list-inline-item ms-md-3 me-3 me-md-0 py-3 <?php // = (($arResult['FILTER']['counts']['prem'])?'':'disabled');?>" data-param="dealership=1502" role="toggle" data-section="prem">
                                    <a href="#" class="text-uppercase text-decoration-none c-yawhite c-h-yawhite py-2 <?= (($arResult['FILTER']['counts']['prem'])?'':'fw-bold');?>">Премиум</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-xl-3 mb-3">
							<div class="form-group">
								<div class="filter-dropcontainer position-relative">
									<div class="b-radius-yaradius-15 bg-yawhite filter-dropdown d-flex justify-content-between c-yadarkgray b-yalightgray position-relative">
										<span><noindex>Марка <span class="d-none d-lg-inline-block">(все)</span></noindex></span>
										<span><img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/drop-corner.svg" /></span>
									</div>
									<div class="filter-droplist bg-yawhite w-100 position-absolute d-none" data-children="models" data-list="brands">
										<?php foreach ( $arResult['FILTER']['dropLists']['brands'] as $k => $item ) { ?>
											<a href="#" 
												class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray"
												data-text="<?= $item['name'];?>"
												data-value="<?= $item['code'];?>"
                                                data-list="brands"
                                                data-indx="<?= $k;?>"
												rel=“nofollow”
												><noindex><?= $item['name'];?></noindex></a>
										<?php } ?>
									</div>
								</div>
							</div>
                        </div>
                        <div class="col-6 col-xl-3 mb-3">
                            <div class="form-group">
								<div class="filter-dropcontainer position-relative">
									<div class="b-radius-yaradius-15 bg-yawhite filter-dropdown d-flex justify-content-between c-yadarkgray b-yalightgray position-relative">
										<span><noindex>Модель</noindex></span>
										<span><img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/drop-corner.svg" /></span>
									</div>
									<div class="filter-droplist bg-yawhite w-100 position-absolute d-none" data-list="models">
										<a href="#" 
											class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray"
											rel=“nofollow”
											><noindex>Выберите марку</noindex></a>
									</div>
								</div>
							</div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-3">
                            <?php 
                                $range = $arResult['FILTER']['ranges']['price']; 
                                $range['code'] = 'price';
                                $range['name'] = 'Цена';
                                $range['unit'] = '₽';
                                $range['format'] = true;
                                $range['range'] = ( $range['max']-$range['min'] ) ?: 1;
                            ?>
                            <div class="b-radius-yaradius-15 bg-yawhite range-row c-yadarkgray position-relative" data-range="<?= $range['code'];?>" role="view">
                                <span class="range-title-from text-minus-minus position-absolute"><?= $range['name'];?> от</span>
                                <span class="range-title-to text-minus-minus position-absolute">до</span>
                                <?php if ( $range['unit'] ) { ?>
                                <span class="range-title-param text-minus-minus position-absolute"><?= $range['unit'];?></span>
                                <?php } ?>
                                <div class="range-view">
                                    <input 
                                        type="text" 
                                        name="min" 
                                        value="<?= (($range['format'])?number_format($range['value'][0], 0, '.', ' '):$range['value'][0]);?>"
                                        /> 
                                    <input 
                                        type="text" 
                                        name="max" 
                                        value="<?= (($range['format'])?number_format($range['value'][1], 0, '.', ' '):$range['value'][1]);?>"
                                        class="ps-2 b-l-yagray text-end"
                                        />
                                </div>
                            </div>
                            <div class="range" data-range="<?= $range['code'];?>" role="range">
                                <div class="range-slider">
                                    <span 
                                        class="range-selected"
                                        data-min="<?= $range['value'][0];?>"
                                        data-max="<?= $range['value'][1];?>"
                                        style="
                                            left: <?= ($range['value'][0]-$range['min'])/($range['range'])*100;?>%;
                                            right: <?= ($range['max']-$range['value'][1])/($range['range'])*100;?>%;
                                        "
                                        ></span>
                                </div>
                                <div class="range-input">
                                    <input 
                                        type="range" 
                                        class="min" 
                                        min="<?= $range['min'];?>" 
                                        max="<?= $range['max'];?>" 
                                        value="<?= $range['value'][0];?>" 
                                        step="1"
                                        />
                                    <input 
                                        type="range" 
                                        class="max" 
                                        min="<?= $range['min'];?>" 
                                        max="<?= $range['max'];?>" 
                                        value="<?= $range['value'][1];?>" 
                                        step="1"
                                        />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3" role="link">
                            <a 
                                href="/cars/used/?!dealership=1489" 
                                class="d-block text-center c-yalightblack c-h-yalightblack bg-h-yayellow bg-yadarkyellow text-decoration-none b-radius-yaradius-15 but-lg fw-bold" 
                                style="padding: 12px;">
                                Показать <?= $arResult['FILTER']['totalCount'];?> авто</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
    </div>
</div>

<div class="container my-5 d-none d-lg-block brands-on-main">
    <div class="row mt-5 mb-3 cis-filter-on-main-brands">
        <div class="col-md-9">
            <h2 class="h3 fw-normal">Автомобили в наличии <a href="/dealerships/" role="top-menu-show-list-city">в <?= $arResult['FILTER']['in_city'];?></a></h2>
        </div>
        <div class="col-md-3 text-start text-md-end">
            <a href="/cars/used/" 
                class="c-yablack c-h-yablack text-decoration-none text-minus">
                Все марки
                <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
            </a>
        </div>
    </div>
    <div class="row mb-5">
        <?php foreach ( $arResult['FILTER']['BRANDS'] as $k => $item ) { ?>
        <div class="col-6 col-md-3 col-lg-2 cis-filter-on-main-brands-item">
            <a 
                href="/cars/used/<?= $item['code'];?>/" 
                class="text-decoration-none c-yadarkgray c-h-yadarkgray d-block b-radius-small py-1 px-2 d-flex align-items-center justify-content-between"
                >
                <?= $item['name'];?>
                <div class="b-radius-yaradius-3 bg-yalightgray c-yalightblack bg-h-yalightgray text-center fw-bold"><?= $item['vehicles'];?></div>
            </a>
        </div>
        <?php } ?>
    </div>
</div>

<script data-skip-moving="true">
	CONNECTOR.MAIN_FILTER = {};
	CONNECTOR.MAIN_FILTER.brands = [];
	CONNECTOR.MAIN_FILTER.models = [];
	CONNECTOR.MAIN_FILTER.price = [];
	CONNECTOR.MAIN_FILTER.DATA = <?= json_encode($arResult['FILTER']); ?>
</script>