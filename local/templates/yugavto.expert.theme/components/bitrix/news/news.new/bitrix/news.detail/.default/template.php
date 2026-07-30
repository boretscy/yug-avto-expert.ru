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
<div itemscope itemtype="https://schema.org/NewsArticle">
	<meta itemprop="mainEntityOfPage" content="<?= $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];?>">
	<meta itemprop="datePublished" content="<?= date('c', strtotime($arResult['ACTIVE_FROM'] ?? 'now'));?>">
	<meta itemprop="dateModified" content="<?= date('c', strtotime($arResult['TIMESTAMP_X'] ?? 'now'));?>">
	<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
		<meta itemprop="name" content="Юг-Авто Эксперт">
		<meta itemprop="url" content="https://<?= $_SERVER['HTTP_HOST'];?>">
	</div>
	<div class="bg-yablue py-4">
		<div class="container">
			<div class="row">
				<div class="col">
					<h1 class="fw-normal c-yawhite" itemprop="headline"><?= $arResult['NAME'];?></h1>
					<p class="c-yawhite"><?= $arResult['DISPLAY_ACTIVE_FROM'];?></p>
				</div>
			</div>
		</div>
	</div>
	<div class="container my-4">
		<div class="row my-3">
			<div class="col">
				<?php if ( $arResult['VIDEO_REVIEW_CODE'] ) { ?>
				<iframe width="100%" height="640" src="https://www.youtube.com/embed/<?= $arResult['VIDEO_REVIEW_CODE'];?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				<?php } else { ?>
				<img src="<?= $arResult['DETAIL_PICTURE']['SRC'];?>" alt="<?= htmlspecialchars(YApp::getCleanAltText($arResult['NAME']));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($arResult['NAME']));?>" class="w-100 b-radius-yaradius-25" itemprop="image" />
				<?php } // if VIDEO ?>
			</div>
		</div>
		<div class="row my-3">
			<div class="col" itemprop="articleBody">
				<?= $arResult['DETAIL_TEXT'];?>
			</div>
		</div>
		<?php /*
		<div class="row">
			<div class="col-12 col-md-6 col-lg-4">
				<a href="#FORM_CALLBACK" data-form="FORM_CALLBACK" class="d-block text-center c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 but-lg">Заказать обратный звонок</a>
			</div>
		</div>
		*/ ?>
	</div>
</div>