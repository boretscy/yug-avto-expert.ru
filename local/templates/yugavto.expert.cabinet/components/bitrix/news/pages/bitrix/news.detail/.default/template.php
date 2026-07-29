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
<div class="container my-5 pages-model">
	<div class="row mb-5">
		<div class="col">
			<h1 class="fw-normal"><?= $arResult['SECTION']['PATH'][0]['NAME'];?> <span class="text-uppercase"><?= $arResult['NAME'];?></span></h1>
		</div>
	</div>
	
	<div class="row mb-5">
		<div class="col-md-9">
			<img src="<?= $arResult['PROPERTIES']['EXTERNAL_PICTURE']['VALUE'];?>" alt="<?= $arResult['SECTION']['PATH'][0]['NAME'];?> <?= $arResult['NAME'];?>" class="w-100" />
		</div>
		<div class="col-md bg-yalightgray p-4">
			<h5 class="mb-3">
				<a href="/cars/new/<?= $arResult['SECTION']['PATH'][0]['CODE'];?>/<?= $arResult['CODE'];?>" alt="<?= $arResult['SECTION']['PATH'][0]['NAME'];?> <?= $arResult['NAME'];?>" class="text-decoration-none pages-model-title fw-bold c-yadarkblue">
					Новый <span class="text-uppercase"><?= $arResult['NAME'];?></span>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
				</a>
			</h5>
			<a 
				href="#FORM_CREDIT"
				alt="<?= $arResult['SECTION']['PATH'][0]['NAME'];?> <?= $arResult['NAME'];?>"
				class="d-block text-decoration-none py-2 text-center bg-yawhite b-yadarkblue b-radius-small mb-3 c-yadarkblue">
				В кредит
			</a>
			<a 
				href="/cars/new/<?= $arResult['SECTION']['PATH'][0]['CODE'];?>/<?= $arResult['CODE'];?>" alt="<?= $arResult['SECTION']['PATH'][0]['NAME'];?> <?= $arResult['NAME'];?>"
				class="text-decoration-none c-yadarkgray c-h-yamiddlegray">
				<span class="b-radius-small bg-yawhite p-1"><?= $arResult['NEW_COUNT'];?></span> авто в наличии
			</a>
			<hr class="my-5" />
			<?php if ( $arResult['USED_COUNT'] ) { ?>
			<h5 class="mb-3">
				<a href="/cars/used/<?= $arResult['SECTION']['PATH'][0]['CODE'];?>/<?= $arResult['CODE'];?>" alt="<?= $arResult['SECTION']['PATH'][0]['NAME'];?> <?= $arResult['NAME'];?>" class="text-decoration-none pages-model-title fw-bold c-yadarkblue">
					<span class="text-uppercase"><?= $arResult['NAME'];?></span> с пробегом
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
				</a>
			</h5>
			<a 
				href="#FORM_CREDIT"
				alt="<?= $arResult['SECTION']['PATH'][0]['NAME'];?> <?= $arResult['NAME'];?>"
				class="d-block text-decoration-none py-2 text-center bg-yawhite b-yadarkblue b-radius-small mb-3 c-yadarkblue">
				В кредит
			</a>
			<a 
				href="/cars/used/<?= $arResult['SECTION']['PATH'][0]['CODE'];?>/<?= $arResult['CODE'];?>" alt="<?= $arResult['SECTION']['PATH'][0]['NAME'];?> <?= $arResult['NAME'];?>"
				class="text-decoration-none c-yadarkgray c-h-yamiddlegray">
				<span class="b-radius-small bg-yawhite p-1"><?= $arResult['USED_COUNT'];?></span> авто в наличии
			</a>
			<hr class="my-5" />
			<?php } ?>
			<?php if ( $arResult['DEALERSHIPS'] ) { ?>
			<a 
				href="#FORM_CREDIT"
				class="d-block text-decoration-none py-2 text-center bg-yawhite b-yadarkblue b-radius-small mb-3  c-yadarkblue">
				Есть в <?= count($arResult['DEALERSHIPS']);?> дилерских центрах
			</a>
			<?php } ?>
		</div>
	</div>

	<?php if ( $arResult['PROPERTIES']['GALLERY']['VALUE'] ) { ?>
	<div class="row mb-5">
		<div class="col">
			<h2 class="fw-normal">Галерея <?= $arResult['SECTION']['PATH'][0]['NAME'];?> <span class="text-uppercase"><?= $arResult['NAME'];?></span></h2>
		</div>
	</div>
	<div class="row">
		<?php foreach ( $arResult['PROPERTIES']['GALLERY']['VALUE'] as $item ) { ?>
		<div class="col-6 col-md-4 mb-3">
			<img src="<?= CFile::GetPath($item);?>" alt="<?= $arResult['SECTION']['PATH'][0]['NAME'];?> <?= $arResult['NAME'];?>" class="w-100" />
		</div>
		<?php } // foreach GELLERY ?>
	</div>
	<?php } // if GALLERY ?>

</div>

<div class="container cis my-5">
	<div class="row mb-5">
		<div class="col-md">
			<h3 class="fw-normal" role="cis-title">Автомобили <?= $arResult['SECTION']['PATH'][0]['NAME'];?> <span class="text-uppercase"><?= $arResult['NAME'];?></span> в наличии</h3>
		</div>
		<div class="col-md-2">
			<a href="#" class="b-radius-small d-block text-center text-decoration-none py-2 c-yadarkgray c-h-yadarkgray b-yayellow" role="cisToggle" data-cis="cis-new">Новые</a>
		</div>
		<div class="col-md-2">
			<a href="#" class="b-radius-small d-block text-center text-decoration-none py-2 c-yadarkgray c-h-yadarkgray" role="cisToggle" data-cis="cis-used">С пробегом</a>
		</div>
	</div>

	<?php if ( $arResult['NEW'] ) { ?>
	<div class="row cis-new" role="cis">
		<div class="col position-relative">
			
			<div class="swiper-cis-new pb-5">
				<div class="swiper-wrapper" role="cis-new-swiper">
					<?php foreach ( $arResult['NEW'] as $item ) { ?>
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
	<?php } // if NEW ?>

	<?php if ( $arResult['USED'] ) { ?>
	<div class="row cis-used"  role="cis" style="display: none;">
		<div class="col position-relative">
			
			<div class="swiper-cis-used pb-5">
				<div class="swiper-wrapper" role="cis-used-swiper">
					<?php foreach ( $arResult['USED'] as $item ) { ?>
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
				
			<div class="swiper-cis-used-button-prev b-yablue">
				<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-left"></use></svg></div>
			</div>
			<div class="swiper-cis-used-button-next b-yablue">
				<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
			</div>

		</div>
	</div>
	<?php } // if NEW ?>

	<?php // YApp::sp($arResult['NEW']); ?>

</div>

<div class="container my-5">
	<div class="row mb-5">
		<div class="col">
			<?= $arResult['DETAIL_TEXT'];?>
		</div>
	</div>
</div>