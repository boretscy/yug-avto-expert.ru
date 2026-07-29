<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>

<?php if ( $arResult['SETTINGS']['PROPERTY_BACKGROUND_VALUE'] ) { ?>
<div class="bg-yalightgray">
<?php } // if BACKGROUND ?>
<!--noindex-->
<div class="container py-5">
	<div class="row mb-5 align-items-center">
		<div class="col-12 col-md<?= (($arResult['SETTINGS']['PROPERTY_IMAGE_VALUE'])?'-8':'');?> pt-2">
			<div class="fw-normal pb-3 h3">
				<?= $arResult['SETTINGS']['PROPERTY_TITLE_VALUE'];?>
				<?php if ($GLOBALS['FORMS'][$arResult['arForm']['SID']]['ADDITIONAL_TITLE']) { ?>
				<?= $GLOBALS['FORMS'][$arResult['arForm']['SID']]['ADDITIONAL_TITLE'];?>
				<?php } // if ADDITIONAL_TITLE ?>
			</div>
			<p class="text-plus c-yadarkgray"><?= $arResult['SETTINGS']['DETAIL_TEXT'];?></p>
		</div>
		<?php if ( $arResult['SETTINGS']['PROPERTY_IMAGE_VALUE'] ) { ?>
		<div class="col-4 desktop">
			<img src="<?= CFile::GetPath($arResult['SETTINGS']['PROPERTY_IMAGE_VALUE']);?>" alt="" class="d-block" style="margin-left: auto; width: 70%;"/>
		</div>
		<?php } // if PICTURE ?>
	</div>
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
			
			<div class="col-md-6 col-lg-3 mb-3">
				<div class="form-group">
					
					<?php switch ( $arItem['SID'] ) {

						case 'NAME':
							?>
							<input 
								type="text" 
								class="form-control b-radius-small" 
								name="<?= $arItem['SID'];?>"
								id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
								<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
									required
								<?php } // if REQUIRED ?>
								placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>" />
							<?php
							break;

						case 'EMAIL':
							?>
							<input 
								type="email" 
								class="form-control b-radius-small" 
								name="<?= $arItem['SID'];?>"
								id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
								<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
									required
								<?php } // if REQUIRED ?>
								placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>" />
							<?php
							break;

						case 'PHONE':
							?>
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
							<?php
							break;

						case 'DEALERSHIP':
							?>
							<div 
								id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_line" 
								mode="single" 
								api_data="dealerships" 
								get_params="mode=all"
								select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_line"
								parent_name="code"
								parent_var="SELECTED_DEALERSHIP_CODE--_line"
								placeholder="Автосалон"
								input_name="<?= $arItem['SID'];?>"
								name="yugavto-multiselect"
								<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
									required="Y"
								<?php } // if REQUIRED ?>
								></div>
							<?php
							break;

						case 'DEALERSHIP_NEW':
							?>
							<div 
								id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_line" 
								mode="single" 
								api_data="dealerships" 
								get_params="mode=new"
								select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_line"
								parent_name="code"
								parent_var="SELECTED_DEALERSHIP_CODE--_line"
								placeholder="Автосалон"
								input_name="<?= $arItem['SID'];?>"
								name="yugavto-multiselect"
								<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
									required="Y"
								<?php } // if REQUIRED ?>
								></div>
							<?php
							break;

						case 'DEALERSHIP_USED':
							?>
							<div 
								id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_line" 
								mode="single" 
								api_data="dealerships" 
								get_params="mode=used"
								select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_line"
								parent_name="code"
								parent_var="SELECTED_DEALERSHIP_CODE--_line"
								placeholder="Автосалон"
								input_name="<?= $arItem['SID'];?>"
								name="yugavto-multiselect"
								<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
									required="Y"
								<?php } // if REQUIRED ?>
								></div>
							<?php
							break;

						case 'DEALERSHIP_CHUNK':
							?>
							<div 
								id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_line" 
								mode="single" 
								api_data="dealerships" 
								select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_line"
								placeholder="Автосалон"
								input_name="<?= $arItem['SID'];?>"
								name="yugavto-multiselect"
								<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
									required="Y"
								<?php } // if REQUIRED ?>
								></div>
							<?php
							break;
						
						case 'BRAND':
							?>
							<div 
								id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_line" 
								mode="single" 
								api_data="brands" 
								select_var="SELECTED_BRAND--<?= $arResult['arForm']['SID'];?>_line"
								parent_name="dealership"
								parent_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_line"
								placeholder="Марка"
								input_name="<?= $arItem['SID'];?>"
								name="yugavto-multiselect"
								<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
									required="Y"
								<?php } // if REQUIRED ?>
								></div>
							<?php
							break;
						
						case 'MODEL':
							?>
							<div 
								id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_line" 
								mode="single" 
								api_data="models" 
								select_var="SELECTED_MODEL--<?= $arResult['arForm']['SID'];?>_line"
								parent_name="brand"
								parent_var="SELECTED_BRAND--<?= $arResult['arForm']['SID'];?>_line"
								placeholder="Модель"
								input_name="<?= $arItem['SID'];?>"
								name="yugavto-multiselect"
								<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
									required="Y"
								<?php } // if REQUIRED ?>
								></div>
							<?php
							break;

						default:
							?>
							<input 
								type="text" 
								class="form-control b-radius-small" 
								name="<?= $arItem['SID'];?>"
								id="<?= $arItem['SID'];?>_<?= $arResult['arForm']['ID'];?>" 
								<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
									required
								<?php } // if REQUIRED ?>
								placeholder="<?= $arItem['TITLE'];?><?= (($arItem['REQUIRED'] == 'Y')?'*':'');?>" />
							<?php
							break;
						} // switch FIELD
					?>
				</div>
			
			</div>

		<?php } // foreach FIELDS ?>

		<div class="col-md-6 col-lg-3 mb-3 mb-lg-0">
			<div class="form-group">
				<a 
					href="#" 
					class="d-block text-center c-yawhite c-h-yablack bg-yadarkblue bg-h-yayellow text-decoration-none b-radius-small but" 
					data-name="Сайт | <?= $arResult['SETTINGS']['NAME'];?>."
					role="sendForm"
					><?= $arResult['arForm']['BUTTON'];?></a>
			</div>
		</div>
		<div class="col-12 mt-4 form-agree c-yamiddlegray">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="" id="AGRYY_<?= $arResult['arForm']['ID'];?>" name="AGRYY">
				<label class="form-check-label text-minus-minus" for="AGRYY_<?= $arResult['arForm']['ID'];?>">
					Нажимая кнопку, я подтверждаю свое ознакомление с <a href="/about/personal-data-policy.php" target="_blank" class="text-decoration-none c-yablue c-h-yadarkblue">политикой обработки персональных данных</a> и даю согласие на их обработку
				</label>
			</div>
		</div>
		<div class="form-cover d-none justify-content-center align-items-center">
			<div class="loader"></div>
		</div>
	</form>
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