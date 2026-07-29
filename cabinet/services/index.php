<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Личный кабинет - Услуги");
// if ( !$USER->IsAuthorized() ) LocalRedirect("/cabinet/login/");
?>
<?php
	if ( !!$user['PROPERTY_CHANGE_PASSWD_VALUE'] ) header('Location: /cabinet/me/#cabinet-me-passwd');
?>
<div class="bg-yablue py-4">
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h1 fw-normal c-yawhite">Услуги</h1></div>
		</div>
	</div>
</div>
<div class="container my-5">
    <div class="row">
        <div class="col-md-4 mb-3 mb-md-0">
            <a href="/cars/used/" class="b-yagray b-radius-yaradius-25 py-5 px-4 d-block text-decoration-none">
                <img src="/cabinet/images/service-select-car.svg" style="height:74px; width:auto;" />
                <div class="title c-yalightblack c-h-yalightblack h4 mt-5">Подбор авто</div>
            </a>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <a href="/services/commission/" class="b-yagray b-radius-yaradius-25 py-5 px-4 d-block text-decoration-none">
                <img src="/cabinet/images/service-sell-car.svg" style="height:74px; width:auto;" />
                <div class="title c-yalightblack c-h-yalightblack h4 mt-5">Оценить авто</div>
            </a>
        </div>
        <div class="col-md-4">
            <a href="#FORM_CALLBACK" data-form="FORM_CALLBACK" class="b-yagray b-radius-yaradius-25 py-5 px-4 d-block text-decoration-none">
                <img src="/cabinet/images/service-phone.svg" style="height:74px; width:auto;" />
                <div class="title c-yalightblack c-h-yalightblack h4 mt-5">Запросить звонок менеджера</div>
            </a>
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
		"WEB_FORM_ID" => "15",
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