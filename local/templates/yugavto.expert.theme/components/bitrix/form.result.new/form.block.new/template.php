<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php if ( $arResult['SETTINGS']['PROPERTY_BACKGROUND_VALUE'] ) { ?>
<div class="position-relative">
<div class="position-absolute bg-yablue blue-form-cover transition-none w-100"></div>
<?php } // if BACKGROUND ?>
<!--noindex-->
<div class="container p-5 pt-0 b-radius-yaradius-50 bg-yawhite">
	<div class="row">
		<?php if ( $arResult['SETTINGS']['DETAIL_PICTURE'] ) { ?>
		<div class="col-lg-5">
			<img src="<?= CFile::GetPath($arResult['SETTINGS']['DETAIL_PICTURE']);?>" alt="" class="w-100 d-block" style="margin: 0 auto"/>
		</div>
		<?php } // if PICTURE ?>
		<div class="col-12 col-md-12 col-lg<?= (($arResult['SETTINGS']['DETAIL_PICTURE'])?'-7':'');?> pt-5 mt-2">
			<div class="row mt-3" style="margin-top: -40px; display: none" role="success" style="margin-bottom: 5rem!important;"> 
				<div class="col">
					<div class="p-3 bg-yalightyellow c-yablack text-center b-radius-small">
						Спасибо за вашу заявку!<br />
						Мы свяжемся с Вами в ближайшее время.
					</div>
				</div>
			</div>
			<div class="row my-3" style="margin-top: -40px; display: none" role="error">
				<div class="col">
					<div class="p-3 bg-yalightred c-yablack text-center b-radius-small">
						Ой, что-то пошло не так.<br />
						Повторите попытку позднее.
					</div>
				</div>
			</div>
			<form class="row position-relative" data-sid="<?= $arResult['arForm']['SID'];?>">
				<input type="hidden" name="FORM_ID" value="<?= $arResult['arForm']['ID'];?>" />
				<?php foreach ( $arResult['arQuestions'] as $arItem ) { ?>
			
				
						<?php switch ( $arItem['SID'] ) {

							case 'NAME':
								?>
								<div class="col-md-6 mb-4">
									<div class="form-group">
										<input 
											type="text" 
											class="form-control b-radius-yaradius-15 px-3" 
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
								<div class="col-md-6 mb-4">
									<div class="form-group">
										<input 
											type="email" 
											class="form-control b-radius-yaradius-15 px-3" 
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
								<div class="col-md-6 mb-4">
									<div class="form-group">
										<input 
											type="phone" 
											class="form-control b-radius-yaradius-15 px-3" 
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
									if ( $GLOBALS['DEALERSHIP'] ) {
									?>
									<input type="hidden" name="DEALERSHIP" value="<?= $GLOBALS['DEALERSHIP'];?>">
									<?php
									} else {
									?>
									<div class="col-md-12">
										<div class="form-group">
											<div 
												id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_block" 
												mode="single" 
												api_data="dealerships" 
												get_params="mode=all"
												select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_block"
												parent_name="code"
												parent_var="SELECTED_DEALERSHIP_CODE--_block"
												placeholder="Автосалон<?= (($arItem['REQUIRED'])?'*':'');?>"
												input_name="<?= $arItem['SID'];?>"
												name="yugavto-multiselect"
												
												<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
													required="Y"
												<?php } // if REQUIRED ?>
												></div>
										</div>
									</div>
									<?php
									}
									break;
								
								case 'DEALERSHIP_SERVICE':
									if ( $GLOBALS['DEALERSHIP'] ) {
									?>
									<input type="hidden" name="DEALERSHIP" value="<?= $GLOBALS['DEALERSHIP'];?>">
									<?php
									} else {
									?>
									<div class="col-md-12">
										<div class="form-group">
											<div 
												id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_block" 
												mode="single" 
												api_data="dealerships" 
												get_params="tag=service"
												select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_block"
												parent_name="code"
												parent_var="SELECTED_DEALERSHIP_CODE--_block"
												placeholder="Автосалон<?= (($arItem['REQUIRED'])?'*':'');?>"
												input_name="<?= $arItem['SID'];?>"
												name="yugavto-multiselect"
												
												<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
													required="Y"
												<?php } // if REQUIRED ?>
												></div>
										</div>
									</div>
									<?php
									}
									break;
		
								case 'DEALERSHIP_NEW':
									?>
									<div class="col-md-12">
										<div class="form-group">
											<div 
												id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_block" 
												mode="single" 
												api_data="dealerships" 
												get_params="mode=new"
												select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_block"
												parent_name="code"
												parent_var="SELECTED_DEALERSHIP_CODE--_block"
												placeholder="Автосалон<?= (($arItem['REQUIRED'])?'*':'');?>"
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
									<div class="col-md-12">
										<div class="form-group">
											<div 
												id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_block" 
												mode="single" 
												api_data="dealerships" 
												get_params="mode=used"
												select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_block"
												parent_name="code"
												parent_var="SELECTED_DEALERSHIP_CODE--_block"
												placeholder="Автосалон<?= (($arItem['REQUIRED'])?'*':'');?>"
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
												placeholder="Марка<?= (($arItem['REQUIRED'])?'*':'');?>"
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
												placeholder="Модель<?= (($arItem['REQUIRED'])?'*':'');?>"
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
											class="form-control b-radius-yaradius-15 px-3"
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
											class="form-control b-radius-yaradius-15 px-3" 
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

				<div class="col-md-6">
					<div class="form-group">
						<a 
							href="#" 
							class="d-block text-center c-yalightblack c-h-yalightblack bg-yayellow text-decoration-none text-uppercase b-radius-yaradius-15 but d-flex justify-content-center align-items-center" 
							data-name="Сайт | <?= $arResult['SETTINGS']['NAME'];?>."
							role="sendForm"
							><?= $arResult['arForm']['BUTTON'];?></a>
					</div>
				</div>
				<div class="col-12 mt-4 form-agree c-yamiddlegray">
					<div class="form-check">
						<input class="form-check-input" type="checkbox" value="" id="AGRYY_<?= $arResult['arForm']['ID'];?>" name="AGRYY" />
						<label class="form-check-label text-minus-minus" for="AGRYY_<?= $arResult['arForm']['ID'];?>">
							Нажимая кнопку, я подтверждаю свое ознакомление с <a href="/about/personal-data-policy.php" target="_blank" class="text-decoration-none c-yayellow">политикой обработки персональных данных</a> и даю согласие на их обработку
						</label>
					</div>
				</div>
				<div class="form-cover d-none justify-content-center align-items-center">
					<div class="loader"></div>
				</div>

			</form>
		</div>
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