<?php 
$APPLICATION->AddChainItem('История автомобиля', '');
$GLOBALS['CABINET_USER']['CAR_INFO'] = $cab::getCarInfo($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'], $data['vin']);
// YApp::sp( $GLOBALS['CABINET_USER']['CAR_INFO'] );
$hA = [];
$timestamp_from = ( $_GET['date_from'] ) ? strtotime($_GET['date_from']) : strtotime(date( 'Y-m-d'))-2*14*24*60*60;
$timestamp_to = ( $_GET['date_to'] ) ? strtotime($_GET['date_to']) : strtotime(date( 'Y-m-d 23:59:59'));
foreach ( $GLOBALS['CABINET_USER']['CAR_INFO']['HistoryAppeals'] as $i) {
    if ( strtotime($i['Date']) > $timestamp_from && strtotime($i['Date']) <= $timestamp_to ) {
        $hA[] = $i;
    }
}
?>
<div class="py-3 bg-yablue c-yawhite vehicle-title">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <h1 class="h3 fw-bold mt-3"><?= $data['brand']['name'];?> <?= $data['model']['name'];?> - История автомобиля</h1>
            </div>
        </div>
    </div>
</div>
<div class="container my-4 vehicle">
    <div class="row mb-5">
        <div class="col-6"><h5>Динамика интереса за 14 дней:</h5></div>
        <div class="col-12">
            <div id="chart-<?= $data['vin'];?>" style="widht: 100%; height: 100%;"></div>
            <div class="text-minus-minus text-center">
				<ul class="list-inline">
					<li class="list-inline-item c-yadarkblue">звонки</li>
					<li class="list-inline-item c-yadarkyellow">визиты</li>
					<li class="list-inline-item c-yared">интернет обращения</li>
				</ul>
			</div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-12">
            <h5 class="mb-4">История изменения цены к получению</h5>
            <table class="table table-hover table-striped text-center">
                <tbody>
                    <tr class="table-active">
                        <td>Дата</td>
                        <td>Новая цена</td>
                    </tr>
					<?php foreach ( $GLOBALS['CABINET_USER']['CAR_INFO']['HistoryPrice'] as $h ) { ?>
                    <tr>
                        <td><?= date( 'd.m.Y', strtotime($h['Date']));?></td>
                        <td><?= number_format((int)$h['Price'], 0, '.', ' ');?> ₽</td>
                    </tr>
					<?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>

	let labels = [], calls = [], visits = [], internets = [];
	<?php foreach ( $hA as $h ) { ?> labels.push('<?= date( 'd.m', strtotime($h['Date']));?>');<?= PHP_EOL;?><?php } ?>
	<?php foreach ( $hA as $h ) { ?> calls.push(<?= $h['Call'];?>);<?= PHP_EOL;?><?php } ?>
	<?php foreach ( $hA as $h ) { ?> visits.push(<?= $h['Visit'];?>);<?= PHP_EOL;?><?php } ?>
	<?php foreach ( $hA as $h ) { ?> internets.push(<?= $h['Internet'];?>);<?= PHP_EOL;?><?php } ?>


	let chart<?= $data['vin'];?> = new Chartist.Line('#chart-<?= $data['vin'];?>', {
		labels: labels,
		series: [calls,visits,internets]
		}, {
		fullWidth: true,
		chartPadding: {
			right: 40
		}
	});
    
</script>