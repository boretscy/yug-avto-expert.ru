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
<div class="container my-5 history">
    <div class="row">
        <?php foreach ( $arResult['ITEMS'] as $arSection ) {?>
            <div class="col-12 col-md-6 col-lg-4">
                <div class="spoiler__container">
                    <div class="spoiler__header">
                        <div class="spoiler__icon">
                            <svg class="icon">
                                <use xlink:href="#corner-right"></use>
                            </svg>
                        </div>
                        <div class="spoiler__title"><?=$arSection['NAME'];?></div>
                    </div>
                    <div class="spoiler__body">
                        <?php foreach ( $arSection['ITEMS'] as $arItem ) {?>
                            <div class="worker">
                                <div class="worker_name"><?=$arItem['NAME']?></div>
                                <?if (!empty($arItem['PROPERTIES']['POSITION']['VALUE'])):?>
                                    <div class="worker_pisition">
                                        <?=$arItem['PROPERTIES']['POSITION']['VALUE']?>
                                    </div>
                                <?endif;?>
                                <?if (!empty($arItem['PROPERTIES']['PHONE']['VALUE'])):?>
                                    <div class="worker_contacts">
                                        <div class="title">Номер телефона:</div>
                                        <div class="fields">
                                            <a href="tel:<?=$arItem['PROPERTIES']['PHONE']['VALUE']?>"><?=$arItem['PROPERTIES']['PHONE']['VALUE']?></a>
                                            <?if (!empty($arItem['PROPERTIES']['PHONE_CODE']['VALUE'])):?>
                                                <span>доб. <?=$arItem['PROPERTIES']['PHONE_CODE']['VALUE']?></span>
                                            <?endif;?>
                                        </div>
                                    </div>
                                <?endif;?>
                                <?if (!empty($arItem['PROPERTIES']['EMAIL']['VALUE'])):?>
                                    <div class="worker_contacts">
                                        <div class="title">E-mail:</div>
                                        <div class="fields">
                                            <a href="mailto:<?=$arItem['PROPERTIES']['EMAIL']['VALUE']?>"><?=$arItem['PROPERTIES']['EMAIL']['VALUE']?></a>
                                        </div>
                                    </div>
                                <?endif;?>
                            </div>
                        <?}?>
                    </div>
                </div>
            </div>
        <?}?>

    </div>

</div>



