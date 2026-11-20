<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if ( $cab::checkAuth() ) {
	LocalRedirect('/cabinet/');
}
$APPLICATION->SetTitle("Регистрация в личном кабинете");

$guid = null;
$errorMessage = '';

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['FORM'] ?? '') === 'REGISTRATION' ) {
	if ( !check_bitrix_sessid() ) {
		$errorMessage = 'Ваша сессия истекла. Пожалуйста, обновите страницу и попробуйте снова.';
	} else {
		$rawPhone = $_POST['PHONE'] ?? '';
		$cleanPhone = YApp::phoneIn($rawPhone);

		if ( empty($cleanPhone) || mb_strlen($cleanPhone) < 10 ) {
			$errorMessage = 'Пожалуйста, укажите корректный номер телефона.';
		} else {
			// Проверка уникальности номера ДО обращения в 1С (требование w.txt для исключения дубликатов с новыми GUID)
			$existingUser = $cab::getCabUserByName($cleanPhone);
			if ( !empty($existingUser) ) {
				$errorMessage = 'Пользователь с таким номером телефона уже зарегистрирован. Вы можете войти в кабинет или восстановить пароль.';
			} else {
				$guid = $cab::regsterUser($_POST);
				if ( $guid ) {
					$_POST['GUID'] = $guid;
					$user = $cab::setCabUser($_POST);
					if ( !$user['status'] ) {
						error_log("Cabinet registration: setCabUser failed for phone {$cleanPhone}, GUID {$guid}");
					}
				} else {
					$errorMessage = 'Не удалось завершить регистрацию. Пожалуйста, проверьте введённые данные или обратитесь к менеджеру дилерского центра.';
				}
			}
		}
	}
}

$safeName = \Bitrix\Main\Text\HtmlFilter::encode($_POST['NAME'] ?? '');
$safePhone = \Bitrix\Main\Text\HtmlFilter::encode($_POST['PHONE'] ?? '');
$safeEmail = \Bitrix\Main\Text\HtmlFilter::encode($_POST['EMAIL'] ?? '');
?>
<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
            <div class="col">
                <div class="p-5 bg-yawhite b-radius-yaradius-25 text-center">
                    <img src="../images/user-profile-circle.svg" alt="Регистрация" />
                    <div class="mt-3 cabinet-sign-title">Регистрация в личном кабинете</div>

					<?php if ( $guid ) { ?>
						<div class="mt-3 cabinet-sign-description c-yablack fw-bold">Спасибо!<br />Заявка на регистрацию отправлена.</div>
						<div class="mt-3 cabinet-sign-description c-yadarkgray mb-4">Наш менеджер свяжется с Вами в ближайшее время</div>
						<a 
							href="/cabinet/" 
							class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button" 
							rel="nofollow"
						><noindex>На главную</noindex></a>
					<?php } else { ?>
						<?php if ( !empty($errorMessage) ) { ?>
							<div class="alert alert-danger mt-3 b-radius-yaradius-15 text-start" role="alert">
								<?= \Bitrix\Main\Text\HtmlFilter::encode($errorMessage) ?>
							</div>
						<?php } ?>

						<div class="mt-3 cabinet-sign-description c-yablack fw-bold">Для получения доступа в личный кабинет комитента необходимо заключить договор комиссионной продажи автомобиля и пройти регистрацию</div>
						<form class="row mt-3" method="post">
							<?= bitrix_sessid_post() ?>
							<input type="hidden" name="FORM" value="REGISTRATION" />
							<div class="col-12 mb-3">
								<div class="form-group">
									<input 
										type="text" 
										class="form-control b-radius-yaradius-15 c-yadarkgray w-100 px-4 py-3" 
										autocomplete="name"
										name="NAME"
										value="<?= $safeName ?>"
										required
										placeholder="ФИО*" />
								</div>
							</div>
							<div class="col-12 mb-3">
								<div class="form-group position-relative">
									<input 
										type="tel" 
										class="form-control b-radius-yaradius-15 c-yadarkgray w-100 px-4 py-3 cabinet-form-icon" 
										autocomplete="tel"
										name="PHONE"
										value="<?= $safePhone ?>"
										required
										placeholder="+7 ___ ___ __ __*"
										data-phone-pattern="+7 ___ ___ __ __"
										maxlength="16" />
									<img src="/cabinet/images/icon-phone.svg" alt="Телефон" />
								</div>
							</div>
							<div class="col-12 mb-3">
								<div class="form-group position-relative">
									<input 
										type="email" 
										class="form-control b-radius-yaradius-15 c-yadarkgray w-100 px-4 py-3 cabinet-form-icon" 
										autocomplete="email"
										name="EMAIL"
										value="<?= $safeEmail ?>"
										required
										placeholder="EMAIL*" />
									<img src="/cabinet/images/icon-phone.svg" alt="Email" />
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<button 
										type="submit"
										class="c-yablack c-h-yablack bg-yayellow bg-yadisabled bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button w-100 border-0" 
										rel="nofollow"
										disabled
									><noindex>Оставить заявку на регистрацию</noindex></button>
								</div>
							</div>
							<div class="col-12 mt-3 c-yadarkgray text-minus-minus">
								<div class="form-check">
									<input class="form-check-input me-2" type="checkbox" id="AGRYY_REGISTRATION" name="PERSONAL" role="enableSubmit" required />
									<label class="form-check-label text-minus-minus text-start" for="AGRYY_REGISTRATION">
										<noindex>Нажимая кнопку, я подтверждаю свое ознакомление с <a href="/about/personal-data-policy.php" target="_blank" class="text-decoration-none c-yayellow">политикой обработки персональных данных</a> и даю согласие на их обработку</noindex>
									</label>
								</div>
							</div>
						</form>
					<?php } ?>
                </div>
            </div>
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
        </div>
    </div>
</div>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
