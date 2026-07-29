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


<div class="container vacancies">
	<div class="row my-5 offer-title">
		<div class="col-12 col-md-12 col-lg-8">
			<h1 class="fw-normal mb-5"><?=$arResult['NAME'];?></h1>
            <?if (!empty($arResult['PREVIEW_TEXT'])):?>
            <div class="preview-text">
                <?=$arResult['PREVIEW_TEXT']?>
            </div>
            <?else:?>
            <div class="preview-text">
                <p>ГРУППА КОМПАНИЙ ЮГ-АВТО — НОВЫЕ АВТОМОБИЛИ И АВТОМОБИЛИ С ПРОБЕГОМ В КРАСНОДАРЕ, НОВОРОССИЙСКЕ И МАЙКОПЕ.</p>
                <p>«ЮГ-АВТО» — ОФИЦИАЛЬНЫЙ ДИЛЕР ТАКИХ МИРОВЫХ БРЕНДОВ, КАК: JAGUAR, LAND ROVER, CADILLAC, OPEL, CHEVROLET, VOLKSWAGEN, SKODA, PEUGEOT, CITROEN, MITSUBISHI, HONDA, LADA, HYUNDAI, FORD, KIA, SUZUKI, HAVAL</p>
                <p>С каждым годом наше направление автомобилей с пробегом набирает все большие обороты и занимает лидирующие показатели прибыльности.</p>
                <p>Поэтому мы в активном поиске продавца-консультанта автомобилей с пробегом, который будет готов поддерживать наш высокий темп работы и показатели!</p>
                <p>Если вы – активный, коммуникабельный и целеустремленный – откликайтесь на нашу вакансию как можно скорее!</p>
            </div>
            <?endif;?>
		</div>
        <div class="col-12 col-md-12 col-lg-4 bg-yalightgray b-radius-small p-4 d-flex flex-column justify-content-between">
            <div class="vacancies-head">
                <p class="c-yamiddlegray c-h-yamiddlegray text-minus mb-4 d-flex text-plus">
                    <?=$arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['DEALERSHIP']['VALUE']]['NAME'];?>
                </p>
                <div class="sum">
                    <?if(!empty($arResult['PROPERTIES']['PAY']['~VALUE'] || $arResult['PROPERTIES']['PAY_FROM']['~VALUE'])):?>
                        <?if(!empty($arResult['PROPERTIES']['PAY']['~VALUE'])):?>
                            <div class="h3 fw-bold mb-4">
                                <?=trim(number_format($arResult['PROPERTIES']['PAY']['~VALUE'], 0, '.', ' '))?>
                                <span class="rub">₽</span>
                            </div>
                        <?else:?>
                            <?if(!empty($arResult['PROPERTIES']['PAY_FROM']['~VALUE'])):?>
                                <div class="h3 fw-bold mb-4">от
                                    <?=trim(number_format($arResult['PROPERTIES']['PAY_FROM']['~VALUE'], 0, '.', ' '))?>
                                    <span class="rub">₽</span>
                                </div>
                                <?if(!empty($arResult['PROPERTIES']['PAY_TO']['~VALUE'])):?>
                                    <div class="h3 fw-bold mb-4">до
                                        <?=trim(number_format($arResult['PROPERTIES']['PAY_TO']['~VALUE'], 0, '.', ' '))?>
                                        <span class="rub">₽</span>
                                    </div>
                                <?endif;?>
                            <?endif;?>
                        <?endif;?>
                    <?else:?>
                        <div class="h3 fw-bold mb-4">Не указано</div>
                    <?endif;?>
                </div>
                <p>
                    <a href="/about/career/vacancy-response/?VACANCY=<?=$arResult['ID']?>&DEALSERSHIP=<?=$arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['DEALERSHIP']['VALUE']]['ID']?>" class="d-block w-100 p-2 text-center b-radius-small b-yadarkblue text-decoration-none c-yablue bg-circle bg-yawhite mb-4">
                        <span>Откликнуться</span>
                    </a>
                </p>
            </div>
            <div class="vacancies-footer">
                <p class="c-yamiddlegray c-h-yamiddlegray text-minus mb-4">Или звоните</p>
                <p>
                    <a href="tel:<?= YApp::phoneIn($GLOBALS['itemHl']['UF_VALUE']);?>" class="w-100 p-2 text-center b-radius-small b-yadarkblue text-decoration-none c-h-yablack bg-circle bg-yawhite mb-4 vacancies-phone">
                        <svg class="icon">
                            <use xlink:href="#profile-icon"></use>
                        </svg>
                        <span class="c-yablue"><?= YApp::phoneOut($GLOBALS['itemHl']['UF_VALUE']);?></span>
                    </a>
                </p>
            </div>
	    </div>
    </div>
    <div class="row my-5">
        <?if(!empty($arResult['PROPERTIES']['WATING_ITEMS']['~VALUE']['TEXT'])):?>
            <div class="col-12 col-md-12 col-lg-4 mb-3">
                <div class="b-yayellow p-4 b-radius-small h-100">
                    <?if(!empty($arResult['PROPERTIES']['WAITING_TITLE']['VALUE'])):?>
                        <p class="fw-bold text-uppercase"><?=$arResult['PROPERTIES']['WAITING_TITLE']['VALUE']?>:</p>
                        <?else:?>
                        <p class="fw-bold text-uppercase">ВАС ЖДЕТ:</p>
                    <?endif;?>
                    <div class="vacancy-content">
                        <?=$arResult['PROPERTIES']['WATING_ITEMS']['~VALUE']['TEXT']?>
                    </div>
                </div>
            </div>
        <?endif;?>
        <?if(!empty($arResult['PROPERTIES']['NEED_ITEMS']['~VALUE']['TEXT'])):?>
            <div class="col-12 col-md-12 col-lg-4 mb-3">
                <div class="b-yayellow p-4 b-radius-small h-100">
                    <?if(!empty($arResult['PROPERTIES']['NEED_TITLE']['VALUE'])):?>
                        <p class="fw-bold text-uppercase"><?=$arResult['PROPERTIES']['NEED_TITLE']['VALUE']?>:</p>
                    <?else:?>
                        <p class="fw-bold text-uppercase">Вам потребуется:</p>
                    <?endif;?>
                    <div class="vacancy-content">
                        <?=$arResult['PROPERTIES']['NEED_ITEMS']['~VALUE']['TEXT']?>
                    </div>
                </div>
            </div>
        <?endif;?>
        <?if(!empty($arResult['PROPERTIES']['OFFER_ITEMS']['~VALUE']['TEXT'])):?>
            <div class="col-12 col-md-12 col-lg-4 mb-3">
                <div class="b-yayellow p-4 b-radius-small h-100">
                    <?if(!empty($arResult['PROPERTIES']['OFFER_TITLE']['VALUE'])):?>
                        <p class="fw-bold text-uppercase"><?=$arResult['PROPERTIES']['OFFER_TITLE']['VALUE']?>:</p>
                    <?else:?>
                        <p class="fw-bold text-uppercase">МЫ ПРЕДЛАГАЕМ:</p>
                    <?endif;?>
                    <div class="vacancy-content">
                        <?=$arResult['PROPERTIES']['OFFER_ITEMS']['~VALUE']['TEXT']?>
                    </div>
                </div>
            </div>
        <?endif;?>
    </div>

    <div class="h3 fw-normal text-uppercase">
        <?if(!empty($arResult['IBLOCK']['NAME'])):?>
            <?=$arResult['IBLOCK']['NAME']?>
        <?endif;?>
    </div>
    <div class="row my-5">
        <div class="col-12 col-md-12 col-lg-7">
            <?if (!empty($arResult['DETAIL_TEXT'])):?>
                <div class="other-text">
                    <?=$arResult['DETAIL_TEXT']?>
                </div>
            <?else:?>
                <div class="other-text">
                    <ul>
                        <li>получение опыта в крупном холдинге Краснодарского края и Республики Адыгея на рынке автомобильного бизнеса в высокопрофессиональной команде</span></li>
                        <li>возможности профессионального и карьерного роста </span></li>
                        <li>обучение специалистов без опыта работы </span></li>
                        <li>возможность профессионального обучения от лидеров автомобильного рынка </span></li>
                        <li>работа в дружном и профессиональном коллективе </span></li>
                        <li>благоприятные условия для развития профессиональных, личностных качеств сотрудника </span></li>
                        <li>корпоративные предложения и бонусы для сотрудников Компании </span></li>
                        <li>забота Компании о детях сотрудников: детские мероприятия, конкурсы, подарки</span></li>
                    </ul>
                </div>
            <?endif;?>
        </div>
        <div class="col-12 col-md-12 col-lg-5 bg-yalightgray b-radius-small p-4">
               <div class="row my-3">
                   <div class="col-12 col-md-12">
                       <span class="text-uppercase" style="margin-right: 10px;">ТЕРРИТОРИАЛЬНО:</span>
                       <span class="text-minus fw-bold"><?=$arResult['DEALERSHIP']['~PROPERTY_ADDRESS_VALUE']?></span>
                   </div>
               </div>

                <div class="row my-3 align-items-center">
                    <div class="col-12">
                        <span class="text-uppercase" style="margin-right: 10px;">ДИЛЕРСКИЙ ЦЕНТР:</span>
                        <span class="text-minus fw-bold"> <?=$arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['DEALERSHIP']['VALUE']]['NAME']?></span>
                    </div>
                </div>

            <p>Уважаемые соискатели, мы приглашаем кандидатов на собеседование после рассмотрения резюме. В случае положительного его рассмотрения, сотрудники нашего отдела обязательно с Вами свяжутся.</p>
            <p>Ждём Ваши отклики!</p>
            <p>
                <a href="/about/career/vacancy-response/?VACANCY=<?=$arResult['ID']?>&DEALSERSHIP=<?=$arResult['DISPLAY_PROPERTIES']['DEALERSHIP']['LINK_ELEMENT_VALUE'][$arResult['PROPERTIES']['DEALERSHIP']['VALUE']]['ID']?>" class="d-inline-block w-50 p-2 text-center b-radius-small b-yadarkblue text-decoration-none c-yablue bg-circle bg-yawhite">
                    <span>Откликнуться</span>
                </a>
            </p>
        </div>
    </div>
</div>


<?php

