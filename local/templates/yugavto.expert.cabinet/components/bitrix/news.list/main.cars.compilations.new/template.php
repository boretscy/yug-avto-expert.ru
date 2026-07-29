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
<div class="container mt-4 compilations-on-main ">
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
						href="<?= $arItem['PROPERTIES']['LINK']['VALUE'];?>" 
						class="bg-yalightgray bg-h-yagray c-yablack c-h-yablack text-decoration-none text-minus-minus text-uppercase py-2 px-3 b-radius-yaradius-15 text-nowrap fw-bold"
						><?= $arItem['NAME'];?></a>
				<?php } ?>
			</div>
		</div>
	</div>
</div>

<div class="container mt-4 dealership-cis" data-scroll="dealership-cis">
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
						<div class="b-radius-yaradius-25 b-yagray vehicle-card mb-4 text-start w-100">
							<div class="vehicle-card-images position-relative">
								<a href="/cars/used/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" role="vehicle-image">
									<?php if ( !empty($item['images']) ) { ?>
										<?php foreach ( $item['images'] as $k => $i ) { ?>
											<style>.vehicle-card-images a .vehicle-card-images-item-container-image.img-<?= $item['id'];?>-<?= $k;?>::after{background-image: url(<?= (($i['preview'])?:$i['preview_large']);?>)}</style>
											<div 
												class="vehicle-card-images-item-container" 
												style="<?= (($k!=0)?'display:none;':'');?>" 
												data-index="<?= $k;?>">
												<div class="vehicle-card-images-item-container-image img-<?= $item['id'];?>-<?= $k;?>" ></div>
											</div>
										<?php } ?>
									<?php } else { ?>
										<img src="https://apps.yug-avto.ru/upload/Cis/bodies/<?= $item['body']['code'];?>_sm.jpg" class="w-100" />
									<?php } ?>
								</a>
								<div class="m-3 vehicle-card-discount-row position-absolute d-flex justify-content-between">
									<div>
										<?php if ( $item['min_price'] < $item['price'] ) { ?>
										<span class="b-radius-yaradius-10 bg-yawhite c-yadarkgray vehicle-card-discount-item">до <strong><?= number_format($item['price']-$item['min_price'], 0, '.', ' ');?></strong> ₽</span>
										<?php } ?>
									</div>
									<div class="text-end">
                                        <a 
                                            href="#" 
                                            role="toggle-fav-com" 
                                            data-target="CIS_FAVORITES" 
                                            data-vehicle="<?= $item['id'];?>"
                                            aria-label="Избранное"
                                            class="ms-1 b-radius-yaradius-7 hint--bottom-left <?= ((in_array($item['id'], $data['FAVORITES']))?'bg-yayellow':'bg-yawhite');?> vehicle-card-discount-item"
                                            ><img src="/cars/used/assets/images/svg/favorites.svg" /></a>
                                        <a 
                                            href="#" 
                                            role="toggle-fav-com" 
                                            data-target="CIS_COMPARE" 
                                            data-vehicle="<?= $item['id'];?>"
                                            aria-label="Сравнение"
                                            class="ms-1 b-radius-yaradius-7 hint--bottom-left <?= ((in_array($item['id'], $data['COMPARE']))?'bg-yayellow':'bg-yawhite');?>  vehicle-card-discount-item"
                                            ><img src="/cars/used/assets/images/svg/compare.svg" /></a>
                                    </div>
								</div>
								<div class="m-3 vehicle-card-images-row position-absolute d-flex justify-content-between">
									<?php foreach ( $item['images'] as $k => $i ) { ?>
									<span class="vehicle-card-images-row-item <?= (($k==0)?'active':'');?>" data-index="<?=$k;?>"></span>
									<?php } ?>
								</div>
							</div>
							<div class="vehicle-card-content p-3">
								<a 
									href="/cars/used/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" 
									class="c-yablack c-h-yablack text-decoration-none h5 line-height-one d-block vehicle-card-content-title fw-bold"
									><?= $item['brand']['name'];?> <?= $item['model']['name'];?> <?= (($item['equipment'])?:'');?></a>
								<div class="vehicle-card-futures">
									<?php foreach ( $item['_tags'] as $tag ) { ?>
										<a href="#" onclick="return false" class="hint--top-right" aria-label="<?= $tag['name'];?>" role="not-cover"><img src="<?= $tag['icon'];?>" title="<?= $tag['name'];?>" /></a>
									<?php } ?>
								</div>
								<div class="vehicle-card-specification my-3 c-yadarkgray">
									<?php foreach (array_chunk($item['_general'], 3) as $s_row) { ?>
									<div>
										<?php foreach ( $s_row as $i ) { ?>
											<?php if ( $i ) { ?><span class="vehicle-card-specification-item pe-2 me-2"><?= $i;?></span><?php } ?>
										<?php } ?>
									</div>
									<?php } ?>
								</div>
								<div class="vehicle-card-status text-uppercase my-3 fw-bold <?= (($item['status']['id']==1)?'c-yablue':'c-yayellow');?>"><?= $item['status']['name'];?></div>
								<div class="vehicle-card-price my-3 d-flex justify-content-between">
									<span class="text-plus c-yablack fw-bold"><?= number_format($item['min_price'], 0, '.', ' ');?> ₽</span>
									<?php if ( $item['min_price'] < $item['price'] ) { ?>
									<span class="text-plus c-yadarkgray text-decoration-line-through"><?= number_format($item['price'], 0, '.', ' ');?> ₽</span>
									<?php } ?>
								</div>
								<div class="">
									<a
										href="/cars/used/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/"
										class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow vehicle-card-button"
										data-vehicle-name="<?= $item['brand']['name'];?> <?= $item['model']['name'];?> <?= (($item['equipment'])?:'');?>"
										data-vehicle-id="<?= $item['id'];?>"
										data-action="set-vehicle"
										<?php if ( !$item['offer_link'] ) { ?>
										data-remodal-target="offer-modal"
										<?php } ?>
										>Подробнее</a>
								</div>
							</div>
						</div>
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
