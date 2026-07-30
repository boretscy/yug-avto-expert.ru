<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div class="position-relative mt-4 mb-0 mb-md-4" itemscope itemtype="https://schema.org/WPHeader">
    <div class="container top-menu">
        <div class="row align-items-center">
            <div class="col-2 pb-3 d-flex d-lg-none align-items-center">
                <a href="#" role="menu">
                    <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#burger"></use></svg>
                </a>
            </div>
            <div class="col col-xl-2 text-center text-xl-start d-flex align-items-center mb-3 mb-lg-0">
                <a href="/" class="text-decoration-none d-inline-block w-100">
                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/logo.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/logo.svg');?>" class="top-logo">
                    <?php /* <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/logo.ny2023.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/svg/logo.ny2023.svg');?>" class="top-logo"> */ ?>
                </a>
            </div>
            <div class="col text-minus text-uppercase d-none d-md-flex align-items-center">
                <ul class="list-inline m-0">
                    <?php foreach ( $arResult['MENU'] as $k => $arItem ) { ?>
                    <li class="list-inline-item me-3 line-height-one" itemscope itemtype="https://schema.org/SiteNavigationElement">
                        <a 
                            href="<?= $arItem['LINK'];?>"
                            alt="<?= $arItem['TEXT'];?>" 
                            itemprop="url"
                            class="text-decoration-none c-yablackgray c-h-yablack fw-bold <?if (!$arItem['SUBMENU']) {?>single_menu<?}?>"
                            <?php if ($arItem['SUBMENU']) { ?>
                            role="submenu"
                            data-menu="<?= 'submenu-'.$k;?>"
                            <?php } // if SUBMENU?>
                            ><span itemprop="name"><?= $arItem['TEXT'];?></span></a>
                    </li>
                    <?php } // foreact ITEMS ?>
                    <li class="list-inline-item ms-4 line-height-one">
                        <a href="/news/yug-avto-lider-po-prodazham-avtomobiley-s-probegom-v-rossii/">
                            <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/reward.png?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/reward.png');?>" style="width: 130px;" />
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-2 pb-3 text-end d-flex d-lg-none justify-content-end align-items-center">
                <a href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>">
                    <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#phone"></use></svg>
                </a>
            </div>
            <div class="city-col col-12 col-lg-3 py-3 px-3 px-lg-0 position-relative d-none d-lg-flex justify-content-between justify-content-lg-end align-items-center">
                <span>
                    <a 
                        href="#" 
                        class="text-minus-minus text-decoration-none c-yablackgray c-h-yablack me-4 top-menu-cities"
                        role="top-menu-cities"
                        >
                        <span><?= $arResult['TITLE'][count($arResult['COOKIE_CITIES'])];?></span>
                        <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="d-none"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-up"></use></svg>
                    </a>
                </span>
                <span>
                    <a href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>" class="c-yablack c-h-yablack text-decoration-none text-minus d-none d-lg-inline-block">
                        <?= YApp::phoneOut($GLOBALS['itemHl']['UF_VALUE']);?>
                    </a>
                    <a href="/cars/favorites/" class="text-decoration-none ms-2 hint--top-left" role="topmmenufavorites" aria-label="Избранное">
                        <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#favorites"></use></svg>
                        <span class="c-yawhite bg-yablue b-white d-flex justify-content-evenly top-menu-icon-label d-none"></span>
                    </a>
                    <a href="/cars/compare/" class="text-decoration-none ms-2 hint--top-left" role="topmmenucompare" aria-label="Сравнение">
                        <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#compare"></use></svg>
                        <span class="c-yawhite bg-yablue b-white d-flex justify-content-evenly top-menu-icon-label d-none"></span>
                    </a>
                </span>
                <div class="position-absolute bg-yawhite px-4 py-3 top-100 top-menu-cities-list text-minus text-start d-none w-100">
                    <ul class="list-unstyled m-0">
                        <li class="py-2 b-b-yagray top-menu-cities-item d mb-2 cursor-pointer" role="setCity" data-city="all">Все города</li>
                        <?php foreach ( $arResult['CITIES'] as $item ) { ?>
                        <li class="py-2 top-menu-cities-item d d-flex align-items-center justify-content-between cursor-pointer" role="setCity" data-city="<?= $item['code'];?>" data-name="<?= $item['name'];?>">
                            <span><?= $item['name'];?></span>
                            <span><input class="form-check-input" type="checkbox" <?= ((in_array($item['name'],$arResult['COOKIE_CITIES']))?'checked':'');?> /></span>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="city-col row d-lg-none py-3 ms-0">
                <div class="col-4 ps-0">
                    <a 
                        href="#" 
                        class="text-minus-minus text-decoration-none c-yablackgray c-h-yablack top-menu-cities"
                        role="top-menu-cities"
                        >
                        <span><?= $arResult['TITLE'][count($arResult['COOKIE_CITIES'])];?></span>
                        <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="d-none"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-up"></use></svg>
                    </a>
                </div>
                <div class="col-4 text-center">
                    <a href="/news/yug-avto-lider-po-prodazham-avtomobiley-s-probegom-v-rossii/">
                        <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/reward.png?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/reward.png');?>" style="width: 100%;" />
                    </a>
                </div>
                <div class="col-4 text-end pe-0">
                    <a href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>" class="c-yablack c-h-yablack text-decoration-none text-minus d-none d-lg-inline-block">
                        <?= YApp::phoneOut($GLOBALS['itemHl']['UF_VALUE']);?>
                    </a>
                    <a href="/cars/favorites/" class="text-decoration-none ms-2 hint--top-left" role="topmmenufavorites" aria-label="Избранное">
                        <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#favorites"></use></svg>
                        <span class="c-yawhite bg-yablue b-white d-flex justify-content-evenly top-menu-icon-label d-none"></span>
                    </a>
                    <a href="/cars/compare/" class="text-decoration-none ms-2 hint--top-left" role="topmmenucompare" aria-label="Сравнение">
                        <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#compare"></use></svg>
                        <span class="c-yawhite bg-yablue b-white d-flex justify-content-evenly top-menu-icon-label d-none"></span>
                    </a>
                </div>
                <div class="position-absolute bg-yawhite px-4 py-3 top-100 top-menu-cities-list text-minus text-start d-none w-100">
                    <ul class="list-unstyled m-0">
                        <li class="py-2 b-b-yagray top-menu-cities-item d mb-2 cursor-pointer" role="setCity" data-city="all">Все города</li>
                        <?php foreach ( $arResult['CITIES'] as $item ) { ?>
                        <li class="py-2 top-menu-cities-item d d-flex align-items-center justify-content-between cursor-pointer" role="setCity" data-city="<?= $item['code'];?>" data-name="<?= $item['name'];?>">
                            <span><?= $item['name'];?></span>
                            <span><input class="form-check-input" type="checkbox" <?= ((in_array($item['name'],$arResult['COOKIE_CITIES']))?'checked':'');?> /></span>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
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
                        <?php foreach ( $arResult['MENU'][$k]['SUBMENU'] as $k2 => $item ) { ?>
                        <li class="list-inline-item me-4" itemscope itemtype="https://schema.org/SiteNavigationElement">
                            <a 
                                href="<?= $item[1];?>"
                                alt="<?= $item[0];?>" 
                                itemprop="url"
                                class="text-decoration-none text-minus c-yablackgray c-h-yablack"
                                ><span itemprop="name"><?= $item[0];?></span></a>
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
                        itemscope itemtype="https://schema.org/SiteNavigationElement"
                        <?php if ($arItem['SUBMENU']) { ?>
                        role="submenu-mobile"
                        data-menu="<?= 'submenu-'.$k;?>"
                        <?php } // if SUBMENU?>
                        >
                        <div class="row c-yamiddlegray c-h-yablackgray">
                            <div class="col">
                                <?php if ($arItem['SUBMENU']) { ?>
                                    <span itemprop="name"><?= $arItem['TEXT'];?></span>
                                <?php } else {  ?>
                                <a 
                                    href="<?= $arItem['LINK'];?>"
                                    alt="<?= $arItem['TEXT'];?>" 
                                    itemprop="url"
                                    class="text-decoration-none c-yamiddlegray c-h-yablackgray <?if (!$arItem['SUBMENU']) {?>single_menu<?}?>"
                                    ><span itemprop="name"><?= $arItem['TEXT'];?></span></a>
                                <?php } // if SUBMENU?>
                            </div>
                            <?php if ($arItem['SUBMENU']) { ?>
                            <div class="col-2 text-end"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
                            <?php } // if SUBMENU?>
                        </div>
                        <?php if ($arItem['SUBMENU']) { ?>
                        <div class="submenu-mobile">
                            <ul class="list-unstyled">
                                <?php foreach ( $arItem['SUBMENU'] as $k2 => $item ) { ?>
                                <li class="py-2 ps-2" itemscope itemtype="https://schema.org/SiteNavigationElement">
                                    <a 
                                        href="<?= $item[1];?>"
                                        alt="<?= $item[0];?>" 
                                        itemprop="url"
                                        class="text-decoration-none c-yamiddlegray c-h-yablackgray"
                                        ><span itemprop="name"><?= $item[0];?></span></a>
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
<script>
    CONNECTOR.CITIES = {};
    CONNECTOR.CITIES_TITLE = <?= json_encode($arResult['TITLE']);?>
</script>