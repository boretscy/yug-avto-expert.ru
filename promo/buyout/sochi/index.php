<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Выкуп и оценка автомобиля");
?>
<?php 
    use Bitrix\Main\Page\Asset;
    $Asset = Asset::getInstance();
    $vehicles = json_decode(file_get_contents('https://apps.yug-avto.ru/API/get/cis/random/used/?token=34b5ac8b71018c0bc7e5c050ed90b243'), true);

    $GLOBALS['TITLE'] = 'Выкуп авто';
    $GLOBALS['CITY'] = 'Сочи';
    $GLOBALS['MAP_CENTER'] = [43.607409, 39.739869];
    $route = explode('/', parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'])['path'])[3];

    $titles = [
        'foreign' => 'Выкуп иностранных автомобилей',
        'credit' => 'Выкуп кредитных, залоговых, лизинговых авто',
        'ban' => 'Выкуп авто с запретом',
        'domestic' => 'Выкуп отечественных автомобилей',
        'corporate' => 'Выкуп авто юридических лиц и из корпоративных парков',
        'faulty' => 'Выкуп неисправных авто',
        'premium' => 'Выкуп премиальных автомобилей',
        'cars' => 'Выкуп легковых автомобилей',
        'accident' => 'Выкуп аварийных автомобилей после ДТП',
        'lux' => 'Выкуп автомобилей класса люкс',
        'commercial' => 'Выкуп коммерческих автомобилей',
        'fines' => 'Выкуп авто с ограничениями и штрафами',
    ];

    if ( $route ) $GLOBALS['TITLE'] = $titles[$route];
?>
<style>
    .list-services img {
        left: 15px;
        top: calc(50% - 9px);
    }
    .title svg {
        fill: var(--yayellow);
        width: 30px;
        height: 30px;
        margin-left: 15px;
        top: 0;
        right: 0;
    }

    .swiper-cis-new {
        width: 100%;
        height: auto;
        overflow-x: hidden;
        position: relative;
    }
    .swiper-cis-new .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }

    .swiper-cis-new .swiper-button-next, .swiper-cis-new .swiper-button-prev {
        color: var(--yablue);
    }

    .swiper-cis-new-button-prev, .swiper-cis-new-button-next {
        width: 50px;
        height: 50px;
        position: absolute;
        background-color: var(--yawhite);
        padding: 3px;
        border-radius: 50%;
        cursor: pointer;
        top: calc(50% - 25px);
    }
    .swiper-button-inner-circle {
        padding: 3px;
        width: 42px;
        height: 42px;
        border-radius: 50%;
    }
    .swiper-cis-new-button-prev svg, .swiper-cis-new-button-next svg {
        width: 35px;
        height: 35px;
        margin-left: 0;
        fill: var(--yablue);
    }
    .swiper-cis-new-button-prev {
        left: -75px;
    }
    .swiper-cis-new-button-next {
        right: -75px;
    }

    .swiper-cis-new .swiper-pagination {
        bottom: 0;
        font-size: .8rem;
    }
    .swiper-cis-new .swiper-pagination-current {
        color: var(--yablue);
        font-size: 1rem;
    }
    .cis-new-item-image {
        height: 230px;
        overflow: hidden;
    }
    .new-item-title {
        height: 60px;
    }
    .webkit_box {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    @media (max-width: 1024px) {
        .swiper-cis-new-button-next {
            right: -15px;
            z-index: 50;
        }
        .swiper-cis-new-button-prev {
            left: -15px;
            z-index: 50;
        }
    }
    @media (max-width: 768px) {
        .swiper-cis-new-button-next {
            right: -10px;
            z-index: 50;
        }
        .swiper-cis-new-button-prev {
            left: -10px;
            z-index: 50;
        }
    }
    @media (max-width: 650px) {
        .swiper-cis-new-button-next {
            right: 0px;
            z-index: 50;
        }
        .swiper-cis-new-button-prev {
            left: 0px;
            z-index: 50;
        }
    }
    /*card cards available__grid-item*/
    .available__grid-item {
        text-decoration: none;
        border: solid 1px var(--yagray);
        display: block;
        padding: 0 0;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        transition: 200ms;
        overflow: hidden;
        border-radius: 3px;
    }
    .available__grid-item:hover {
        color: var(--yablack);
        border: solid 1px var(--yayellow);
    }
    .available__grid-item:hover .button::before {
        bottom: -199px;
        left: -240px;
    }
    .liner_model .available__grid-item {
        padding: 0 0;
    }
    .grid-item__head {
        position: relative;
        display: flex;
        align-items: center;
        margin-bottom: 1em;
    }
    .grid-item__head-img {
        --heigth: 200px;
        background: var(--yawhite);
        min-height: var(--heigth);
        height: 100%;
        display: flex;
        align-items: center;
        width: 100%;
        justify-content: space-around;
    }
    .grid-item__head-img img {
        max-height: var(--heigth);
        object-fit: cover !important;
        width: 100%;
    }
    .head_items-box {
        padding: 1em 1em;
        text-align: left;
    }
    .grid-item__title {
        text-decoration: none;
        font-size: 18px;
        font-weight: 600;
        line-height: 1em;
        margin-bottom: 1em;
        display: block;
        min-height: 35px;
        max-height: 40px;
        text-transform: uppercase;
        color: var(--yablack) !important;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        color: var(--yadarkgray);
    }
    .model__grid-card__content--list_box {
        --margin-bottom: 2em;
        margin-bottom: var(--margin-bottom);
    }
    .model__grid-card__content--list {
        --margin-bottom: 2em;
        margin-bottom: 0;
        word-break: break-all;
        min-height: revert;
        display: -webkit-box;
        -webkit-line-clamp: 4;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        line-height: 1.4rem;
    }
    .model__grid-card__content--list-item {
        font-size: 13px;
        font-weight: 300;
        line-height: 1em;
        color: var(--yadarkgray);
        display: inline-block;
    }
    .model__grid-card__content--list-item::before {
        content: '\2022';
        color: var(--yadarkblue);
        margin-right: 0.3rem;
        margin-left: 0.3rem;
        font-size: 20px;
        vertical-align: middle;
    }
    .model__grid-card__content--list-item:nth-child(1)::before {
        content: '';
        margin-left: 0;
        margin-right: 0;
    }
    .model__grid-card__footer {
        padding: var(--padding);
        padding-top: 0;
    }
    .model__grid-card__content--price {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }
    .model__grid-card__content--price_curent {
        font-size: 16px;
        font-weight: 400;
        line-height: 1em;
    }
    .button {
        --ui-color: var(--yadarkblue);
        --border-color: var(--ui-color);
        --background: transparent;
        --color: var(--ui-color);
        --font-size: 14px;
        --padding-top-bottom: 12px;
        --padding-left-right: 40px;
        --margin-inner: 15px;
        --icon-size: calc(1em * 1.2);
        --transition: 100ms;
        line-height: calc(1em * 1);
        display: inline-flex;
        border: 1px solid var(--yadarkblue);
        color: var(--yawhite);
        background: var(--color);
        font-size: var(--font-size);
        padding: var(--padding-top-bottom) var(--padding-left-right);
        border-radius: 3px;
        cursor: pointer;
        justify-content: center;
        align-items: center;
        /*margin-bottom: 10px;*/
        align-content: space-between;
        transition: var(--transition);
        text-decoration: none;
        /*box-shadow: inset 0 0 1px 1px var(--yablack)00038, 0px 1px 0px 0px var(--yablack)0002b;*/
    }
    .button:active {
        box-shadow: inset 0 0 3px 2px var(--yablack)00020;
    }
    .button:hover {
        --ui-color: var(--yayellow);
        color: var(--yablack);
        background: var( --ui-color);
        border: solid 1px var(--yadarkblue);
        /*
        Создать медиа запрос на кастомный скрин вот так
        */
    }
    .button span {
        z-index: 50;
    }
    .transparent{
        --ui-color: var(--yadarkblue);
        position: relative;
        overflow: hidden;
        transition: 300ms;
        background: var(--yawhite);
        color: var(--ui-color);
    }
    .transparent:hover {
        --ui-color: var(--yadarkblue);
        background: var(--yawhite);
        color: var(--ui-color);
        border: solid 1px var(--ui-color);
    }
    .transparent::before {
        content: "";
        background-color: var(--yayellow);
        border-radius: 50%;
        width: 300px;
        height: 300px;
        position: absolute;
        bottom: -300px;
        left: -300px;
        transition: .2s;
        z-index: 0;
    }
    .transparent:hover::before{
        bottom: -199px;
        left: -240px;
    }


.bordered {
    position: relative;
}
.bordered:before {
    content: '';
    border-radius: 5px 0 0 5px;
    border-left: 3px solid var(--yayellow);
    border-top: 3px solid var(--yayellow);
    height: calc(100% - 40px);
    width: 210px;
    position: absolute;
    bottom: 0;
    left: 0;
}
.bordered:after {
    content: '';
    border-radius: 0 0 0 5px;
    /* border-right: 3px solid var(--yayellow); */
    border-bottom: 3px solid var(--yayellow);
    height: 80px;
    width: 100%;
    position: absolute;
    bottom: -1px;
    left: 0;
}
.bullet-number {
    width: 34px;
    height: 34px;
}


@media (max-width: 768px) {
    #form-block-semiblue .moved-car {
        transition: .2s;
        bottom: -60px;
        right: 0;
        width: 258px;
        height: auto;
    }
    #form-block-semiblue:hover .moved-car {
        transition: .2s;
        bottom: -70px;
        right: 20px;
        width: 268px;
        height: auto;
    }
    .bordered:before, .bordered:after {
        content: unset;
    }
}
</style>
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"form.block.semiblue", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "form.block.semiblue",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"WEB_FORM_ID" => "16",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>
<div class="container my-5" data-scroll="buyoutBlock">
    <div class="row">
        <div class="col-md-6 col-lg-3">
            <img class="w-100" src="/promo/buyout/sochi/car2.png" />
        </div>
        <div class="col">
            <div class="row pt-3 list-services">

            <div class="col-md-4 mb-3 d-md-none">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-yellow.svg" class="position-absolute" />
                        Выкуп авто с запретом
                    </a>
                </div>
                <div class="col-md-4 mb-3 d-md-none">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-yellow.svg" class="position-absolute" />
                        Выкуп неисправных авто
                    </a>
                </div>
                <div class="col-md-4 mb-3 d-md-none">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-yellow.svg" class="position-absolute" />
                        Выкуп аварийных автомобилей после ДТП
                    </a>
                </div>
                <div class="col-md-4 mb-3 d-md-none">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-yellow.svg" class="position-absolute" />
                        Выкуп авто с ограничениями и штрафами
                    </a>
                </div>

                <div class="col-md-4 mb-3">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-circle.svg" class="position-absolute" />
                        Выкуп иностранных автомобилей
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-circle.svg" class="position-absolute" />
                        Выкуп кредитных, залоговых, лизинговых авто
                    </a>
                </div>
                <div class="col-md-4 mb-3 d-none d-md-block">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-yellow.svg" class="position-absolute" />
                        Выкуп авто с запретом
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-circle.svg" class="position-absolute" />
                        Выкуп отечественных автомобилей
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-circle.svg" class="position-absolute" />
                        Выкуп авто юридических лиц и из корпоративных парков
                    </a>
                </div>
                <div class="col-md-4 mb-3 d-none d-md-block">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-yellow.svg" class="position-absolute" />
                        Выкуп неисправных авто
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-circle.svg" class="position-absolute" />
                        Выкуп премиальных автомобилей
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-circle.svg" class="position-absolute" />
                        Выкуп легковых автомобилей
                    </a>
                </div>
                <div class="col-md-4 mb-3 d-none d-md-block">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-yellow.svg" class="position-absolute" />
                        Выкуп аварийных автомобилей после ДТП
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-circle.svg" class="position-absolute" />
                        Выкуп автомобилей класса люкс
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-circle.svg" class="position-absolute" />
                        Выкуп коммерческих автомобилей
                    </a>
                </div>
                <div class="col-md-4 mb-3 d-none d-md-block">
                    <a 
                        class="p-2 ps-5 b-radius-small bg-yalightgray position-relative d-flex align-items-center h-100 text-decoration-none c-yablack c-h-yablack">
                        <img src="/promo/buyout/sochi/check-yellow.svg" class="position-absolute" />
                        Выкуп авто с ограничениями и штрафами
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container my-5">
    <div class="row title mb-5">
        <div class="col-md"><h2>Последние выкупленные автомобили</h2></div>
    </div>
                
    <div class="row cis-new" role="cis">
        <div class="col position-relative">
            
            <div class="swiper-cis-new pb-5">
                <div class="swiper-wrapper" role="cis-new-swiper">
                    <?php foreach ( $vehicles as $item ) { ?>
                    <div class="swiper-slide">
                        <div class="available__grid-item">
                            <div class="grid-item__head">
                                <a class="grid-item__head-img"><img src="<?= $item['image'];?>" alt="<?= $item['name'];?>"></a>
                            </div>
                            <div  class="head_items-box">
                                <div class="head_items">
                                    <a class="grid-item__title"><?= $item['name'];?></a>
                                </div>
                                <div class="model__grid-card__content--list_box">
                                    <div class="model__grid-card__content--list">
                                        <?php foreach ( array_chunk($item['general'], 3)[0] as $g ) { ?>
                                            <?php if ($g) { ?>
                                                <span  class="model__grid-card__content--list-item"><?= $g?></span>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="model__grid-card__content--list">
                                        <?php foreach ( array_chunk($item['general'], 3)[1] as $g ) { ?>
                                            <?php if ($g) { ?>
                                                <span  class="model__grid-card__content--list-item"><?= $g?></span>
                                            <?php } ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div  class="model__grid-card__footer">
                                    <div  class="model__grid-card__content--price">
                                        <div  class="model__grid-card__content--price_curent"><?= YApp::formatNumber($item['price']);?> <span  class="rub">₽</span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } // foreach USED ?>
                </div>
                <div class="swiper-pagination"></div>
            </div>
                    
            <div class="swiper-cis-new-button-prev b-yablue">
                <div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-left"></use></svg></div>
            </div>
            <div class="swiper-cis-new-button-next b-yablue">
                <div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
            </div>

        </div>
    </div>
        
</div>
<div class="container my-5">
    <div class="row title mb-5">
        <div class="col-md-8"><h2>Юг-Авто Эксперт гарантирует</h2></div>
        <div class="col-md-4 text-md-end pt-2">
            <a href="#FORM_BUYOUT_BUYOUT" class="c-yablack c-h-yablack text-decoration-none">
                Продать авто
                <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
            <div class="b-radius-small b-yagray p-4">
                <div class="row">
                    <div class="col-4 col-md-12 mb-md-5"><img src="/promo/buyout/sochi/wallet.svg" /></div>
                    <div class="col-8 col-md-12 c-yadarkgray text-plus">Справедливую<br />цену</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
            <div class="b-radius-small b-yagray p-4">
                <div class="row">
                    <div class="col-4 col-md-12 mb-md-5"><img src="/promo/buyout/sochi/shield.svg" /></div>
                    <div class="col-8 col-md-12 c-yadarkgray text-plus">Юридическую<br />чистоту сделки</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
            <div class="b-radius-small b-yagray p-4">
                <div class="row">
                    <div class="col-4 col-md-12 mb-md-5"><img src="/promo/buyout/sochi/clock.svg" /></div>
                    <div class="col-8 col-md-12 c-yadarkgray text-plus">Деньги<br />в день сделки</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
            <div class="b-radius-small b-yagray p-4">
                <div class="row">
                    <div class="col-4 col-md-12 mb-md-5"><img src="/promo/buyout/sochi/like.svg" /></div>
                    <div class="col-8 col-md-12 c-yadarkgray text-plus">Сделка там,<br />где удобно вам</div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="py-5 bg-yalightgray" data-scroll="sellBlock">
    <div class="container bordered b-radius-small">
        <div class="row mb-5">
            <div class="col-md-3 text-end ps-4 pb-5"><img class="w-100" src="/promo/buyout/sochi/steps-start.png" /></div>
            <div class="col-md">
                <div class="row py-5">
                    <div class="col-md-4 mb-3 mb-lg-0">
                        <div class="b-radius-small b-yagray p-3 bg-yawhite">
                            <span class="bullet-number c-yablack b-radius-small bg-yayellow d-flex align-items-center justify-content-center">1</span>
                            <div class="h5 text-uppercase my-4">Свяжитесь с нами</div>
                            <p class="text-minus-minus line-height-one c-yadarkgray mb-0" style="height: 80px;">Мы уточним данные об авто и желаемую Вами сумму оценки. Согласуем с Вами время и место осмотра автомобиля.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-lg-0">
                        <div class="b-radius-small b-yagray p-3 bg-yawhite">
                            <span class="bullet-number c-yablack b-radius-small bg-yayellow d-flex align-items-center justify-content-center">2</span>
                            <div class="h5 text-uppercase my-4">Оценка автомобиля</div>
                            <p class="text-minus-minus line-height-one c-yadarkgray mb-0" style="height: 80px;">Мы проведем осмотр Вашего авто <span class="text-uppercase c-yablack">там, где удобно Вам</span> и предложим оценочную стоимость автомобиля.</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3 mb-lg-0">
                        <div class="b-radius-small b-yagray p-3 bg-yawhite">
                            <span class="bullet-number c-yablack b-radius-small bg-yayellow d-flex align-items-center justify-content-center">3</span>
                            <div class="h5 text-uppercase my-4">Сделка и выплата</div>
                            <p class="text-minus-minus line-height-one c-yadarkgray mb-0" style="height: 80px;">При Вашем положительном решении, оформим документы и выплатим полную стоимость в течении 15 минут.</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="col-md-3 text-end ps-5 d-none d-lg-block"><img class="w-100" src="/promo/buyout/sochi/car4.png" /></div> -->
        </div>
    </div>
    <div class="container">
        <div class="row my-5">
            <div class="col text-center">
                <a href="#FORM_BUYOUT_BUYOUT" data-remodal-target="FORM_BUYOUT_BUYOUT" class="bg-yayellow bg-h-yayellow c-yablack c-h-yablack text-uppercase text-decoration-none py-3 px-5 b-radius-small">Связаться</a>
            </div>
        </div>
    </div>
</div>
<?php $arFilterDealerships = ['PROPERTY_TAG_VALUE' => ['Выкуп','Выездной выкуп'],'PROPERTY_CITY_VALUE' => ['Сочи']];?>
<?$APPLICATION->IncludeComponent("bitrix:news.list", "buyout.dealerships", Array(
	"ACTIVE_DATE_FORMAT" => "d.m.Y",	// Формат показа даты
		"ADD_SECTIONS_CHAIN" => "N",	// Включать раздел в цепочку навигации
		"AJAX_MODE" => "N",	// Включить режим AJAX
		"AJAX_OPTION_ADDITIONAL" => "",	// Дополнительный идентификатор
		"AJAX_OPTION_HISTORY" => "N",	// Включить эмуляцию навигации браузера
		"AJAX_OPTION_JUMP" => "N",	// Включить прокрутку к началу компонента
		"AJAX_OPTION_STYLE" => "N",	// Включить подгрузку стилей
		"CACHE_FILTER" => "N",	// Кешировать при установленном фильтре
		"CACHE_GROUPS" => "N",	// Учитывать права доступа
		"CACHE_TIME" => "36000000",	// Время кеширования (сек.)
		"CACHE_TYPE" => "A",	// Тип кеширования
		"CHECK_DATES" => "Y",	// Показывать только активные на данный момент элементы
		"COMPONENT_TEMPLATE" => "main.dealerships",
		"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
		"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"FIELD_CODE" => array(	// Поля
			0 => "",
			1 => "",
		),
		"FILTER_NAME" => "arFilterDealerships",	// Фильтр
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
		"IBLOCK_ID" => "4",	// Код информационного блока
		"IBLOCK_TYPE" => "content",	// Тип информационного блока (используется только для проверки)
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"INCLUDE_SUBSECTIONS" => "N",	// Показывать элементы подразделов раздела
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"NEWS_COUNT" => "100",	// Количество новостей на странице
		"PAGER_BASE_LINK_ENABLE" => "N",	// Включить обработку ссылок
		"PAGER_DESC_NUMBERING" => "N",	// Использовать обратную навигацию
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",	// Время кеширования страниц для обратной навигации
		"PAGER_SHOW_ALL" => "N",	// Показывать ссылку "Все"
		"PAGER_SHOW_ALWAYS" => "N",	// Выводить всегда
		"PAGER_TEMPLATE" => ".default",	// Шаблон постраничной навигации
		"PAGER_TITLE" => "Новости",	// Название категорий
		"PARENT_SECTION" => "",	// ID раздела
		"PARENT_SECTION_CODE" => "",	// Код раздела
		"PREVIEW_TRUNCATE_LEN" => "",	// Максимальная длина анонса для вывода (только для типа текст)
		"PROPERTY_CODE" => array(	// Свойства
			0 => "",
			1 => "LINK",
			2 => "",
		),
		"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
		"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SHOW_404" => "N",	// Показ специальной страницы
		"SORT_BY1" => "NAME",	// Поле для первой сортировки новостей
		"SORT_BY2" => "SORT",	// Поле для второй сортировки новостей
		"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
		"SORT_ORDER2" => "ASC",	// Направление для второй сортировки новостей
		"STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа списка
	),
	false
);?>

<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"form.block.semiblue", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "form.block.semiblue",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"WEB_FORM_ID" => "15",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>

<?php 
	foreach ( glob($_SERVER['DOCUMENT_ROOT'].'/local/vue-apps/dealerships-multiselect/dist/js/*.js') as $file ) {

		$arF = explode('/', $file);
		$Asset->addJs('/local/vue-apps/dealerships-multiselect/dist/js/'.$arF[count($arF)-1]);
	}
?>

<script>
const swiper_cis_new = new Swiper('.swiper-cis-new', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-cis-new-button-next',
        prevEl: '.swiper-cis-new-button-prev',
    },
    slidesPerView: 4,
    spaceBetween: 25,
    
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        750: {
            slidesPerView: 2,
            spaceBetween: 25
        },
        1024: {
            slidesPerView: 4,
            spaceBetween: 25
        },
    }
})
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>