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
			<div class="col"><h1 class="h1 fw-normal c-yawhite"><?= $arResult['NAME'];?></h1></div>
		</div>
	</div>
</div>

<?php if ( !$_GET['dealership'] ) { ?>
<div class="container my-5 filter dealerships-filter">
	<div class="row">
		<div class="col-md-4 col-xl-2">
			<div class="filter-dropcontainer position-relative">
				<div class="b-radius-yaradius-15 bg-yalightgray filter-dropdown d-flex justify-content-between c-yadarkgray position-relative">
					<span><?= $arResult['vuefilter']['items']['city']['title'];?></span>
					<?php if ( $_GET['city'] && count(explode(',', $_GET['city'])) != 0 ) { ?>
					<span><?= count(explode(',', $_GET['city']));?> выбрано</span>
					<?php } ?>
					<span><img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/drop-corner.svg" /></span>
				</div>
				<div class="filter-droplist bg-yawhite w-100 position-absolute d-none">
					<?php foreach ( $arResult['vuefilter']['items']['city']['items'] as $item ) { ?>
					<a href="<?= YApp::makeFilterUrl($_GET, ['city'=>$item['name']]);?>" 
						class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= (($item['selected'])?'bg-yalightgray selected fw-bold':'');?>"
						data-name="brand"
						data-value="<?= $item['name'];?>"
						><?= $item['name'];?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xl-2 mt-3 mt-md-0">
			<div class="filter-dropcontainer position-relative">
				<div class="b-radius-yaradius-15 bg-yalightgray filter-dropdown d-flex justify-content-between c-yadarkgray position-relative">
					<span><?= $arResult['vuefilter']['items']['brand']['title'];?></span>
					<?php if ( $_GET['brand'] && count(explode(',', $_GET['brand'])) != 0 ) { ?>
					<span><?= count(explode(',', $_GET['brand']));?> выбрано</span>
					<?php } ?>
					<span><img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/drop-corner.svg" /></span>
				</div>
				<div class="filter-droplist bg-yawhite w-100 position-absolute d-none">
					<?php foreach ( $arResult['vuefilter']['items']['brand']['items'] as $item ) { ?>
					<a href="<?= YApp::makeFilterUrl($_GET, ['brand'=>$item['code']]);?>" 
						class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= (($item['selected'])?'bg-yalightgray selected fw-bold':'');?>"
						data-name="brand"
						data-value="<?= $item['code'];?>"
						><?= $item['name'];?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xl-1 mt-3 mt-md-0">
			<a href="<?= YApp::makeFilterUrl($_GET, []);?>" class="b-radius-yaradius-15 c-yalightblack c-h-yalightblack bg-yayellow text-decoration-none text-center filter-button d-block">Сбросить</a>
		</div>
		<div class="col-md-10 col-xl-6 mt-3 mt-xl-0 d-flex justify-content-start justify-content-xl-end align-items-center">

			<div class="row d-md-none">
				<div class="col-6 py-2 d-flex align-items-center">
					<span class="b-radius-yaradius-7 bg-<?= ((!$_GET['tag'])?'yayellow':'yalightgray');?> ms-4 me-2 d-inline-block check d-flex justify-content-center align-items-center">
						<?php if (!$_GET['tag']) { ?>
						<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/check.svg" />
						<?php } ?>
					</span>
					<span><a href="<?= YApp::makeFilterUrl($_GET, ['tag'=>false]);?>" class="c-yalightblack c-h-yadarkgray text-decoration-none">Все</a></span>
				</div>
				<?php foreach ( $arResult['vuefilter']['items']['tag']['items'] as $item ) { ?>
				<div class="col-6 py-2 d-flex align-items-center">
					<span class="b-radius-yaradius-7 bg-<?= (($item['selected'])?'yayellow':'yalightgray');?> ms-4 me-2 d-inline-block check d-flex justify-content-center align-items-center">
						<?php if ($item['selected']) { ?>
						<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/check.svg" />
						<?php } ?>
					</span>
					<span><a href="<?= YApp::makeFilterUrl($_GET, ['tag'=>$item['code']]);?>" class="c-yalightblack c-h-yadarkgray text-decoration-none"><?= $item['name'];?></a></span>
				</div>
				<?php } ?>
			</div>



			<span class="b-radius-yaradius-7 bg-<?= ((!$_GET['tag'])?'yayellow':'yalightgray');?> ms-0 ms-xl-4 me-2 d-inline-block check d-none d-md-flex justify-content-center align-items-center">
				<a href="<?= YApp::makeFilterUrl($_GET, ['tag'=>false]);?>" class="c-yalightblack c-h-yadarkgray text-decoration-none">
                <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/<?= (($_GET['tag'])?'un':'');?>check.svg" />
				</a>
            </span>
			<span class="d-none d-md-block"><a href="<?= YApp::makeFilterUrl($_GET, ['tag'=>false]);?>" class="c-yalightblack c-h-yadarkgray text-decoration-none">Все</a></span>
			<?php foreach ( $arResult['vuefilter']['items']['tag']['items'] as $item ) { ?>
			<span class="b-radius-yaradius-7 bg-<?= (($item['selected'])?'yayellow':'yalightgray');?> ms-4 me-2 d-inline-block check d-none d-md-flex justify-content-center align-items-center">
				<a href="<?= YApp::makeFilterUrl($_GET, ['tag'=>$item['code']]);?>" class="c-yalightblack c-h-yadarkgray text-decoration-none">
                <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/<?= ((!$item['selected'])?'un':'');?>check.svg" />
				</a>
            </span>
			<span class="d-none d-md-block"><a href="<?= YApp::makeFilterUrl($_GET, ['tag'=>$item['code']]);?>" class="c-yalightblack c-h-yadarkgray text-decoration-none"><?= $item['name'];?></a></span>
			<?php } ?>
		</div>
		<?php $modeGET = $_GET; unset($modeGET['mode']); ?>
		<div class="col-md-2 col-xl-1 mt-3 mt-xl-0">
			<a 
				href="<?= YApp::makeFilterUrl($modeGET, ['mode'=>(( $arResult['MODE']=='list')?'map':'list')]);?>" 
				class="b-radius-yaradius-15 c-yadarkgray c-h-yadarkgray b-yagray text-decoration-none text-center filter-button-sm d-block"
				><?= (( $arResult['MODE']=='list')?'На карте':'Списком');?></a>
		</div>
	</div>
</div>
<?php } ?>

<?php if ( $arResult['MODE'] == 'map' ) { ?>
<div class="container my-4">
	<div class="row">
		<div class="col-lg-6 dealerships-map-items">
			<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
			<div class="p-4 b-radius-yaradius-25 bg-yawhite b-yagray mb-3 offer-dealerships-item">
				<div class="row">
                    <div class="col-12 col-sm-12 mobile m-img" style="background-image: url(<?= $arItem['DETAIL_PICTURE']['SRC'];?>); background-size: cover"></div>
					<div class="col-12 col-sm-12 col-lg-12">
                        <div class="row">
                            <div class="col-8 col-md-10">
                                <div class="h3"><a href="<?= $arItem['DETAIL_PAGE_URL'];?>" class="c-yablack c-h-yablack text-decoration-none" alt="<?= $arItem['NAME'];?>"><?= $arItem['NAME'];?></a>
                                </div>
                                <p><?= $arItem['PROPERTIES']['ADDRESS']['VALUE'];?></p>
                            </div>
                            <div class="col-4 col-md-2">
                                <img src="<?= $arItem['PROPERTIES']['BRAND']['PICTURE'];?>" class="w-100" alt="<?= $arItem['PROPERTIES']['BRAND']['TITLE'];?>" />
                            </div>
                            <div class="col-6">
								<?php if ( $_GET['dealership'] ) { ?>
								<?= $arItem['PROPERTIES']['PPP']['VALUE'];?> км 
								<?php } ?>
                                <a href="https://yandex.ru/maps/?ll=<?= $arItem['PROPERTIES']['COORDS_LON']['VALUE'];?>,<?= $arItem['PROPERTIES']['COORDS_LAT']['VALUE'];?>&z=15&mode=routes&rtext=~<?= $arItem['PROPERTIES']['COORDS_LAT']['VALUE'];?>,<?= $arItem['PROPERTIES']['COORDS_LON']['VALUE'];?>&rtt=auto&ruri=~" target="_blank" alt="<?= $arResult['NAME'];?>">Построить маршрут</a>
                            </div>
                            <div class="col-6 text-end">
                                <a href="tel:+<?= YApp::phoneIn($arItem['PROPERTIES']['PHONE']['VALUE']);?>" class="c-yablack c-h-yablack text-decoration-none fw-bold text-phone"><?= YApp::phoneOut($arItem['PROPERTIES']['PHONE']['VALUE']);?></a>
                            </div>
                        </div>
                    </div>
				</div>


				<div class="row mt-3 mobile_button">
					<div class="col-12 col-md-4 mb-md-0 mb-3">
						<a 
							href="#FORM_CALLBACK" 
							data-form="FORM_CALLBACK"
							class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-yaradius-15 bg-yayellow c-yablackgray c-h-yablackgray"
							role="setDealership"
							data-dealership="<?= $arItem['CODE'];?>"
							><span>Заказать звонок</span></a>
					</div>
					<?php if ( !empty($arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('showroom', $arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) ) { ?>
					<div class="col-12 col-md-4 mb-md-0 mb-3">
						<a 
							href="/cars/used/?dealership=<?= $arItem['PROPERTIES']['EXTERNAL_CODE']['VALUE'];?>" 
							class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-yaradius-15 bg-yalightgray c-yablackgray c-h-yablackgray"
							><span>Автомобили в наличии</span></a>
					</div>
					<?php } ?>
					<?php if ( !empty($arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('service', $arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) ) { ?>
					<div class="col-12 col-md-4 mb-md-0 mb-3">
						<a 
							href="#FORM_SERVICE"
							data-form="FORM_SERVICE"
							class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-yaradius-15 bg-yalightgray c-yablackgray c-h-yablackgray"
							role="setDealership"
							data-dealership="<?= $arItem['CODE'];?>"
							><span>Запись на сервис</span></a>
					</div>
					<?php } ?>
				</div>
			</div>
			<?php } // foreach ITEMS ?>
		</div>
		<div class="col-lg-6 mt-lg-0 mt-3">
			<div id="dealershipsMap"></div>
		</div>
	</div>
</div>
<?php $this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU'); ?>
<script>
var dealershipsMap;
ymaps.ready(dealershipsMapInit);

function dealershipsMapInit () {
	
    dealershipsMap = new ymaps.Map('dealershipsMap', {

        center: [45.348370, 39.393297],
		<?php /*
			$geoStr = 'center: ';
			foreach ($arResult['ITEMS'] as $arItem) {
				if ($arItem['PROPERTIES']['COORDS_LAT']['VALUE'] && $arItem['PROPERTIES']['COORDS_LON']['VALUE']) {
					$geoStr .= '['.(float)$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].', '.(float)$arItem['PROPERTIES']['COORDS_LON']['VALUE'].'],';
					break;
				}
			}
			echo PHP_EOL.$geoStr.PHP_EOL
		*/?>
        zoom: 6.2
    }, {
        searchControlProvider: 'yandex#search'
    });
	dealershipsMap.behaviors.disable('scrollZoom');
	<?php 
		$geoStr = 'dealershipsMap.geoObjects';
		foreach ($arResult['ITEMS'] as $arItem) {
			if ($arItem['PROPERTIES']['COORDS_LAT']['VALUE'] && $arItem['PROPERTIES']['COORDS_LON']['VALUE']) {
				$geoStr .= '.add(new ymaps.Placemark(';
				$geoStr .= '['.(float)$arItem['PROPERTIES']['COORDS_LAT']['VALUE'].', '.(float)$arItem['PROPERTIES']['COORDS_LON']['VALUE'].'],';
				$geoStr .= '{balloonContent: "'.$arItem['NAME'].'", iconCaption: "'.$arItem['NAME'].'"},';
				$geoStr .= '{preset: "islands#darkBlueDotIconWithCaption"}';
				$geoStr .= '))';
			}
		}
		echo PHP_EOL.$geoStr.PHP_EOL;
	?>
	dealershipsMap.setBounds(dealershipsMap.geoObjects.getBounds()).
		then( function() {
			dealershipsMap.setZoom( dealershipsMap.getZoom() - 1 )
		});
}
</script>
<?php } else { ?>
<div class="container my-5">
	<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
	<div class="row my-4">
		<div class="col-12 px-1">
			<div class="row dealerships-item b-yagray b-radius-yaradius-25 mx-2">
				<div class="col-sm-12 col-md-4 col-lg px-0 dealerships-item-image" <?php /* style="background-image: url(<?= $arItem['DETAIL_PICTURE']['SRC'];?>);" */ ?>>
                    <picture class="w-100">
                        <source srcset="<?= CFile::GetPath($arItem['PROPERTIES']['PIC_MOBILE_PREVIEW']['VALUE']);?>" media="(max-width:500px)">
                    	<source srcset="<?= CFile::GetPath($arItem['PROPERTIES']['PIC_TABLET_PREVIEW']['VALUE']);?>" media="(max-width:768px)">
                        <img src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?=$arItem['NAME'];?>" class="w-100">
                    </picture>
				</div>
				<div class="col-sm-12 col-md-8 col-lg-6 p-4 b-r-yagray">
					<div class="row">
						<div class="col-10">
							<div class="h4 fw-bold"><a href="<?= $arItem['DETAIL_PAGE_URL'];?>" class="c-yablack c-h-yablack text-decoration-none" alt="<?= $arItem['NAME'];?>"><?= $arItem['NAME'];?></a></div>
							<p><?= $arItem['PROPERTIES']['ADDRESS']['VALUE'];?></p>
							
							<?php if ( $_GET['dealership'] ) { ?>
								<?= $arItem['PROPERTIES']['PPP']['VALUE'];?> км 
								<?php } ?>
							<a href="https://yandex.ru/maps/?ll=<?= $arItem['PROPERTIES']['COORDS_LON']['VALUE'];?>,<?= $arItem['PROPERTIES']['COORDS_LAT']['VALUE'];?>&z=15&mode=routes&rtext=~<?= $arItem['PROPERTIES']['COORDS_LAT']['VALUE'];?>,<?= $arItem['PROPERTIES']['COORDS_LON']['VALUE'];?>&rtt=auto&ruri=~" target="_blank" alt="<?= $arResult['NAME'];?>">Построить маршрут</a>
							<div class="row">
								<div class="col-md-6 mt-3">
									<?php if ($arItem['PROPERTIES']['WORK']['VALUE'][0]) { ?>
									<div class="text-minus-minus c-yagray"><?= $arItem['PROPERTIES']['WORK']['DESCRIPTION'][0];?>:</div>
									<div class="text-minus"><?= $arItem['PROPERTIES']['WORK']['VALUE'][0];?></div>
									<?php } ?>
								</div>
								<div class="col-md-6 mt-3">
									<?php if ($arItem['PROPERTIES']['WORK']['VALUE'][1]) { ?>
									<div class="text-minus-minus c-yagray"><?= $arItem['PROPERTIES']['WORK']['DESCRIPTION'][1];?>:</div>
									<div class="text-minus"><?= $arItem['PROPERTIES']['WORK']['VALUE'][1];?></div>
									<?php } ?>
								</div>
								<div class="col-md-6 mt-2">
									<?php if ($arItem['PROPERTIES']['BRAND']['LINK']) { ?>
									<div class="text-minus-minus c-yagray">Сайт:</div>
									<div class="text-minus">
										<a href="<?= $arItem['PROPERTIES']['BRAND']['LINK'];?>" target="_blank" class="text-decoration-none c-yablack c-h-yadarkgray"><?= parse_url($arItem['PROPERTIES']['BRAND']['LINK'])['host'];?></a>
									</div>
									<?php } ?>
								</div>
								<div class="col-md-6 mt-2">
									<?php if ( $arItem['PROPERTIES']['PHONE']['VALUE'] ) { ?>
									<div class="text-minus-minus c-yagray">Номер телефона:</div>
									<div class="text-minus">
										<a href="tel:<?= YApp::phoneIn($arItem['PROPERTIES']['PHONE']['VALUE']);?>" class="text-decoration-none fw-bold c-yablack c-h-yadarkgray text-phone"><?= YApp::phoneOut($arItem['PROPERTIES']['PHONE']['VALUE']);?></a>
									</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="col-2">
							<img src="<?= $arItem['PROPERTIES']['BRAND']['PICTURE'];?>" class="w-100 custom-m" alt="<?= $arItem['PROPERTIES']['BRAND']['TITLE'];?>" />
						</div>
					</div>
					<div class="row mt-4">
						<div class="col-md-4 mb-md-0 mb-3">
							<a 
								href="#FORM_CALLBACK" 
								data-form="FORM_CALLBACK"
								class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-yaradius-15 bg-yayellow c-yablackgray c-h-yablackgray"
								role="setDealership"
								data-dealership="<?= $arItem['CODE'];?>"
								><span>Заказать звонок</span></a>
						</div>
						<?php if ( !empty($arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('showroom', $arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) ) { ?>
						<div class="col-md-4 mb-md-0 mb-3">
							<a 
								href="/cars/used/?dealership=<?= $arItem['PROPERTIES']['EXTERNAL_CODE']['VALUE'];?>" 
								class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-yaradius-15 bg-yalightgray c-yablackgray c-h-yablackgray"
								><span>Автомобили в наличии</span></a>
						</div>
						<?php } ?>
						<?php if ( !empty($arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) && in_array('service', $arItem['PROPERTIES']['TAG']['VALUE_XML_ID']) ) { ?>
						<div class="col-md-4 mb-md-0 mb-3">
							<a 
								href="#FORM_SERVICE"
								data-form="FORM_SERVICE"
								class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-yaradius-15 bg-yalightgray c-yablackgray c-h-yablackgray"
								role="setDealership"
								data-dealership="<?= $arItem['CODE'];?>"
								><span>Запись на сервис</span></a>
						</div>
						<?php } ?>
					</div>
				</div>
				<div class="col-3 col-lg p-4 text-minus-minus-minus dealerships-item-history desktop">
					<div class="row">
						<div class="col-3 text-end pe-3 position-relative">
							<?php if ($arItem['HISTORY']) { ?>
							<div class="dealerships-item-history-line"></div>
							<div class="dealerships-item-history-arrow"></div>
							<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ds-cup"></use></svg>
							<?php } // if HISTORY ?>
						</div>
						<div class="col">
							<a href="/about/history/" class="c-yamiddlegray c-h-yadarkgray">История компании</a>
						</div>
					</div>
					<?php foreach ( $arItem['HISTORY'] as $item ) { ?>
					<div class="row c-yamiddlegray">
						<div class="col-3 text-end pe-3 position-relative pt-3">
							<div class="dealerships-item-history-line"></div>
							<?= $item['SECTION'];?>
						</div>
						<div class="col pt-3">
							<?= $item['~NAME'];?>
						</div>
					</div>
					<?php } // foreach HISTORY ?>
				</div>
			</div> 
		</div>
			
	</div>
	<?php } // foreach ITEMS ?>
</div>
<?php } ?>

<?php // YApp::sp( $arResult['ITEMS'][0]['PROPERTIES'] ); ?>

<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.2" width="0" height="0" display="none" aria-hidden="true">
    
	<symbol id="ds-map" viewbox="0 0 19 19">
		<path d="M18.3222 1.90001e-05C18.2163 -8.52516e-05 18.1119 0.0259998 18.0185 0.0759302L12.8915 2.66661L7.07607 0.080995H7.04567L6.96474 0.0557016H6.88368H6.71674H6.63568L6.55474 0.080995H6.52435L0.420551 2.79311C0.300222 2.84677 0.197932 2.93407 0.126093 3.0445C0.0542543 3.15492 0.0159065 3.28374 0.015625 3.41547V18.3422C0.0159364 18.4549 0.0442628 18.5657 0.0981672 18.6647C0.152072 18.7636 0.229785 18.8476 0.324293 18.9089C0.418276 18.9714 0.526659 19.0088 0.63914 19.0176C0.751621 19.0265 0.864488 19.0065 0.967084 18.9596L6.80274 16.3689L12.6333 18.9596C12.6333 18.9596 12.6334 18.9596 12.6637 18.9596C12.7432 18.9956 12.8295 19.0143 12.9168 19.0143C13.0041 19.0143 13.0904 18.9956 13.1699 18.9596H13.2003L18.631 16.2474C18.7441 16.1902 18.8389 16.1026 18.9051 15.9945C18.9712 15.8863 19.006 15.7619 19.0055 15.6352V0.683127C19.0062 0.593234 18.989 0.504108 18.9549 0.420928C18.9208 0.337747 18.8704 0.262164 18.8068 0.198599C18.7432 0.135033 18.6677 0.0847576 18.5845 0.0506676C18.5013 0.0165776 18.4121 -0.000654379 18.3222 1.90001e-05ZM6.10941 15.1798L1.35681 17.2898V3.83545L6.10941 1.72547V15.1798ZM12.2132 17.2898L7.4658 15.1798V1.72547L12.2132 3.83545V17.2898ZM17.6439 15.2051L13.5949 17.2291V3.82028L17.6439 1.79632V15.2051Z" />
    </symbol>

	<symbol id="ds-list" viewbox="0 0 19 19">
		<path d="M0.992186 9.50558C0.992186 9.20599 1.08627 8.91862 1.25371 8.70678C1.42115 8.49494 1.64824 8.37598 1.88504 8.37598L18.0993 8.37598C18.3361 8.37598 18.5632 8.49494 18.7307 8.70678C18.8981 8.91862 18.9922 9.20599 18.9922 9.50558C18.9922 9.80518 18.8981 10.0924 18.7307 10.3043C18.5632 10.5161 18.3361 10.6352 18.0993 10.6352L1.88504 10.6352C1.64824 10.6352 1.42115 10.5161 1.25371 10.3043C1.08627 10.0924 0.992186 9.80517 0.992186 9.50558Z" />
		<path d="M0.992187 17.1296C0.992187 16.83 1.08627 16.5426 1.25371 16.3308C1.42116 16.119 1.64824 16 1.88504 16L18.0993 16C18.3361 16 18.5632 16.119 18.7307 16.3308C18.8981 16.5426 18.9922 16.83 18.9922 17.1296C18.9922 17.4292 18.8981 17.7164 18.7307 17.9283C18.5632 18.1401 18.3361 18.2592 18.0993 18.2592L1.88504 18.2592C1.64824 18.2592 1.42116 18.1401 1.25371 17.9283C1.08627 17.7164 0.992187 17.4292 0.992187 17.1296Z" />
		<path d="M0.992197 1.14645C0.992197 0.846862 1.08628 0.55949 1.25372 0.347647C1.42116 0.135805 1.64825 0.0168453 1.88505 0.0168453L9.13058 0.0168457C9.36738 0.0168457 9.5945 0.135805 9.76194 0.347647C9.92938 0.55949 10.0234 0.846863 10.0234 1.14645C10.0234 1.44604 9.92938 1.73342 9.76194 1.94526C9.5945 2.1571 9.36738 2.27606 9.13058 2.27606L1.88505 2.27606C1.64825 2.27606 1.42116 2.1571 1.25372 1.94526C1.08628 1.73342 0.992197 1.44604 0.992197 1.14645Z" />
    </symbol>

	<symbol id="ds-cup" viewbox="0 0 19 21">
		<path d="M13.0889 18.3453H5.91109C5.79911 18.3453 5.69165 18.2991 5.61247 18.2168C5.53329 18.1345 5.48887 18.0229 5.48887 17.9065V15.3047C5.48899 15.2313 5.50679 15.1591 5.54072 15.0947C5.57465 15.0303 5.62362 14.9758 5.68308 14.9361L8.02221 13.3961V13.1548C6.93709 12.6282 5.98708 11.5094 5.26508 9.89916C4.41728 9.78637 3.59697 9.51116 2.84576 9.08747C1.95583 8.57941 1.22356 7.81846 0.734646 6.89367C0.474009 6.39103 0.280763 5.85367 0.160378 5.29658C0.0367935 4.73674 -0.025503 4.16417 -0.025375 3.58979C-0.0259003 3.34208 -0.013177 3.09454 0.0126621 2.84829L0.101312 2.18575C0.115652 2.08033 0.166398 1.98393 0.24408 1.9145C0.321763 1.84508 0.421081 1.80738 0.523534 1.80843H3.71556C3.71556 1.51007 3.71556 1.21172 3.71556 0.908975C3.71556 0.792608 3.75997 0.681014 3.83915 0.598731C3.91834 0.516448 4.0258 0.470215 4.13778 0.470215H14.8537C14.9657 0.470215 15.0731 0.516448 15.1523 0.598731C15.2314 0.681014 15.276 0.792608 15.276 0.908975C15.276 1.21172 15.276 1.51007 15.276 1.80843H18.4595C18.562 1.80738 18.6613 1.84508 18.739 1.9145C18.8167 1.98393 18.8674 2.08033 18.8818 2.18575L18.9662 2.84829C18.997 3.09411 19.0112 3.3419 19.0084 3.58979C19.0079 4.25202 18.9241 4.91136 18.7593 5.55106C18.5344 6.44501 18.1107 7.27158 17.5222 7.96424C17.0406 8.51699 16.4578 8.96447 15.808 9.28052C15.1537 9.59474 14.4578 9.80477 13.7433 9.90355C13.0213 11.5182 12.0755 12.637 10.9862 13.1635V13.4049L13.3252 14.9449C13.3847 14.9845 13.4337 15.039 13.4676 15.1034C13.5015 15.1678 13.5194 15.2401 13.5195 15.3135V17.9153C13.5184 17.9729 13.5064 18.0298 13.4842 18.0826C13.462 18.1354 13.4299 18.1831 13.3899 18.223C13.3499 18.2629 13.3028 18.2943 13.2511 18.3153C13.1995 18.3363 13.1443 18.3465 13.0889 18.3453ZM6.33332 17.4678H12.6666V15.5504L10.3275 14.0103C10.2675 13.9703 10.2181 13.9151 10.1841 13.8499C10.1502 13.7847 10.1327 13.7116 10.1333 13.6374V12.8608C10.1339 12.7719 10.1604 12.6853 10.2094 12.6124C10.2584 12.5395 10.3276 12.4839 10.4077 12.4527C11.4464 12.0491 12.3626 10.9653 13.0635 9.31561C13.0932 9.2456 13.14 9.18488 13.1993 9.13947C13.2585 9.09406 13.3282 9.06555 13.4013 9.05675C14.1058 8.9817 14.7934 8.786 15.4363 8.47758C15.9854 8.20951 16.4777 7.83066 16.8846 7.36312C17.3854 6.77228 17.7455 6.06739 17.936 5.30533C18.0818 4.73263 18.1556 4.1427 18.1555 3.55029C18.1576 3.34352 18.1463 3.13685 18.1217 2.93165L18.0837 2.65084H14.8537C14.7969 2.65061 14.7406 2.63846 14.6884 2.61509C14.6362 2.59172 14.589 2.5576 14.5497 2.51482C14.5103 2.47243 14.4796 2.42222 14.4592 2.36719C14.4389 2.31216 14.4295 2.25344 14.4315 2.19454C14.4315 1.90496 14.4315 1.61099 14.4526 1.31702H4.58949C4.58949 1.61538 4.58949 1.90934 4.58949 2.19454C4.59149 2.25344 4.58207 2.31216 4.56176 2.36719C4.54144 2.42222 4.51065 2.47243 4.47125 2.51482C4.43201 2.5576 4.38485 2.59172 4.33261 2.61509C4.28037 2.63846 4.22414 2.65061 4.16726 2.65084H0.920399L0.882362 2.93165C0.86025 3.13851 0.850453 3.34657 0.85288 3.55468C0.851977 4.06269 0.907183 4.56912 1.0175 5.06402C1.12077 5.54457 1.28695 6.00813 1.51147 6.44173C1.91646 7.22448 2.52904 7.87011 3.27643 8.30207C4.00144 8.70713 4.79643 8.95914 5.61556 9.04358C5.68825 9.05196 5.75756 9.07981 5.81677 9.12442C5.87599 9.16903 5.92298 9.22888 5.95325 9.29806C6.65414 10.9522 7.5746 12.0359 8.60905 12.4352C8.68919 12.4663 8.75837 12.522 8.80738 12.5948C8.85639 12.6677 8.88298 12.7544 8.88355 12.8433V13.6198C8.88415 13.694 8.8666 13.7671 8.83263 13.8323C8.79867 13.8975 8.74931 13.9528 8.68925 13.9928L6.35022 15.5329L6.33332 17.4678ZM4.978 8.28014C4.94576 8.28441 4.91303 8.28441 4.88079 8.28014C4.51514 8.19566 4.15979 8.06911 3.82112 7.90281C3.34113 7.67408 2.91035 7.34729 2.55445 6.94193C2.11782 6.42735 1.80516 5.81224 1.64238 5.14738C1.52727 4.70332 1.46211 4.2469 1.44818 3.78724C1.44672 3.72803 1.45682 3.66913 1.47786 3.61408C1.49891 3.55903 1.53048 3.50899 1.57064 3.46695C1.60939 3.4247 1.65585 3.3909 1.70732 3.36755C1.7588 3.34419 1.81424 3.33172 1.8704 3.33091H4.24334C4.34903 3.33047 4.45101 3.37126 4.52918 3.44518C4.60736 3.51911 4.65605 3.62081 4.66556 3.7302C4.77409 5.08445 5.00879 6.42455 5.36641 7.73169C5.38988 7.80712 5.3932 7.88774 5.3761 7.96499C5.359 8.04225 5.32213 8.11325 5.26931 8.17045C5.19125 8.242 5.09043 8.28106 4.98635 8.28014H4.978ZM2.34334 4.19528C2.36932 4.43358 2.41157 4.66965 2.46992 4.90168C2.60231 5.43393 2.85242 5.92672 3.20036 6.34083C3.47749 6.66001 3.81349 6.91812 4.18839 7.09987L4.36992 7.18324C4.14044 6.2 3.97543 5.20173 3.87595 4.19528H2.34334ZM14.0135 8.28014C13.9559 8.28051 13.8989 8.26863 13.8459 8.24524C13.7929 8.22185 13.745 8.18744 13.7053 8.14412C13.6525 8.08693 13.6155 8.01592 13.5984 7.93867C13.5813 7.86141 13.5847 7.78079 13.6082 7.70536C13.9642 6.39783 14.1988 5.05789 14.309 3.70387C14.3186 3.59448 14.3673 3.49278 14.4454 3.41886C14.5236 3.34493 14.6256 3.30414 14.7313 3.30459H17.0915C17.1484 3.30481 17.2046 3.31699 17.2569 3.34037C17.3091 3.36374 17.3563 3.39782 17.3955 3.4406C17.4349 3.483 17.4657 3.53324 17.486 3.58827C17.5063 3.6433 17.5158 3.70201 17.5138 3.76092C17.5038 4.15108 17.4556 4.53918 17.3702 4.91925C17.2831 5.3438 17.1411 5.75411 16.9479 6.13899C16.5991 6.81436 16.0698 7.37052 15.4238 7.74047C15.016 7.97501 14.5781 8.14787 14.1233 8.25381C14.0868 8.26857 14.0484 8.27745 14.0093 8.28014H14.0135ZM15.1113 4.19528C15.0111 5.19988 14.8475 6.19655 14.6215 7.17885C14.7524 7.12181 14.8791 7.056 14.9973 6.99018C15.5033 6.6978 15.9179 6.26078 16.1921 5.73094C16.3542 5.41765 16.4736 5.08243 16.5468 4.73495C16.5887 4.55727 16.6198 4.37703 16.6397 4.19528H15.1113Z" fill="#003375"/>
		<path d="M14.3132 19.3369H4.68652V20.6927H14.3132V19.3369Z" fill="#FDBA4D"/>
    </symbol>
    
</svg>



