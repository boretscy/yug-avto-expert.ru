<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php if ( $arResult['SETTINGS']['PROPERTY_BACKGROUND_VALUE'] ) { ?>
<div class="bg-yalightgray mt-5">
<?php } // if BACKGROUND ?>
<!--noindex-->
<div class="container p-5 b-radius-small">
	<div class="row align-items-center">
		<div class="col-12 col-md-12 col-lg<?= (($arResult['SETTINGS']['PROPERTY_IMAGE_VALUE'])?'-8':'');?>">
			<div class="fw-normal h3"><noindex><?= $arResult['SETTINGS']['PROPERTY_TITLE_VALUE'];?></noindex></div>
			<p class="text-plus c-yadarkgray"><?= $arResult['SETTINGS']['DETAIL_TEXT'];?></p>
			<div class="row mt-3" style="margin-top: -40px; display: none" role="success" style="margin-bottom: 5rem!important;"> 
				<div class="col">
					<div class="p-3 bg-yalightyellow c-yablack text-center b-radius-small">
						<noindex>Спасибо за вашу заявку!<br />
						Мы свяжемся с Вами в ближайшее время.</noindex>
					</div>
				</div>
			</div>
			<div class="row my-3" style="margin-top: -40px; display: none" role="error">
				<div class="col">
					<div class="p-3 bg-yalightred c-yablack text-center b-radius-small">
						<noindex>Ой, что-то пошло не так.<br />
						Повторите попытку позднее.</noindex>
					</div>
				</div>
			</div>
			<form class="row position-relative" data-sid="<?= $arResult['arForm']['SID'];?>">
				<input type="hidden" name="FORM_ID" value="<?= $arResult['arForm']['ID'];?>" />
				<?php foreach ( $arResult['arQuestions'] as $arItem ) { ?>
			
				
						<?php switch ( $arItem['SID'] ) {

							case 'NAME':
								?>
								<div class="col-md-4 mb-2">
									<div class="form-group">
										<input 
											type="text" 
											class="form-control b-radius-small" 
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
								<div class="col-md-4 mb-2">
									<div class="form-group">
										<input 
											type="email" 
											class="form-control b-radius-small" 
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
								<div class="col-md-4 mb-2">
									<div class="form-group">
										<input 
											type="phone" 
											class="form-control b-radius-small" 
											name="<?= $arItem['SID'];?>"
											id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
											<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
												required
											<?php } // if REQUIRED ?>
											placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>"
											data-phone-pattern = "+7 ___ ___ __ __"
											maxlength="16" />
									</div>
								</div>
								<?php
								break;

								case 'DEALERSHIP':
									?>
									<div class="col-md-4 mb-2">
										<div class="form-group">
											<div 
												id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_block" 
												mode="single" 
												api_data="dealerships" 
												get_params="mode=all"
												select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_block"
												parent_name="code"
												parent_var="SELECTED_DEALERSHIP_CODE--_block"
												placeholder="Автосалон"
												input_name="<?= $arItem['SID'];?>"
												name="yugavto-multiselect"
												
												<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
													required="Y"
												<?php } // if REQUIRED ?>
												></div>
										</div>
									</div>
									<?php
									break;
		
								case 'DEALERSHIP_NEW':
									?>
									<div class="col-md-4 mb-2">
										<div class="form-group">
											<div 
												id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_block" 
												mode="single" 
												api_data="dealerships" 
												get_params="mode=new"
												select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_block"
												parent_name="code"
												parent_var="SELECTED_DEALERSHIP_CODE--_block"
												placeholder="Автосалон"
												input_name="<?= $arItem['SID'];?>"
												name="yugavto-multiselect"
												<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
													required="Y"
												<?php } // if REQUIRED ?>
												></div>
										</div>
									</div>
									<?php
									break;
		
								case 'DEALERSHIP_USED':
									?>
									<div class="col-md-4 mb-2">
										<div class="form-group">
											<div 
												id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_block" 
												mode="single" 
												api_data="dealerships" 
												get_params="mode=used"
												select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_block"
												parent_name="code"
												parent_var="SELECTED_DEALERSHIP_CODE--_block"
												placeholder="Автосалон"
												input_name="<?= $arItem['SID'];?>"
												name="yugavto-multiselect"
												<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
													required="Y"
												<?php } // if REQUIRED ?>
												></div>
										</div>
									</div>
									<?php
									break;
								
								case 'BRAND':
									?>
									<div class="col-md-4 mb-2">
										<div class="form-group">
											<div 
												id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_block" 
												mode="single" 
												api_data="brands" 
												select_var="SELECTED_BRAND--<?= $arResult['arForm']['SID'];?>_block"
												parent_name="dealership"
												parent_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_block"
												placeholder="Марка"
												input_name="<?= $arItem['SID'];?>"
												name="yugavto-multiselect"
												<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
													required="Y"
												<?php } // if REQUIRED ?>
												></div>
										</div>
									</div>
									<?php
									break;
								
								case 'MODEL':
									?>
									<div class="col-md-4 mb-2">
										<div class="form-group">
											<div 
												id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_block" 
												mode="single" 
												api_data="models" 
												select_var="SELECTED_MODEL--<?= $arResult['arForm']['SID'];?>_block"
												parent_name="brand"
												parent_var="SELECTED_BRAND--<?= $arResult['arForm']['SID'];?>_block"
												placeholder="Модель"
												input_name="<?= $arItem['SID'];?>"
												name="yugavto-multiselect"
												<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
													required="Y"
												<?php } // if REQUIRED ?>
												></div>
										</div>
									</div>
									<?php
									break;
							
							case 'COMMENT':
								?>
								<div class="col-md-12 mb-2">
									<div class="form-group">
										<textarea
											class="form-control b-radius-small"
											name="<?= $arItem['SID'];?>"
											id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
											rows="3"
											<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
												required
											<?php } // if REQUIRED ?>
											placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>"
											></textarea>
									</div>
								</div>
								<?php
								break;

							default:
								?>
								<div class="col-md-6 mb-2">
									<div class="form-group">
										<input 
											type="text" 
											class="form-control b-radius-small" 
											name="<?= $arItem['SID'];?>"
											id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
											<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
												required
											<?php } // if REQUIRED ?>
											placeholder="<?= $arItem['COMMENTS'];?>" />
									</div>
								</div>
								<?php
								break;
							} // switch FIELD
						?>

				<?php } // foreach FIELDS ?>

				<div class="col-12 col-md-6">
					<div class="form-group">
						<a 
							href="#" 
							class="d-block text-center c-yawhite c-h-yablack bg-yadarkblue bg-h-yayellow text-decoration-none b-radius-small but d-flex justify-content-center align-items-center" 
							data-name="Сайт | <?= $arResult['SETTINGS']['NAME'];?>."
							role="sendForm"
							><noindex><?= $arResult['arForm']['BUTTON'];?></noindex></a>
					</div>
				</div>
				<div class="col-12 col-md-6 md-mt-4 form-agree c-yamiddlegray">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="AGRYY_<?= $arResult['arForm']['ID'];?>" name="AGRYY" />
						<label class="form-check-label text-minus-minus" for="AGRYY_<?= $arResult['arForm']['ID'];?>">
							<noindex>Нажимая кнопку, я подтверждаю свое ознакомление с <a href="/about/personal-data-policy.php" target="_blank" class="text-decoration-none c-yayellow">политикой обработки персональных данных</a> и даю согласие на их обработку</noindex>
						</label>
					</div>
				</div>
				<div class="form-cover d-none justify-content-center align-items-center">
					<div class="loader"></div>
				</div>

			</form>
		</div>
		<?php if ( $arResult['SETTINGS']['PROPERTY_IMAGE_VALUE'] ) { ?>
		<div class="col-4 desktop">
			<img src="<?= CFile::GetPath($arResult['SETTINGS']['PROPERTY_IMAGE_VALUE']);?>" alt="" class="w-75 d-block" style="margin: 0 auto"/>
		</div>
		<?php } // if PICTURE ?>
	</div>
	<?php // YApp::sp($arResult); ?>
</div>
<!--/noindex-->

<?php if ( $arResult['SETTINGS']['PROPERTY_BACKGROUND_VALUE'] ) { ?>
</div>
<?php } // if BACKGROUND ?>

<?php 
	foreach ( glob($_SERVER['DOCUMENT_ROOT'].'/local/vue-apps/dealerships-multiselect/dist/js/*.js') as $file ) {

		$arF = explode('/', $file);
		$this->addExternalJS('/local/vue-apps/dealerships-multiselect/dist/js/'.$arF[count($arF)-1]);
	}
?>