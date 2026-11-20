<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Text\HtmlFilter;
?>

<!-- Модальное окно: Изменение основных данных -->
<div class="remodal" data-remodal-id="cabinet-me-main" >
    <button data-remodal-action="close" class="remodal-close"></button>
	<div class="row">
		<div class="col-12">
			<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/user-attention.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/user-attention.svg');?>" alt="" />
			<div class="remodal-title text-plus c-yablack fw-bold mt-4">Изменение основных данных</div>
			<div class="remodal-description c-yadarkgray text-minus my-4">Для внесения изменений в основные данные: ФИО, паспортные данные, номер телефона - необходимо обратиться к сотрудникам в дилерском центре ООО «Юг-Авто Эксперт»</div>
			<a 
				href="#" 
				class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button" 
				data-remodal-action="close"
				rel="nofollow"
			><noindex>Назад</noindex></a>
		</div>
	</div>
</div>

<!-- Модальное окно: Изменение E-mail -->
<div class="remodal" data-remodal-id="cabinet-me-email" >
    <button data-remodal-action="close" class="remodal-close"></button>
	<div class="row">
		<div class="col-12">
			<div class="remodal-title text-plus c-yablack fw-bold mt-4">Изменение адреса<br />электронной почты</div>
			<div class="remodal-description c-yadarkgray text-minus my-4">Введите новый адрес электронной почты и запросите код подтверждения через СМС на Ваш номер телефона.</div>
			<form class="row mt-3" method="post">
				<?= bitrix_sessid_post() ?>
				<input type="hidden" name="FORM" value="CHANGE_EMAIL" />
				<input type="hidden" name="PHONE" value="<?= HtmlFilter::encode($GLOBALS['CABINET_USER']['NAME'] ?? '');?>" />
				<div class="col-12 mb-3">
					<div class="text-plus">Введите новый E-mail:</div>
				</div>
                <div class="col-12 mb-3">
					<div class="form-group">
						<input 
							type="email" 
							class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3" 
							autocomplete="off"
							name="EMAIL"
							value="<?= HtmlFilter::encode($_POST['EMAIL'] ?? '');?>" 
							required
							placeholder="E-mail" />
					</div>
				</div>
				<?php if (($form_email_status ?? 'start') == 'start') { ?>
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
				<?php if (empty($timeout)) { ?>
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
                            placeholder="Код из смс" />
                    </div>
                </div>
                <?php } ?>
				<div class="col-12 mb-3">
					<a href="#" class="text-minus c-yamiddlegray c-h-yamiddlegray">
						<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/icon-repeat.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/icon-repeat.svg');?>" alt="" />
						Запросить код повторно
					</a>
				</div>
                <div class="col-12">
					<div class="form-group">
						<a 
							href="#cabinet-me-email-confirm" data-remodal-target="cabinet-me-email-confirm"
							class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button" 
							rel="nofollow"
						><noindex>Отправить</noindex></a>
					</div>
				</div>
            </form>
		</div>
	</div>
</div>

<!-- Модальное окно: Подтверждение E-mail -->
<div class="remodal" data-remodal-id="cabinet-me-email-confirm" >
    <button data-remodal-action="close" class="remodal-close"></button>
	<div class="row">
		<div class="col-12">
			<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/user-confirm.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/user-confirm.svg');?>" alt="" />
			<div class="remodal-title text-plus c-yablack fw-bold mt-4">Подтвердите ваш новый E-mail</div>
			<div class="remodal-description c-yadarkgray text-minus my-4">На указанный Вами адрес электронной почты отправлено письмо со ссылкой для подтверждения. Перейдите по ссылке в письме, чтобы завершить изменение.<br />Не нашли письмо? Проверьте папку «Спам».</div>
			<a 
				href="#cabinet-me-confirm" data-remodal-target="cabinet-me-confirm"
				class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center cabinet-text-size-button" 
				rel="nofollow"
			><noindex>Подтвердить</noindex></a>
		</div>
	</div>
</div>

<!-- Модальное окно: Подтверждение действия по оферу -->
<div class="remodal" data-remodal-id="cabinet-offer-confirm" >
    <button data-remodal-action="close" class="remodal-close"></button>
	<div class="row">
		<div class="col-12">
			<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/user-attention.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/user-attention.svg');?>" alt="" />
			<div class="remodal-title text-plus c-yablack fw-bold mt-4">Подтвердите действие:</div>
			<div class="remodal-title text-plus c-yadarkgreen text-uppercase mt-4 d-none" role="confim-action" data-action="accept">Согласиться</div>
			<div class="remodal-title text-plus c-yared text-uppercase mt-4 d-none" role="confim-action" data-action="refuse">Отказаться</div>
			<div class="remodal-description c-yadarkgray text-minus my-4">На Ваш номер телефона будет направлен код подтверждения. Если код не приходит, нажмите «Запросить код повторно».</div>
			<form class="row mt-3" method="post">
				<?= bitrix_sessid_post() ?>
				<input type="hidden" name="FORM" value="CONFIM_OFFER" /> 
				<input type="hidden" name="GUID" value="<?= HtmlFilter::encode($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'] ?? '');?>" /> 
				<input type="hidden" name="ACTION" value="<?= HtmlFilter::encode($_POST['ACTION'] ?? '');?>" /> 
				<input type="hidden" name="VIN" value="<?= HtmlFilter::encode($_POST['VIN'] ?? '');?>" /> 
				<input type="hidden" name="DOC" value="<?= HtmlFilter::encode($_POST['DOC'] ?? '');?>" /> 
                <?php if (($status ?? 'offer_start') == 'offer_start') { ?>
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
				<?php if (($status ?? '') == 'offer_code') { ?>
                    <?php if (empty($timeout)) { ?>
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
                    <?php if (!empty($timeout)) { ?>
                    <div class="col-12 mb-3">
                        <div class="c-yared">Срок действия кода истек</div>
                    </div>
                    <div class="col-12 mb-3">
                        <a href="/cabinet/recovery/" class="text-minus c-yamiddlegray c-h-yamiddlegray">
                            <img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/icon-repeat.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/icon-repeat.svg');?>" alt="" />
                            Запросить код повторно
                        </a>
                    </div>
                    <?php } ?>
                    <?php if (!empty($error)) { ?>
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
                <?php if (($status ?? '') == 'offer_send') { ?>
					<?php if (!empty($confim)) { ?>
					<div class="col-12 mb-3">
						<div class="text-success fw-bold">Действие успешно выполнено</div>
					</div>
					<?php } else { ?>
					<div class="col-12 mb-3">
						<div class="c-yared">Что-то пошло не так. Попробуйте повторить позже.</div>
					</div>
					<?php } ?>
				<?php } ?>
            </form>
		</div>
	</div>
</div>

<!-- Модальное окно: Удаление аккаунта -->
<div class="remodal" data-remodal-id="cabinet-me-delete" >
    <button data-remodal-action="close" class="remodal-close"></button>
	<div class="row">
		<div class="col-12">
			<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/user-delete.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/user-delete.svg');?>" alt="" />
			<div class="remodal-title text-plus c-yablack fw-bold mt-4">Помогите нам стать лучше</div>
			<div class="remodal-description c-yadarkgray text-minus my-4">Укажите причину удаления аккаунта:</div>
			<form class="row mt-3" method="post">
				<?= bitrix_sessid_post() ?>
				<input type="hidden" name="FORM" value="DELETE_ACCOUNT" /> 
				<input type="hidden" name="GUID" value="<?= HtmlFilter::encode($GLOBALS['CABINET_USER']['PROPERTY_GUID_VALUE'] ?? '');?>" /> 
                <div class="col-12 mb-3 text-start">
					<div class="form-group text-minus c-yamiddlegray">
						<div class="form-check d-flex justify-content-between align-items-center">
							<span class="list-num b-radius-c-yaradius bg-yalightgray fw-bold me-3 d-flex justify-content-center align-items-center <?= ((($_POST['REASON'] ?? '') == 'Продал автомобиль и услуги больше не требуются') ? 'c-yablack' : '');?>">1</span>
							<label class="form-check-label <?= ((($_POST['REASON'] ?? '') == 'Продал автомобиль и услуги больше не требуются') ? 'c-yablack' : '');?>" for="reason1" style="width: 70%;">Продал автомобиль и услуги больше не требуются;</label>
							<input 
								class="form-check-input ms-3" 
								type="radio" 
								name="REASON" 
								id="reason1" 
								value="Продал автомобиль и услуги больше не требуются"
								<?= ((($_POST['REASON'] ?? '') == 'Продал автомобиль и услуги больше не требуются') ? 'checked' : '');?>
							/>
						</div>
						<div class="form-check d-flex justify-content-between align-items-center">
							<span class="list-num b-radius-c-yaradius bg-yalightgray fw-bold me-3 d-flex justify-content-center align-items-center <?= ((($_POST['REASON'] ?? '') == 'Передумал продавать автомобиль') ? 'c-yablack' : '');?>">2</span>
							<label class="form-check-label <?= ((($_POST['REASON'] ?? '') == 'Передумал продавать автомобиль') ? 'c-yablack' : '');?>" for="reason2" style="width: 70%;">Передумал продавать автомобиль;</label>
							<input 
								class="form-check-input ms-3" 
								type="radio" 
								name="REASON" 
								id="reason2" 
								value="Передумал продавать автомобиль"
								<?= ((($_POST['REASON'] ?? '') == 'Передумал продавать автомобиль') ? 'checked' : '');?>
							/>
						</div>
						<div class="form-check d-flex justify-content-between align-items-center">
							<span class="list-num b-radius-c-yaradius bg-yalightgray fw-bold me-3 d-flex justify-content-center align-items-center <?= ((($_POST['REASON'] ?? '') == 'Не понравилась работа в личном кабинете комитента') ? 'c-yablack' : '');?>">3</span>
							<label class="form-check-label <?= ((($_POST['REASON'] ?? '') == 'Не понравилась работа в личном кабинете комитента') ? 'c-yablack' : '');?>" for="reason3" style="width: 70%;">Не понравилась работа в личном кабинете комитента;</label>
							<input 
								class="form-check-input ms-3" 
								type="radio" 
								name="REASON" 
								id="reason3" 
								value="Не понравилась работа в личном кабинете комитента"
								<?= ((($_POST['REASON'] ?? '') == 'Не понравилась работа в личном кабинете комитента') ? 'checked' : '');?>
							/>
						</div>
						<div class="form-check d-flex justify-content-between align-items-center">
							<span class="list-num b-radius-c-yaradius bg-yalightgray fw-bold me-3 d-flex justify-content-center align-items-center <?= ((($_POST['REASON'] ?? '') == 'Другая причина') ? 'c-yablack' : '');?>">4</span>
							<label class="form-check-label <?= ((($_POST['REASON'] ?? '') == 'Другая причина') ? 'c-yablack' : '');?>" for="reason4" style="width: 70%;">Другая причина:</label>
							<input 
								class="form-check-input ms-3" 
								type="radio" 
								name="REASON" 
								id="reason4" 
								value="Другая причина"
								<?= ((($_POST['REASON'] ?? '') == 'Другая причина') ? 'checked' : '');?>
							/>
						</div>
						<div class="form-group ps-5 pe-2 mt-2">
							<input 
								type="text" 
								class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-2" 
								autocomplete="off"
								name="CUSTOM_REASON"
								value="<?= HtmlFilter::encode($_POST['CUSTOM_REASON'] ?? '');?>"
								<?= ((($_POST['REASON'] ?? '') != 'Другая причина') ? 'disabled' : '');?>
								placeholder="" />
						</div>
					</div>
				</div>
				<div class="col-12 mb-2 text-start">
					<div>Как бы мы могли улучшить свой сервис:</div>
				</div>
				<div class="col-12 mb-3">
					<div class="form-group">
						<textarea 
							class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3" 
							autocomplete="off"
							name="ADVICE"
							required
							placeholder=""><?= HtmlFilter::encode($_POST['ADVICE'] ?? '');?></textarea>
					</div>
				</div>
                <div class="col-12">
					<div class="form-group">
						<button 
                            type="submit" 
                            class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow border-0 text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block text-center w-100" 
                            rel="nofollow"
                        ><noindex>Отправить</noindex></button>
					</div>
				</div>
            </form>
		</div>
	</div>
	<script>
		$('input[name="REASON"]').change( function() {
			$('input[name="REASON"]').siblings('label,.list-num').removeClass('c-yablack');
			$(this).siblings('label,.list-num').addClass('c-yablack');
			if ( $(this).val() == 'Другая причина' ) {
				$('input[name="CUSTOM_REASON"]').attr({'disabled': false});
			} else {
				$('input[name="CUSTOM_REASON"]').attr({'disabled': true});
			}
		});
	</script>
</div>

<!-- Модальное окно: Смена пароля -->
<div class="remodal" data-remodal-id="cabinet-me-passwd" >
    <button data-remodal-action="close" class="remodal-close"></button>
	<div class="row">
		<div class="col-12">
			<img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/cabinet/user-lock.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].SITE_TEMPLATE_PATH.'/assets/images/cabinet/user-lock.svg');?>" alt="" />
            <div class="mt-3 cabinet-sign-title">Создайте новый пароль!</div>

            <div class="mt-3 cabinet-sign-description">
                <div>Основные требования пароля:</div>
                <div class="text-start mt-4">
                    <p class="fw-bold">Минимальная длина пароля - 8 символов<br />Пароль должен удовлетворять всем критериям:</p>
                    <ol>
                        <li>Содержать строчные буквы;</li>
                        <li>Содержать заглавные буквы;</li>
                        <li>Содержать цифры;</li>
                        <li>Содержать специальные символы: !@#$%^&*</li>
                    </ol>
                </div>
            </div>
			<?php if (empty($result['success'])) { ?>
            <form class="row mt-3" method="post">
				<?= bitrix_sessid_post() ?>
				<input type="hidden" name="FORM" value="CHANGE_PASSWD" /> 
                <div class="col-12 mb-3">
					<div class="form-group position-relative">
						<input 
							type="password" 
							class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3 cabinet-form-icon" 
							autocomplete="off"
							name="PASSWD"
							required
							placeholder="Текущий пароль *"
							maxlength="32" />
						<img src="/cabinet/images/icon-lock.svg" alt="" />
					</div>
				</div>
                <div class="col-12 mb-3">
					<div class="form-group position-relative">
						<input 
							type="password" 
							class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3 cabinet-form-icon" 
							autocomplete="off"
							name="NEWPASSWD"
							required
							placeholder="Новый пароль *"
							maxlength="32" />
						<img src="/cabinet/images/icon-lock.svg" alt="" />
					</div>
				</div>
                <div class="col-12 mb-3">
					<div class="form-group position-relative">
						<input 
							type="password" 
							class="form-control b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3 cabinet-form-icon" 
							autocomplete="off"
							name="CONFIMPASSWD"
							required
							placeholder="Повторите пароль *"
							maxlength="32" />
						<img src="/cabinet/images/icon-lock.svg" alt="" />
					</div>
				</div>
				<?php if (!empty($result['error'])) { ?>
				<div class="col-12 mb-3 text-center c-yared text-minus"><?= HtmlFilter::encode($result['description'] ?? '');?>.<br />Попробуйте еще раз.</div>
				<?php } ?>
                <div class="col-12">
					<div class="form-group">
						<button 
							type="submit"
							class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 d-block border-0 w-100 text-center cabinet-text-size-button" 
							rel="nofollow"
						><noindex>Подтвердить</noindex></button>
					</div>
				</div>
            </form>
			<?php } else { ?>
			<div class="col-12 mb-3 text-center"><?= HtmlFilter::encode($result['description'] ?? '');?></div>
			<?php } ?>
		</div>
	</div>
</div>
