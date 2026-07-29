<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Обменивайте старый автомобиль на новый или поддержанный в Юг-Авто Эксперт. Мы предлагаем честную оценку и выгодные условия обмена по программе Трейд-ин Получите деньги или выберите новый автомобиль в тот же день");
$APPLICATION->SetTitle("Обмен автомобилей по программе Трейд-ин в Краснодаре");
?>
<div class="bg-yablue py-4">
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h1 fw-normal c-yawhite">Обмен автомобилей в Краснодаре — Трейд-ин</h1></div>
		</div>
	</div>
</div>
<div class="container mt-3 mb-5 c-yalightblack">
	<div class="row">
		<div class="col">
			<div class="bg-yalightgray px-5 py-4 b-radius-yaradius-25 my-5">
				Меняемся? Вы нам — мы Вам! Компания <strong>Юг-Авто Эксперт</strong> принимает любые транспортные средства вне зависимости от пробега, года производства и бренда, в счет покупки новых автомобилей. Широкий выбор: покупка нового автомобиля или автомобиля с пробегом, выгодные кредитные программы от банков-партнеров.
			</div>
			<h2 class="my-4 h3 px-5">Какие автомобили мы принимаем в обмен:</h2>
			<div class="px-5">
				<ul>
					<li class="MsoNormal"><span>с запретом на регистрационные действия;</span></li>
					<li class="MsoNormal"><span>с обременением;</span></li>
					<li class="MsoNormal"><span>лизинговые машины, находящиеся в залоге;</span></li>
					<li class="MsoNormal"><span>неисправные;</span></li>
					<li class="MsoNormal"><span>конфискованные, в том числе кредитные или после ДТП;</span></li>
					<li class="MsoNormal"><span>с возможностью заключения сделки в день обращения.</span></li>
				</ul>
			</div>
			<div class="bg-yalightgray px-5 py-4 b-radius-yaradius-25 my-5">
				<h2 class="my-4 h3">5 простых шагов обмена Вашего автомобиля:</h2>
				<ul>
					<li class="MsoNormal"><span>оценка вашего авто нашими сотрудниками;</span></li>
					<li class="MsoNormal"><span>выбор машины в нашем дилерском центре;</span></li>
					<li class="MsoNormal"><span>определение суммы доплаты, при необходимости оформление кредита;</span></li>
					<li class="MsoNormal"><span>оформление пакета документов;</span></li>
					<li class="MsoNormal"><span>расчет и передача автотранспортного средства новому владельцу.</span></li>
				</ul>
			</div>
			<h2 class="my-4 h3 px-5">Обменять ваш автомобиль на новый — легко! Оставьте заявку, а все остальное сделают наши специалисты.</h2>
		</div>
	</div>
</div>
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"form.block.new", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "form.block.new",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"WEB_FORM_ID" => "11",
		"COMPOSITE_FRAME_MODE" => "A",
		"COMPOSITE_FRAME_TYPE" => "AUTO",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>