<?php
/**
 * Скрипт создания группы Комитенты, UF-полей и миграции учетных записей из ИБ 20 в b_user.
 */
$_SERVER["DOCUMENT_ROOT"] = "/var/www/admin/data/www/etest.yug-avto.ru";
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

CModule::IncludeModule("iblock");
CModule::IncludeModule("main");

echo "=== Запуск миграции пользователей кабинета ===" . PHP_EOL;

// 1. Создание или получение группы 'CABINET_USERS'
$groupStringId = 'CABINET_USERS';
$groupName = 'Комитенты личного кабинета';
$cabinetGroupId = null;

$resGroup = CGroup::GetList($by = "c_sort", $order = "asc", ["STRING_ID" => $groupStringId]);
if ($grp = $resGroup->Fetch()) {
    $cabinetGroupId = (int)$grp['ID'];
    echo "[OK] Группа уже существует: ID {$cabinetGroupId} ({$groupStringId})" . PHP_EOL;
} else {
    $group = new CGroup;
    $arFields = [
        "ACTIVE"       => "Y",
        "C_SORT"       => 150,
        "NAME"         => $groupName,
        "DESCRIPTION"  => "Пользователи личного кабинета комитента yug-avto-expert.ru",
        "STRING_ID"    => $groupStringId
    ];
    $cabinetGroupId = $group->Add($arFields);
    if ($cabinetGroupId) {
        echo "[CREATED] Создана группа: ID {$cabinetGroupId} ({$groupStringId})" . PHP_EOL;
    } else {
        echo "[ERROR] Ошибка создания группы: " . $group->LAST_ERROR . PHP_EOL;
        exit(1);
    }
}

// 2. Создание пользовательских полей (UF)
$userType = new CUserTypeEntity;
$ufFields = [
    [
        'ENTITY_ID'         => 'USER',
        'FIELD_NAME'        => 'UF_CAB_GUID',
        'USER_TYPE_ID'      => 'string',
        'XML_ID'            => 'UF_CAB_GUID',
        'SORT'              => 100,
        'MULTIPLE'          => 'N',
        'MANDATORY'         => 'N',
        'SHOW_FILTER'       => 'E',
        'SHOW_IN_LIST'      => 'Y',
        'EDIT_IN_LIST'      => 'Y',
        'IS_SEARCHABLE'     => 'Y',
        'SETTINGS'          => ['SIZE' => 64, 'ROWS' => 1, 'REGEXP' => '', 'MIN_LENGTH' => 0, 'MAX_LENGTH' => 64, 'DEFAULT_VALUE' => ''],
        'EDIT_FORM_LABEL'   => ['ru' => 'GUID комитента в 1С', 'en' => '1C Comitent GUID'],
        'LIST_COLUMN_LABEL' => ['ru' => 'GUID 1C', 'en' => '1C GUID'],
        'LIST_FILTER_LABEL' => ['ru' => 'GUID 1C', 'en' => '1C GUID'],
    ],
    [
        'ENTITY_ID'         => 'USER',
        'FIELD_NAME'        => 'UF_CAB_CODE',
        'USER_TYPE_ID'      => 'string',
        'XML_ID'            => 'UF_CAB_CODE',
        'SORT'              => 110,
        'MULTIPLE'          => 'N',
        'MANDATORY'         => 'N',
        'SHOW_FILTER'       => 'N',
        'SHOW_IN_LIST'      => 'N',
        'EDIT_IN_LIST'      => 'Y',
        'IS_SEARCHABLE'     => 'N',
        'SETTINGS'          => ['SIZE' => 10, 'ROWS' => 1, 'REGEXP' => '', 'MIN_LENGTH' => 0, 'MAX_LENGTH' => 10, 'DEFAULT_VALUE' => ''],
        'EDIT_FORM_LABEL'   => ['ru' => 'Код подтверждения СМС', 'en' => 'SMS verification code'],
        'LIST_COLUMN_LABEL' => ['ru' => 'Код СМС', 'en' => 'SMS code'],
        'LIST_FILTER_LABEL' => ['ru' => 'Код СМС', 'en' => 'SMS code'],
    ],
    [
        'ENTITY_ID'         => 'USER',
        'FIELD_NAME'        => 'UF_CAB_CODE_TIMEOUT',
        'USER_TYPE_ID'      => 'integer',
        'XML_ID'            => 'UF_CAB_CODE_TIMEOUT',
        'SORT'              => 120,
        'MULTIPLE'          => 'N',
        'MANDATORY'         => 'N',
        'SHOW_FILTER'       => 'N',
        'SHOW_IN_LIST'      => 'N',
        'EDIT_IN_LIST'      => 'Y',
        'IS_SEARCHABLE'     => 'N',
        'SETTINGS'          => ['SIZE' => 20, 'MIN_VALUE' => 0, 'MAX_VALUE' => 0, 'DEFAULT_VALUE' => 0],
        'EDIT_FORM_LABEL'   => ['ru' => 'Таймаут кода СМС', 'en' => 'SMS code timeout'],
        'LIST_COLUMN_LABEL' => ['ru' => 'Таймаут СМС', 'en' => 'SMS timeout'],
        'LIST_FILTER_LABEL' => ['ru' => 'Таймаут СМС', 'en' => 'SMS timeout'],
    ],
    [
        'ENTITY_ID'         => 'USER',
        'FIELD_NAME'        => 'UF_CAB_CHANGE_PASSWD',
        'USER_TYPE_ID'      => 'boolean',
        'XML_ID'            => 'UF_CAB_CHANGE_PASSWD',
        'SORT'              => 130,
        'MULTIPLE'          => 'N',
        'MANDATORY'         => 'N',
        'SHOW_FILTER'       => 'N',
        'SHOW_IN_LIST'      => 'Y',
        'EDIT_IN_LIST'      => 'Y',
        'IS_SEARCHABLE'     => 'N',
        'SETTINGS'          => ['DEFAULT_VALUE' => 0, 'DISPLAY' => 'CHECKBOX'],
        'EDIT_FORM_LABEL'   => ['ru' => 'Требуется смена пароля', 'en' => 'Change password required'],
        'LIST_COLUMN_LABEL' => ['ru' => 'Смена пароля', 'en' => 'Change pass'],
        'LIST_FILTER_LABEL' => ['ru' => 'Смена пароля', 'en' => 'Change pass'],
    ],
];

