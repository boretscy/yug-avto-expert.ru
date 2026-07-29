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
<div class="container mt-3 mb-5 history">

	<div class="row">
		<div class="col-3 col-md-2 pe-4 pe-md-5 py-3 position-relative">
			<div class="arrow-up"></div>
			<div class="line bg-yayellow"></div>
		</div>
	</div>
	<?php  $i = 0; foreach ( $arResult['ITEMS'] as $arSection ) {?>
		<a class="row history-group-title history-group-active c-yadarkgray c-h-yabiddlegray text-decoration-none" href="#" data-group="<?= $arSection['NAME'];?>" role="historyGroup">
			<div class="col-3 col-md-2 pe-4 pe-md-5  position-relative">
				<div class="line bg-yayellow"></div>
				<div class="history-group-title-icon bg-yawhite b-yayellow">
					<div class="history-group-title-icon-internal">
						<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-up"></use></svg>
					</div>
				</div>
			</div>
			<div class="col d-flex align-items-center">
				<div class="h4 line-height-one"><?= $arSection['NAME'];?></div>
			</div>
		</a>
		<?php foreach ( $arSection['ITEMS'] as $arItem ) { ?>
		<div class="row history-item  history-group-active" data="<?= $arSection['NAME'];?>">
			<div class="col-3 col-md-2 pe-4 pe-md-5  position-relative d-flex align-items-center justify-content-end pe-md-5 pe-0">
				<div class="line bg-yayellow"></div>
				<div class="circle bg-yayellow"></div>
				<?php if ( $arItem['PROPERTIES']['ICON']['VALUE_XML_ID'] == 'double-point' ) { ?>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#history-point"></use></svg>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#history-point"></use></svg>
				<?php } elseif ( $arItem['PROPERTIES']['ICON']['VALUE_XML_ID'] == 'cup' ) { ?>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#history-cup"></use></svg>
				<?php } else  { ?>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#history-point"></use></svg>
				<?php } ?>
				<span class="ms-2 me-md-0 me-1 "><?= $arSection['NAME'];?></span>
			</div>
			<div class="col pe-md-0 pe-5">
				<div class="row ms-2 history-item-block b-radius-yaradius-15 b-yagray position-relative <?= (($arItem['PROPERTIES']['YELLOW_BLOCK']['VALUE'])?'bg-yayellow':'bg-yawhite');?>">
					<svg class="block-corner" xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#history-block-corner-<?= (($arItem['PROPERTIES']['YELLOW_BLOCK']['VALUE'])?'yellow':'white');?>"></use></svg>
					<div class="col-4 col-md-2 p-3 d-flex">
						<?php foreach ( $arItem['DISPLAY_PROPERTIES']['BRAND']['LINK_ELEMENT_VALUE'] as $arBrand ) { 
							$brandAlt = YApp::getCleanAltText($arBrand['NAME']);
						?>
						<div class="px-1 flex-fill d-flex align-items-center justify-content-center"><img class="w-100" src="<?= CFile::GetPath($arBrand['PREVIEW_PICTURE']);?>" alt="<?= htmlspecialchars($brandAlt);?>" title="<?= htmlspecialchars($brandAlt);?>" /></div>
						<?php } // foreach BRANDS ?>
						<?php foreach ( $arItem['PROPERTIES']['OLD_BRAND']['VALUE'] as $item ) { 
							$oldBrandAlt = YApp::getCleanAltText($arItem['NAME']);
						?>
						<div class="px-1 flex-fill d-flex align-items-center justify-content-center"><img class="w-100" src="<?= CFile::GetPath($item);?>" alt="<?= htmlspecialchars($oldBrandAlt);?>" title="<?= htmlspecialchars($oldBrandAlt);?>" /></div>
						<?php } // if OLD LOGO ?>
					</div>
					<div class="col col-md p-3 d-flex align-items-center name"><?= $arItem['~NAME'];?></div>
					<?php if ( $arItem['PROPERTIES']['DEALERSHIP']['VALUE'] ) { ?>
                        <div class="row col-sm-12 col-md-6 margin-mobile"  style="padding-right: 10px;">
                            <div class="col-12 col-xl-4 p-3 bg-yalightgray d-flex align-items-center text-minus history-item-block-map bg sm-button">
                                <?php if ( is_countable($arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE']) && count($arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE']) > 1 ) { ?>
                                    <a href="#dealership-<?= $arItem['ID'].'_'.$arSection['NAME'];?>">Построить маршрут</a>
                                    <div class="remodal history-modal text-start bg-yalightgray" data-remodal-id="dealership-<?= $arItem['ID'].'_'.$arSection['NAME'];?>">
                                        <button data-remodal-action="close" class="remodal-close"></button>
                                        <p class="c-yadarkgray">Выбор дилерского центра:</p>
                                        <?php foreach ( $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'] as $item ) { ?>
                                            <a
                                                    href="https://yandex.ru/maps/?ll=<?= $item['COORDS']['LON'];?>,<?= $item['COORDS']['LAT'];?>&z=15&mode=routes&rtext=~<?= $item['COORDS']['LAT'];?>,<?= $item['COORDS']['LON'];?>&rtt=auto&ruri=~"
                                                    class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block"
                                                    target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#map"></use></svg>
                                                <?= $item['NAME'];?>
                                            </a>
                                        <?php } // foreach LINKS ?>
                                    </div>
                                <?php } else { ?>
									<a href="https://yandex.ru/maps/?ll=<?= $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['DEALERSHIP']['VALUE'][0]]['COORDS']['LON'];?>,<?= $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['DEALERSHIP']['VALUE'][0]]['COORDS']['LAT'];?>&z=15&mode=routes&rtext=~<?= $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['DEALERSHIP']['VALUE'][0]]['COORDS']['LAT'];?>,<?= $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['DEALERSHIP']['VALUE'][0]]['COORDS']['LON'];?>&rtt=auto&ruri=~" target="_blank" alt="<?= $arResult['NAME'];?>">Построить маршрут</a>
                                <?php } ?>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-4 px-4 py-2 p-md-3 bg-yalightgray text-minus history-item-block-site bg">
                                <?php if ( $arItem['SITES'] ) { ?>
                                    <span class="c-yagray">Сайт:</span><br />
                                    <?php foreach ($arItem['SITES'] as $site) { ?>
                                        <a href="<?= $site;?>" target="_blank" class="c-yamiddlegray c-h-yadarkgray text-decoration-none"><?= parse_url($site)['host'];?></a><br />
                                    <?php } ?>
                                <?php } // if SITES ?>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-4 px-4 py-2 p-md-3 bg-yalightgray text-minus history-item-block-phone bg">
                                <?php if ( $arItem['PHONE'] ) { ?>
                                    <span class="c-yagray">Номер телефона:</span><br />
                                    <a href="tel:+<?= YApp::phoneIn($arItem['PHONE']);?>" class="c-yablack c-h-yadarkgray text-decoration-none fw-bold"><?= YApp::phoneOut($arItem['PHONE']);?></a>
                                <?php } // if PHONE ?>
                            </div>
                        </div>

					<?php } // if DEALERSHIP ?>
				</div>
			</div>
		</div>
		<div class="row history-item-delimiter history-group-active" data="<?= $arSection['NAME'];?>"><div class="col-3 col-md-2 pe-4 pe-md-5 position-relative"><div class="line bg-yayellow"></div></div></div>
		<?php } ?>
	<?php $i++; } // foreach ITEMS ?>
	
	<div class="row history-footer">
		<div class="col-3 col-md-2 pe-4 pe-md-5 position-relative mb-5">
			<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#history-point-fill"></use></svg>
		</div>
	</div>
	<?php // YApp::sp( $arResult['ITEMS'] ); ?>
	<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.2" width="0" height="0" display="none" aria-hidden="true">
    
		<symbol id="history-point" viewbox="0 0 74 74">
			<path fill="#3048A7" d="M37,4c-6.6,0-12.7,2.5-17.4,7c-4.7,4.5-7.2,10.6-7.2,17c0,8.3,3.9,17.7,11.7,27.9c2.4,3.1,5,6.2,7.9,9.2
				c1.1,1.1,2,2,2.6,2.6l0.7,0.7l0.8-0.9c0,0,0,0,0,0l-0.5,1.1l0.6-0.7l0,0l-0.6,0.7L37,70l1.4-1.3l-0.6-0.7c0,0,0,0,0,0l0.7,0.6
				l0.9-0.9c0.6-0.6,1.5-1.5,2.6-2.6c2.9-3,5.5-6.1,7.9-9.2c7.7-10.2,11.7-19.6,11.7-27.9c0-6.4-2.6-12.5-7.2-17C49.7,6.5,43.6,4,37,4z
				M35,62.3c-1.9-1.9-4.7-5.1-7.6-8.8C22.5,47,16.6,37.3,16.6,28.1c0-5.3,2.1-10.3,6-14.1c3.9-3.8,9-5.8,14.4-5.8
				c5.5,0,10.6,2.1,14.4,5.8c3.9,3.8,6,8.8,6,14.1c0,9.2-5.9,18.9-10.8,25.5c-2.9,3.8-5.7,6.9-7.6,8.8c-0.8,0.8-1.5,1.5-2,2
				C36.5,63.8,35.8,63.1,35,62.3z M36.3,67.8L36.3,67.8L36.3,67.8L36.3,67.8z"/>
			<path fill="#3048A7" d="M49.3,26.8c-0.5-2.6-1.7-4.9-3.4-6.8c-1.8-1.9-4-3.1-6.4-3.7c-2.5-0.5-5-0.3-7.3,0.8v0
				c-2.3,1-4.2,2.7-5.6,4.9c-1.4,2.2-2.1,4.7-2.1,7.3c0,3.5,1.3,6.8,3.6,9.3c2.3,2.5,5.6,3.9,8.9,3.9c2.5,0,4.9-0.8,7-2.3
				c2.1-1.5,3.6-3.5,4.6-6C49.5,32,49.7,29.3,49.3,26.8z M31.1,35.7c-1.6-1.7-2.5-4-2.5-6.4c0-1.8,0.5-3.5,1.4-5
				c0.9-1.5,2.2-2.6,3.8-3.3c1-0.4,2.1-0.7,3.2-0.7c0.5,0,1.1,0.1,1.6,0.2c1.6,0.3,3.1,1.2,4.3,2.4c1.2,1.3,2,2.9,2.3,4.6
				c0.3,1.8,0.2,3.6-0.5,5.2c-0.6,1.7-1.7,3-3.1,4C38.4,39.1,33.9,38.7,31.1,35.7z"/>
		</symbol>
		<symbol id="history-cup" viewbox="0 0 74 74">
			<path fill="#003375" d="M49.1,62.3H24.9c-0.4,0-0.7-0.2-1-0.4c-0.3-0.3-0.4-0.6-0.4-1v-8.5c0-0.2,0.1-0.5,0.2-0.7
				c0.1-0.2,0.3-0.4,0.5-0.5l7.9-5v-0.8c-3.7-1.7-6.9-5.4-9.3-10.6c-2.9-0.4-5.6-1.3-8.2-2.6c-3-1.7-5.5-4.1-7.1-7.2
				c-0.9-1.6-1.5-3.4-1.9-5.2c-0.4-1.8-0.6-3.7-0.6-5.6c0-0.8,0-1.6,0.1-2.4l0.3-2.2c0-0.3,0.2-0.7,0.5-0.9c0.3-0.2,0.6-0.3,0.9-0.3
				h10.8c0-1,0-1.9,0-2.9c0-0.4,0.1-0.7,0.4-1c0.3-0.3,0.6-0.4,1-0.4h36.2c0.4,0,0.7,0.2,1,0.4c0.3,0.3,0.4,0.6,0.4,1c0,1,0,2,0,2.9
				h10.7c0.3,0,0.7,0.1,0.9,0.3c0.3,0.2,0.4,0.5,0.5,0.9l0.3,2.2c0.1,0.8,0.2,1.6,0.1,2.4c0,2.2-0.3,4.3-0.8,6.4
				c-0.8,2.9-2.2,5.6-4.2,7.9c-1.6,1.8-3.6,3.3-5.8,4.3c-2.2,1-4.6,1.7-7,2c-2.4,5.3-5.6,8.9-9.3,10.6v0.8l7.9,5
				c0.2,0.1,0.4,0.3,0.5,0.5c0.1,0.2,0.2,0.4,0.2,0.7v8.5c0,0.2,0,0.4-0.1,0.5c-0.1,0.2-0.2,0.3-0.3,0.5c-0.1,0.1-0.3,0.2-0.5,0.3
				C49.5,62.3,49.3,62.3,49.1,62.3z M26.4,59.5h21.4v-6.3l-7.9-5c-0.2-0.1-0.4-0.3-0.5-0.5s-0.2-0.5-0.2-0.7v-2.5
				c0-0.3,0.1-0.6,0.3-0.8c0.2-0.2,0.4-0.4,0.7-0.5c3.5-1.3,6.6-4.9,9-10.2c0.1-0.2,0.3-0.4,0.5-0.6c0.2-0.1,0.4-0.2,0.7-0.3
				c2.4-0.2,4.7-0.9,6.9-1.9c1.9-0.9,3.5-2.1,4.9-3.6c1.7-1.9,2.9-4.2,3.5-6.7c0.5-1.9,0.7-3.8,0.7-5.7c0-0.7,0-1.3-0.1-2L66,11.1H55.1
				c-0.2,0-0.4,0-0.6-0.1c-0.2-0.1-0.3-0.2-0.5-0.3c-0.1-0.1-0.2-0.3-0.3-0.5c-0.1-0.2-0.1-0.4-0.1-0.6c0-0.9,0-1.9,0.1-2.9H20.5
				c0,1,0,1.9,0,2.9c0,0.2,0,0.4-0.1,0.6c-0.1,0.2-0.2,0.3-0.3,0.5c-0.1,0.1-0.3,0.3-0.5,0.3c-0.2,0.1-0.4,0.1-0.6,0.1h-11L8,12
				c-0.1,0.7-0.1,1.4-0.1,2c0,1.7,0.2,3.3,0.6,4.9c0.3,1.6,0.9,3.1,1.7,4.5c1.4,2.6,3.4,4.7,6,6.1c2.4,1.3,5.1,2.1,7.9,2.4
				c0.2,0,0.5,0.1,0.7,0.3c0.2,0.1,0.4,0.3,0.5,0.6c2.4,5.4,5.5,8.9,9,10.2c0.3,0.1,0.5,0.3,0.7,0.5c0.2,0.2,0.3,0.5,0.3,0.8v2.5
				c0,0.2-0.1,0.5-0.2,0.7c-0.1,0.2-0.3,0.4-0.5,0.5l-7.9,5L26.4,59.5z M21.8,29.5c-0.1,0-0.2,0-0.3,0c-1.2-0.3-2.4-0.7-3.6-1.2
				c-1.6-0.7-3.1-1.8-4.3-3.1c-1.5-1.7-2.5-3.7-3.1-5.9c-0.4-1.4-0.6-2.9-0.7-4.4c0-0.2,0-0.4,0.1-0.6c0.1-0.2,0.2-0.3,0.3-0.5
				c0.1-0.1,0.3-0.2,0.5-0.3c0.2-0.1,0.4-0.1,0.6-0.1h8c0.4,0,0.7,0.1,1,0.4c0.3,0.2,0.4,0.6,0.5,0.9c0.4,4.4,1.2,8.8,2.4,13.1
				c0.1,0.2,0.1,0.5,0,0.8c-0.1,0.3-0.2,0.5-0.4,0.7C22.5,29.4,22.2,29.5,21.8,29.5L21.8,29.5z M12.9,16.2c0.1,0.8,0.2,1.5,0.4,2.3
				c0.4,1.7,1.3,3.3,2.5,4.7c0.9,1,2.1,1.9,3.3,2.5l0.6,0.3c-0.8-3.2-1.3-6.5-1.7-9.8H12.9z M52.3,29.5c-0.2,0-0.4,0-0.6-0.1
				c-0.2-0.1-0.3-0.2-0.5-0.3c-0.2-0.2-0.3-0.4-0.4-0.7c-0.1-0.3,0-0.5,0-0.8c1.2-4.3,2-8.6,2.4-13.1c0-0.4,0.2-0.7,0.5-0.9
				c0.3-0.2,0.6-0.4,1-0.4h8c0.2,0,0.4,0,0.6,0.1c0.2,0.1,0.3,0.2,0.5,0.3c0.1,0.1,0.2,0.3,0.3,0.5s0.1,0.4,0.1,0.6
				c0,1.3-0.2,2.5-0.5,3.8c-0.3,1.4-0.8,2.7-1.4,4c-1.2,2.2-3,4-5.1,5.2c-1.4,0.8-2.9,1.3-4.4,1.7C52.5,29.5,52.4,29.5,52.3,29.5
				L52.3,29.5z M56,16.2c-0.3,3.3-0.9,6.5-1.7,9.7c0.4-0.2,0.9-0.4,1.3-0.6c1.7-1,3.1-2.4,4-4.1c0.5-1,0.9-2.1,1.2-3.3
				c0.1-0.6,0.2-1.2,0.3-1.8H56z"/>
			<path fill="#FDBA4D" d="M53.3,65.6H20.8V70h32.5V65.6z"/>
		</symbol>
		<symbol id="history-flag" viewbox="0 0 74 74">
			<path fill="#003375" d="M58.2,30.5l7.5-13.4H48.8v-5V9.3H23.7V5.4c0-0.4-0.1-0.7-0.4-1C23,4.1,22.7,4,22.3,4c-0.4,0-0.7,0.1-1,0.4
				c-0.3,0.3-0.4,0.6-0.4,1v51.1h-6.4c-0.6,0-1.2,0.2-1.6,0.7c-0.4,0.4-0.7,1-0.7,1.7c0,0.6,0.2,1.2,0.7,1.7c0.4,0.4,1,0.7,1.6,0.7
				h15.5c0.6,0,1.2-0.2,1.6-0.7c0.4-0.4,0.7-1,0.7-1.7c0-0.6-0.2-1.2-0.7-1.7c-0.4-0.4-1-0.7-1.6-0.7h-6.4V36.6h13.6v7.8h0.1v0H64v0
				l2,0L58.2,30.5z M23.7,33.8V12.2h22.3v21.6L23.7,33.8z M40.1,41.6v-5h8.7v-2.8V20h12L55,30.5l6.2,11.1L40.1,41.6z"/>
			<path fill="#FFE687" d="M60.9,20h-12v13.8v2.8h-8.7v5h21.1L55,30.5L60.9,20z"/>
			<path fill="#FDBA4D" d="M36.6,65.3H8V70h28.6V65.3z"/>
		</symbol>
		<symbol id="history-point-fill" viewbox="0 0 74 74">
			<path fill="#fdba4d" d="M53.8,11.1c-2.2-2.2-4.8-4-7.7-5.2c-2.9-1.2-6-1.8-9.1-1.8c-3.1,0-6.2,0.6-9.1,1.8c-2.9,1.2-5.5,3-7.7,5.2
				c-4.4,4.5-6.9,10.5-6.9,16.9c0,10.2,5.9,20.6,11.6,28.3c2.4,3.3,5.1,6.5,7.9,9.5c1.1,1.2,2,2.1,2.6,2.7c0.3,0.3,0.6,0.6,0.7,0.7
				c0.1,0.1,0.1,0.1,0.2,0.2v0L37,70l0.6-0.6v0l0.2-0.2c0.2-0.2,0.4-0.4,0.7-0.7c0.6-0.6,1.5-1.5,2.6-2.7c2.8-3,5.4-6.2,7.9-9.5
				c5.7-7.8,11.6-18.2,11.6-28.3C60.7,21.7,58.2,15.6,53.8,11.1L53.8,11.1z M47.6,33.7c-0.8,2.2-2.3,4.1-4.2,5.5
				c-1.9,1.3-4.1,2.1-6.4,2.1c-1.5,0-3-0.3-4.4-1c-1.4-0.6-2.7-1.5-3.7-2.6c-2.2-2.4-3.4-5.5-3.4-8.7c0-2.4,0.7-4.8,2-6.8
				c1.2-2,3-3.6,5.2-4.5c2.1-0.9,4.4-1.2,6.6-0.7c2.3,0.5,4.3,1.7,5.9,3.4c1.6,1.8,2.7,3.9,3.1,6.3C48.8,29,48.5,31.5,47.6,33.7
				L47.6,33.7z"/>
			<path fill="#fff" d="M43.8,21.7c-1.3-1.4-3-2.4-4.9-2.8c-1.9-0.4-3.8-0.2-5.6,0.6c-1.8,0.8-3.3,2.1-4.3,3.8
				C27.9,25,27.4,27,27.4,29c0,2.7,1,5.3,2.8,7.3c0.9,0.9,1.9,1.7,3.1,2.2c1.2,0.5,2.4,0.8,3.7,0.8c1.9,0,3.8-0.6,5.4-1.7
				c1.6-1.2,2.8-2.8,3.6-4.6c0.7-1.9,0.9-3.9,0.6-5.9C46.1,25,45.2,23.2,43.8,21.7z"/>
		</symbol>
		<symbol id="history-block-corner-white" viewbox="0 0 74 74">
			<polyline fill="#FFFFFF" points="66.9,7.2 22,37 66.9,66.8 "/>
			<path fill="#BDC0C2" d="M65.1,69.2l-44-31c-0.4-0.3-0.6-0.7-0.6-1.2s0.2-0.9,0.6-1.2l44-31l1.7,2.5L24.6,37l42.2,29.8L65.1,69.2z"/>
		</symbol>
		<symbol id="history-block-corner-yellow" viewbox="0 0 74 74">
			<polyline fill="#fdba4d" points="66.9,7.2 22,37 66.9,66.8 "/>
			<path fill="#BDC0C2" d="M65.1,69.2l-44-31c-0.4-0.3-0.6-0.7-0.6-1.2s0.2-0.9,0.6-1.2l44-31l1.7,2.5L24.6,37l42.2,29.8L65.1,69.2z"/>
		</symbol>

	</svg>
</div>