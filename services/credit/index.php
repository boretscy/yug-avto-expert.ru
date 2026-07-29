<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetPageProperty("description", "Оформите автокредит на выгодных условиях. Юг-Авто Эксперт предлагает различные программы кредитования с минимальными процентными ставками и быстрым одобрением");
$APPLICATION->SetTitle("Автокредит в Юг-Авто Эксперт");
?> 
<div class="bg-yablue py-4">
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h1 fw-normal c-yawhite">Кредит</h1></div>
		</div>
	</div>
</div>
<div class="container mt-3 mb-5 c-yalightblack">
	<div class="row">
		<div class="col">
			<div class="bg-yalightgray px-5 py-4 b-radius-yaradius-25 my-5">
				Ваша мечта ближе, чем кажется! Когда автомобиль это уже не роскошь, а средство передвижения, но нет всей необходимой суммы на его покупку — автокредит единственный вариант решения.
			</div>
			<h2 class="h3 px-5">В автоцентрах <strong>Юг-Авто Эксперт</strong> Вы можете приобрести автомобиль с пробегом в кредит!</h2>
			<p class="px-5">Широкий выбор банков партнеров позволит выбрать наиболее подходящие условия кредитования. Минимальный первоначальный взнос, комфортный ежемесячный платеж или же рассрочка на покупку — специалисты нашего кредитного отдела разбираясь во всех тонкостях программ кредитования подберут наиболее выгодную для вас!</p>
			<div class="bg-yalightgray px-5 py-4 b-radius-yaradius-25 my-5">
				<h2 class="h3">Почему покупать автомобиль с пробегом в кредит в <strong>Юг-Авто Эксперт</strong> надежно, удобно и выгодно?</h2>
				<ul class="fst-italic c-yadarkgray">
					<li>льготные программы кредитования с комфортным ежемесячным платежом;</li>
					<li>автокредит от 0% первоначального взноса;</li>
					<li>дополнительные выгоды при покупке автомобиля в кредит;</li>
					<li>срок кредитования от 1 до 8 лет;</li>
					<li>минимальный пакет документов при оформлении кредита (паспорт и 2 документ) без предоставления справки о доходах;</li>
					<li>досрочное погашение кредита без лишних комиссий;</li>
					<li>включение сервисных услуг и автоКАСКО в сумму кредитования;</li>
					<li>при рассмотрении заявки учитывается совокупный доход семьи;</li>
					<li>возможность допуска третьих лиц, кроме заемщика, к управлению автомобилем;</li>
					<li>высокий процент одобрения кредитов через специалистов кредитного отдела Юг-Авто Эксперт.</li>
				</ul>
			</div>
			<h2 class="h4">Ещё сомневаетесь? Оставьте заявку, и наши специалисты помогут подобрать выгодный для вас вариант автокредита.</h2>
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
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"WEB_FORM_ID" => "5",
		"COMPONENT_TEMPLATE" => "form.block.new",
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