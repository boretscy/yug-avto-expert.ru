<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if ( !$cab::checkauth() ) header('Location: /cabinet/login/');
$APPLICATION->SetTitle("Верификация");
?>

<?php if ( $GLOBALS['CABINET_USER']['INFO']['Status'] ) { ?>
<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
            <div class="col">
                <div class="p-5 bg-yawhite b-radius-yaradius-25 text-center">
                    <img src="../images/user-success.svg" />
                    <div class="mt-3 cabinet-sign-title">Статус верификации<br />учетной записи:</div>
                    <div class="mt-3 cabinet-sign-title c-yadarkgreen text-uppercase">Верифицирована</div>
                    <div class="mt-3 cabinet-sign-description c-yablack mb-4">Поздравляем!<br />Ваша учетная запись верифицирована. Вы можете пользоваться всеми функциями личного кабинета</div>
                    <a 
						href="/cabinet/" 
						class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button" 
						rel=“nofollow”
						><noindex>На главную</noindex></a>
                </div>
            </div>
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
        </div>
    </div>
</div>
<?php } else { ?>
<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
            <div class="col">
                <div class="p-5 bg-yawhite b-radius-yaradius-25 text-center">
                    <img src="../images/user-attention.svg" />
                    <div class="mt-3 cabinet-sign-title">Статус верификации<br />учетной записи:</div>
                    <div class="mt-3 cabinet-sign-title c-yared text-uppercase">Не верифицирована</div>
                    <div class="mt-3 cabinet-sign-description c-yablack mb-4">Для верификации Вашей учетной записи обратитесь к сотруднику-кассиру ООО “Юг-Авто Эксперт”</div>
                </div>
            </div>
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
        </div>
    </div>
</div>
<?php } ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>