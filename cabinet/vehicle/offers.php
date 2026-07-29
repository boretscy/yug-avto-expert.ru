<?php 
$APPLICATION->AddChainItem('Предложения', '');
$GLOBALS['CABINET_USER']['CAR_INFO'] = $cab::getCarInfo($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'], $data['vin']);
$GLOBALS['CABINET_USER']['CAR_INFO']['OFFERS'] = $cab::getOffersForCarRevaluation($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'], $data['vin']);

$status = 'offer_start';
if ( $_POST['FORM'] == 'CONFIM_OFFER' ) {
    if ( !!$_POST['CODE'] ) {
        $status = 'offer_send';
        if ( time() > (int)$GLOBALS['CABINET_USER']['PROPERTY_CODE_TIMEOUT_VALUE'] ) {
            $timeout = true;
            $status = 'offer_code';
        } elseif ( (int)$_POST['CODE'] != (int)$GLOBALS['CABINET_USER']['PROPERTY_CODE_VALUE'] ) {
            $error = true;
            $status = 'offer_code';
        } else {
            $confim = $GLOBALS['CABINET_USER']['CAR_INFO']['OFFERS'] = $cab::postOffersForCarRevaluation( $_POST );
        }
    } else {
        $status = 'offer_code';
        $code = $cab::getSMSCodeByName( $GLOBALS['CABINET_USER']['NAME'] );
    }
}
?>
<div class="py-3 bg-yablue c-yawhite vehicle-title">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <h1 class="h3 fw-bold mt-3"><?= $data['brand']['name'];?> <?= $data['model']['name'];?> - Предложения</h1>
            </div>
        </div>
    </div>
</div>
<div class="container my-4 vehicle">
    <div class="row">
        <?php foreach ( $GLOBALS['CABINET_USER']['CAR_INFO']['OFFERS']['Current'] as $k => $i ) { ?>
        <div class="col-6 col-lg-4 mb-4">
            <a 
                href="#cabinet-offer-<?= $k;?>" 
                data-remodal-target="cabinet-offer-<?= $k;?>" 
                class="c-yadarkgray b-yagray b-radius-yaradius-7 text-minus text-decoration-none px-2 py-1 d-flex justify-content-between align-items-center me-2">
                <span>Текущее предложение: <?= number_format((int)$i['OldPrice'], 0, '.', ' ');?> ₽ &rarr; <?= number_format((int)$i['NewPrice'], 0, '.', ' ');?> ₽</span>
                <span class="cabinet-vehicle-offers-count bg-yadarkgreen c-yawhite b-radius-c-yaradius ms-1 d-flex justify-content-center align-items-center">!</span>
            </a>
        </div>
        <?php } ?>
        <?php if ( !empty($GLOBALS['CABINET_USER']['CAR_INFO']['OFFERS']['History']) ) { ?>
        <div class="col-12">
            <table class="table text-center">
                <tbody>
                    <tr class="table-active">
                        <td>Инициатор</td>
                        <td>Дата</td>
                        <td>Цена</td>
                        <td>Согласовал</td>
                        <td>Статус</td>
                    </tr>
                    <?php foreach ( $GLOBALS['CABINET_USER']['CAR_INFO']['OFFERS']['History'] as $h ) { ?>
                    <tr>
                        <td><?= $h['Initiator'];?></td>
                        <td><?= date( 'd.m.Y', strtotime($h['Date']));?></td>
                        <td><?= number_format((int)$h['Price'], 0, '.', ' ');?> ₽</td>
                        <td><?= $h['Signatory'];?></td>
                        <td><?= $h['Status'];?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
</div>

<?php foreach ( $GLOBALS['CABINET_USER']['CAR_INFO']['OFFERS']['Current'] as $k => $item ) { ?>
<div class="remodal" data-remodal-id="cabinet-offer-<?= $k;?>" >
    <button data-remodal-action="close" class="remodal-close"></button>
	<div class="row">
		<div class="col-12">
			<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/cabinet-offer.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/cabinet-offer.svg');?>" />
			<div class="remodal-title text-plus c-yablack fw-bold mt-4">Предлагаем ускорить продажу</div>
			<div class="remodal-description c-yadarkgray text-minus my-4">Изменить цену автомобиля<br /><?= $data['brand']['name'];?> <?= $data['model']['name'];?> <?= $data['general'][4]['value'];?> г.в.,<br />VIN <?= $data['vin'];?><br />с <?= number_format((int)$item['OldPrice'], 0, '.', ' ');?> ₽ на <?= number_format((int)$item['NewPrice'], 0, '.', ' ');?> ₽</div>
			<a 
				href="#cabinet-offer-confirm" data-remodal-target="cabinet-offer-confirm"
				class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button mb-3" 
				rel=“nofollow”
                role="offerConfim"
                data-vin="<?= $data['vin'];?>"
                data-doc="<?= $item['GUIDDoc'];?>"
                data-action="accept"
				><noindex>Принять</noindex></a>
			<a 
				href="#cabinet-offer-confirm" data-remodal-target="cabinet-offer-confirm"
				class="c-yablack c-h-yablack bg-yawhite bg-h-yawhite b-yadarkgray text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button" 
				rel=“nofollow”
                role="offerConfim"
                data-vin="<?= $data['vin'];?>"
                data-doc="<?= $item['GUIDDoc'];?>"
                data-action="refuse"
				><noindex>Отказать</noindex></a>
		</div>
	</div>
</div>
<?php } ?>

<?php if ( is_countable($GLOBALS['CABINET_USER']['CAR_INFO']['OFFERS']['Current']) && count($GLOBALS['CABINET_USER']['CAR_INFO']['OFFERS']['Current']) == 1 ) { ?>
<script>
    let offer = $('[data-remodal-id="cabinet-offer-0"]').remodal();
    offer.open();
</script>
<?php } ?>