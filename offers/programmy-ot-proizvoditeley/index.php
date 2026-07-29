<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Персональные выгоды на автомобиль при покупке по в дилерском центре «Юг-Авто Эксперт»");
$APPLICATION->SetTitle("Программы от производителей - Акции и программы - ООО «Юг-Авто Эксперт»");
?>
<div class="bg-yablue py-4">
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h1 fw-normal c-yawhite">Программы от производителей</h1></div>
		</div>
	</div>
</div>
<div class="container my-5">
    <div class="row programm-title" data="chery">
        <div class="col-2 col-md-1">
            <img src="chery.jpg" class="b-yalightgray b-radius-yaradius-15 w-100" />
        </div>
        <div class="col">
            <h4 class="fw-bold">CHERY - Pango Cars</h4>
            <p>Выбирая автомобиль по программе Pango Cars, вы получаете:</p>
        </div>
        <div class="col-1 d-flex justify-content-end align-items-center"><img src="corner.svg" class="corner" /></div>
    </div>
    <div class="row programm-content d-none" data="chery">
        <div class="col-1"></div>
        <div class="col">
            <ul>
                <li>Наилучшее предложение за собственный автомобиль;</li>
                <li>Гарантию честной сделки;</li>
                <li>Защиту при эксплуатации;</li>
                <li>Качество ремонта;</li>
                <li>Выше ценность при продаже.</li>
            </ul>
        </div>
        <div class="col-1"></div>
    </div>
    <hr />
    <div class="row programm-title" data="haval-city-trade-in">
        <div class="col-2 col-md-1">
            <img src="haval.png" class="b-yalightgray b-radius-yaradius-15 w-100" />
        </div>
        <div class="col">
            <h4 class="fw-bold">HAVAL CITY Trade-In</h4>
            <p>Выбирая автомобиль по программе HAVAL CITY Trade-In, вы получаете:</p>
        </div>
        <div class="col-1 d-flex justify-content-end align-items-center"><img src="corner.svg" class="corner" /></div>
    </div>
    <div class="row programm-content d-none" data="haval-city-trade-in">
        <div class="col-1"></div>
        <div class="col">
            <ul>
                <li>Выгоду на новый автомобиль HAVAL до 200 000 р;</li>
                <li>Прозрачную историю владения;</li>
                <li>Возможность обменять свой автомобиль;</li>
                <li>Выгодное предложение по кредиту и страхованию.</li>
            </ul>
        </div>
        <div class="col-1"></div>
    </div>
    <hr />
    <div class="row programm-title" data="haval-city-flat-discount-2">
        <div class="col-2 col-md-1">
            <img src="haval.png" class="b-yalightgray b-radius-yaradius-15 w-100" />
        </div>
        <div class="col">
            <h4 class="fw-bold">HAVAL CITY Flat Discount 2</h4>
            <p>Выбирая автомобиль по программе HAVAL CITY Flat Discount 2, вы получаете:</p>
        </div>
        <div class="col-1 d-flex justify-content-end align-items-center"><img src="corner.svg" class="corner" /></div>
    </div>
    <div class="row programm-content d-none" data="haval-city-flat-discount-2">
        <div class="col-1"></div>
        <div class="col">
            <ul>
                <li>Выгоду на новый HAVAL до 300 000 р;</li>
                <li>Полностью проверенный и готовый к эксплуатации автомобиль;</li>
                <li>Гарантию честной сделки.</li>
            </ul>
        </div>
        <div class="col-1"></div>
    </div>
</div>
<script>
    $(document).on('click', '.programm-title', function() {
        $(this).find('img.corner').toggleClass('rotate-180');
        $('.programm-content[data="'+$(this).attr('data')+'"]').toggleClass('d-none')
    });
</script>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>