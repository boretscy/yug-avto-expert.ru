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
<?php if ( $arResult['SECTIONS'] ) { ?>

<div class="container my-5 pages-brands">
	<div class="row mb-3">
		<div class="col">
			<h1 class="fw-normal">Автомобили</h1>
		</div>
	</div>

	<div class="row mb-3">
		<?php foreach ( $arResult['SECTIONS'] as $arItem ) { ?>
		<div class="col-4 col-md-1 mb-2">
			<div class="b-yagray b-radius-small p-3 pages-brands-item d-flex align-items-center">
				<a href="/brands/<?= $arItem['CODE'];?>/" alt="<?= $arItem['NAME'];?>">
					<img src="<?= CFile::GetPath($arItem['LOGO']);?>" alt="<?= $arItem['NAME'];?>" class="w-100" />
				</a>
			</div>
		</div>
		<?php } // foreach SECTIONS ?>
	</div>

</div>

<?php } else { ?>

<div class="container my-5 pages-brand">
	<div class="row">
		<div class="col">
			<h1 class="fw-normal">Автомобили <?= $arResult['SECTION']['NAME'];?></h1>
		</div>
		<div class="col-1">
			<img src="<?= CFile::GetPath($arResult['SECTION']['LOGO']);?>" alt="" class="w-100" />
		</div>
	</div>

	<div class="row my-5">
		<div class="col-md-4 mb-3">
			<a href="/dealerships/?brand=<?= $arResult['SECTION']['CODE'];?>" class="d-block px-3 py-2 b-radius-small text-decoration-none b-yadarkblue pages-brand-link position-relative">
				<?= count($arResult['DEALERSHIPS']);?> <?= YApp::getWorld(count($arResult['DEALERSHIPS']), 'dc');?>
				<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
			</a>
		</div>
		<div class="col-md-4 mb-3">
			<a href="/cars/new/<?= $arResult['SECTION']['CODE'];?>" class="d-block px-3 py-2 b-radius-small text-decoration-none b-yadarkblue pages-brand-link position-relative">
				<?= $arResult['NEW_COUNT'];?> <?= YApp::getWorld($arResult['NEW_COUNT'], 'n');?> <?= YApp::getWorld($arResult['NEW_COUNT'], 'a');?> в наличии
				<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
			</a>
		</div>
		<div class="col-md-4 mb-3">
			<a href="/cars/used/<?= $arResult['SECTION']['CODE'];?>" class="d-block px-3 py-2 b-radius-small text-decoration-none b-yadarkblue pages-brand-link position-relative">
				<?= $arResult['USED_COUNT'];?> <?= YApp::getWorld($arResult['USED_COUNT'], 'a');?> с пробегом в наличии
				<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
			</a>
		</div>
	</div>

	<div class="row mb-3">
		<div class="col">
			<h2 class="fw-normal">Модельный ряд</h2>
		</div>
	</div>

	<div class="row mb-3">
		<?php foreach ( $arResult['ITEMS'] as $arItem ) { ?>
		<div class="col-md-6 col-lg-4 mb-3">
			<div class="b-yagray b-radius-small p-3 bg-circle pages-models-item">
				<span>
					<div class="pages-models-item-image d-flex align-items-center">
						<a href="<?= $arItem['DETAIL_PAGE_URL'];?>" alt="<?= $arItem['NAME'];?>" class="mb-4">
							<img src="<?= $arItem['PROPERTIES']['EXTERNAL_PICTURE']['VALUE'];?>" alt="<?= $arItem['NAME'];?>" class="w-100" />
						</a>
					</div>
					<div class="mb-2"><a class="pages-models-item-title c-yablack text-decoration-none mb-2" href="/brands/<?= $arItem['CODE'];?>/" alt="<?= $arItem['NAME'];?>"><?= $arItem['NAME'];?></a></div>
					
					<div class="mb-3 pages-models-item-cis">
						<?php if ( (int)$arResult['VEHICLES'][$arItem['PROPERTIES']['EXTERNAL_CODE']['VALUE']]['vehicles'] ) { ?>
						<a class="c-yadarkgray c-h-yamiddlegray text-decoration-none mb-2" href="/cars/new/<?= $arResult['SECTION']['CODE'];?>/<?= $arItem['CODE'];?>" alt="<?= $arItem['NAME'];?>">
							<span class="bg-yalightgray p-1 b-radius-small"><?= (int)$arResult['VEHICLES'][$arItem['PROPERTIES']['EXTERNAL_CODE']['VALUE']]['vehicles'];?></span> авто в наличии
						</a>
						<?php } // if VEHICLES ?>
					</div>
				</span>
			</div>
		</div>
		<?php } // foreach ITEMS ?>
	</div>

	<?php if ( $arResult['USED'] ) { ?>
	
	<div class="container cis-others my-5">
		<div class="row mb-5">
			<div class="col">
				<h3 class="fw-normal" role="cis-others-title">Автомобили с пробегом</h3>
			</div>
			<div class="col-6 text-end pt-2">
				<a href="/cars/used/<?= $arResult['SECTION']['CODE'];?>" class="c-yablack c-h-yablack text-decoration-none">
					Смотреть все
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
				</a>
			</div>
		</div>

		<div class="row">
			<div class="col position-relative">
				
				<div class="swiper-cis-others pb-5">
					<div class="swiper-wrapper" role="cis-others-swiper">
						<?php foreach ( $arResult['USED'] as $item ) { ?>
						<div class="swiper-slide">
							<div class="available__grid-item">
								<div class="grid-item__head">
									<a href="<?= $item['link'];?>" class="grid-item__head-img"><img src="<?= $item['image'];?>" alt="<?= $item['name'];?>"></a>
								</div>
								<div  class="head_items-box">
									<div class="head_items">
										<a href="<?= $item['link'];?>" class="grid-item__title"><?= $item['name'];?></a>
									</div>
									<div class="model__grid-card__content--list">
										<?php foreach ( $item['general'] as $g ) { ?>
											<?php if ($g) { ?><span  class="model__grid-card__content--list-item"><?= $g?></span><?php } ?>
										<?php } ?>
									</div>
									<div  class="model__grid-card__footer">
										<div  class="model__grid-card__content--price">
											<div  class="model__grid-card__content--price_curent"><?= YApp::formatNumber($item['price']);?> <span  class="rub">₽</span></div>
										</div>
										<a href="<?= $item['link'];?>" class="button transparent w100"><span >ПОЛУЧИТЬ ПРЕДЛОЖЕНИЕ</span></a>
									</div>
								</div>
							</div>
						</div>
						<?php } // foreach USED ?>
					</div>
					<div class="swiper-pagination"></div>
				</div>
				
				<div class="swiper-cis-others-button-prev b-yablue">
					<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-left"></use></svg></div>
				</div>
				<div class="swiper-cis-others-button-next b-yablue">
					<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
				</div>

			</div>
		</div>
	</div>

	<?php } // if USED ?>
</div>


<div class="py-5 bg-yalightgray">
<?php $GLOBALS['MAIN_SERVICES_TITLE'] = 'Доверьте ремонт своего автомобиля настоящим профессионалам своего дела'; ?>
<?$APPLICATION->IncludeComponent("bitrix:news.list", "main.services", Array(
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
		"COMPONENT_TEMPLATE" => "main.services",
		"DETAIL_URL" => "",	// URL страницы детального просмотра (по умолчанию - из настроек инфоблока)
		"DISPLAY_BOTTOM_PAGER" => "N",	// Выводить под списком
		"DISPLAY_DATE" => "N",
		"DISPLAY_NAME" => "N",
		"DISPLAY_PICTURE" => "N",
		"DISPLAY_PREVIEW_TEXT" => "N",
		"DISPLAY_TOP_PAGER" => "N",	// Выводить над списком
		"FIELD_CODE" => array(	// Поля
			0 => "DETAIL_PICTURE",
			1 => "",
		),
		"FILTER_NAME" => "",	// Фильтр
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",	// Скрывать ссылку, если нет детального описания
		"IBLOCK_ID" => "9",	// Код информационного блока
		"IBLOCK_TYPE" => "content",	// Тип информационного блока (используется только для проверки)
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",	// Включать инфоблок в цепочку навигации
		"INCLUDE_SUBSECTIONS" => "N",	// Показывать элементы подразделов раздела
		"MESSAGE_404" => "",	// Сообщение для показа (по умолчанию из компонента)
		"NEWS_COUNT" => "2",	// Количество новостей на странице
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
			0 => "LINK",
			1 => "",
		),
		"SET_BROWSER_TITLE" => "N",	// Устанавливать заголовок окна браузера
		"SET_LAST_MODIFIED" => "N",	// Устанавливать в заголовках ответа время модификации страницы
		"SET_META_DESCRIPTION" => "N",	// Устанавливать описание страницы
		"SET_META_KEYWORDS" => "N",	// Устанавливать ключевые слова страницы
		"SET_STATUS_404" => "N",	// Устанавливать статус 404
		"SET_TITLE" => "N",	// Устанавливать заголовок страницы
		"SHOW_404" => "N",	// Показ специальной страницы
		"SORT_BY1" => "SORT",	// Поле для первой сортировки новостей
		"SORT_BY2" => "TIMESTAMP_X",	// Поле для второй сортировки новостей
		"SORT_ORDER1" => "ASC",	// Направление для первой сортировки новостей
		"SORT_ORDER2" => "DESC",	// Направление для второй сортировки новостей
		"STRICT_SECTION_CHECK" => "N",	// Строгая проверка раздела для показа списка
	),
	false
);?>
</div>

