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

    $arResult['VEHICLES'] = json_decode(
        file_get_contents('https://apps.yug-avto.ru/API/get/cis/modelscount/new/?token=34b5ac8b71018c0bc7e5c050ed90b243&model='.implode(',',$arModels)),
        true
    );

	$arResult['USED'] = json_decode(
        file_get_contents('https://apps.yug-avto.ru/API/get/cis/limit/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&brand='.$arResult['SECTION']['CODE'].'&limit=12'),
        true
    );
	$arResult['NEW_COUNT'] = json_decode(
        file_get_contents('https://apps.yug-avto.ru/API/get/cis/count/new/?token=34b5ac8b71018c0bc7e5c050ed90b243&brand='.$arResult['SECTION']['CODE']),
        true
    );
	$arResult['USED_COUNT'] = json_decode(
        file_get_contents('https://apps.yug-avto.ru/API/get/cis/count/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&brand='.$arResult['SECTION']['CODE']),
        true
    );

	$arDealerships = json_decode(
        file_get_contents('https://apps.yug-avto.ru/API/get/cis/dealerships/new/?token=34b5ac8b71018c0bc7e5c050ed90b243&brand='.$arResult['SECTION']['CODE']),
        true
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