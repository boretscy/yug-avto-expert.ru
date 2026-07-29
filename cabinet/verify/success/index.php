<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Успешно");
?>
<?php
if ( !!$user['PROPERTY_CHANGE_PASSWD_VALUE'] ) header('Location: /cabinet/me/#cabinet-me-passwd');
?>

<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
            <div class="col">
                <div class="p-5 bg-yawhite b-radius-yaradius-25 text-center">
                    <img src="../../images/user-success.svg" />
                    <div class="mt-3 cabinet-sign-title">Учетная запись активирована!</div>
                    <div class="mt-3 cabinet-sign-description c-yablack fw-bold mb-4">Необходимо пройти верификацию</div>
                    <a 
						href="/cabinet/" 
						class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button mb-3" 
						role="sendForm"
						rel=“nofollow”
						><noindex>Верификация</noindex></a>
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