<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if ( $cab::checkAuth() ) header('Location: /cabinet/');
$APPLICATION->SetTitle("Регистрация в личном кабинете");

if ( $_POST['FORM'] == 'REGISTRATION' ) {

	// $send = $cab::sendform( $_POST );
	// YApp::sp($_POST);
	$guid = $cab::regsterUser($_POST);
	// $guid = '38c5342d-067d-11f1-a166-00155dca01c6';
	$register_result = [
		'status' => 'fd,shdfku',
		'descriptiion' => ''
	];
	if ( $guid ) {
		// YApp::sp( $guid );
		$_POST['GUID'] = $guid;
		$user = $cab::setCabUser($_POST);
		// YApp::sp( $user );
		if ( $user['status'] ) {
			// if ( $send = $cab::sendform( $_POST ) ) {

			// };
		} else {

		}
	} else {
		$error = true;
	}
}
?>
<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
            <div class="col">
                <div class="p-5 bg-yawhite b-radius-yaradius-25 text-center">
                    <img src="../images/user-profile-circle.svg" />
                    <div class="mt-3 cabinet-sign-title">Регистрация в личном кабинете</div>
					<?php if ( $guid ) { ?>
					<div class="mt-3 cabinet-sign-description c-yablack fw-bold">Спасибо!<br />Заявка на регистрацию отправлена.</div>
                    <div class="mt-3 cabinet-sign-description c-yadarkgray mb-4">Наш менеджер свяжется с Вами в ближайшее время</div>
                    <a 
						href="/cabinet/" 
						class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button" 
						rel=“nofollow”
						><noindex>На главную</noindex></a>
					<?php } elseif ( !$error) { ?>
                    <div class="mt-3 cabinet-sign-description c-yablack fw-bold">Для получения доступа в личный кабинет комитента необходимо связаться с менеджером ООО “Юг-Авто Эксперт” для заключения договора комиссионной продажи автомобиля и регистрации</div>
                    <form class="row mt-3" method="post">
						<input type="hidden" name="FORM" value="REGISTRATION" />
						<div class="col-12 mb-3">
							<div class="form-group">
								<input 
									type="text" 
									class="form-control b-radius-yaradius-15 c-yadarkgray w-100 px-4 py-3" 
									autocomplete="off"
									name="NAME"
									value="<?= $_POST['NAME'];?>"
									required
									placeholder="ФИО*" />
							</div>
						</div>
						<div class="col-12 mb-3">
							<div class="form-group position-relative">
								<input 
									type="phone" 
									class="form-control b-radius-yaradius-15 c-yadarkgray w-100 px-4 py-3 cabinet-form-icon" 
									autocomplete="off"
									name="PHONE"
									value="<?= $_POST['PHONE'];?>"
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
									type="email" 
									class="form-control b-radius-yaradius-15 c-yadarkgray w-100 px-4 py-3 cabinet-form-icon" 
									autocomplete="off"
									name="EMAIL"
									value="<?= $_POST['EMAIL'];?>"
									required
									placeholder="EMAIL*" />
								<img src="/cabinet/images/icon-phone.svg" />
							</div>
						</div>
						<div class="col-12 mb-2 text-minus text-start">
							Паспорт:
						</div>
						<div class="col-5 mb-3">
							<div class="form-group position-relative">
								<input 
									type="text" 
									class="form-control b-radius-yaradius-15 c-yadarkgray w-100 px-4 py-3" 
									autocomplete="off"
									name="PASSPORT_SERIES"
									value="<?= $_POST['PASSPORT_SERIES'];?>"
									required
									placeholder="Серия*"
									maxlength="4" />
							</div>
						</div>
						<div class="col-7 mb-3">
							<div class="form-group position-relative">
								<input 
									type="text" 
									class="form-control b-radius-yaradius-15 c-yadarkgray w-100 px-4 py-3" 
									autocomplete="off"
									name="PASSPORT_NUMBER"
									value="<?= $_POST['PASSPORT_NUMBER'];?>"
									required
									placeholder="Номер*"
									maxlength="6" />
							</div>
						</div>
                        <div class="col-12">
							<div class="form-group">
								<button 
									type="submit"
									class="c-yablack c-h-yablack bg-yayellow bg-yadisabled bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button w-100 border-0" 
									rel=“nofollow”
									disabled
									><noindex>Оставить заявку на регистрацию</noindex></button>
							</div>
						</div>
                        <div class="col-12 mt-3 c-yadarkgray text-minus-minus">
							<div class="form-check">
								<input class="form-check-input me-2" type="checkbox" id="AGRYY_REGISTRATION" name="PERSONAL" role="enableSubmit" require  />
								<label class="form-check-label text-minus-minus text-start" for="AGRYY_REGISTRATION">
									<noindex>Нажимая кнопку, я подтверждаю свое ознакомление с <a href="/about/personal-data-policy.php" target="_blank" class="text-decoration-none c-yayellow">политикой обработки персональных данных</a> и даю согласие на их обработку</noindex>
								</label>
							</div>
						</div>
                    </form>
					<?php } else { ?>
					<div class="mt-3 c-yared fw-bold">Ой! Что-то пошло не так.</div>
                    <div class="mt-3 c-yadarkgray mb-4">Попробуйте позже.</div>
					<?php } ?>
                </div>
            </div>
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
        </div>
    </div>
</div>



<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>