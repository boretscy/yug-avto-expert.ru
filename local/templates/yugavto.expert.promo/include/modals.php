<?php
use Bitrix\Main\Loader;
Loader::includeModule('form');

$rs = CIBlockElement::GetList(
    ['CODE'=>'FORM_BUYOUT_BUYOUT'],
    ['IBLOCK_ID'=>YApp::IBLOCK_FORM_SETTINGS, 'ACTIVE'=>'Y'],
    false, false,
    ['CODE']
);
while ( $ob = $rs->GetNextElement() ) $arForms[] = CForm::GetBySID($ob->GetFields()['CODE'])->Fetch()['ID'];

foreach ( $arForms as $item ) {

    $APPLICATION->IncludeComponent(
        "bitrix:form.result.new", 
        "form.modal", 
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
            "WEB_FORM_ID" => $item,
            "COMPONENT_TEMPLATE" => "form.modal",
            "VARIABLE_ALIASES" => array(
                "WEB_FORM_ID" => "WEB_FORM_ID",
                "RESULT_ID" => "RESULT_ID",
            )
        ),
        false
    );
}

?>