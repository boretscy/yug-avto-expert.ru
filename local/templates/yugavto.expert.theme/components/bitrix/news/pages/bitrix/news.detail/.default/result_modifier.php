<?php
    $apiToken = '34b5ac8b71018c0bc7e5c050ed90b243';
    $apiBase = 'https://' . (class_exists('YApp') ? YApp::API_DOMAIN : 'apps.yug-avto.ru') . '/API/get/cis';
    $modelCode = urlencode((string)$arResult['CODE']);

    $arResult['NEW_COUNT'] = YApp::safeJsonGet($apiBase . '/count/new/?token=' . $apiToken . '&model=' . $modelCode, []);
    $arResult['USED_COUNT'] = YApp::safeJsonGet($apiBase . '/count/used/?token=' . $apiToken . '&model=' . $modelCode, []);

    $arDealerships = YApp::safeJsonGet($apiBase . '/dealerships/new/?token=' . $apiToken . '&model=' . $modelCode, []);
	// YApp::sp( $arDealerships );
	if ( $arDealerships && is_array($arDealerships) ) foreach ( $arDealerships as $item ) $dealership_ext_ids[] = $item['id'];

	$rs = CIBlockElement::GetList(
		['NAME'=>'ASC'],
		[
			'IBLOCK_ID' => YApp::IBLOCK_DEALERSHIPS,
			'PROPERTY_EXTERNAL_CODE' => $dealership_ext_ids,
			'ACTIVE' => 'Y'
		],
		false, false,
		['ID', 'NAME', 'CODE', 'DETAIL_PAGE_URL', 'PREVIEW_PICTURE', 'PROPERTY_ADDRESS', 'PROPERTY_PHONE', 'PROPERTY_COORDS_LAT', 'PROPERTY_COORDS_LON', 'PROPERTY_EXTERNAL_CODE' ]
	);
	while ( $ob = $rs->GetNextElement() ) $arResult['DEALERSHIPS'][] = $ob->GetFields();

    $arResult['NEW'] = YApp::safeJsonGet($apiBase . '/limit/new/?token=' . $apiToken . '&model=' . $modelCode . '&limit=12', []);
    $arResult['USED'] = YApp::safeJsonGet($apiBase . '/limit/used/?token=' . $apiToken . '&model=' . $modelCode . '&limit=12', []);
?>