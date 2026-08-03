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
<div data-nosnippet class="container mt-4 compilations-on-main">
	<div class="row mb-3">
		<div class="col-6">
			<h3 class="fw-normal h2">Подборки</h3>
		</div>
		<div class="col-6 text-end text-minus pt-0 pt-md-2">
			<a href="/cars/used/" class="c-yablack c-h-yablack text-decoration-none text-minus">
				Все автомобили
				<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
			</a>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col">
			<div class="collections__list">
				<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
					<a 
						<?php /* href="<?= $arItem['PROPERTIES']['LINK']['VALUE'];?>"  */ ?>
						class="bg-yalightgray bg-h-yagray c-yablack c-h-yablack text-decoration-none text-minus-minus text-uppercase py-2 px-3 b-radius-yaradius-15 text-nowrap fw-bold"
						href="#" 
						data-query="<?= $arItem['PROPERTIES']['QUERY']['VALUE'];?>"
						data-link="<?= $arItem['PROPERTIES']['LINK']['VALUE'];?>"
						><?= $arItem['NAME'];?></a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<div data-nosnippet class="container mt-4 dealership-cis" data-scroll="dealership-cis">
	<div class="row cis-new" role="cis">
		<div class="col position-relative">
			
			<div class="swiper-cis-compilations pb-5">
				<div class="swiper-wrapper" role="cis-new-swiper">
				<?php $vehicles = $arResult['VEHICLES'];?>
                <?php foreach ( $vehicles as $item ) { ?>
                    <?php
                        $data['FAVORITES'] = ( json_decode($_COOKIE['CIS_FAVORITES'], true) ) ?: [];
                        $data['COMPARE'] = ( json_decode($_COOKIE['CIS_COMPARE'], true) ) ?: [];
                    ?>
					<?php $item['_general'] = $item['general']; ?>
                    <?php $item['id'] = $item['ext_id']; ?>
                    <?php $item['offer_link'] = true; ?>
					<div class="swiper-slide">
						<?php
						$vehicleMode = 'used';
						include $_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/include/item_vehicle.php';
						?>
					</div>
					<?php } // foreach USED ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
				
			<div class="swiper-cis-compilations-button-prev">
				<div class="swiper-button-inner-circle b-yayellow bg-h-yayellow"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-left"></use></svg></div>
			</div>
			<div class="swiper-cis-compilations-button-next">
				<div class="swiper-button-inner-circle b-yayellow bg-h-yayellow"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
			</div>

		</div>
	</div>
</div>
