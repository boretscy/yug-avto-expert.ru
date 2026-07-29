<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div class="position-relative mt-4 shadow-small">
    <div class="container top-menu">
        <div class="row align-items-center">
            <div class="col-2 mobile">
                <a href="#" role="menu">
                    <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#burger"></use></svg>
                </a>
            </div>
            <div class="col col-lg-2 text-center text-lg-start mb-3">
                <a class="text-decoration-none d-inline-block w-100">
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/logo.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/logo.svg');?>" class="top-logo">
                </a>
            </div>
            <div class="col pt-3 text-minus text-uppercase d-none d-lg-flex justify-content-center" style="padding-top: 1.25rem! important;">
                <ul class="list-inline">
                    <?php foreach ( $arResult['MENU'] as $k => $arItem ) { ?>
                    <li class="list-inline-item me-3">
                        <a 
                            href="<?= $arItem['LINK'];?>"
                            alt="<?= $arItem['TEXT'];?>" 
                            class="text-decoration-none c-yablackgray c-h-yablack fw-bold single_menu"
                            role="scroll"
                            data-scroll="<?= $arItem['SCROLL'];?>"
                            ><?= $arItem['TEXT'];?></a>
                    </li>
                    <?php } // foreact ITEMS ?>
                </ul>
            </div>
            <div class="col-2 text-end mobile">
                <a href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>">
                    <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#phone"></use></svg>
                </a>
            </div>
            <div class="col-2 col-lg-3 px-0 text-end desktop">
                <a href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>">
                    <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#phone"></use></svg>
                    <?= YApp::phoneOut($GLOBALS['itemHl']['UF_VALUE']);?>
                </a>
            </div>
        </div>
    </div>
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
                                <a 
                                    href="<?= $arItem['LINK'];?>"
                                    alt="<?= $arItem['TEXT'];?>" 
                                    role="scroll"
                                    data-scroll="<?= $arItem['SCROLL'];?>"
                                    class="text-decoration-none c-yamiddlegray c-h-yablackgray single_menu"
                                    ><?= $arItem['TEXT'];?></a>
                            </div>
                        </div>
                    </li>
                <?php } // foreact ITEMS ?>
            </ul>
        </div>
    </div>
</div>