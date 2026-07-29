<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
if ( !$cab::checkauth() ) header('Location: /cabinet/login/');
// if ( !$GLOBALS['CABINET_USER']['INFO']['Status'] ) header('Location: /cabinet/verify/');
$APPLICATION->SetTitle("Личный кабинет - Документы");
// YApp::sp($GLOBALS['CABINET_USER']);

$status['DELETE_ACCOUNT'] = 'start';
$status['CONFIM_OFFER'] = 'start';


switch ( $_POST['FORM'] ) {

	case 'CHANGE_PASSWD':
		if ( $GLOBALS['CABINET_USER'] && $cab::passwdVerify($_POST['PASSWD'], $GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE']) ) {
			if ( $_POST['NEWPASSWD'] == $_POST['CONFIMPASSWD'] ) {
				$cab::setPasswd( $GLOBALS['CABINET_USER']['NAME'], $_POST['NEWPASSWD'] );
				$result = [
					'success' => true,
					'description' => 'Вы успешно изменили пароль.'
				];
			} else {
				$result = [
					'error' => true,
					'description' => 'Введеные пароли не совпадают'
				];
			}
		} else {
			$result = [
				'error' => true,
				'description' => 'Неверный пароль'
			];
		}
		break;

	case 'DELETE_ACCOUNT':
		YApp::sp($_POST);
		$status = 'delete_start';
		break;
	
	case 'CHANGE_EMAIL':
		break;

	default: break;
}
?>
<div class="bg-yablue py-4">
	<div class="container">
		<div class="row">
			<div class="col"><h1 class="h1 fw-normal c-yawhite">Мои данные</h1></div>
		</div>
	</div>
</div>
<?php if ( $GLOBALS['CABINET_USER']['INFO']['Status'] ) { ?>
<div class="container my-5">
    <div class="row">
		<div class="col-12">
			<div class="p-5 b-yalightgray b-radius-yaradius-15">
				<div class="row">
					<div class="col-md-6 pe-lg-4">
						<p class="fw-bold">ФИО</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= $GLOBALS['CABINET_USER']['INFO']['FIO'];?></span>
							<a href="#cabinet-me-main" data-remodal-target="cabinet-me-main">Изменить</a>
						</p>
						<hr />
						<p class="fw-bold">Паспортные данные:</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= $cab::passportOut( $GLOBALS['CABINET_USER']['INFO']['Series'].$GLOBALS['CABINET_USER']['INFO']['Number'] );?></span>
							<a href="#cabinet-me-main" data-remodal-target="cabinet-me-main">Изменить</a>
						</p>
					</div>
					<div class="col-md-6 ps-lg-4">
						<p class="fw-bold">Номер телефона:</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= YApp::phoneOut( $GLOBALS['CABINET_USER']['NAME']);?></span>
							<a href="#cabinet-me-main" data-remodal-target="cabinet-me-main">Изменить</a>
						</p>
						<hr />
						<p class="fw-bold">Электронная почта</p>
						<p class="d-flex justify-content-between align-items-center">
							<span><?= $GLOBALS['CABINET_USER']['INFO']['Email'];?></span>
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
<?php } else { ?>
<div class="py-5 bg-yalightgray">
    <div class="container">
        <div class="row">
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
            <div class="col">
                <div class="p-5 bg-yawhite b-radius-yaradius-25 text-center">
                    <img src="../images/user-attention.svg" />
                    <div class="mt-3 cabinet-sign-title">Раздел недоступен</div>
                    <div class="mt-3 cabinet-sign-description c-yablack mb-4">Раздел доступен только для верифицированных пользователей. Пройдите процедуру верификации в дилерском центре.</div>
                </div>
            </div>
            <div class="col-md-2 col-lg-3 col-xl-4"></div>
        </div>
    </div>
</div>
<?php } ?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>