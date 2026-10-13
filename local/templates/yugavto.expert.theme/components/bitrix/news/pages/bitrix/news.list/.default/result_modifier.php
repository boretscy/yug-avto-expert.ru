<?php
foreach ( $arResult['ITEMS'] as $item ) $tmp[] = $item['IBLOCK_SECTION_ID'];
$arSections = array_unique($tmp);

if ( count($arSections) > 1) {

	$rs = CIBlockSection::GetList(
		['NAME'=>'ASC'],
		[
			'IBLOCK_ID' => YApp::IBLOCK_PAGES,
			'ACTIVE' => 'Y'
		],
		false,
		['ID', 'IBLOCK_ID', 'NAME', 'CODE', 'UF_*'],
		false
	);
	while ( $ob = $rs->GetNext() ) {

		$ob['LOGO'] = CIBlockElement::GetByID($ob['UF_PAGES_BRAND'])->GetNext()['PREVIEW_PICTURE'];
		$arResult['SECTIONS'][] = $ob;
	}

} else {

    $rs = CIBlockSection::GetList(
		['NAME'=>'ASC'],
		[
			'IBLOCK_ID' => YApp::IBLOCK_PAGES,
			'ID' => $arSections[0]
		],
		false,
		['ID', 'IBLOCK_ID', 'NAME', 'DESCRIPTION', 'CODE', 'UF_*'],
		false
	);
	while ( $ob = $rs->GetNext() ) {

		$ob['LOGO'] = CIBlockElement::GetByID($ob['UF_PAGES_BRAND'])->GetNext()['PREVIEW_PICTURE'];
		$arResult['SECTION'] = $ob;
	}

    foreach ( $arResult['ITEMS'] as $i ) $arModels[] = $i['PROPERTIES']['EXTERNAL_CODE']['VALUE'];

    $apiToken = '34b5ac8b71018c0bc7e5c050ed90b243';
    $apiBase = 'https://' . (class_exists('YApp') ? YApp::API_DOMAIN : 'apps.yug-avto.ru') . '/API/get/cis';
    $brandCode = urlencode((string)$arResult['SECTION']['CODE']);

    $arResult['VEHICLES'] = YApp::safeJsonGet(
        $apiBase . '/modelscount/new/?token=' . $apiToken . '&model=' . implode(',', $arModels),
        []
    );

	$arResult['USED'] = YApp::safeJsonGet(
        $apiBase . '/limit/used/?token=' . $apiToken . '&brand=' . $brandCode . '&limit=12',
        []
    );
	$arResult['NEW_COUNT'] = YApp::safeJsonGet(
        $apiBase . '/count/new/?token=' . $apiToken . '&brand=' . $brandCode,
        []
    );
	$arResult['USED_COUNT'] = YApp::safeJsonGet(
        $apiBase . '/count/used/?token=' . $apiToken . '&brand=' . $brandCode,
        []
    );

	$arDealerships = YApp::safeJsonGet(
        $apiBase . '/dealerships/new/?token=' . $apiToken . '&brand=' . $brandCode,
        []
    );
	// YApp::sp( $arDealerships );
	foreach ( $arDealerships as $item ) $dealership_ext_ids[] = $item['id'];

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
}
?>