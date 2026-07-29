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
<footer itemscope itemtype="http://schema.org/WPFooter" class="c-yalightgray bg-yablue py-5 text-minus" style="margin-top: -1px;">
	<meta itemprop="copyrightYear" content="<?= date('Y');?>">
	<meta itemprop="copyrightHolder" content="Юг-Авто Эксперт">
	<div class="container">
		
		<!-- Footer SEO -->
		<?php if ( $arResult['SEO_TEXT'] ) { ?>
		<div class="row">
			<div class="col footer-seo">
				<div class="footer-seo-text mb-3">
					<?= $arResult['SEO_TEXT'];?>
				</div>
				<a href="#" class="c-yawhite c-h-yawhite text-decoration-none" role="footer-seo-expand">
					Читать далее
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<a href="#" class="c-yawhite c-h-yawhite text-decoration-none" style="display: none;" role="footer-seo-collapse">
					Свернуть
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-up"></use></svg>
				</a>
			</div>
		</div>
		<div class="row py-3"><div class="col"><hr /></div></div>
		<!-- // Footer SEO -->
		<?php } ?>

		<div class="row py-3">
			<div class="col-12">
				<div class="row">
					<div class="col-12 c-yawhite text-plus text-uppercase mb-3">Автомобили</div>
					<?php foreach ( $arResult['BRANDS'] as $item ) { ?>
						<div class="col-6 col-lg-3 my-1">
							<a href="/cars/used/<?= $item['code'];?>/" class="c-yalightgray c-h-yayellow text-decoration-none" alt="<?= $item['name'];?>"><?= $item['name'];?></a>
						</div>
					<?php } // foreach BRANDS ?>
				</div>
			</div>
		</div>

		<div class="row py-3"><div class="col"><hr /></div></div>

		<div class="row py-3">
			<div class="col-12">
				<div class="row">
					<div class="col-12 c-yawhite text-plus text-uppercase mb-3">Услуги</div>
					<?php foreach ( $arResult['PROPERTIES']['MENU_SERVICES']['VALUE'] as $k => $item ) { ?>
						<div class="col-6 col-lg-3 my-1">
							<a href="<?= $arResult['PROPERTIES']['MENU_SERVICES']['DESCRIPTION'][$k];?>" class="c-yalightgray c-h-yayellow text-decoration-none"><?= $item;?></a>
						</div>
					<?php } // foreach MENU SERVICES ?>
				</div>
			</div>
			<?php /*
			<div class="col-12 col-md-6">
				<div class="row">
					<div class="col-12 c-yawhite text-plus text-uppercase mb-3">Сервис</div>
					<?php foreach ( $arResult['PROPERTIES']['MENU_SERVICE']['VALUE'] as $k => $item ) { ?>
						<div class="col-6 my-1">
							<a href="<?= $arResult['PROPERTIES']['MENU_SERVICE']['DESCRIPTION'][$k];?>" class="c-yalightgray c-h-yayellow text-decoration-none"><?= $item;?></a>
						</div>
					<?php } // foreach MENU SERVICE ?>
				</div>
			</div>
			*/ ?>
		</div>
		
		<div class="row py-3"><div class="col"><hr /></div></div>

		<div class="row py-3">
			<div class="col-12 col-lg-6">
				<div class="row">
					<div class="col-12 c-yawhite text-plus text-uppercase mb-3">Акции и гарантия</div>
					<?php foreach ( $arResult['PROPERTIES']['MENU_COMPANY']['VALUE'] as $k => $item ) { ?>
						<div class="col-6 my-1">
							<a href="<?= $arResult['PROPERTIES']['MENU_COMPANY']['DESCRIPTION'][$k];?>" class="c-yalightgray c-h-yayellow text-decoration-none"><?= $item;?></a>
						</div>
					<?php } // foreach MENU SERVICES ?>
				</div>
			</div>
            <div class="col-12 py-3 mobile"><hr /></div>
			<div class="col-12 col-lg-6">
				<div class="row">
					<div class="col-12 c-yawhite text-plus text-uppercase mb-3">Информация</div>
					<?php foreach ( $arResult['PROPERTIES']['MENU_INFO']['VALUE'] as $k => $item ) { ?>
						<div class="col-6 my-1">
							<a href="<?= $arResult['PROPERTIES']['MENU_INFO']['DESCRIPTION'][$k];?>" class="c-yalightgray c-h-yayellow text-decoration-none"><?= $item;?></a>
						</div>
					<?php } // foreach MENU SERVICE ?>
				</div>
			</div>
		</div>

		<div class="row py-3"><div class="col"><hr /></div></div>

		<div class="row py-3">
			<div class="col-lg-3 mb-3 mb-md-0 pt-2 text-center text-md-start">
				<a href="/" class="text-decoration-none">
					<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/logo-white.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/logo-white.svg');?>" style="width: 150px;" />
				</a>
				<p class="mt-3">&copy; Юг-Авто Эксперт <?= date('Y');?><br />Все права защищены</p>
			</div>
			<?php /*
			<!-- <div class="col-lg-3 mb-3 mb-lg-0">
				<a href="#FORM_QUESTIONBACK" data-form="FORM_QUESTIONBACK" class="d-block text-center c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 but-lg">Написать письмо</a>
			</div> -->
			*/ ?>
			<div class="col footer-social mb-3 mb-md-0 pt-1 text-center">
				<?php foreach ( $arResult['PROPERTIES']['SOCIAL']['VALUE'] as $k => $item ) { ?>
				<a href="<?= $item;?>" class="text-decoration-none d-inline-block bg-yalightgray bg-h-yawhite me-3 text-center" target="_blank">
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#<?= $arResult['PROPERTIES']['SOCIAL']['DESCRIPTION'][$k];?>"></use></svg>
				</a>
				<?php } // foreach SOCIAL ?>
			</div>
		</div>
		
		
		<div class="row py-3">
			<div class="col footer-disclamer">
				<div class="footer-disclamer-text mb-3">	
					<?= $arResult['PREVIEW_TEXT'];?>
				</div>
				<?php /*
				<a href="#" class="c-yawhite c-h-yawhite text-decoration-none" role="footer-disclamer-expand">
					Читать далее
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<a href="#" class="c-yawhite c-h-yawhite text-decoration-none" style="display: none;" role="footer-disclamer-collapse">
					Свернуть
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-up"></use></svg>
				</a>
				*/?>
			</div>
		</div>
		

	</div>
</footer>

<div class="cookie bg-yablack c-yagray p-3 position-fixed w-100 bottom-0 text-minus-minus">
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-9 text-center text-md-start"><?= $arResult['PROPERTIES']['COOKIE']['~VALUE']['TEXT'];?></div>
			<div class="col-12 col-md-3 d-flex justify-content-center justify-content-md-end align-items-center pt-3 pt-md-0">
				<a href="#" role="close-cookie" class="text-center c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 but-lg">Я согласен</a>
			</div>
		</div>
	</div>
</div>