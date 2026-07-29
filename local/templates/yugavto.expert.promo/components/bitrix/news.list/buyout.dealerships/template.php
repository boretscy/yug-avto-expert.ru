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
    <div class="row mb-3 dealerships-buyout-title">
		<div class="col-md mb-3 mb-lg-0">
			<h2 class="fw-normal">Центр выкупа автомобилей Юг-Авто Эксперт <?= $GLOBALS['CITY'];?></h2>
		</div>
		<!-- <div class="col d-flex justify-content-end align-items-center">
			<ul class="list-inline m-0">
				<?php foreach ( $arResult['CITIES'] as $k => $item ) { ?>
				<li class="list-inline-item mb-3 mb-lg-0">
					<a 
						class="text-minus text-decoration-none tab-button b-radius-small c-yadarkgray c-h-yadarkgray b-yawhite <?= (($k=='all')?'c-yablue c-h-yablue b-yayellow':'');?>" 
						href="#" 
						data-city="<?= $k;?>" 
						role="toggleCity"
						><?= $item;?></a>
				</li>
				<?php } ?>
			</ul>
		</div> -->
	</div>
	<div class="row mt-4 pt-2">
		<div class="col">
			<div id="dealershipsMap" style="height: 460px;"></div>
		</div>
	</div>
</div>

<?php $this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU'); ?>
<script data-skip-moving="true">
var EXPERT_MAP_DEALERSHIPS = <?= json_encode( $arResult['MAP'] );?>
</script>
