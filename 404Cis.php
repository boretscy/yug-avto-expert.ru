<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Ошибка 404");

$brandCode = $filter['brand'] ?? $GLOBALS['CIS_FILTER']['brand'] ?? '';
$modelCode = $filter['model'] ?? $GLOBALS['CIS_FILTER']['model'] ?? '';

$brandName = '';
$modelName = '';

if (!empty($brandCode) && isset($app)) {
    $brandsUrl = $app->makeApiUrl([], 'brands');
    $brandsData = json_decode(file_get_contents($brandsUrl), true);
    if (!empty($brandsData['dropLists']['brands'])) {
        foreach ($brandsData['dropLists']['brands'] as $b) {
            if ($b['code'] === $brandCode) {
                $brandName = $b['name'];
                if (!empty($modelCode) && !empty($b['models'])) {
                    foreach ($b['models'] as $m) {
                        if ($m['code'] === $modelCode) {
                            $modelName = $m['name'];
                            break;
                        }
                    }
                }
                break;
            }
        }
    }
}

if (empty($brandName) && !empty($brandCode)) {
    $brandName = ucfirst($brandCode);
}
if (empty($modelName) && !empty($modelCode)) {
    $modelName = ucfirst($modelCode);
}
?>
<div class="container text-center">
    <div class="row my-5">
        <div class="col text-start"><img src="/404.png" alt="404" class="w-auto"></div>
    </div>
    <div class="row my-5">
        <div class="col"><div class="h2">К сожалению, запрашиваемый Вами автомобиль уже продан...</div></div>
    </div>
    <div class="row my-5">
        <div class="col text-center">
            <a href="/cars/used/" class="text-center text-uppercase c-yawhite c-h-yawhite text-decoration-none b-radius-yaradius-15 bg-yablue bg-h-yadarkblue py-2 px-4 d-inline-block me-3 mb-2"><span>Все автомобили</span></a>
            
            <?php if (!empty($brandCode)) { ?>
                <a href="/cars/used/<?= htmlspecialchars($brandCode); ?>/" class="text-center text-uppercase c-yawhite c-h-yawhite text-decoration-none b-radius-yaradius-15 bg-yablue bg-h-yadarkblue py-2 px-4 d-inline-block me-3 mb-2"><span><?= htmlspecialchars($brandName); ?></span></a>
            <?php } ?>
            
            <?php if (!empty($brandCode) && !empty($modelCode)) { ?>
                <a href="/cars/used/<?= htmlspecialchars($brandCode); ?>/<?= htmlspecialchars($modelCode); ?>/" class="text-center text-uppercase c-yawhite c-h-yawhite text-decoration-none b-radius-yaradius-15 bg-yablue bg-h-yadarkblue py-2 px-4 d-inline-block me-3 mb-2"><span><?= htmlspecialchars($brandName . ' ' . $modelName); ?></span></a>
            <?php } ?>

            <a href="/" class="text-center text-uppercase c-yalightblack c-h-yalightblack text-decoration-none b-radius-yaradius-15 bg-yayellow bg-h-yadarkyellow py-2 px-4 d-inline-block mb-2"><span>На главную</span></a>
        </div>
    </div>
</div>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>