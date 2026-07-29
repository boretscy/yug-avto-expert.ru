<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

LocalRedirect ("/404.php"); 
/*
$APPLICATION->SetTitle("Согласие на обработку персональных данных");
$APPLICATION->AddChainItem("Согласие на обработку персональных данных");
?>
<div class="container mt-3 my-5">
	<div class="row">
		<div class="col">

			</div>
		</div>
	</div>
</div>
 <?$APPLICATION->IncludeComponent("bitrix:main.include", "include.text", Array(
	"AREA_FILE_SHOW" => "page",	// Показывать включаемую область
		"AREA_FILE_SUFFIX" => "inc",	// Суффикс имени файла включаемой области
		"EDIT_TEMPLATE" => "",	// Шаблон области по умолчанию
	),
	false
 );?><br>
 */
 require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");

?>