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
<?php if ( !empty($arResult['ITEMS']) ) { ?>
<div class="container my-4">
	<div class="row">
		<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
		<div class="col-md-6 col-lg-3 mb-3 news-item">
			<a 
				href="<?= $arItem['DETAIL_PAGE_URL'];?>" 
				class="b-radius-yaradius-25 overflow-hidden b-yagray bg-yawhite shadow-small-h d-block c-yablack c-h-yablack text-decoration-none"
				alt="<?= $arItem['NAME'];?>"
				>
				<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?= $arItem['NAME'];?>" class="w-100" />
				<p class="my-3 p-3 с-yamiddlegray">
					<span class="c-yamiddlegray text-minus d-block mb-3"><?= $arItem['DISPLAY_ACTIVE_FROM'];?></span>
					<span class="fw-bold d-block" style="min-height: 81px;"><?= $arItem['NAME'];?> &rarr;</span>
				</p>
			</a>

		</div>
		<?php } // foreach ITEMS ?>
	</div>
</div>
<?php } // if ITEMS ?>