foreach ($ufFields as $field) {
    $existing = CUserTypeEntity::GetList([], ['ENTITY_ID' => 'USER', 'FIELD_NAME' => $field['FIELD_NAME']])->Fetch();
    if ($existing) {
        echo "[OK] UF-поле {$field['FIELD_NAME']} уже существует" . PHP_EOL;
    } else {
        $fieldId = $userType->Add($field);
        if ($fieldId) {
            echo "[CREATED] Создано UF-поле {$field['FIELD_NAME']} (ID: {$fieldId})" . PHP_EOL;
        } else {
            echo "[ERROR] Ошибка создания UF-поля {$field['FIELD_NAME']}" . PHP_EOL;
        }
    }
}

// 3. Миграция записей из ИБ 20 в b_user
$rs = CIBlockElement::GetList(
    [],
    ['IBLOCK_ID' => 20],
    false, false,
    ['ID', 'NAME', 'PROPERTY_GUID', 'PROPERTY_CODE', 'PROPERTY_CODE_TIMEOUT', 'PROPERTY_CHANGE_PASSWD', 'PROPERTY_PASSWD']
);

$migratedCount = 0;
$userObj = new CUser;

while ($el = $rs->Fetch()) {
    $phone = trim($el['NAME']);
    $guid = $el['PROPERTY_GUID_VALUE'];
    $code = $el['PROPERTY_CODE_VALUE'];
    $timeout = (int)$el['PROPERTY_CODE_TIMEOUT_VALUE'];
    $changePasswd = (int)$el['PROPERTY_CHANGE_PASSWD_VALUE'];

    if (empty($phone)) {
        continue;
    }

    echo "--- Обработка записи ИБ {$el['ID']} (Телефон: {$phone}, GUID: {$guid}) ---" . PHP_EOL;

    // Поиск пользователя в b_user по логину (телефону)
    $existingUser = CUser::GetByLogin($phone)->Fetch();
    
    $arUserFields = [
        "UF_CAB_GUID"          => $guid,
        "UF_CAB_CODE"          => $code,
        "UF_CAB_CODE_TIMEOUT"  => $timeout,
        "UF_CAB_CHANGE_PASSWD" => $changePasswd,
    ];

    if ($existingUser) {
        $userId = (int)$existingUser['ID'];
        // Добавляем группу 'Комитенты' к существующим группам
        $userGroups = CUser::GetUserGroup($userId);
        if (!in_array($cabinetGroupId, $userGroups)) {
            $userGroups[] = $cabinetGroupId;
        }
        $arUserFields["GROUP_ID"] = $userGroups;

        $userObj->Update($userId, $arUserFields);
        echo "[UPDATED] Пользователь b_user ID {$userId} обновлен" . PHP_EOL;
    } else {
        $randomPass = 'Cab_' . bin2hex(random_bytes(6)) . '!9';
        $arUserFields["LOGIN"] = $phone;
        $arUserFields["NAME"] = $phone;
        $arUserFields["EMAIL"] = $phone . "@yug-avto-expert.ru";
        $arUserFields["PASSWORD"] = $randomPass;
        $arUserFields["CONFIRM_PASSWORD"] = $randomPass;
        $arUserFields["ACTIVE"] = "Y";
        $arUserFields["GROUP_ID"] = [2, $cabinetGroupId];
        $arUserFields["PERSONAL_PHONE"] = $phone;

        $newUserId = $userObj->Add($arUserFields);
        if ($newUserId) {
            echo "[CREATED] Создан пользователь b_user ID {$newUserId}" . PHP_EOL;
        } else {
            echo "[ERROR] Ошибка создания b_user для {$phone}: " . $userObj->LAST_ERROR . PHP_EOL;
        }
    }
    $migratedCount++;
}

echo "=== Миграция завершена. Обработано записей: {$migratedCount} ===" . PHP_EOL;
