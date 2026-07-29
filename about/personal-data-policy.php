<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Политика обработки персональных данных - О компании -  Юг-Авто");
$APPLICATION->AddChainItem("Политика обработки персональных данных");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.include", 
	"include.text", 
	array(
		"AREA_FILE_SHOW" => "page",
		"AREA_FILE_SUFFIX" => "inc",
		"EDIT_TEMPLATE" => "",
		"COMPONENT_TEMPLATE" => "include.text"
	),
	false
);?>
<div class="container mt-3 mb-5">
	<div class="row">
		<div class="col">
			<h1 class="h1 mb-3 fw-normal"></h1>
		</div>
	</div>
</div>
 <br><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>