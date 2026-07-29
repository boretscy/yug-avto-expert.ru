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
			<div class="col"><h1 class="h1 fw-normal c-yawhite">Услуги</h1></div>
		</div>
	</div>
</div>
<div class="container my-5">
    <div class="row">
        <?php foreach ($arResult['ITEMS'] as $arItem) { ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'];?>" class="b-yagray b-radius-yaradius-25 py-5 px-4 d-block text-decoration-none" title="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>">
                    <img src="<?= $templateFolder;?>/images/<?= $arItem['PROPERTIES']['SVG']['VALUE'];?>.svg" style="height:74px; width:auto;" alt="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($arItem['NAME']));?>" />
                    <div class="title c-yalightblack c-h-yalightblack h3 mt-5"><?= $arItem['NAME'];?></div>
                    <div class="text c-yadarkgray c-h-yadarkgray"><?= $arItem['PREVIEW_TEXT'];?></div>
                </a>
            </div>
        <?php } ?>
    </div>
</div>