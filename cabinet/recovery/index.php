<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Восстановление пароля");
if ( $cab::checkAuth() ) header('Location: /cabinet/');

$status = 'start';
if ( $_POST['FORM'] == 'RECOVERY' ) {
    $user = $cab::getCabUserByName( $_POST['PHONE'] );
    if ( !!$_POST['CODE'] ) {
        $status = 'send';
        if ( time() > (int)$user['PROPERTY_CODE_TIMEOUT_VALUE'] ) {
            $timeout = true;
            $status = 'code';
        } elseif ( (int)$_POST['CODE'] != (int)$user['PROPERTY_CODE_VALUE'] ) {
            $error = true;
            $status = 'code';
        } else {
            $new_passwd = $cab::passwdRecovery( $_POST['PHONE'] );
            YApp::sp( $new_passwd );
        }
    } else {
        $status = 'code';
        $code = $cab::getSMSCodeByName( $_POST['PHONE'] );
    }
}
if ( $_POST['FORM'] == 'DELETE_ACCOUNT' ) {
    YApp::sp( $POST );
}
?>


<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
            <div class="col">
                <div class="p-5 bg-yawhite b-radius-yaradius-25 text-center">
                    <img src="../images/user-profile-circle.svg" />
                    <div class="mt-3 cabinet-sign-title">Восстановление пароля</div>
                    <?php /* 
                    <div class="mt-3 cabinet-sign-description c-yagray">Войдите или зарегистрируйтесь</div>
                    */ ?>
                    <form class="row mt-3" method="post">
						<input type="hidden" name="FORM" value="RECOVERY" />
                        <div class="col-12 mb-3">
							<div class="form-group position-relative">
								<input 
									type="phone" 
									class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3 cabinet-form-icon" 
									autocomplete="off"
									name="PHONE"
									required
									placeholder="+7 ___ ___ __ __*"
									data-phone-pattern = "+7 ___ ___ __ __"
                                    <?php if ( $status != 'start' ) { ?>
                                    value="<?= $_POST['PHONE'];?>"
                                    <?php } ?>
									maxlength="16" />
								<img src="/cabinet/images/icon-phone.svg" />
							</div>
						</div>
                        <?php if ( $status == 'start') { ?>
                        <div class="col-12 mb-3">
                            <div class="form-group">
                                <button 
                                    type="submit"
                                    class="c-yablack c-h-yablack bg-yawhite bg-h-yayellow b-yayellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button w-100" 
                                    rel=“nofollow”
                                    ><noindex>Запросить код в смс</noindex></button>
                                <?php /* 
                                <a 
                                    href="#" 
                                    class="c-yablack c-h-yablack bg-yawhite bg-h-yayellow b-yayellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button" 
                                    role="sendForm"
                                    rel=“nofollow”
                                    ><noindex>Запросить код в смс</noindex></a>
                                    */ ?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php if ( $status == 'code') { ?>
                            <!-- <div class="col-12 mb-3">
                                <div class="c-yagray">ВРЕМЕННО, вместо отправки смс!<br />Код: <?= $code;?></div>
                            </div> -->
                            <?php if ( !$timeout ) { ?>
                            <div class="col-12 mb-3">
                                <div class="text-plus">Введите код из смс:</div>
                            </div>
                            <div class="col-12 mb-2">
                                <div class="form-group">
                                    <input 
                                        type="text" 
                                        class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3" 
                                        autocomplete="off"
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
                                    <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/icon-repeat.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/icon-repeat.svg');?>" />
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
                                        rel=“nofollow”
                                        ><noindex>Отправить</noindex></button>
                                    <?php /* 
                                    <a 
                                        href="#"
                                        role="sendForm" 
                                        class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow border-0 text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center w-100" 
                                        rel=“nofollow”
                                        ><noindex>Войти</noindex></a>
                                        */ ?>
                                </div>
                            </div>
                            <?php } ?>
                            <?php if ( $status == 'send') { ?>
                            <?php if ( $new_passwd ) { ?>
                            <div class="col-12 mb-3">
                                <div>Одноразовый пароль для входа отправлен в смс</div>
                            </div>
                            <!-- <div class="col-12 mb-3">
                                <div class="c-yagray">ВРЕМЕННО, вместо отправки смс!<br />Новый пароль: <?= $new_passwd;?></div>
                            </div> -->
                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <a 
                                        href="/cabinet/login/" 
                                        class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center" 
                                        rel=“nofollow”
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
									rel=“nofollow”
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


<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>