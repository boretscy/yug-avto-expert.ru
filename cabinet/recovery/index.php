<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление пароля");
if ( $cab::checkAuth() ) {
	LocalRedirect('/cabinet/');
}

$status = 'start';
$timeout = false;
$error = false;
$new_passwd = false;
$sessError = false;

if ( $_SERVER['REQUEST_METHOD'] === 'POST' && (($_POST['FORM'] ?? '') === 'RECOVERY') ) {
	if ( !check_bitrix_sessid() ) {
		$sessError = true;
	} else {
		$phone = $_POST['PHONE'] ?? '';
		$code = trim($_POST['CODE'] ?? '');
		$user = $cab::getCabUserByName($phone);

		if ( !empty($code) ) {
			$status = 'send';
			$codeTimeout = (int)($user['PROPERTY_CODE_TIMEOUT_VALUE'] ?? 0);
			$codeExpected = (int)($user['PROPERTY_CODE_VALUE'] ?? 0);

			if ( time() > $codeTimeout ) {
				$timeout = true;
				$status = 'code';
			} elseif ( empty($codeExpected) || (int)$code !== $codeExpected ) {
				$error = true;
				$status = 'code';
				// Защита от брутфорса: лимит 3 неверные попытки
				$attempts = (int)($user['PROPERTY_SMS_ATTEMPTS'] ?? 0) + 1;
				if ( !empty($user['B_USER_ID']) ) {
					$uObj = new \CUser;
					if ( $attempts >= 3 ) {
						$uObj->Update($user['B_USER_ID'], ['UF_CAB_CODE' => '', 'UF_CAB_SMS_ATTEMPTS' => 0]);
						$timeout = true;
					} else {
						$uObj->Update($user['B_USER_ID'], ['UF_CAB_SMS_ATTEMPTS' => $attempts]);
					}
				}
			} else {
				$new_passwd = $cab::passwdRecovery($phone);
			}
		} else {
			$status = 'code';
			$codeSent = $cab::getSMSCodeByName($phone);
		}
	}
}

$safePhone = \Bitrix\Main\Text\HtmlFilter::encode($_POST['PHONE'] ?? '');
?>

<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
            <div class="col">
                <div class="p-5 bg-yawhite b-radius-yaradius-25 text-center">
                    <img src="../images/user-profile-circle.svg" alt="Профиль" />
                    <div class="mt-3 cabinet-sign-title">Восстановление пароля</div>

					<?php if ( $sessError ) { ?>
						<div class="alert alert-danger mt-3 b-radius-yaradius-15 text-start" role="alert">
							Ваша сессия истекла. Пожалуйста, обновите страницу и попробуйте снова.
						</div>
					<?php } ?>

                    <form class="row mt-3" method="post">
						<?= bitrix_sessid_post() ?>
						<input type="hidden" name="FORM" value="RECOVERY" />
                        <div class="col-12 mb-3">
							<div class="form-group position-relative">
								<input 
									type="tel" 
									class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3 cabinet-form-icon" 
									autocomplete="tel"
									name="PHONE"
									required
									placeholder="+7 ___ ___ __ __*"
									data-phone-pattern="+7 ___ ___ __ __"
                                    <?php if ( $status !== 'start' ) { ?>
                                    value="<?= $safePhone ?>"
                                    <?php } ?>
									maxlength="16" />
								<img src="/cabinet/images/icon-phone.svg" alt="Телефон" />
							</div>
						</div>
                        <?php if ( $status === 'start' ) { ?>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <button 
                                    type="submit"
                                    class="c-yablack c-h-yablack bg-yawhite bg-h-yayellow b-yayellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button w-100" 
                                    rel="nofollow"
                                ><noindex>Запросить код в смс</noindex></button>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ( $status === 'code' ) { ?>
                            <?php if ( !$timeout ) { ?>
                            <div class="col-12 mb-3">
                                <div class="text-plus">Введите код из смс:</div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <input 
                                        type="text" 
                                        class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3" 
                                        autocomplete="one-time-code"
                                        name="CODE"
                                        required
                                        placeholder="Код из смс" />
                                </div>
                            </div>
                            <?php } ?>
                            <?php if ( $timeout ) { ?>
                            <div class="col-12 mb-3">
                                <div class="c-yared">Срок действия кода истек</div>
                            </div>
                            <div class="col-12 mb-3">
                                <a href="/cabinet/recovery/" class="text-minus c-yamiddlegray c-h-yamiddlegray">
                                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/icon-repeat.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/icon-repeat.svg');?>" alt="Повторить" />
                                    Запросить код повторно
                                </a>
                            </div>
                            <?php } ?>
                            <?php if ( $error ) { ?>
                            <div class="col-12 mb-3">
                                <div class="c-yared">Неверный код</div>
                            </div>
                            <?php } ?>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <button 
                                        type="submit" 
                                        class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow border-0 text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center w-100" 
                                        rel="nofollow"
                                    ><noindex>Отправить</noindex></button>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ( $status === 'send' ) { ?>
                            <?php if ( $new_passwd ) { ?>
                            <div class="col-12 mb-3">
                                <div>Новый временный пароль для входа отправлен в смс</div>
                            </div>
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <a 
                                        href="/cabinet/login/" 
                                        class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center" 
                                        rel="nofollow"
                                    ><noindex>Войти</noindex></a>
                                </div>
                            </div>
                            <?php } else { ?>
                            <div class="col-12 mb-3">
                                <div class="c-yared">Что-то пошло не так. Попробуйте повторить позже.</div>
                            </div>
                            <?php } ?>
                        <?php } ?>
                        <div class="col-12">
							<div class="form-group">
								<a 
									href="/cabinet/registration/" 
									class="c-yablack c-h-yablack bg-yawhite bg-h-yalightgray b-yadarkgray text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center" 
									rel="nofollow"
								><noindex>Зарегистрироваться</noindex></a>
							</div>
						</div>
                    </form>
                </div>
            </div>
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
        </div>
    </div>
</div>

<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php"); ?>
