<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if ( !$cab::checkauth() ) header('Location: /cabinet/login/');
$APPLICATION->SetTitle("Личный кабинет");

// YApp::sp( $GLOBALS['CABINET_USER']['INFO']['MassAvto'] );
?>
<?php
    if ( !!$GLOBALS['CABINET_USER']['PROPERTY_CHANGE_PASSWD_VALUE'] ) header('Location: /cabinet/me/#cabinet-me-passwd');
    if ( !$GLOBALS['CABINET_USER']['INFO']['Status'] ) header('Location: /cabinet/verify/');
	foreach ( $GLOBALS['CABINET_USER']['INFO']['MassAvto'] as $k => $item) {
		$GLOBALS['CABINET_USER']['INFO']['MassAvto'][$k]['CIS'] = json_decode( YApp::httpGet('https://apps.yug-avto.ru/API/get/cis/vehicles/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&vin='.$item['Avto']), true )['items'][0];
		$GLOBALS['CABINET_USER']['INFO']['MassAvto'][$k]['CarInfo'] = $cab::getCarInfo($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'], $item['Avto']);
		// if ($item['Request']) $GLOBALS['CABINET_USER']['INFO']['MassAvto'][$k]['OFFERS'] = $cab::getOffersForCarRevaluation($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'], $item['Avto']);
	}
	// YApp::sp( $GLOBALS['CABINET_USER']['INFO']['MassAvto'] );
?>
<script>
	let labels, calls, visits, internets;
</script>
<div class="bg-yablue py-4">
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h1 fw-normal c-yawhite">Мои автомобили</h1></div>
		</div>
	</div>
</div>
<div class="container my-4">
	<div class="row">
		<div class="col-12">
			<?php $vehicles = $GLOBALS['CABINET_USER']['INFO']['MassAvto'];?>
			<?php foreach ( $vehicles as $item ) { ?>
				<?php if ( $item['CIS'] ) { ?>
				<div class="p-3 b-yalightgray b-radius-yaradius-25 mb-4">
					<div class="row">
						<div class="col-6 col-lg-3">
							<a href="/cabinet/vehicle/<?= $item['CIS']['id'];?>/" class="text-decoration-none"><img src="<?= $item['CIS']['image'];?>" class="w-100 b-radius-yaradius-25" /></a>
						</div>
						<div class="col-6 col-lg-2">
							<div class="h5 mb-3"><a href="/cabinet/vehicle/<?= $item['CIS']['id'];?>/" class="text-decoration-none c-yablack c-h-yablack"><?= $item['CIS']['brand']['name'];?> <?= $item['CIS']['model']['name'];?></a></div>
							<div class="d-inline-block mb-3">
								<a href="/cabinet/vehicle/<?= $item['CIS']['id'];?>/history/" class="c-yadarkgray b-yagray b-radius-yaradius-7 text-decoration-none px-2 py-1 d-flex justify-content-between align-items-center">
									<img src="/cabinet/images/icon-clock.svg" class="me-1" />
									<span>История</span>
								</a>
							</div>
							<ul class="list-unstyled text-minus-minus">
								<li class="d-flex justify-content-start align-items-center"><img src="/cabinet/images/icon-list-bullet.svg" class="me-1" /><span class="c-yamiddlegray"><?= $item['CIS']['_general'][0];?></li>
								<li class="d-flex justify-content-start align-items-center"><img src="/cabinet/images/icon-list-bullet.svg" class="me-1" /><span class="c-yamiddlegray">VIN: <?= (($item['CIS']['vin'])?:'Не указан');?></li>
								<?php /* <li class="d-flex justify-content-start align-items-center"><img src="/cabinet/images/icon-list-bullet.svg" class="me-1" /><span class="c-yamiddlegray">Гос.номер: Не указан</li> */ ?>
								<li class="d-flex justify-content-start align-items-center"><img src="/cabinet/images/icon-list-bullet.svg" class="me-1" /><span class="c-yamiddlegray"><?= $item['CIS']['_general'][2];?></li>
								<li class="d-flex justify-content-start align-items-center"><img src="/cabinet/images/icon-list-bullet.svg" class="me-1" /><span class="c-yamiddlegray">Пробег: <?= $item['CIS']['_general'][1];?></li>
							</ul>
							<div class="text-minus-minus">
								Начало комиссионных услуг: <?= date( 'd.m.Y', strtotime($item['CarInfo']['CommissionServicesStart']));?>
							</div>
						</div>
						<div class="col-6 col-lg-4">
							<div class="mb-3">Динамика интереса за 7 дней:</div>
							<div id="chart-<?= $item['CIS']['vin'];?>" style="widht: 100%; height: 80%;"></div>
							<div class="text-minus-minus text-center">
								<ul class="list-inline">
									<li class="list-inline-item c-yadarkblue">звонки</li>
									<li class="list-inline-item c-yadarkyellow">визиты</li>
									<li class="list-inline-item c-yared">интернет обращения</li>
								</ul>
							</div>
						</div>
						<div class="col-6 col-lg-3">
							<div class="p-3 bg-yalightgray b-radius-yaradius-15 h-100 d-flex flex-column justify-content-between align-items-start">
								<div>
									<div class="h6 mb-3">Комиссионная продажа</div>
									<?php if ( $item['Request'] ) { ?>
									<a href="/cabinet/vehicle/<?= $item['CIS']['id'];?>/offers/" class="c-yadarkgray b-yagray bg-yawhite b-radius-yaradius-7 text-decoration-none px-2 py-1 d-flex justify-content-between align-items-center">
										<span>Предложения</span>
										<span class="cabinet-vehicle-offers-count bg-yadarkgreen c-yawhite b-radius-c-yaradius ms-1 d-flex justify-content-center align-items-center">!</span>
									</a>
									<?php } ?>
								</div>
								<div>
									<div class="c-yamiddlegray">Вы получите</div>
									<div class="h2 mb-1"><?= number_format($item['PriceC'], 0, '.', ' ');?> ₽</div>
									<div class="c-yamiddlegray">Цена продажи</div>
									<div class="h5 mb-0 c-yamiddlegray"><?= number_format($item['Price'], 0, '.', ' ');?> ₽</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script>

					<?php
						$hA = [];
						// for ($i=1; $i<=31; $i += 5) {
						// 	$hA[] = [
						// 		'Date' => (($i<10)?'0'.$i:$i).'.01.2026',
						// 		'Call' => mt_rand(5,99),
						// 		'Visit' => mt_rand(5,99),
						// 		'Internet' => mt_rand(5,99)
						// 	];
						// }
						foreach ( $item['CarInfo']['HistoryAppeals'] as $i) {
							if ( strtotime($i['Date']) > time()-5*7*24*60*60 && strtotime($i['Date']) <= time()-4*7*24*60*60 ) {
								$hA[] = $i;
							}
						}
					?>

					labels = []; calls = []; visits = []; internets = [];
					<?php foreach ( $hA as $h ) { ?> labels.push('<?= date( 'd.m', strtotime($h['Date']));?>');<?= PHP_EOL;?><?php } ?>
					<?php foreach ( $hA as $h ) { ?> calls.push(<?= $h['Call'];?>);<?= PHP_EOL;?><?php } ?>
					<?php foreach ( $hA as $h ) { ?> visits.push(<?= $h['Visit'];?>);<?= PHP_EOL;?><?php } ?>
					<?php foreach ( $hA as $h ) { ?> internets.push(<?= $h['Internet'];?>);<?= PHP_EOL;?><?php } ?>


						let chart<?= $item['CIS']['vin'];?> = new Chartist.Line('#chart-<?= $item['CIS']['vin'];?>', {
							labels: labels,
							series: [calls,visits,internets]
							}, {
							fullWidth: true,
							chartPadding: {
								right: 40
							}
							});
				</script>
				<?php } // if CIS ?>
			<?php } ?>
		</div>
	</div>
</div>
<?php /*
<script>
	window.onload = function () {
		<?php foreach ( $vehicles as $item ) { ?>
		$("#chart-<?= $item['CIS']['vin'];?>").CanvasJSChart(options_<?= $item['CIS']['vin'];?>);
		<?php } ?>
	}
</script>
*/?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>