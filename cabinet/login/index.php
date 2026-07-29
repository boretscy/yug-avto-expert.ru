<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вход в личный кабинет");

if ( $_POST['FORM'] == 'AUTH' ) {
	$user = $cab::getCabUserByName($_POST['PHONE']);
	if ( $user && $cab::passwdVerify($_POST['PASSWD'], $user['PROPERTY_GUID_VALUE']) ) {
		$cab::AUth($user);
	} else {
        $error = true;
    }
}
if ( $cab::checkAuth() ) header('Location: /cabinet/');
?>


<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
            <div class="col">
                <div class="p-5 bg-yawhite b-radius-yaradius-25 text-center">
                    <img src="../images/user-profile-circle.svg" />
                    <div class="mt-3 cabinet-sign-title">Вход в личный кабинет</div>
                    <div class="mt-3 cabinet-sign-description c-yagray">Войдите или зарегистрируйтесь</div>
                    <form class="row mt-3" method="post">
						<input type="hidden" name="FORM" value="AUTH" />
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
									maxlength="16" />
								<img src="/cabinet/images/icon-phone.svg" />
							</div>
						</div>
                        <div class="col-12 mb-3">
							<div class="form-group position-relative">
								<input 
									type="password" 
									class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3 cabinet-form-icon" 
									autocomplete="off"
									name="PASSWD"
									required
									placeholder="Пароль *"
									maxlength="16" />
								<img src="/cabinet/images/icon-lock.svg" />
							</div>
						</div>
						<?php if ( $error ) { ?>
						<div class="col-12 mb-3 text-center c-yared text-minus">Введен неверный номер телефона или пароль.<br />Попробуйте еще раз.</div>
						<?php } ?>
                        <a href="/cabinet/recovery/" class="mb-3 cabinet-sign-description c-yagray text-end">Восстановить пароль</a>
                        <div class="col-12 mb-3">
							<div class="form-group">
								<button 
									type="submit" 
									class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow border-0 text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center w-100" 
									rel=“nofollow”
									><noindex>Войти</noindex></button>
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