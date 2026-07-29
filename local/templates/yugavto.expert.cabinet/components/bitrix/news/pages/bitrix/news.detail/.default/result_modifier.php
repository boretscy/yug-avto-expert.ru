<?php
    $arResult['NEW_COUNT'] = json_decode(
        file_get_contents('https://apps.yug-avto.ru/API/get/cis/count/new/?token=34b5ac8b71018c0bc7e5c050ed90b243&model='.$arResult['CODE']),
        true
    );
    $arResult['USED_COUNT'] = json_decode(
        file_get_contents('https://apps.yug-avto.ru/API/get/cis/count/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&model='.$arResult['CODE']),
        true
    );

    $arDealerships = json_decode(
        file_get_contents('https://apps.yug-avto.ru/API/get/cis/dealerships/new/?token=34b5ac8b71018c0bc7e5c050ed90b243&model='.$arResult['CODE']),
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

    $arResult['NEW'] = json_decode(
        file_get_contents('https://apps.yug-avto.ru/API/get/cis/limit/new/?token=34b5ac8b71018c0bc7e5c050ed90b243&model='.$arResult['CODE'].'&limit=12'),
        true
    );

    $arResult['USED'] = json_decode(
        file_get_contents('https://apps.yug-avto.ru/API/get/cis/limit/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&model='.$arResult['CODE'].'&limit=12'),
        true
    );
?>