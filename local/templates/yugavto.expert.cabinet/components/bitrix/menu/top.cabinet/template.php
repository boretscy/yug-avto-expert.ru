<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div class="position-relative mt-4 mb-0 mb-md-4">
    <div class="container top-menu">
        <div class="row align-items-center">
            <div class="col-2 pb-3 mobile">
                <a href="#" role="menu">
                    <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#burger"></use></svg>
                </a>
            </div>
            <div class="col col-xl-2 text-center text-xl-start mb-3">
                <a href="/" class="text-decoration-none d-inline-block w-100">
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/logo.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/logo.svg');?>" class="top-logo">
                    <?php /* <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/logo.ny2023.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/logo.ny2023.svg');?>" class="top-logo"> */ ?>
                </a>
            </div>
            <div class="col pt-3 text-minus text-uppercase desktop" style="padding-top: 1.25rem! important;">
                <ul class="list-inline">
                    <?php foreach ( $arResult['MENU'] as $k => $arItem ) { ?>
                    <li class="list-inline-item me-3">
                        <a 
                            href="<?= $arItem['LINK'];?>"
                            alt="<?= $arItem['TEXT'];?>" 
                            class="text-decoration-none c-yablackgray c-h-yablack <?if (!$arItem['SUBMENU']) {?>single_menu<?}?>"
                            <?php if ($arItem['SUBMENU']) { ?>
                            role="submenu"
                            data-menu="<?= 'submenu-'.$k;?>"
                            <?php } // if SUBMENU?>
                            ><?= $arItem['TEXT'];?></a>
                    </li>
                    <?php } // foreact ITEMS ?>
                </ul>
            </div>
            <?php if ( $GLOBALS['CABINET_USER'] ) { ?>
            <div class="col-5 d-flex justify-content-end">
                <?php /*
                <a href="#" class="text-decoration-none me-4">
                    <img src="<?= $templateFolder;?>/images/notify.svg" />
                </a>
                */ ?>
                <a href="/cabinet/me/" class="me-4 text-decoration-none d-flex align-items-center">
                    <img src="<?= $templateFolder;?>/images/user.svg" class="me-2" />
                    <span class="d-none d-xl-inline-block"><?= $GLOBALS['CABINET_USER']['INFO']['FIO'];?></span>
                </a>
                <a href="/cabinet/logout/" class="text-decoration-none d-flex align-items-center">
                    <img src="<?= $templateFolder;?>/images/logout.svg" class="me-2" />
                    <span class="d-none d-xl-inline-block">Выход</span>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
    <?php foreach ($arResult['MENU'] as $k => $arItem) { ?>
    <?php if ( $arItem['SUBMENU'] ) { ?>
    <div class="submenu my-2 bg-yawhite shadow-small" data-menu="submenu-<?= $k;?>">
        <div class="container">
            <div class="row">
                <div class="col-2"></div>
                <div class="col pt-3" style="padding-top: 1.25rem! important;">
                    <ul class="list-inline">
                        <?php foreach ( $arItem['SUBMENU'] as $k => $item ) { ?>
                        <li class="list-inline-item me-4">
                            <a 
                                href="<?= $item[1];?>"
                                alt="<?= $item[0];?>" 
                                class="text-decoration-none text-minus c-yablackgray c-h-yablack"
                                ><?= $item[0];?></a>
                        </li>
                        <?php } // foreact ITEMS ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php } ?>
</div>
<div class="menu-cover mobile"></div>

<div class="container mobile top-menu position-relative bg-yawhite">
    <div class="row menu bg-yawhite">
        <div class="col-12 pt-2">
            <ul class="list-unstyled">
                <?php foreach ( $arResult['MENU'] as $k => $arItem ) { ?>
                    <li 
                        class="py-2"
                        <?php if ($arItem['SUBMENU']) { ?>
                        role="submenu-mobile"
                        data-menu="<?= 'submenu-'.$k;?>"
                        <?php } // if SUBMENU?>
                        >
                        <div class="row c-yamiddlegray c-h-yablackgray">
                            <div class="col">
                                <?php if ($arItem['SUBMENU']) { ?>
                                    <?= $arItem['TEXT'];?>
                                <?php } else {  ?>
                                <a 
                                    href="<?= $arItem['LINK'];?>"
                                    alt="<?= $arItem['TEXT'];?>" 
                                    class="text-decoration-none c-yamiddlegray c-h-yablackgray <?if (!$arItem['SUBMENU']) {?>single_menu<?}?>"
                                    ><?= $arItem['TEXT'];?></a>
                                <?php } // if SUBMENU?>
                            </div>
                            <?php if ($arItem['SUBMENU']) { ?>
                            <div class="col-2 text-end"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
                            <?php } // if SUBMENU?>
                        </div>
                        <?php if ($arItem['SUBMENU']) { ?>
                        <div class="submenu-mobile">
                            <ul class="list-unstyled">
                                <?php foreach ( $arItem['SUBMENU'] as $k => $item ) { ?>
                                <li class="py-2 ps-2">
                                    <a 
                                        href="<?= $item[1];?>"
                                        alt="<?= $item[0];?>" 
                                        class="text-decoration-none c-yamiddlegray c-h-yablackgray"
                                        ><?= $item[0];?></a>
                                </li>
                                <?php } // foreact ITEMS ?>
                            </ul>
                        </div>
                        <?php } // if SUBMENU?>
                    </li>
                <?php } // foreact ITEMS ?>
            </ul>
        </div>
    </div>
</div>
