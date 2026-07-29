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
    <div class="car-cards ">
        <?php foreach( $arResult['ITEMS'] as $arItem ) { ?>
        <a href="<?= $arItem['PROPERTIES']['LINK']['VALUE'];?>" class="car-cards__item b-yalightgray b-radius-yaradius-25 bg-yawhite position-relative text-decoration-none" data-section="<?= $arItem['PROPERTIES']['SECTION']['VALUE'];?>">
            <div class="car-card__item-footer">
                <img src="<?= CFile::GetPath($arItem['PROPERTIES']['ICON']['VALUE']);?>" alt="<?= $arItem['NAME'];?>" alt="">
            </div>
            <div class="car-card__item-head">
                <div class="car-cards__item-title c-yalightblack c-h-yalightblack fw-bold">
                    <span><?= $arItem['NAME'];?></span>
                    <svg class="icon">
                        <use xlink:href="#arrow"></use>
                    </svg>
                </div>
                <div class="car-cards__item-sub">
                    <?php if ($arItem['PROPERTIES']['SECTION']['VALUE']) { ?>
                    <span role="carcount" data-section="<?= $arItem['PROPERTIES']['SECTION']['VALUE'];?>"><?= $arResult['COUNTS'][$arItem['PROPERTIES']['SECTION']['VALUE']];?></span> <?= YApp::getWorld($arResult['COUNTS'][$arItem['PROPERTIES']['SECTION']['VALUE']], 'a');?> в наличии
                    <?php } else { ?>
                    <?= $arItem['PREVIEW_TEXT'];?>
                    <?php } ?>
                </div>
            </div>
        </a>
        <?php } ?>
    </div>
</div>
