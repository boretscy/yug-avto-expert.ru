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
<div class="container blog-on-main my-5">
	<div class="row mb-3">
		<div class="col-6">
			<h3 class="fw-normal h2">Блог</h3>
		</div>
		<div class="col-6 text-end text-minus pt-0 pt-md-2">
			<a href="/blog/" class="c-yablack c-h-yablack text-decoration-none">
				Все статьи
				<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col position-relative">
			
			<div class="swiper-blog-on-main pb-5">
				<div class="swiper-wrapper">
					<!-- Slides -->
					<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
					<div class="swiper-slide">
						<div class="b-yagray b-radius-yaradius-25 overflow-hidden blog-on-main-card">
							<a 
								href="<?= $arItem['DETAIL_PAGE_URL'];?>" 
								alt="<?= $arItem['NAME'];?>"
								>
								<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" class="w-100" alt="<?= $arItem['NAME'];?>">
							</a>
							<div class="p-4">
								<p class="text-minus c-yamiddlegray text-start"><?= $arItem['DISPLAY_ACTIVE_FROM'];?></p>
								<p class="text-start swiper-blog-on-main-item-title">
									<a 
										href="<?= $arItem['DETAIL_PAGE_URL'];?>" title="<?= $arItem['NAME'];?>"
										class="fw-bold c-yablack c-h-yablack text-decoration-none"
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
			
			<div class="swiper-blog-on-main-button-prev">
				<div class="swiper-button-inner-circle b-yayellow bg-h-yayellow"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-left"></use></svg></div>
			</div>
			<div class="swiper-blog-on-main-button-next">
				<div class="swiper-button-inner-circle b-yayellow bg-h-yayellow"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
			</div>

		</div>
	</div>

</div>