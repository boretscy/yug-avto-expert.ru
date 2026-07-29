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
<div class="container py-5">
	<div class="row">
		<div class="col position-relative">

			<div class="swiper-on-main pb-4">
				<div class="swiper-wrapper">
					<!-- Slides -->
					<?php foreach ( $arResult['ITEMS'] as $arItem ) { 
						$slideTitle = YApp::getCleanAltText($arItem['NAME']);
					?>
					<div class="swiper-slide">
						<a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'];?>" title="<?= htmlspecialchars($slideTitle);?>">
							<img src="<?= $arItem['DETAIL_PICTURE']['SRC'];?>" class="w-100 desktop" alt="<?= htmlspecialchars($slideTitle);?>" title="<?= htmlspecialchars($slideTitle);?>">
							<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" class="w-100 mobile" alt="<?= htmlspecialchars($slideTitle);?>" title="<?= htmlspecialchars($slideTitle);?>">
						</a>
					</div>
					<?php } // foreasch ITEMS ?>
				</div>
				<div class="swiper-pagination"></div>
			</div>
			<div class="swiper-on-main-button-prev b-yablue">
				<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-left"></use></svg></div>
			</div>
			<div class="swiper-on-main-button-next b-yablue">
				<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
			</div>

		</div>
	</div>
</div>