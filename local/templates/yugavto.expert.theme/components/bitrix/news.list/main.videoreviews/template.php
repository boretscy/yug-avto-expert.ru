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
<div class="container videioreviews-on-main my-5">
	<div class="row mb-3">
		<div class="col-6">
			<h3 class="fw-normal">Видеообзоры</h3>
		</div>
		<div class="col-6 text-end pt-2">
			<a href="/news/?category=videoreviews" class="c-yablack c-h-yablack text-decoration-none">
				Все видео
				<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col position-relative">
			
			<div class="swiper-videoreviews-on-main pb-5">
				<div class="swiper-wrapper">
					<!-- Slides -->
					<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
					<div class="swiper-slide">
						<div class="b-yagray b-radius-small shadow-small-h overflow-hidden">
							<a 
								href="#videoreview" 
								alt="<?= $arItem['NAME'];?>" 
								data-code="<?= $arItem['VIDEO_REVIEW_CODE'];?>"
								role="open-videoreview"
								>
								<img src="<?= $arItem['DETAIL_PICTURE']['SRC'];?>" class="w-100 desktop" alt="<?= $arItem['NAME'];?>">
								<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" class="w-100 mobile" alt="<?= $arItem['NAME'];?>">
							</a>
							<div class="p-4">
								<p class="text-minus c-yamiddlegray text-start"><?= $arItem['DISPLAY_ACTIVE_FROM'];?></p>
								<p class=" text-start">
									<a 
										href="#videoreview" 
										class="fw-bold c-yablack c-h-yablack text-decoration-none webkit_box"
                                        title="<?= $arItem['NAME'];?>"
										data-code="<?= $arItem['VIDEO_REVIEW_CODE'];?>"
										role="open-videoreview"
										>
										<?= $arItem['NAME'];?>
									</a>
								</p>
							</div>
						</div>
					</div>
					<?php } // foreasch ITEMS ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>

			<div class="swiper-videoreviews-on-main-button-prev b-yablue">
				<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-left"></use></svg></div>
			</div>
			<div class="swiper-videoreviews-on-main-button-next b-yablue">
				<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
			</div>

		</div>
	</div>
	<?php // YApp::sp( $arResult['ITEMS'] ); ?>
</div>
<div class="remodal videoreview-modal text-start" data-remodal-id="videoreview">
	<button data-remodal-action="close" class="remodal-close"></button>
	<div class="row">
		<div class="col">
		</div>
	</div>
</div>