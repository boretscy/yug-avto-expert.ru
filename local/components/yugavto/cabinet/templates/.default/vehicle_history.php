<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Text\HtmlFilter;

$data = $arResult["CIS_DATA"] ?? [];
$vin = $data['vin'] ?? '';
$hA = $arResult["FILTERED_HISTORY_APPEALS"] ?? [];
$historyPrice = $arResult["HISTORY_PRICE"] ?? [];

$chartDomId = 'chart-' . md5($vin);
$chartVarId = 'chart_' . md5($vin);
?>

<div class="py-3 bg-yablue c-yawhite vehicle-title">
    <div class="container">
        <div class="row">
            <div class="col-xl-8">
                <h1 class="h3 fw-bold mt-3">
                    <?= HtmlFilter::encode(($data['brand']['name'] ?? '') . ' ' . ($data['model']['name'] ?? ''));?> - История автомобиля
                </h1>
            </div>
        </div>
    </div>
</div>

<div class="container my-4 vehicle">
    <div class="row mb-5">
        <div class="col-6"><h5>Динамика интереса за 14 дней:</h5></div>
        <div class="col-12">
            <div id="<?= $chartDomId; ?>" style="width: 100%; height: 260px;"></div>
            <div class="text-minus-minus text-center mt-2">
				<ul class="list-inline mb-0">
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
            <?php if (!empty($historyPrice) && is_array($historyPrice)) { ?>
            <table class="table table-hover table-striped text-center">
                <tbody>
                    <tr class="table-active">
                        <td>Дата</td>
                        <td>Новая цена</td>
                    </tr>
					<?php foreach ($historyPrice as $h) { ?>
                    <tr>
                        <td><?= !empty($h['Date']) ? date('d.m.Y', strtotime($h['Date'])) : '—';?></td>
                        <td><?= number_format((int)($h['Price'] ?? 0), 0, '.', ' ');?> ₽</td>
                    </tr>
					<?php } ?>
                </tbody>
            </table>
            <?php } else { ?>
            <div class="p-3 b-yalightgray b-radius-yaradius-15 text-center text-muted">
                Данные по изменению цены пока отсутствуют.
            </div>
            <?php } ?>
        </div>
    </div>
</div>

<?php
$chartLabels = [];
$chartCalls = [];
$chartVisits = [];
$chartInternets = [];
foreach ($hA as $h) {
    $chartLabels[] = !empty($h['Date']) ? date('d.m', strtotime($h['Date'])) : '';
    $chartCalls[] = (int)($h['Call'] ?? 0);
    $chartVisits[] = (int)($h['Visit'] ?? 0);
    $chartInternets[] = (int)($h['Internet'] ?? 0);
}
?>

<script>
(function() {
    var labels = <?= json_encode($chartLabels) ?>;
    var calls = <?= json_encode($chartCalls) ?>;
    var visits = <?= json_encode($chartVisits) ?>;
    var internets = <?= json_encode($chartInternets) ?>;
    var domSelector = '#<?= $chartDomId ?>';

    document.addEventListener('DOMContentLoaded', function() {
        if (typeof Chartist !== 'undefined' && document.querySelector(domSelector)) {
            new Chartist.Line(domSelector, {
                labels: labels,
                series: [calls, visits, internets]
            }, {
                fullWidth: true,
                chartPadding: {
                    right: 40
                }
            });
        }
    });
})();
</script>
