<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if ( !$cab::checkAuth() ) {
	LocalRedirect('/cabinet/login/');
}

$APPLICATION->SetTitle("Личный кабинет - Мои данные");

$result = [];
$isVerified = !empty($GLOBALS['CABINET_USER']['INFO']['Status']);

if ( $_SERVER['REQUEST_METHOD'] === 'POST' ) {
	if ( !check_bitrix_sessid() ) {
		$result = [
			'error' => true,
			'description' => 'Истек срок действия сессии. Пожалуйста, обновите страницу.'
		];
	} else {
		$formType = $_POST['FORM'] ?? '';
		switch ( $formType ) {
			case 'CHANGE_PASSWD':
				$oldPass = $_POST['PASSWD'] ?? '';
				$newPass = $_POST['NEWPASSWD'] ?? '';
				$confirmPass = $_POST['CONFIMPASSWD'] ?? '';

				if ( $GLOBALS['CABINET_USER'] && $cab::passwdVerify($oldPass, $GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE']) ) {
					if ( !empty($newPass) && $newPass === $confirmPass ) {
						if ( mb_strlen($newPass) >= 8 ) {
							$cab::setPasswd($GLOBALS['CABINET_USER']['NAME'], $newPass);
							$result = [
								'success' => true,
								'description' => 'Вы успешно изменили пароль.'
							];
						} else {
							$result = [
								'error' => true,
								'description' => 'Пароль должен содержать минимум 8 символов.'
							];
						}
					} else {
						$result = [
							'error' => true,
							'description' => 'Введенные новые пароли не совпадают.'
						];
					}
				} else {
					$result = [
						'error' => true,
						'description' => 'Неверно указан текущий пароль.'
					];
				}
				break;

			case 'DELETE_ACCOUNT':
				$reason = trim(($_POST['REASON'] ?? '') . ' ' . ($_POST['CUSTOM_REASON'] ?? ''));
				$advice = trim($_POST['ADVICE'] ?? '');
				
				// Отправляем заявку администратору
				$cab::sendform([
					'SENDER' => 'Запрос на удаление аккаунта комитента',
					'NAME' => $GLOBALS['CABINET_USER']['INFO']['FIO'] ?? $GLOBALS['CABINET_USER']['NAME'],
					'PHONE' => $GLOBALS['CABINET_USER']['NAME'],
					'COMMENT' => "Причина: {$reason}\nПожелания: {$advice}\nGUID: {$GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE']}"
				]);

				$result = [
					'success' => true,
					'description' => 'Ваш запрос на удаление аккаунта принят. Менеджер свяжется с вами для подтверждения.'
				];
				break;

			default:
				break;
		}
	}
}

$userGuid = $GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'] ?? '';
$userPhone = $GLOBALS['CABINET_USER']['NAME'] ?? '';
$fio = !empty($GLOBALS['CABINET_USER']['INFO']['FIO']) ? $GLOBALS['CABINET_USER']['INFO']['FIO'] : 'Не указано';
$email = !empty($GLOBALS['CABINET_USER']['INFO']['Email']) ? $GLOBALS['CABINET_USER']['INFO']['Email'] : 'Не указан';
$series = $GLOBALS['CABINET_USER']['INFO']['Series'] ?? '';
$number = $GLOBALS['CABINET_USER']['INFO']['Number'] ?? '';
$passportStr = (!empty($series) || !empty($number)) ? $cab::passportOut($series . $number) : 'Не указаны';
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
			<?php if ( !empty($result['description']) ) { ?>
				<div class="alert <?= !empty($result['success']) ? 'alert-success' : 'alert-danger' ?> b-radius-yaradius-15 mb-4" role="alert">
					<?= \Bitrix\Main\Text\HtmlFilter::encode($result['description']) ?>
				</div>
			<?php } ?>

			<!-- Статус верификации аккаунта -->
			<div class="p-4 b-yalightgray b-radius-yaradius-15 mb-4 d-flex flex-wrap justify-content-between align-items-center">
				<div>
					<span class="c-yadarkgray fw-bold d-block mb-1">Статус учетной записи:</span>
					<?php if ( $isVerified ) { ?>
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
							<span><?= \Bitrix\Main\Text\HtmlFilter::encode($fio);?></span>
							<a href="#cabinet-me-main" data-remodal-target="cabinet-me-main">Изменить</a>
						</p>
						<hr />
						<p class="fw-bold">Паспортные данные:</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= \Bitrix\Main\Text\HtmlFilter::encode($passportStr);?></span>
							<a href="#cabinet-me-main" data-remodal-target="cabinet-me-main">Изменить</a>
						</p>
					</div>
					<div class="col-md-6 ps-lg-4">
						<p class="fw-bold">Номер телефона:</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= YApp::phoneOut($userPhone);?></span>
							<a href="#cabinet-me-main" data-remodal-target="cabinet-me-main">Изменить</a>
						</p>
						<hr />
						<p class="fw-bold">Электронная почта</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= \Bitrix\Main\Text\HtmlFilter::encode($email);?></span>
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

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
