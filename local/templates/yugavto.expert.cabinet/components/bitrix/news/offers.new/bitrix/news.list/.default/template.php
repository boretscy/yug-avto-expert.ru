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

<div class="container my-5 filter">
	<div class="row">
		<div class="col-md-6 col-lg-4">
			<div class="filter-dropcontainer position-relative">
				<div class="b-radius-yaradius-15 bg-yalightgray filter-dropdown d-flex justify-content-between c-yalightblack position-relative">
					<span><?= $arResult['vuefilter']['items']['dealership']['title'];?></span>
					<?php if ( $_GET['dealership'] && count(explode(',', $_GET['dealership'])) != 0 ) { ?>
					<span><?= count(explode(',', $_GET['dealership']));?> выбрано</span>
					<?php } ?>
					<span><img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/drop-corner.svg" /></span>
				</div>
				<div class="filter-droplist bg-yawhite w-100 position-absolute d-none">
					<?php foreach ( $arResult['vuefilter']['items']['dealership']['items'] as $item ) { ?>
					<a href="<?= YApp::makeFilterUrl($_GET, ['dealership'=>$item['code']]);?>" 
						class="filter-droplist-item py-2 d-block c-yalightblack c-h-yalightblack text-decoration-none bg-h-yalightgray <?= (($item['selected'])?'bg-yalightgray selected fw-bold':'');?>"
						data-name="brand"
						data-value="<?= $item['code'];?>"
						><?= $item['name'];?></a>
					<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-lg-2 mt-3 mt-md-0">
			<a href="<?= YApp::makeFilterUrl($_GET, []);?>" class="b-radius-yaradius-15 c-yalightblack c-h-yalightblack bg-yayellow text-decoration-none text-center filter-button d-block">Сбросить</a>
		</div>
		<div class="col-md-12 col-lg-6 mt-3 mt-lg-0 text-end d-flex justify-content-start justify-content-lg-end align-items-center">
			<div class="row d-md-none">
				<div class="col-6 py-2 d-flex align-items-center">
					<span class="b-radius-yaradius-7 bg-<?= ((!$_GET['tag'])?'yayellow':'yalightgray');?> ms-4 me-2 d-inline-block check d-flex justify-content-center align-items-center">
					<?php if (!$_GET['tag']) { ?>
					<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/check.svg" />
					<?php } ?>
					</span>
					<span><a href="<?= YApp::makeFilterUrl($_GET, ['tag'=>false]);?>" class="c-yalightblack c-h-yalightblack text-decoration-none">Все</a></span>
				</div>
				<?php foreach ( $arResult['vuefilter']['items']['tag']['items'] as $item ) { ?>
				<div class="col-6 py-2 d-flex align-items-center">
					<span class="b-radius-yaradius-7 bg-<?= (($item['selected'])?'yayellow':'yalightgray');?> ms-4 me-2 d-inline-block check d-flex justify-content-center align-items-center">
						<?php if ($item['selected']) { ?>
						<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/check.svg" />
						<?php } ?>
					</span>
					<span><a href="<?= YApp::makeFilterUrl($_GET, ['tag'=>$item['code']]);?>" class="c-yalightblack c-h-yalightblack text-decoration-none"><?= $item['name'];?></a></span>
				</div>
				<?php } ?>

			</div>
			

			<span class="b-radius-yaradius-7 bg-<?= ((!$_GET['tag'])?'yayellow':'yalightgray');?> ms-4 me-2 d-inline-block check d-none d-md-flex justify-content-center align-items-center">
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
	</div>
</div>

<?php if ( empty($arResult['ITEMS']) ) { ?>
	<div class="container my-5 text-center">
		<div class="row">
			<div class="col">
				<p class="h2 fw-normal c-yamiddlegray">Ничего не найдено</p>
			</div>
		</div>
	</div>
<?php } else { ?>
	<div class="container my-4">
		<div class="row">
			<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
			<div class="col-md-6 col-xl-4 mb-4 offers-item">
				<a 
					href="<?= $arItem['DETAIL_PAGE_URL'];?>" 
					class="b-radius-yaradius-25 overflow-hidden b-yagray bg-yawhite shadow-small-h d-block c-yablack c-h-yablack text-decoration-none fw-bold"
					alt="<?= $arItem['NAME'];?>"
					>
					<img src="<?= $arItem['PREVIEW_PICTURE']['SRC'];?>" alt="<?= $arItem['NAME'];?>" class="w-100 b-b-yagray fix-h__img" />
					<div class="row mt-3 с-yamiddlegray fw-normal">
						<div class="col ps-4">
							<?php foreach ($arItem['PROPERTIES']['TAG']['VALUE'] as $item ) { ?>
							<span class="me-2 text-minus-minus c-yamiddlegray offers-item-tag">
								<?= $item;?>
							</span>
							<?php } // foreach TAGS ?>
						</div>
						<div class="col text-end pe-4">
							<?php if ( $arItem['DATE_ACTIVE_TO'] ) { ?>
							<span class="text-minus c-yamiddlegray">
								до <?= date('d.m.Y', strtotime($arItem['DATE_ACTIVE_TO']));?>
							</span>
							<?php } ?>
						</div>
					</div>
					<div class="row mb-3 fix_h">
						<div class="col-10 d-block mt-2 px-4 offers-item-title" style="min-height: 81px;">
							<?= $arItem['NAME'];?>
						</div>
                        <div class="col-2 text-end">
                            <svg xmlns="http://www.w3.org/2000/svg">
                                <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use>
                            </svg>
                        </div>
					</div>
				</a>
			</div>
			<?php } // foreach ITEMS ?>
		</div>
	</div>
	<?php if ( $arParams["DISPLAY_BOTTOM_PAGER"] ) { ?>
	<div class="container my-5">
		<div class="row">
			<div class="col"><?= $arResult["NAV_STRING"];?></div>
		</div>
	</div>
	<?php } // if PAGES >?>
<?php } // if ITEMS ?>

<?php // YApp::sp( $arResult['vuefilter']['items']['tag']['items'] ); ?>