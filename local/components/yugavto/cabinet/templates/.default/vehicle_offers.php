<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Text\HtmlFilter;

$data = $arResult["CIS_DATA"] ?? [];
$vin = $data['vin'] ?? '';
$userGuid = $arResult["USER_GUID"] ?? '';
$offers = $arResult["OFFERS"] ?? [];
$currentOffers = $offers['Current'] ?? [];
$historyOffers = $offers['History'] ?? [];
$status = $arResult["OFFER_STATUS"] ?? 'offer_start';
$notice = $arResult["OFFER_NOTICE"] ?? '';
$confim = $arResult["OFFER_CONFIM"] ?? false;
?>

<div class="py-3 bg-yablue c-yawhite vehicle-title">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <h1 class="h3 fw-bold mt-3">
                    <?= HtmlFilter::encode(($data['brand']['name'] ?? '') . ' ' . ($data['model']['name'] ?? ''));?> - Предложения
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="container my-4 vehicle">
    <div class="row">
        <?php if (!empty($notice)) { ?>
        <div class="col-12 mb-3">
            <div class="alert alert-warning b-radius-yaradius-15">
                <?= HtmlFilter::encode($notice) ?>
            </div>
        </div>
        <?php } ?>

        <?php if (!empty($currentOffers) && is_array($currentOffers)) { ?>
            <?php foreach ($currentOffers as $k => $i) { ?>
            <div class="col-6 col-lg-4 mb-4">
                <a 
                    href="#cabinet-offer-<?= $k;?>" 
                    data-remodal-target="cabinet-offer-<?= $k;?>" 
                    class="c-yadarkgray b-yagray b-radius-yaradius-7 text-minus text-decoration-none px-2 py-1 d-flex justify-content-between align-items-center me-2">
                    <span>Текущее предложение: <?= number_format((int)($i['OldPrice'] ?? 0), 0, '.', ' ');?> ₽ &rarr; <?= number_format((int)($i['NewPrice'] ?? 0), 0, '.', ' ');?> ₽</span>
                    <span class="cabinet-vehicle-offers-count bg-yadarkgreen c-yawhite b-radius-c-yaradius ms-1 d-flex justify-content-center align-items-center">!</span>
                </a>
            </div>
            <?php } ?>
        <?php } else { ?>
            <div class="col-12 mb-4">
                <div class="p-4 b-yalightgray b-radius-yaradius-15 text-center text-muted">
                    Активных предложений по переоценке автомобиля в данный момент нет.
                </div>
            </div>
        <?php } ?>

        <?php if (!empty($historyOffers) && is_array($historyOffers)) { ?>
        <div class="col-12">
            <h5 class="mb-3">История предложений</h5>
            <table class="table text-center table-hover">
                <tbody>
                    <tr class="table-active">
                        <td>Инициатор</td>
                        <td>Дата</td>
                        <td>Цена</td>
                        <td>Согласовал</td>
                        <td>Статус</td>
                    </tr>
                    <?php foreach ($historyOffers as $h) { ?>
                    <tr>
                        <td><?= HtmlFilter::encode($h['Initiator'] ?? '');?></td>
                        <td><?= !empty($h['Date']) ? date('d.m.Y', strtotime($h['Date'])) : '—';?></td>
                        <td><?= number_format((int)($h['Price'] ?? 0), 0, '.', ' ');?> ₽</td>
                        <td><?= HtmlFilter::encode($h['Signatory'] ?? '');?></td>
                        <td><?= HtmlFilter::encode($h['Status'] ?? '');?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
    </div>
</div>

<?php if (!empty($currentOffers) && is_array($currentOffers)) { ?>
    <?php foreach ($currentOffers as $k => $item) { ?>
    <div class="remodal" data-remodal-id="cabinet-offer-<?= $k;?>" >
        <button data-remodal-action="close" class="remodal-close"></button>
        <div class="row">
            <div class="col-12">
                <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/cabinet-offer.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/cabinet-offer.svg');?>" alt="" />
                <div class="remodal-title text-plus c-yablack fw-bold mt-4">Предлагаем ускорить продажу</div>
                <div class="remodal-description c-yadarkgray text-minus my-4">
                    Изменить цену автомобиля<br />
                    <?= HtmlFilter::encode(($data['brand']['name'] ?? '') . ' ' . ($data['model']['name'] ?? ''));?> <?= HtmlFilter::encode($data['general'][4]['value'] ?? '');?> г.в.,<br />
                    VIN <?= HtmlFilter::encode($vin);?><br />
                    с <?= number_format((int)($item['OldPrice'] ?? 0), 0, '.', ' ');?> ₽ на <?= number_format((int)($item['NewPrice'] ?? 0), 0, '.', ' ');?> ₽
                </div>
                <a 
                    href="#cabinet-offer-confirm" data-remodal-target="cabinet-offer-confirm"
                    class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button mb-3" 
                    rel="nofollow"
                    role="offerConfim"
                    data-vin="<?= HtmlFilter::encode($vin);?>"
                    data-doc="<?= HtmlFilter::encode($item['GUIDDoc'] ?? '');?>"
                    data-action="accept"
                ><noindex>Принять</noindex></a>
                <a 
                    href="#cabinet-offer-confirm" data-remodal-target="cabinet-offer-confirm"
                    class="c-yablack c-h-yablack bg-yawhite bg-h-yawhite b-yadarkgray text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button" 
                    rel="nofollow"
                    role="offerConfim"
                    data-vin="<?= HtmlFilter::encode($vin);?>"
                    data-doc="<?= HtmlFilter::encode($item['GUIDDoc'] ?? '');?>"
                    data-action="refuse"
                ><noindex>Отказать</noindex></a>
            </div>
        </div>
    </div>
    <?php } ?>

    <?php if (count($currentOffers) === 1) { ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof $ !== 'undefined' && $.fn.remodal) {
                var offer = $('[data-remodal-id="cabinet-offer-0"]').remodal();
                if (offer) {
                    offer.open();
                }
            }
        });
    </script>
    <?php } ?>
<?php } ?>
