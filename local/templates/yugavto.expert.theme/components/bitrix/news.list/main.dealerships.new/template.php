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
<div class="container my-3">
    <div class="row mb-3 dealerships-on-main-title">
		<div class="col">
			<h2 class="fw-normal"><?= $arParams['DISPLAY_TITLE'];?></h2>
		</div>
	</div>
	<div class="row mb-3">
		<div class="col">
			<div class="tabs">
				<div class="tabs_head">
					<?php foreach ( $arResult['CITIES'] as $k => $item ) { ?>
					<a 
						href="#" 
						class="bg-yalightgray bg-h-yagray c-yablack c-h-yablack text-decoration-none text-minus-minus text-uppercase py-2 px-3 b-radius-yaradius-15 text-nowrap <?= (($k=='all')?'--is-active':'');?> fw-bold"
						role="toggleCity"
						data-city="<?= $k;?>"
						><?= $item;?></a>
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

<?php //$this->addExternalJS('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU'); ?>
<?php /* <script src="https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU" acync></script> */ ?>
<script>

function loadScript(src, callback) {
    var script = document.createElement('script');
    script.src = src;
    script.type = 'text/javascript';
    script.charset = 'utf-8';
    script.async = true;
    script.onload = () => callback(script);
    document.body.append(script);
}

loadScript('https://api-maps.yandex.ru/2.1/?apikey=34ddb940-0941-4b80-ab80-b0aa351b6560&lang=ru_RU', function() {
    
    var dealershipsMap;

    ymaps.ready(firstInit);

    function firstInit() {
        setTimeout(() => {
            dealershipsMapInit('all')
        }, 500);
    }

    function dealershipsMapInit( city = 'all' ) {

        if ( typeof dealershipsMap != 'undefined' ) dealershipsMap.destroy()

        dealershipsMap = new ymaps.Map('dealershipsMap', {
            center: EXPERT_MAP_DEALERSHIPS[city].CENTER,
            zoom: EXPERT_MAP_DEALERSHIPS[city].ZOOM
        }, {
            searchControlProvider: 'yandex#search'
        });

        dealershipsMap.behaviors.disable('scrollZoom');

        EXPERT_MAP_DEALERSHIPS[city].ITEMS.forEach((i) => {
            dealershipsMap.geoObjects.add(
                new ymaps.Placemark(
                    [
                        i.COORDS.LAT,
                        i.COORDS.LON
                    ],
                    {
                        balloonContent: i.NAME,
                        // iconCaption: i.NAME,
                        hintContent: i.NAME,
                        balloonContentHeader: i.NAME,
                        balloonContentBody: i.BALLOON.CONTENT,
                        balloonContentFooter: i.BALLOON.FOOTER,
                    },
                    {
                        preset: "islands#darkBlueDotIconWithCaption"
                    }
                )
            )
        });
    }
});


$(document).on('click', '[role="toggleCity"]', function() {
    $('[role="toggleCity"]').removeClass('--is-active')
    $(this).addClass('--is-active')
    dealershipsMapInit($(this).data('city'))

    return false;
})
</script>
<script data-skip-moving="true">
var EXPERT_MAP_DEALERSHIPS = <?= json_encode( $arResult['MAP'] );?>
</script>

<?php //YApp::sp( $arParams, true ); ?>