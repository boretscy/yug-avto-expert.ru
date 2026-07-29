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
	<div class="row mb-3 dealerships-on-main-title">
		<div class="col">
			<h2 class="fw-normal">Центры выкупа автомобилей Юг-Авто Эксперт</h2>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col">
			<div class="tabs">
				<div class="tabs_head">
					<?php foreach ( $arResult['CITIES'] as $k => $item ) { ?>
					<button class="button --gray <?= (($k=='all')?'--is-active':'');?> fw-normal" data-city="<?= $k;?>" role="toggleCity"><?= $item;?></button>
					<?php } ?>
				</div>
			</div>
		</div>
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
