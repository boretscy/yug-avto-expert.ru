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
<div class="container my-5">
	<div class="row mb-3">
		<div class="col">
			<h3 class="fw-normal">Доверьте ремонт своего автомобиля настоящим профессионалам своего дела</h3>
		</div>
	</div>
	<div class="row">
		<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
		<div class="col-12 col-md-6">
			<div class="services-on-main-item b-yagray bg-yawhite shadow-small-h b-radius-small">
				<div class="row pt-5 pb-3">
					<div class="col-6">
						<img src="<?= $arItem['DETAIL_PICTURE']['SRC'];?>" alt="<?= $arItem['NAME'];?>" class="w-75" />
					</div>
					<div class="col-6">
						<h4 class="fw-normal mb-4 services-on-main-item-title">
							<span><?= $arItem['NAME'];?></span>
							<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
						</h4>
						<p><?= $arItem['PREVIEW_TEXT'];?></p>
					</div>
				</div>
				<img class="services-on-main-item-logo desktop" src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" />
				<a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'];?>" class="services-on-main-item-link"></a>
			</div>
		</div>
		<?php } // foreach ITEMS ?>
	</div>
</div>