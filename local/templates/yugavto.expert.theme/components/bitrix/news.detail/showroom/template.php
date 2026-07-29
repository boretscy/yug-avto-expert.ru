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
<script data-skip-moving="true">
var YAppsShowroomStyles = {
    '--yalightgray': '#f3f5f6',
    '--yagray': '#bdc0c2',
    '--yamiddlegray': '#7b8284',
    '--yadarkgray': '#565b5d',
    '--yablackgray': '#1c232c',
    '--yalightblack': '#5C5D5E',
    '--detail_bg': '#F3F5F6',
    '--yablack': '#000000',
    '--yawhite': '#ffffff',
    '--yalightred': '#ee9999',
    '--yared': '#cc0000',
    '--yalightgreen': '#99eea0',
    '--yargreen': '#1bcc00',
    '--yalightblue': '#87cefa',
    '--yablue': '#0048a9',
    '--yadarkblue': '#003375',
    '--yalightyellow': '#fce0b2',
    '--yayellow': '#fdba4d',
    '--yadarkyellow': '#fdaa25',
    'font-family': "'Roboto', Helvetica, sans-serif",
    'font-size': '14px',
    '--h1': '40px',
    '--h2': '28px',
    '--h3': '24px',
    '--h4': '20px',
    '--p': '14px'
}
var CTId = 20930, CTSess = 'e94ad128', YandexID = 31748036
</script>
<div class="container mb-5 mt-3">
	<div class="row">
		<div class="col">
			<div id="YAppsShowroom" mode="<?= $arResult['CODE'];?>"></div>
		</div>
	</div>
</div>

<div class="container cis-dealership my-5" style="display: none;">
	<div class="row mb-3">
		<div class="col">
			<div class="fw-normal h3" role="cis-dealership-title">Автомобиль в наличии <span></span></div>
		</div>
	</div>

	<div class="row my-4">
		<div class="col-12 px-1">
			<div class="row cis-dealership b-yagray b-radius-small mx-2">
				<div class="col-sm-12 col-md-4 col-lg-3 px-0 cis-dealership-image"></div>
				<div class="col-sm-12 col-md-8 col-lg-4 p-4 bg-yalightgray">
					<div class="row">
						<div class="col-10">
							<div class="h4 fw-bold">
								<a href="#" class="c-yablack c-h-yablack text-decoration-none cis-dealership-link" alt=""></a>
							</div>
							<p class="cis-dealership-address"></p>
							<a class="cis-dealership-link-map" href="#" target="_blank" alt="">Построить маршрут</a>
							<div class="row">
								<div class="col-6 mt-3">
									<div class="text-minus-minus c-yagray cis-dealership-work-dealer-description"></div>
									<div class="text-minus cis-dealership-work-dealer-value"></div>
								</div>
								<div class="col-6 mt-3">
									<div class="text-minus-minus c-yagray cis-dealership-work-service-description"></div>
									<div class="text-minus cis-dealership-work-service-value"></div>
								</div>
								<div class="col-6 mt-2">
									<div class="text-minus-minus c-yagray">Сайт:</div>
									<div class="text-minus">
										<a href="#" target="_blank" class="text-decoration-none c-yablack c-h-yadarkgray cis-dealership-site"></a>
									</div>
								</div>
								<div class="col-6 mt-2">
									<div class="text-minus-minus c-yagray">Номер телефона:</div>
									<div class="text-minus">
										<a href="#" class="text-decoration-none fw-bold c-yablack c-h-yadarkgray cis-dealership-phone"></a>
									</div>
								</div>
							</div>
						</div>
						<div class="col-2 cis-dealership-logo">
							<img src="" class="w-100" alt="" />
						</div>
					</div>
				</div>
				<div class="col-sm-12 col-md-12 col-lg-5 p-4 bg-yalightgray">
					<div id="dealershipMap"></div>
				</div>
			</div> 
		</div>
	</div>

</div>

<div class="container cis-offers my-5" style="display: none;">
	<div class="row mb-3">
		<div class="col">
			<div class="fw-normal h3" role="cis-offers-title">Акции в Юг-Авто <span></span></div>
		</div>
	</div>

	<div class="row">
		<div class="col position-relative">
			
			<div class="swiper-cis-offers pb-5">
				<div class="swiper-wrapper" role="cis-offers-swiper">
					<!-- Slides -->
					
				</div>
				<div class="swiper-pagination"></div>
			</div>
			
			<div class="swiper-cis-offers-button-prev b-yablue">
				<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-left"></use></svg></div>
			</div>
			<div class="swiper-cis-offers-button-next b-yablue">
				<div class="swiper-button-inner-circle b-yadarkyellow-2 bg-h-yadarkyellow-2"><svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg></div>
			</div>

		</div>
	</div>
</div>

<?php $APPLICATION->IncludeComponent(
	"bitrix:form.result.new",
	"form.line",
	Array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"VARIABLE_ALIASES" => array("RESULT_ID"=>"RESULT_ID","WEB_FORM_ID"=>"WEB_FORM_ID",),
		"WEB_FORM_ID" => "1"
	)
);?>

<div class="container cis-others my-5" style="display: none;">
	<div class="row mb-3">
		<div class="col">
			<h3 class="fw-normal" role="cis-others-title">Возможно вас заинтересует автомобиль с пробегом:</h3>
		</div>
	</div>

	<div class="row">
		<div class="col position-relative">
			
			<div class="swiper-cis-others pb-5">
				<div class="swiper-wrapper" role="cis-others-swiper">
					<!-- Slides -->
					
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

<?php if ( $arResult['SEO_TEXT'] ) { ?>
<div class="container my-5">
	<div class="row">
		<div class="col">
			<?= $arResult['SEO_TEXT'];?>
		</div>
	</div>
</div>
<?php } ?>

<?php 
	$this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU');
	// $this->addExternalJS('https://apps.yug-avto.ru/API/get/cis/script/?token=34b5ac8b71018c0bc7e5c050ed90b243');
	// foreach ( glob($_SERVER['DOCUMENT_ROOT'].'/local/vue-apps/vue-showroom/dist/js/*.js') as $file ) {
	// 	$arF = explode('/', $file);
	// 	$this->addExternalJS('/local/vue-apps/vue-showroom/dist/js/'.$arF[count($arF)-1]);
	// }
?>
<script data-skip-moving="true">
	<?= file_get_contents('https://apps.yug-avto.ru/API/get/cis/script/?token=34b5ac8b71018c0bc7e5c050ed90b243');?>
</script>