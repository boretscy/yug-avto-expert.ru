<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вход в личный кабинет");

$cab::unAUth();
header('Location: /cabinet/login/');
?>


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>