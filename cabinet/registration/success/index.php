<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Успешно");
?>

<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
            <div class="col">
                <div class="p-5 bg-yawhite b-radius-yaradius-25 text-center">
                    <img src="../../images/user-profile-circle.svg" />
                    <div class="mt-3 cabinet-sign-title">Регистрация в личном кабинете</div>
                    <div class="mt-3 cabinet-sign-description c-yablack fw-bold">Спасибо!<br />Заявка на регистрацию отправлена.</div>
                    <div class="mt-3 cabinet-sign-description c-yadarkgray mb-4">Ваш временный пароль отправлен в смс. Наш менеджер свяжется с Вами в ближайшее время.</div>
                    <a 
						href="/cabinet/" 
						class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button" 
						role="sendForm"
						rel=“nofollow”
						><noindex>На главную</noindex></a>
                </div>
            </div>
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
        </div>
    </div>
</div>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>