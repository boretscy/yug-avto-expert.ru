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
	<div class="row mb-3 align-items-center">
		<div class="col-12 col-md-10">
            <h1 class="fw-normal">Работа в Юг-Авто
                <span class="c-yablue"><?=count($arResult['ITEMS'])?> <?=YApp::getWorld(count($arResult['ITEMS']), 'v')?></span>
            </h1>
        </div>
        <div class="col-12 col-md-2">
            <a href="#FORM_VACANCY" class="d-block w-100 p-2 text-center b-radius-small b-yadarkblue text-decoration-none c-yablack c-h-yablack bg-circle">
                <span>Заполнить анкету</span>
            </a>
        </div>
	</div>
</div>

<div id="VueFilter"></div>


<?php if ( empty($arResult['ITEMS']) ) { ?>
    <div class="container my-5 text-center">
        <div class="row">
            <div class="col">
                <p class="h2 fw-normal c-yamiddlegray">Ничего не найдено</p>
            </div>
        </div>
    </div>
<?php } else { ?>

    <div class="container my-5">
        <div class="row mb-3">
            <?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
            <div class="col-12 col-md-4 mb-3">
                <a href="<?=$arItem['DETAIL_PAGE_URL']?>" class="vacancies b-radius-small d-block p-4 shadow-small-h position-relative">
                    <div class="vacancies__head">
                        <p class="fw-bold c-yablue text-plus-plus"><?=$arItem['NAME']?></p>
                        <p class="c-yamiddlegray c-h-yamiddlegray text-minus"><?= $arItem['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arItem['PROPERTIES']['DEALERSHIP']['VALUE']]['NAME'];?></p>
                    </div>
                    <div class="vacancies__footer">
                        <?if(!empty($arItem['PROPERTIES']['PAY']['~VALUE'] || $arItem['PROPERTIES']['PAY_FROM']['~VALUE'])):?>
                            <?if(!empty($arItem['PROPERTIES']['PAY']['~VALUE'])):?>
                                <span>
                                    <strong><?=number_format($arItem['PROPERTIES']['PAY']['~VALUE'], 0, '.', ' ')?>
                                        <span class="rub">₽</span>
                                    </strong>
                                </span>
                                <?else:?>
                                <?if(!empty($arItem['PROPERTIES']['PAY_FROM']['~VALUE'])):?>
                                    <span>
                                            <strong>от <?=number_format($arItem['PROPERTIES']['PAY_FROM']['~VALUE'], 0, '.', ' ')?>
                                                <span class="rub">₽</span>
                                            </strong>
                                        </span>
                                    <?if(!empty($arItem['PROPERTIES']['PAY_TO']['~VALUE'])):?>
                                        <span>
                                            <strong> - до <?=number_format($arItem['PROPERTIES']['PAY_TO']['~VALUE'], 0, '.', ' ')?>
                                                <span class="rub">₽</span>
                                            </strong>
                                        </span>
                                    <?endif;?>
                                <?endif;?>
                            <?endif;?>
                            <?else:?>
                            <span>
                                <strong>Не указано</strong>
                            </span>
                        <?endif;?>
                    </div>
                    <svg class="icon position-absolute">
                        <use xlink:href="#email"></use>
                    </svg>
                </a>
            </div>

            <?php } // foreach ITEMS ?>

        </div>

           

    </div>
<?php } // ?>

<?php if ( $arParams["DISPLAY_BOTTOM_PAGER"] ) { ?>
<div class="container my-5">
	<div class="row">
		<div class="col"><?= $arResult["NAV_STRING"];?></div>
	</div>
</div>
<?php } // if PAGES ?>

<script data-skip-moving="true">
	var filter = <?= json_encode($arResult['vuefilter']);?>
</script>

<?php 
	foreach ( glob($_SERVER['DOCUMENT_ROOT'].'/local/vue-apps/vue-filter/dist/js/*.js') as $file ) {

		$arF = explode('/', $file);
		$this->addExternalJS('/local/vue-apps/vue-filter/dist/js/'.$arF[count($arF)-1]);
	}
?>
