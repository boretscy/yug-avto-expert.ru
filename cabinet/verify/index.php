<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

if ( !$cab::checkAuth() ) {
	LocalRedirect('/cabinet/login/');
}

$APPLICATION->SetTitle("Верификация учетной записи");

$userGuid = $GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'] ?? '';
$userPhone = $GLOBALS['CABINET_USER']['NAME'] ?? '';
$isVerified = !empty($GLOBALS['CABINET_USER']['INFO']['Status']);
$notice = '';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && (($_POST['ACTION'] ?? '') === 'CHECK_STATUS') ) {
	if ( !check_bitrix_sessid() ) {
		$notice = 'Срок сессии истек. Пожалуйста, обновите страницу.';
	} else {
		if ( !empty($userGuid) ) {
			$info1C = $cab::getUserByGUID($userGuid);
			if ( !empty($info1C['Status']) ) {
				$GLOBALS['CABINET_USER']['INFO']['Status'] = true;
				$isVerified = true;
				// Синхронизируем сессию
				if ( !empty($_SESSION['CABINET_USER']) ) {
					$_SESSION['CABINET_USER']['INFO']['Status'] = true;
				}
			} else {
				$notice = 'Статус пока не подтвержден в системе. Пожалуйста, обратитесь к сотруднику дилерского центра.';
			}
		}
	}
}

$qrPayload = json_encode(['GUID' => $userGuid], JSON_UNESCAPED_SLASHES);
?>

<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-3 col-xl-4"></div>
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="p-4 p-md-5 bg-yawhite b-radius-yaradius-25 text-center shadow-sm">
					<?php if ( $isVerified ) { ?>
						<img src="/cabinet/images/user-success.svg" alt="Верифицирован" width="72" height="72" />
						<div class="mt-3 cabinet-sign-title">Статус верификации<br />учетной записи:</div>
						<div class="mt-2 cabinet-sign-title c-yadarkgreen text-uppercase fw-bold">Верифицирована</div>
						<div class="mt-3 cabinet-sign-description c-yablack mb-4">
							Поздравляем! Ваша учетная запись верифицирована. Вам доступны все возможности личного кабинета.
						</div>
						<a 
							href="/cabinet/" 
							class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button fw-bold" 
							rel="nofollow"
						><noindex>В личный кабинет</noindex></a>
					<?php } else { ?>
						<img src="/cabinet/images/user-attention.svg" alt="Требуется верификация" width="72" height="72" />
						<div class="mt-3 cabinet-sign-title">Верификация учетной записи</div>
						<div class="mt-2 text-uppercase fw-bold text-warning" style="color: #b78103 !important;">Требуется подтверждение</div>
						<div class="mt-3 cabinet-sign-description c-yadarkgray mb-4">
							Для подтверждения личности покажите данный QR-код сотруднику дилерского центра ООО «Юг-Авто Эксперт».
						</div>

						<!-- Контейнер QR-кода -->
						<div class="d-flex justify-content-center align-items-center my-3 p-3 bg-white border b-radius-yaradius-15 mx-auto" style="width: 240px; height: 240px;">
							<div id="cabinet-qrcode"></div>
						</div>

						<!-- Данные для сверки сотрудником ДЦ (требование w.txt) -->
						<div class="bg-yalightgray p-3 b-radius-yaradius-15 text-start text-minus mb-4">
							<div class="mb-2">
								<span class="c-yamiddlegray d-block">Номер телефона:</span>
								<strong class="c-yablack"><?= YApp::phoneOut($userPhone) ?></strong>
							</div>
							<div>
								<span class="c-yamiddlegray d-block">Идентификатор (GUID):</span>
								<code class="text-break user-select-all" style="font-size: 0.85rem; color: #333;"><?= \Bitrix\Main\Text\HtmlFilter::encode($userGuid) ?></code>
							</div>
						</div>

						<?php if ( !empty($notice) ) { ?>
							<div class="alert alert-info py-2 px-3 text-minus b-radius-yaradius-15 mb-3 text-start" role="alert">
								<?= \Bitrix\Main\Text\HtmlFilter::encode($notice) ?>
							</div>
						<?php } ?>

						<!-- Кнопка проверки статуса -->
						<form method="post" class="mb-3">
							<?= bitrix_sessid_post() ?>
							<input type="hidden" name="ACTION" value="CHECK_STATUS" />
							<button 
								type="submit" 
								class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow border-0 text-decoration-none b-radius-yaradius-15 py-3 px-4 d-block text-center w-100 fw-bold cabinet-text-size-button"
								rel="nofollow"
							><noindex>Проверить статус верификации</noindex></button>
						</form>

						<a 
							href="/cabinet/me/" 
							class="c-yamiddlegray c-h-yablack text-decoration-none text-minus d-inline-block"
						>Перейти в мой профиль</a>
					<?php } ?>
                </div>
            </div>
            <div class="col-md-3 col-lg-3 col-xl-4"></div>
        </div>
    </div>
</div>

<?php if ( !$isVerified && !empty($userGuid) ) { ?>
<script src="/bitrix/js/main/qrcode/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var qrTarget = document.getElementById('cabinet-qrcode');
    if (qrTarget && typeof QRCode !== 'undefined') {
        new QRCode(qrTarget, {
            text: <?= json_encode($qrPayload) ?>,
            width: 208,
            height: 208,
            colorDark: "#000000",
            colorLight: "#ffffff",
            correctLevel: QRCode.CorrectLevel.M
        });
    }
});
</script>
<?php } ?>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
