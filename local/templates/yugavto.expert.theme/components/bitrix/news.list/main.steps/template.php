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
<div class="py-5 bg-yalightgray main-steps">
    <div class="container bordered px-5 px-md-3">
        <div class="top-yellow-border"></div>
        <div class="row pb-md-4">
            <div class="col-md-8 col-xl-3 main-steps-title pt-5 px-4 position-relative">
                <div class="pt-xl-4 pt-md-5 mt-3 mt-md-0">
                    Всего<br class="d-md-none d-xl-inline" /> <span class="bigest fw-bolder text-uppercase">3 шага</span>, чтобы <span class="big fw-bold">получить</span> <span class="bigest fw-bolder text-uppercase">деньги</span> за свой автомобиль
                </div>
                <img src="<?= $templateFolder;?>/images/wallet.svg?4" />
            </div>
            <div class="col-md-4 d-none d-md-block text-md-center text-xl-start d-xl-none"><img class="w-75" src="<?= $templateFolder;?>/images/money.png" /></div>
            <div class="col-xl pt-0 pt-xl-4">
                <div class="row mt-4 mt-md-3 mt-xl-5">
					<?php foreach ( $arResult['ITEMS'] as $k => $arItem ) { ?>
					<div class="col-md-4 mb-3 mb-xl-0">
                        <div class="b-radius-yaradius-25 p-3 bg-yawhite h-100">
                            <div class="d-flex align-items-center justify-content-start d-md-none">
                                <span class="bullet-number c-yablack b-radius-small bg-yayellow d-inline-flex align-items-center justify-content-center me-2"><?= $k+1;?></span>
                                <div class="h5 text-uppercase my-0 my-mb-4"><?= $arItem['NAME'];?></div>
                            </div>
                            <span class="bullet-number c-yablack b-radius-small bg-yayellow align-items-center justify-content-center me-2 d-none d-md-inline-flex"><?= $k+1;?></span>
                            <div class="h5 text-uppercase  my-3 my-mb-4 d-none d-md-block"><?= $arItem['NAME'];?></div>
                            <p class="text-minus-minus line-height-one c-yadarkgray mt-3 mb-0 mb-md-3"><?= $arItem['PREVIEW_TEXT'];?></p>
                        </div>
                    </div>
					<?php } ?>
                </div>
            </div>
            <div class="col-md-3 text-end ps-5 d-block d-md-none d-xl-block"><img class="w-100" src="<?= $templateFolder;?>/images/money.png" /></div>
        </div>
    </div>
    <div class="container">
        <div class="row mt-md-5">
            <div class="col"></div>
            <div class="col-10 col-md-7 col-xl-4 text-center">
                <a href="#FORM_BUYOUT_BUYOUT" data-form="FORM_BUYOUT_BUYOUT" class="bg-yadarkyellow bg-h-yayellow c-yablack c-h-yablack text-uppercase text-decoration-none py-3 px-5 b-radius-yaradius-15 d-block position-relative">Связаться</a>
            </div>
            <div class="col"></div>
        </div>
    </div>
</div>
