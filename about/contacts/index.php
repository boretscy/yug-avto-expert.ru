<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Контактная информация компании ЮГ-Авто");
$APPLICATION->SetTitle("Контакты компании ЮГ-Авто");
?>

    <div class="container my-5">
        <div class="row">
            <div class="col">
                <div class="h1 fw-normal">Контактная информация</div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-12 col-md-12">
                <p>Возникли вопросы?</p>
                <p> Мы будем рады ответить.</p>
                <p>пос. Яблоновский, г. Краснодар, г. Новороссийск, г. Майкоп</p>
                <p>Тел.:<a href="tel:<?= YApp::phoneIn($itemHl['UF_VALUE']);?>" class="text-decoration-none"> <?= YApp::phoneOut($itemHl['UF_VALUE']);?></a></p>
                <p></p>E-mail:<a href="mailto:callcenter@yug-avto.ru" class="text-decoration-none"> callcenter@yug-avto.ru</a></p>
            </div>
            <div class="col-12">
                <iframe src="https://yandex.ru/map-widget/v1/?um=constructor%3Ada830c5c4d478b3b006ead816f50d3f049ff604e259c62487ea052e9a4dfecdd&amp;source=constructor" width="100%" height="450" frameborder="0"></iframe>
            </div>
        </div>
    </div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>