<?php if ( $arResult['DEALERSHIPS'] ) { ?>
	<div class="container brand-dealerships my-5">
		<div class="row mb-5 brand-dealerships-title">
			<div class="col">
				<h1 class="fw-normal">Официальный дилер <?= $arResult['SECTION']['NAME'];?> в Краснодарском крае - Юг-Авто</h1>
			</div>
		</div>
		<div class="row mb-3 brand-dealerships-title">
			<div class="col-6">
				<h3 class="fw-normal">Ждем вас в наших дилерских центрах</h3>
			</div>
			<div class="col-6 text-end pt-2">
				<a href="/dealerships/" class="c-yablack c-h-yablack text-decoration-none">
					Смотреть все
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>
				</a>
			</div>
		</div>
		<div class="row mb-3">
			<div class="col-md-6 brand-dealerships-items">
				<?php foreach ( $arResult['DEALERSHIPS'] as $item ) { ?>
					<div class="p-4 b-radius-small bg-yawhite b-yagray mb-3 brand-dealerships-item">
						<div class="row">
							<div class="col-10">
								<div class="h3 fw-bold"><?= $item['NAME'];?></div>
							</div>
							<div class="col-2 text-end">
								<img src="<?= CFile::GetPath($arResult['SECTION']['LOGO']);?>" alt="" class="w-50" />
							</div>
						</div>
						<p><?= $item['PROPERTY_ADDRESS'];?></p>
						<div class="row my-3">
							<div class="col-6">
								<a href="<?= $item['DETAIL_PAGE_URL'];?>" alt="<?= $item['NAME'];?>">Построить маршрут</a>
							</div>
							<div class="col-6 text-end">
								<a href="tel:+<?= YApp::phoneIn($item['PROPERTY_PHONE_VALUE']);?>" class="text-plus-plus c-yablack c-h-yablack text-decoration-none fw-bold"><?= YApp::phoneOut($item['PROPERTY_PHONE_VALUE']);?></a>
							</div>
						</div>
						<div class="row">
							<div class="col-4">
								<a 
									href="#FORM_CALLBACK" 
									class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-small b-yablue bg-circle"
									><span>Заказать звонок</span></a>
							</div>
							<div class="col-4">
								<a 
									href="/cars/new/?dealership=<?= $item['PROPERTY_EXTERNAL_CODE_VALUE'];?>" 
									class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-small b-yablue bg-circle"
									><span>Автомобили в наличии</span></a>
							</div>
							<div class="col-4">
								<a 
									href="/services/service/?dealership=<?= $item['CODE'];?>" 
									class="d-block text-decoration-none text-uppercase text-minus-minus text-center py-2 b-radius-small b-yablue bg-circle"
									><span>Запись на сервис</span></a>
							</div>
						</div>
					</div>
				<?php } // foreach DEALERSHIPS ?>
			</div>
			<div class="col-md-6 brand-dealerships-map">
				<div id="brandMap"></div>
			</div>
		</div>
	</div>
<?php $this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU'); ?>
<script>
var brandMap;
ymaps.ready(OfferMapInit);

function OfferMapInit () {
		
	brandMap = new ymaps.Map('brandMap', {

		center: [45.044963, 38.971193],
		zoom: 10
	}, {
		searchControlProvider: 'yandex#search'
	});
	<?php 
		$geoStr = 'brandMap.geoObjects';
		foreach ($arResult['DEALERSHIPS'] as $item) {
			$geoStr .= '.add(new ymaps.Placemark(';
			$geoStr .= '['.$item['PROPERTY_COORDS_LAT_VALUE'].', '.$item['PROPERTY_COORDS_LON_VALUE'].'],';
			$geoStr .= '{balloonContent: "'.$item['NAME'].'", iconCaption: "'.$item['NAME'].'"},';
			$geoStr .= '{preset: "islands#darkBlueDotIconWithCaption"}';
			$geoStr .= '))';
		}
		echo PHP_EOL.$geoStr.PHP_EOL;
	?>
}
</script>
<?php } // if DEALERSHIPS ?>

<div class="container my-5">
	<div class="row">
		<div class="col"><?= $arResult['SECTION']['DESCRIPTION'];?></div>
	</div>
</div>
	



<?php } ?>
