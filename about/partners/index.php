<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Информация для партнеров компании Юг-Авто");
$APPLICATION->SetTitle("Партнерам - Юг-Авто");
?>

    <div class="container my-5">
        <div class="row mb-3">
            <div class="col"><h1 class="fw-normal">Карьера</h1></div>
        </div>
        <div class="row">
            <div class="col-md-6">
             <blockquote class="blockquote text-plus-plus c-blackgray">
                Принцип нашей компании: «Профессиональный подход во всем». Мы всегда открыты к партнерским отношениям для взаимовыгодного развития бизнеса.
            </blockquote>
            <p>Если по специфике вашей работы наши компании могут стать надежными партнерами, предлагаем Вам заполнить форму обратной связи.</p>
                <div class="row my-3">
                    <div class="col col-md-4">
                        <a href="#FORM_PARTNERS" class="d-block text-center c-yawhite c-h-yawhite bg-yablue bg-h-yadarkblue text-decoration-none b-radius-small but d-flex align-items-center justify-content-center">Оставить заявку</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <?php $pageTitle = YApp::getCleanAltText($APPLICATION->GetTitle(false)); ?>
                <img src="/upload/img/partners-1.jpg" alt="<?= htmlspecialchars($pageTitle);?>" title="<?= htmlspecialchars($pageTitle);?>" class="w-100 b-radius-small" />
            </div>
        </div>
    </div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>