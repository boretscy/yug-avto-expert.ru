<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Title");
if ( !$USER->IsAuthorized() ) LocalRedirect("/cabinet/login/");
?>

Text here....

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>