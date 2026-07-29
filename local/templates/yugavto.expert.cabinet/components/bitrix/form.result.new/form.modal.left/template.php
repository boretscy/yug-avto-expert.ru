<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<div class="position-fixed p-4 forms-modal bg-yawhite h-100 top-0" data-form="<?= $arResult['arForm']['SID'];?>">
    <div class="d-flex justify-content-end">
        <a href="#" class="forms-modal-close">
            <img class="" src="<?= SITE_TEMPLATE_PATH.'/assets/images/svg/cross-modal.svg';?>" />
        </a>
    </div>
    <div class="forms-modal-content">
		<div class="row">
			<div class="col">
				<div class="h3 c-yadarkgray fw-normal mb-5"><noindex><?= $arResult['SETTINGS']['~PROPERTY_TITLE_VALUE'];?></noindex></div>
			</div>
		</div>
		<div class="row" role="description">
			<div class="col">
				<p class="text-plus c-yadarkgray"><noindex><?= $arResult['SETTINGS']['DETAIL_TEXT'];?></noindex></p>
			</div>
		</div>
		<div class="form">
			<div>
				<div>
					<div class="form-card">
						<form class="row text-minus" data-sid="<?= $arResult['arForm']['SID'];?>">
							<input type="hidden" name="FORM_ID" value="<?= $arResult['arForm']['ID'];?>" />
							<input type="hidden" name="FORM" value="<?= $arResult['SETTINGS']['PROPERTY_TITLE_VALUE'];?>" />
							<input type="hidden" name="SSID" value="<?= $_SESSION['fixed_session_id'];?>" />
							<?php foreach ( $arResult['arQuestions'] as $arItem ) { ?>
								<?php switch ( $arItem['SID'] ) {

									case 'NAME':
									case 'SECOND_NAME':
									case 'LAST_NAME':
									case 'POSITION':
									case 'COMPANY':
									case 'SCOPE_OF_WORK':
										?>
										<div class="col-12 mb-3">
											<div class="form-group">
												<input 
													type="text" 
													class="b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3" 
													autocomplete="off"
													name="<?= $arItem['SID'];?>"
													id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
													<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
														required
													<?php } // if REQUIRED ?>
													placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>" />
											</div>
										</div>
										<?php 
										break;
									
									case 'EMAIL':
										?>
										<div class="col-12 mb-3">
											<div class="form-group">
												<input 
													type="email" 
													class="b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3" 
													autocomplete="off"
													name="<?= $arItem['SID'];?>"
													id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
													<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
														required
													<?php } // if REQUIRED ?>
													placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>" />
											</div>
										</div>
										<?php 
										break;

									case 'PHONE':
										?>
										<div class="col-12 mb-3">
											<div class="form-group">
												<input 
													type="email" 
													class="b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3" 
													autocomplete="off"
													name="<?= $arItem['SID'];?>"
													id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
													<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
														required
													<?php } // if REQUIRED ?>
													placeholder="+7 ___ ___ __ __<?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>"
													data-phone-pattern = "+7 ___ ___ __ __"
													maxlength="16" />
											</div>
										</div>
										<?php 
										break;

									case 'DEALERSHIP':
										?>
										<div class="col-12 mb-3">
											<input 
												type="hidden" 
												<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
													required
												<?php } // if REQUIRED ?>
												name="<?= $arItem['SID'];?>" />
											<div class="form-group">
												<div class="filter-dropcontainer position-relative">
													<div class="b-radius-yaradius-15 y filter-dropdown d-flex justify-content-between c-yadarkgray b-yalightgray position-relative">
														<span><noindex><?= $arItem['TITLE'];?> (все) <?= (($arItem['REQUIRED'] == 'Y')?'*':'');?></noindex></span>
														<span><img src="<?= SITE_TEMPLATE_PATH;?>/assets/images/svg/drop-corner.svg" /></span>
													</div>
													<div class="filter-droplist bg-yawhite w-100 position-absolute d-none">
														<?php foreach ( $arResult['DEALERSHIPS'] as $item ) { ?>
															<?php if ( $item['code'] != 'none' ) { ?>
															<a href="#" 
																class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray"
																data-text="<?= $item['name'];?>"
																data-value="<?= $item['code'];?>"
																rel=“nofollow”
																><noindex><?= $item['name'];?></noindex></a>
															<?php } else { ?>
															<span class="filter-droplist-item not-link py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray"><?= $item['name'];?></span>
															<?php } ?>
														<?php } ?>
													</div>
												</div>
											</div>
										</div>
										<?php
										break;

									case 'COMMENT':
									?>
									<div class="col-12 mb-3">
										<div class="form-group">
											<textarea
												class="b-radius-yaradius-15 y c-yadarkgray w-100 px-4 py-3" 
												name="<?= $arItem['SID'];?>"
												id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
												rows="1"
												<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
													required
												<?php } // if REQUIRED ?>
												placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>"
												></textarea>
										</div>
									</div>
									<?php
									break;
								} ?>
							<?php } // QUESTIONS  ?>
							<div class="col-12 mb-5 c-yadarkgray text-minus-minus">
								<div class="form-check">
									<input class="form-check-input me-2" type="checkbox" value="" id="AGRYY_<?= $arResult['arForm']['ID'];?>" name="AGRYY"  />
									<label class="form-check-label text-minus-minus" for="AGRYY_<?= $arResult['arForm']['ID'];?>">
										<noindex>Даю согласие на обработку своих <a href="/about/personal-data-permission.php" target="_blank" class="c-yablack c-h-yablack">персональных данных</a> и соглашаюсь с <a href="/about/personal-data-policy.php" target="_blank" class="c-yablack c-h-yablack">политикой обработки персональных данных</a></noindex>
									</label>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									<a 
										href="#" 
										class="c-yablack c-h-yablack bg-yayellow bg-h-yadarkyellow text-decoration-none b-radius-yaradius-15 py-3 px-5 block-title" 
										role="sendForm"
										rel=“nofollow”
										data-name="Сайт | <?= $arResult['SETTINGS']['NAME'];?> | Модальная"
										><noindex><?= $arResult['arForm']['BUTTON'];?></noindex></a>
								</div>
							</div>
						</form>
						<div class="row mb-3 w-100" style="display: none;" role="success">
							<div class="col">
								<div class="p-3 bg-yawhite c-yablack text-center b-radius-small">
									<noindex>Спасибо за вашу заявку!<br />
									Мы свяжемся с Вами в ближайшее время.</noindex>
								</div>
							</div>
						</div>
						<div class="row mb-3 w-100" style="display: none;" role="error">
							<div class="col">
								<div class="p-3 y c-yablack text-center b-radius-small">
									<noindex>Ой, что-то пошло не так.<br />
									Повторите попытку позднее.</noindex>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

    </div>
</div>