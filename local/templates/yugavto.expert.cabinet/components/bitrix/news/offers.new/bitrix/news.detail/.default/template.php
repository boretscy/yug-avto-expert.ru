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

<div class="bg-yablue py-4">
	<div class="container">
		<div class="row">
			<div class="col">
				<h1 class="fw-normal c-yawhite"><?= $arResult['NAME'];?></h1>
				<p class="c-yawhite"><?= $arResult['DISPLAY_ACTIVE_FROM'];?></p>
			</div>
		</div>
	</div>
</div>
<div class="container my-4 offer">
	<div class="row my-4 desktop">
		<div class="col-2">
			<?php /* if ( $arResult['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'buyers' ) { ?>
			<a href="car" class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-small b-yablue bg-circle" role="scroll"><span>К списку автомобилей</span></a>
			<?php } */ ?>
		</div>
		<?php if ( $arResult['DATE_ACTIVE_TO'] ) { ?>
		<div class="col text-end text-minus c-yamiddlegray">
			Акция действует до: <span class="fw-bold"><?= FormatDate('j F Y', MakeTimeStamp($arResult['DATE_ACTIVE_TO']));?> г.</span>
			
			<div class="ms-3 d-inline-block b-yayellow py-2 px-4 b-radius-small">
				<div class="row text-center">
					<div class="col">
						<p class="c-yablue text-plus-plus fw-bold line-height-one p-0 m-0" role="days"><?= $arResult['TIMER']['Days'];?></p>
						<p class="text-minus-minus-minus c-yagray line-height-one p-0 m-0"><?= YApp::getWorld($arResult['TIMER']['Days'], 'd');?></p>
					</div>
					<div class="col">
						<p class="c-yablue text-plus-plus fw-bold line-height-one p-0 m-0" role="days"><?= $arResult['TIMER']['Hours'];?></p>
						<p class="text-minus-minus-minus c-yagray line-height-one p-0 m-0"><?= YApp::getWorld($arResult['TIMER']['Hours'], 'h');?></p>
					</div>
					<div class="col">
						<p class="c-yablue text-plus-plus fw-bold line-height-one p-0 m-0" role="days"><?= $arResult['TIMER']['Minuts'];?></p>
						<p class="text-minus-minus-minus c-yagray line-height-one p-0 m-0"><?= YApp::getWorld($arResult['TIMER']['Minuts'], 'm');?></p>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
	</div>
	<div class="row my-4">
		<div class="col">
			<img src="<?= $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?= $arResult['NAME'];?>" class="w-100  b-radius-yaradius-25" />
		</div>
	</div>
    <div class="row my-4 mobile">
        <div class="col-12 py-2">
            <?php if ( $arResult['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'buyers' ) { ?>
                <a href="#" class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-small b-yablue bg-circle" role="scroll"><span>К списку моделей</span></a>
            <?php } ?>
        </div>
		<?php if ( $arResult['DATE_ACTIVE_TO'] ) { ?>
        <div class="row">
			<div class="col text-start text-minus c-yamiddlegray">
				
				<div class="col-12 py-2">
						Акция действует до: <span class="fw-bold"><?= FormatDate('j F Y', MakeTimeStamp($arResult['DATE_ACTIVE_TO']));?> г.</span>
				</div>
				<div class="col-12 py-2">
					<div class="d-inline-block b-yayellow py-2 px-4 b-radius-small">
						<div class="row text-center">
							<div class="col">
								<p class="c-yablue text-plus-plus fw-bold line-height-one p-0 m-0" role="days"><?= $arResult['TIMER']['Days'];?></p>
								<p class="text-minus-minus-minus c-yagray line-height-one p-0 m-0"><?= YApp::getWorld($arResult['TIMER']['Days'], 'd');?></p>
							</div>
							<div class="col">
								<p class="c-yablue text-plus-plus fw-bold line-height-one p-0 m-0" role="days"><?= $arResult['TIMER']['Hours'];?></p>
								<p class="text-minus-minus-minus c-yagray line-height-one p-0 m-0"><?= YApp::getWorld($arResult['TIMER']['Hours'], 'h');?></p>
							</div>
							<div class="col">
								<p class="c-yablue text-plus-plus fw-bold line-height-one p-0 m-0" role="days"><?= $arResult['TIMER']['Minuts'];?></p>
								<p class="text-minus-minus-minus c-yagray line-height-one p-0 m-0"><?= YApp::getWorld($arResult['TIMER']['Minuts'], 'm');?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php } ?>
    </div>
	<?php if ( $arResult['PREVIEW_TEXT'] ) { ?>
	<div class="row my-5">
		<div class="col">
			<div class=" b-radius-yaradius-25 bg-yalightgray p-5">
				<?= $arResult['PREVIEW_TEXT'];?>
			</div>
		</div>
	</div>
	<?php } ?>
	<div class="row my-5">
		<div class="col-md"></div>
		<div class="col-md-9">
			<?= $arResult['DETAIL_TEXT'];?>
		</div>
		<div class="col-md"></div>
	</div>
	<?php if ( $arResult['PROPERTIES']['DISCLAMER']['VALUE'] ) { ?>
	<div class="row my-5">
		<div class="col">
			<a href="#offer-disclamer" data-remodal-target="offer-disclamer" class="text-decoration-none">Подробнее &rarr;</a>
		</div>
	</div>
	<div class="remodal text-start text-minus" data-remodal-id="offer-disclamer">
		<button data-remodal-action="close" class="remodal-close"></button>
		<div class="row">
			<div class="col">
				<?= $arResult['PROPERTIES']['DISCLAMER']['~VALUE']['TEXT'];?>
			</div>
		</div>
	</div>
	<?php } // if DISCLAMER ?>
</div>
<?php /* if ( $GLOBALS['DEALERSHIP'] ) { ?>
	<div class="my-5 py-5 bg-yalightgray">
		<div class="container offer-dealerships">
			<div class="row mb-3 offer-dealerships-title">
				<div class="col-6">
					<h3 class="fw-normal">Ждем вас в наших дилерских центрах</h3>
				</div>
				<div class="col-6 text-end pt-2">
					<a href="/dealerships/" class="c-yablack c-h-yablack text-decoration-none">
						Смотреть все
						<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
					</a>
				</div>
			</div>
			<div class="row mb-3">
				<div class="col-md-6 offer-dealerships-items">
					<?php foreach ( $arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'] as $item ) { ?>
						<div class="p-4 b-radius-small bg-yawhite b-yagray mb-3 offer-dealerships-item">
							<div class="row">
								<div class="col-10">
									<div class="h3"><?= $item['NAME'];?></div>
								</div>
								<div class="col-2">
									<img src="<?= CFile::GetPath( $arResult['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'][ $arResult['DISPLAY_PROPERTIES']['BRAND']['VALUE'][0] ]['PREVIEW_PICTURE'] );?>" class="w-100" alt="" />
								</div>
							</div>
							<p><?= $item['PROPERTY_ADDRESS'];?></p>
							<div class="row my-3">
								<div class="col-6">
									<a href="https://yandex.ru/maps/?ll=<?= $item['PROPERTY_COORDS_LON'];?>,<?= $item['PROPERTY_COORDS_LAT'];?>&z=15&mode=routes&rtext=~<?= $item['PROPERTY_COORDS_LAT'];?>,<?= $item['PROPERTY_COORDS_LON'];?>&rtt=auto&ruri=~" alt="<?= $item['NAME'];?>" target="_blank">Построить маршрут</a>
								</div>
								<div class="col-6 text-end">
									<a href="tel:+<?= YApp::phoneIn($item['PROPERTY_PHONE']);?>" class="text-plus-plus c-yablack c-h-yablack text-decoration-none fw-bold"><?= YApp::phoneOut($item['PROPERTY_PHONE']);?></a>
								</div>
							</div>
							<div class="row">
								<div class="col-4">
									<a 
										href="#FORM_CALLBACK"  
										data-remodal-target="FORM_CALLBACK"
										class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-small b-yablue bg-circle"
										role="setDealership"
										data-dealership="<?= $item['PROPERTY_EXTERNAL_CODE'];?>"
										><span>Заказать звонок</span></a>
								</div>
								<?php if ( $item['PROPERTY_IS_NEW'] ) { ?>
								<div class="col-4">
									<a 
										href="/cars/new?dealership=<?= $item['CODE'];?>" 
										class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-small b-yablue bg-circle"
										><span>Автомобили в наличии</span></a>
								</div>
								<?php } ?>
								<div class="col-4">
									<a 
										href="/services/service/?dealership=<?= $item['CODE'];?>" 
										class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-small b-yablue bg-circle"
										><span>Запись на сервис</span></a>
								</div>
							</div>
						</div>
					<?php } // foreach DEALERSHIPS ?>
				</div>
				<div class="col-md-6 offer-dealerships-map">
					<div id="offerMap"></div>
				</div>
			</div>
			<?php // YApp::sp( $arResult['DISPLAY_PROPERTIES']['BRAND'] ); ?>
		</div>
	</div>
<?php } // if DEALERSHIPS */ ?>
<?php /* if ( $arResult['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'buyers' ) { ?>
	<div class="container my-5 offer-cis" data-scroll="offer-cis">
		<div class="row mb-3 offer-cis-title">
			<div class="col">
				<h3 class="fw-normal">Автомобили, учавствующие в акции</h2>
			</div>
			<div class="col-6 text-end pt-2">
				<a href="/cars/<?= $arResult['MODE'];?>/?dealership=<?= implode(',', $arResult['DCs']);?>" class="c-yablack c-h-yablack text-decoration-none">
					Смотреть все
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
				</a>
			</div>
		</div>
		<div class="row cis-new" role="cis">
			<div class="col position-relative">
				
				<div class="swiper-cis-new pb-5">
					<div class="swiper-wrapper" role="cis-new-swiper">
						<?php foreach ( $arResult['VEHICLES'] as $item ) { ?>
						<div class="swiper-slide">
							<div class="available__grid-item">
								<div class="grid-item__head">
									<a href="<?= $item['link'];?>" class="grid-item__head-img"><img src="<?= $item['image'];?>" alt="<?= $item['name'];?>"></a>
								</div>
								<div  class="head_items-box">
									<div class="head_items">
										<a href="<?= $item['link'];?>" class="grid-item__title"><?= $item['name'];?></a>
									</div>
									<div class="model__grid-card__content--list">
										<?php foreach ( $item['general'] as $g ) { ?>
											<?php if ($g) { ?><span  class="model__grid-card__content--list-item"><?= $g?></span><?php } ?>
										<?php } ?>
									</div>
									<div  class="model__grid-card__footer">
										<div  class="model__grid-card__content--price">
											<div  class="model__grid-card__content--price_curent"><?= YApp::formatNumber($item['price']);?> <span  class="rub">₽</span></div>
										</div>
										<a href="<?= $item['link'];?>" class="button transparent w100"><span >ПОЛУЧИТЬ ПРЕДЛОЖЕНИЕ</span></a>
									</div>
								</div>
							</div>
						</div>
						<?php } // foreach USED ?>
					</div>
					<div class="swiper-pagination"></div>
				</div>
					
				<div class="swiper-cis-new-button-prev b-yablue">
					<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-left"></use></svg></div>
				</div>
				<div class="swiper-cis-new-button-next b-yablue">
					<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
				</div>

			</div>
		</div>
	</div>
<?php } ?>
<?php $this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU'); ?>
<script>
var offerMap;
ymaps.ready(OfferMapInit);

function OfferMapInit () {
	
    offerMap = new ymaps.Map('offerMap', {

        center: [45.044963, 38.971193],
        zoom: 10
    }, {
        searchControlProvider: 'yandex#search'
    });
	<?php 
		$geoStr = 'offerMap.geoObjects';
		foreach ($arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'] as $item) {
			$geoStr .= '.add(new ymaps.Placemark(';
			$geoStr .= '['.$item['PROPERTY_COORDS_LAT'].', '.$item['PROPERTY_COORDS_LON'].'],';
			$geoStr .= '{balloonContent: "'.$item['NAME'].'", iconCaption: "'.$item['NAME'].'"},';
			$geoStr .= '{preset: "islands#darkBlueDotIconWithCaption"}';
			$geoStr .= '))';
		}
		echo PHP_EOL.$geoStr.PHP_EOL;
	?>
}
</script>
*/?>