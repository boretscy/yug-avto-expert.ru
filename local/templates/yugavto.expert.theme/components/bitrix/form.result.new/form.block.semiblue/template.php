<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php // $arResult['SETTINGS']['PROPERTY_TITLE_VALUE'] = str_replace('{{title}}', (($GLOBALS['TITLE'])?:'Выкуп авто'), $arResult['SETTINGS']['PROPERTY_TITLE_VALUE']); ?>
<!--noindex-->
<a id="FORM_BUYOUT_BUYOUT"></a>
<div class="position-relative">
	<div class="bg-yablue w-100 position-absolute blue-cover"></div>
    <div class="container">
		<div class="row mb-5 bg-yalightyellow p-2 p-md-5 b-radius-yaradius-50" style="display: none" role="success">
			<div class="col">
				Спасибо за вашу заявку!<br />
				Мы свяжемся с Вами в ближайшее время.
			</div>
		</div>
		<div class="row mb-5 bg-yalighred p-2 p-md-5 b-radius-yaradius-50" style="display: none" role="error">
			<div class="col">
				Ой, что-то пошло не так.<br />
				Повторите попытку позднее.
			</div>
		</div>
        <form class="row bg-yawhite p-2 p-md-5 b-radius-yaradius-50" id="form-block-semiblue" data-sid="<?= $arResult['arForm']['SID'];?>">
			<input type="hidden" name="FORM_ID" value="<?= $arResult['arForm']['ID'];?>" />
            <div class="col-lg-4 d-lg-none pb-5 mb-5 form-block-semiblue position-relative">
                <img class="w-100" src="<?= CFile::GetPath($arResult['SETTINGS']['PROPERTY_IMAGE_VALUE']);?>" />
				<?php if ( $arResult['SETTINGS']['PREVIEW_PICTURE'] ) { ?>
                <img class="position-absolute moved-car" src="<?= CFile::GetPath($arResult['SETTINGS']['PREVIEW_PICTURE']);?>" />
				<?php } ?>
            </div>
            <div class="col-lg-8 pe-lg-5">
                <div class="row pt-4">
					<?php foreach ( $arResult['arQuestions'] as $arItem ) { ?>

						<?php switch ( $arItem['SID'] ) {

							case 'NAME':
								?>
								<div class="col-md-6 mb-4">
									<div class="form-floating ">
										<input 
											type="text" 
											class="form-control b-radius-yaradius-15" 
											name="<?= $arItem['SID'];?>"
											id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
											<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
												required
											<?php } // if REQUIRED ?>
											placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>" />
										<label for="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>"><?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'<sup>*</sup>':'');?></label>
									</div>
								</div>
								<?php
								break;

							case 'PHONE':
								?>
								<div class="col-md-6 mb-4">
									<div class="form-floating">
										<input 
											type="phone" 
											class="form-control b-radius-yaradius-15" 
											name="<?= $arItem['SID'];?>"
											id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
											<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
												required
											<?php } // if REQUIRED ?>
											placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>"
											data-phone-pattern = "+7 ___ ___ __ __"
											maxlength="16" />
										<label for="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>"><?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'<sup>*</sup>':'');?></label>
									</div>
								</div>
								<?php
								break;

								case 'DEALERSHIP':
									?>
									<div class="col-md-12 mb-2">
										<div 
											id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_block-semiblue" 
											mode="single" 
											api_data="dealerships" 
											get_params="mode=all"
											select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_block-semiblue"
											parent_name="code"
											parent_var="SELECTED_DEALERSHIP_CODE--_block-semiblue"
											placeholder="Автосалон"
											input_name="<?= $arItem['SID'];?>"
											name="yugavto-multiselect"
											<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
												required="Y"
											<?php } // if REQUIRED ?>
											></div>
									</div>
									<?php
									break;

							case 'CAR':
								?>
								<div class="col-md-12 mb-4">
									<div class="row">
										<div class="col-lg-6 col-xl-4 d-none d-lg-block pe-2 pe-md-0">
											<div class="input-label ps-3 d-flex align-items-center">
												Ускорьте процесс оценки
											</div>
										</div>
										<div class="col ps-lg-0">
											<div class="form-floating position-relative">
												<input 
													type="text" 
													class="form-control pe-5 labeled" 
													name="<?= $arItem['SID'];?>"
													id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>"
													placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>" />
												<label for="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>">Укажите автомобиль</label>
											</div>
										</div>
									</div>
								</div>
								<?php
								break;
							
							case 'COMMENT':
								?>
								<div class="col-md-12 mb-2">
									<div class="form-floating position-relative">
										<textarea 
											class="form-control b-radius-yaradius-15 <?= (($arItem['COMMENTS'])?'pe-5':'');?>" 
											placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>" 
											id="COMMENT" 
											name="<?= $arItem['SID'];?>"
											></textarea>
										<label for="COMMENT"><?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?></label>
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
											class="form-control b-radius-yaradius-15" 
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
                    <div class="col-md-12 my-3">
                        <a 
                            href="#" 
                            class="d-flex align-items-center justify-content-center d-md-inline text-center c-yablack c-h-yablack bg-yadarkyellow bg-h-yayellow text-decoration-none b-radius-yaradius-15 but button-send py-3 px-5" 
                            role="sendForm"
							data-form="FORM.BLOCK.SEMIBLUE"
							data-name="Сайт | <?= $arResult['SETTINGS']['NAME'];?>."
                            ><?= $arResult['arForm']['BUTTON'];?></a>
                    </div>
                    <div class="col-md-12 my-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="" id="AGRYY_<?= $arResult['arForm']['ID'];?>" name="AGRYY" />
                            <label class="form-check-label text-minus-minus" for="AGRYY_<?= $arResult['arForm']['ID'];?>">
								Нажимая кнопку, я подтверждаю свое ознакомление с <a href="/about/personal-data-policy.php" target="_blank" class="text-decoration-none c-yayellow">политикой обработки персональных данных</a> и даю согласие на их обработку
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 d-none d-lg-block form-block-semiblue position-relative moveded-car">
                <img class="w-100" src="<?= CFile::GetPath($arResult['SETTINGS']['PROPERTY_IMAGE_VALUE']);?>" />
                <img class="position-absolute moved-car" src="<?= CFile::GetPath($arResult['SETTINGS']['PREVIEW_PICTURE']);?>" />
            </div>
        </form>
    </div>
</div>
<!--/noindex-->
<?php 
	foreach ( glob($_SERVER['DOCUMENT_ROOT'].'/local/vue-apps/dealerships-multiselect/dist/js/*.js') as $file ) {

		$arF = explode('/', $file);
		$this->addExternalJS('/local/vue-apps/dealerships-multiselect/dist/js/'.$arF[count($arF)-1]);
	}
?>

