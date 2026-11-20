<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Text\HtmlFilter;

$user = $arResult["USER"] ?? [];
$userGuid = $arResult["USER_GUID"] ?? '';
$userPhone = $arResult["USER_PHONE"] ?? '';
$isVerified = !empty($arResult["IS_VERIFIED"]);
$result = $arResult["FORM_RESULT"] ?? [];

$fio = !empty($user['INFO']['FIO']) ? $user['INFO']['FIO'] : 'Не указано';
$email = !empty($user['INFO']['Email']) ? $user['INFO']['Email'] : 'Не указан';
$series = $user['INFO']['Series'] ?? '';
$number = $user['INFO']['Number'] ?? '';
$passportStr = (!empty($series) || !empty($number)) ? \Cabinet::passportOut($series . $number) : 'Не указаны';
?>

<div class="bg-yablue py-4">
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h1 fw-normal c-yawhite">Мои данные</h1></div>
		</div>
	</div>
</div>

<div class="container my-5">
    <div class="row">
		<div class="col-12">
			<?php if (!empty($result['description'])) { ?>
				<div class="alert <?= !empty($result['success']) ? 'alert-success' : 'alert-danger' ?> b-radius-yaradius-15 mb-4" role="alert">
					<?= HtmlFilter::encode($result['description']) ?>
				</div>
			<?php } ?>

			<!-- Статус верификации аккаунта -->
			<div class="p-4 b-yalightgray b-radius-yaradius-15 mb-4 d-flex flex-wrap justify-content-between align-items-center">
				<div>
					<span class="c-yadarkgray fw-bold d-block mb-1">Статус учетной записи:</span>
					<?php if ($isVerified) { ?>
						<span class="badge bg-success py-2 px-3 b-radius-yaradius-7" style="font-size: 0.95rem;">
							✓ Верифицирована
						</span>
					<?php } else { ?>
						<span class="badge bg-warning text-dark py-2 px-3 b-radius-yaradius-7" style="font-size: 0.95rem;">
							⚠ Требуется верификация
						</span>
						<span class="c-yamiddlegray text-minus ms-2 d-none d-md-inline">Для доступа ко всем операциям подтвердите личность в ДЦ</span>
					<?php } ?>
				</div>
				<div class="mt-3 mt-md-0">
					<a href="/cabinet/verify/" class="btn btn-outline-dark b-radius-yaradius-15 px-4 py-2 text-minus">
						<?= $isVerified ? 'Информация о верификации' : 'Показать QR-код для кассира' ?>
					</a>
				</div>
			</div>

			<div class="p-5 b-yalightgray b-radius-yaradius-15">
				<div class="row">
					<div class="col-md-6 pe-lg-4">
						<p class="fw-bold">ФИО</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= HtmlFilter::encode($fio);?></span>
							<a href="#cabinet-me-main" data-remodal-target="cabinet-me-main">Изменить</a>
						</p>
						<hr />
						<p class="fw-bold">Паспортные данные:</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= HtmlFilter::encode($passportStr);?></span>
							<a href="#cabinet-me-main" data-remodal-target="cabinet-me-main">Изменить</a>
						</p>
					</div>
					<div class="col-md-6 ps-lg-4">
						<p class="fw-bold">Номер телефона:</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= \YApp::phoneOut($userPhone);?></span>
							<a href="#cabinet-me-main" data-remodal-target="cabinet-me-main">Изменить</a>
						</p>
						<hr />
						<p class="fw-bold">Электронная почта</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= HtmlFilter::encode($email);?></span>
							<a href="#cabinet-me-email" data-remodal-target="cabinet-me-email">Изменить</a>
						</p>
					</div>
				</div>
				<div class="row"><div class="col-12"><hr /></div></div>
				<div class="row">
					<div class="col-12">
						<a href="#cabinet-me-passwd" data-remodal-target="cabinet-me-passwd" class="me-3 d-inline-block">Изменить пароль</a>
						<a href="#cabinet-me-delete" data-remodal-target="cabinet-me-delete" class="c-yared c-h-yared d-inline-block">Удалить аккаунт</a>
					</div>
				</div>
			</div>
		</div>
    </div>
</div>
