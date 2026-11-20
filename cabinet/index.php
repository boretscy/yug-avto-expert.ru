<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if ( !$cab::checkAuth() ) {
	LocalRedirect('/cabinet/login/');
}
$APPLICATION->SetTitle("Личный кабинет");

if ( !empty($GLOBALS['CABINET_USER']['PROPERTY_CHANGE_PASSWD_VALUE']) ) {
	LocalRedirect('/cabinet/me/#cabinet-me-passwd');
}
if ( empty($GLOBALS['CABINET_USER']['INFO']['Status']) ) {
	LocalRedirect('/cabinet/verify/');
}

$massAvto = $GLOBALS['CABINET_USER']['INFO']['MassAvto'] ?? [];
if ( !empty($massAvto) && is_array($massAvto) ) {
	foreach ( $massAvto as $k => $item ) {
		$vin = $item['Avto'] ?? '';
		if ( !empty($vin) ) {
			$rawCis = YApp::httpGet('https://apps.yug-avto.ru/API/get/cis/vehicles/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&vin=' . urlencode($vin));
			$decodedCis = !empty($rawCis) ? json_decode($rawCis, true) : null;
			$massAvto[$k]['CIS'] = $decodedCis['items'][0] ?? null;
			$massAvto[$k]['CarInfo'] = $cab::getCarInfo($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'], $vin);
		}
	}
	$GLOBALS['CABINET_USER']['INFO']['MassAvto'] = $massAvto;
}
?>

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
			<?php 
			$vehicles = $GLOBALS['CABINET_USER']['INFO']['MassAvto'] ?? [];
			if ( empty($vehicles) ) { ?>
				<div class="p-5 b-yalightgray b-radius-yaradius-25 text-center my-4">
					<div class="h4 mb-3">У вас пока нет автомобилей на комиссии</div>
					<div class="c-yamiddlegray">Когда ваш автомобиль будет принят на комиссионную продажу, он появится в этом разделе.</div>
				</div>
			<?php } else { ?>
				<?php foreach ( $vehicles as $item ) { ?>
					<?php if ( !empty($item['CIS']) ) { 
						$vinClean = $item['CIS']['vin'] ?? '';
						$chartVarId = 'chart_' . md5($vinClean ?: uniqid('', true));
						$commStart = !empty($item['CarInfo']['CommissionServicesStart']) ? date('d.m.Y', strtotime($item['CarInfo']['CommissionServicesStart'])) : '—';
					?>
					<div class="p-3 b-yalightgray b-radius-yaradius-25 mb-4">
						<div class="row">
							<div class="col-6 col-lg-3">
								<a href="/cabinet/vehicle/<?= $item['CIS']['id'];?>/" class="text-decoration-none">
									<img src="<?= $item['CIS']['image'];?>" class="w-100 b-radius-yaradius-25" alt="Автомобиль" />
								</a>
							</div>
							<div class="col-6 col-lg-2">
								<div class="h5 mb-3">
									<a href="/cabinet/vehicle/<?= $item['CIS']['id'];?>/" class="text-decoration-none c-yablack c-h-yablack">
										<?= \Bitrix\Main\Text\HtmlFilter::encode(($item['CIS']['brand']['name'] ?? '') . ' ' . ($item['CIS']['model']['name'] ?? ''));?>
									</a>
								</div>
								<div class="d-inline-block mb-3">
									<a href="/cabinet/vehicle/<?= $item['CIS']['id'];?>/history/" class="c-yadarkgray b-yagray b-radius-yaradius-7 text-decoration-none px-2 py-1 d-flex justify-content-between align-items-center">
										<img src="/cabinet/images/icon-clock.svg" class="me-1" alt="" />
										<span>История</span>
									</a>
								</div>
								<ul class="list-unstyled text-minus-minus">
									<li class="d-flex justify-content-start align-items-center mb-1">
										<img src="/cabinet/images/icon-list-bullet.svg" class="me-1" alt="" />
										<span class="c-yamiddlegray"><?= $item['CIS']['_general'][0] ?? '';?></span>
									</li>
									<li class="d-flex justify-content-start align-items-center mb-1">
										<img src="/cabinet/images/icon-list-bullet.svg" class="me-1" alt="" />
										<span class="c-yamiddlegray">VIN: <?= !empty($vinClean) ? \Bitrix\Main\Text\HtmlFilter::encode($vinClean) : 'Не указан';?></span>
									</li>
									<li class="d-flex justify-content-start align-items-center mb-1">
										<img src="/cabinet/images/icon-list-bullet.svg" class="me-1" alt="" />
										<span class="c-yamiddlegray"><?= $item['CIS']['_general'][2] ?? '';?></span>
									</li>
									<li class="d-flex justify-content-start align-items-center mb-1">
										<img src="/cabinet/images/icon-list-bullet.svg" class="me-1" alt="" />
										<span class="c-yamiddlegray">Пробег: <?= $item['CIS']['_general'][1] ?? '';?></span>
									</li>
								</ul>
								<div class="text-minus-minus">
									Начало комиссионных услуг: <?= $commStart;?>
								</div>
							</div>
							<div class="col-6 col-lg-4">
								<div class="mb-3">Динамика интереса за 7 дней:</div>
								<div id="chart-<?= \Bitrix\Main\Text\HtmlFilter::encode($vinClean);?>" style="width: 100%; height: 80%;"></div>
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
										<?php if ( !empty($item['Request']) ) { ?>
										<a href="/cabinet/vehicle/<?= $item['CIS']['id'];?>/offers/" class="c-yadarkgray b-yagray bg-yawhite b-radius-yaradius-7 text-decoration-none px-2 py-1 d-flex justify-content-between align-items-center">
											<span>Предложения</span>
											<span class="cabinet-vehicle-offers-count bg-yadarkgreen c-yawhite b-radius-c-yaradius ms-1 d-flex justify-content-center align-items-center">!</span>
										</a>
										<?php } ?>
									</div>
									<div>
										<div class="c-yamiddlegray">Вы получите</div>
										<div class="h2 mb-1"><?= number_format((float)($item['PriceC'] ?? 0), 0, '.', ' ');?> ₽</div>
										<div class="c-yamiddlegray">Цена продажи</div>
										<div class="h5 mb-0 c-yamiddlegray"><?= number_format((float)($item['Price'] ?? 0), 0, '.', ' ');?> ₽</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<script>
						(function() {
							<?php
								$hA = [];
								if ( !empty($item['CarInfo']['HistoryAppeals']) && is_array($item['CarInfo']['HistoryAppeals']) ) {
									foreach ( $item['CarInfo']['HistoryAppeals'] as $i ) {
										$time = !empty($i['Date']) ? strtotime($i['Date']) : 0;
										if ( $time > time() - 5*7*24*60*60 && $time <= time() - 4*7*24*60*60 ) {
											$hA[] = $i;
										}
									}
								}
							?>
							var labels = [];
							var calls = [];
							var visits = [];
							var internets = [];

							<?php foreach ( $hA as $h ) { ?>
								labels.push('<?= !empty($h['Date']) ? date('d.m', strtotime($h['Date'])) : '';?>');
								calls.push(<?= (int)($h['Call'] ?? 0);?>);
								visits.push(<?= (int)($h['Visit'] ?? 0);?>);
								internets.push(<?= (int)($h['Internet'] ?? 0);?>);
							<?php } ?>

							if ( typeof Chartist !== 'undefined' ) {
								var <?= $chartVarId ?> = new Chartist.Line('#chart-<?= \Bitrix\Main\Text\HtmlFilter::encode($vinClean);?>', {
									labels: labels,
									series: [calls, visits, internets]
								}, {
									fullWidth: true,
									chartPadding: { right: 40 }
								});
							}
						})();
					</script>
					<?php } // if CIS ?>
				<?php } ?>
			<?php } ?>
		</div>
	</div>
</div>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
