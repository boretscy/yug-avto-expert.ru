<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("Ошибка 404");
// if ( CSite::InDir('/cars/') ) $vehicles = json_decode(file_get_contents('https://apps.yug-avto.ru/API/get/cis/random/'.(($GLOBALS['SHOWROOM_MODE'])?:'new').'/?token=34b5ac8b71018c0bc7e5c050ed90b243'), true);
?>
<div class="container text-center">
    <div class="row my-5">
        <div class="col text-start"><img src="/404.png" alt="404" class="w-auto"></div>
    </div>
    <div class="row my-5">
        <div class="col"><div class="h2">К сожалению, запрашиваемая Вами страница не найдена...</div></div>
    </div>
    <div class="row my-5">
        <div class="col text-center">
            <a href="/" class="text-center text-uppercase c-yalightblack c-h-yalightblack text-decoration-none b-radius-yaradius-15 bg-yayellow py-2 px-4 d-inline-block me-3"><span>На главную</span></a>
        </div>
    </div>
</div>
<?php if ( CSite::InDir('/cars/') ) { ?>

<?php } ?>
<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>