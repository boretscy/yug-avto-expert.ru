<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Text\HtmlFilter;

$userGuid = $arResult["USER_GUID"] ?? '';
$userPhone = $arResult["USER_PHONE"] ?? '';
$isVerified = !empty($arResult["IS_VERIFIED"]);
$notice = $arResult["VERIFY_NOTICE"] ?? '';
$qrPayload = $arResult["QR_PAYLOAD"] ?? '';
?>

<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-lg-3 col-xl-4"></div>
            <div class="col-md-6 col-lg-6 col-xl-4">
                <div class="p-4 p-md-5 bg-yawhite b-radius-yaradius-25 text-center shadow-sm">
					<?php if ($isVerified) { ?>
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
								<strong class="c-yablack"><?= \YApp::phoneOut($userPhone) ?></strong>
							</div>
							<div>
								<span class="c-yamiddlegray d-block">Идентификатор (GUID):</span>
								<code class="text-break user-select-all" style="font-size: 0.85rem; color: #333;"><?= HtmlFilter::encode($userGuid) ?></code>
							</div>
						</div>

						<div id="verification-notice-area">
							<?php if (!empty($notice)) { ?>
								<div class="alert alert-info py-2 px-3 text-minus b-radius-yaradius-15 mb-3 text-start" role="alert">
									<?= HtmlFilter::encode($notice) ?>
								</div>
							<?php } ?>
						</div>

						<!-- Кнопка проверки статуса -->
						<form method="post" id="verification-status-form" class="mb-3">
							<?= bitrix_sessid_post() ?>
							<input type="hidden" name="ACTION" value="CHECK_STATUS" />
							<button 
								type="submit" 
								id="btn-check-verify-status"
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

<?php if (!$isVerified && !empty($userGuid)) { ?>
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

    var checkBtn = document.getElementById('btn-check-verify-status');
    if (checkBtn) {
        checkBtn.addEventListener('click', function(e) {
            if (typeof BX !== 'undefined' && BX.ajax) {
                e.preventDefault();
                checkBtn.disabled = true;
                checkBtn.innerText = 'Проверка...';

                BX.ajax.runComponentAction('yugavto:cabinet', 'checkVerificationStatus', {
                    mode: 'class'
                }).then(function(response) {
                    if (response.data && response.data.verified) {
                        window.location.reload();
                    } else {
                        var noticeArea = document.getElementById('verification-notice-area');
                        if (noticeArea) {
                            noticeArea.innerHTML = '<div class="alert alert-info py-2 px-3 text-minus b-radius-yaradius-15 mb-3 text-start" role="alert">' + 
                                (response.data.message || 'Статус пока не подтвержден в 1С.') + '</div>';
                        }
                        checkBtn.disabled = false;
                        checkBtn.innerText = 'Проверить статус верификации';
                    }
                }).catch(function(error) {
                    checkBtn.disabled = false;
                    checkBtn.innerText = 'Проверить статус верификации';
                    var noticeArea = document.getElementById('verification-notice-area');
                    if (noticeArea) {
                        noticeArea.innerHTML = '<div class="alert alert-danger py-2 px-3 text-minus b-radius-yaradius-15 mb-3 text-start" role="alert">Ошибка связи с сервером. Попробуйте еще раз.</div>';
                    }
                });
            }
        });
    }
});
</script>
<?php } ?>
