<?php if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die(); ?>
<?php // $arResult['SETTINGS']['PROPERTY_TITLE_VALUE'] = str_replace('{{title}}', (($GLOBALS['TITLE'])?:'Выкуп авто'), $arResult['SETTINGS']['PROPERTY_TITLE_VALUE']); ?>
<!--noindex-->
<div class="remodal text-start" data-remodal-id="<?= $arResult['arForm']['SID'];?>">
	<button data-remodal-action="close" class="remodal-close"></button>
	<div class="row">
		<div class="col">
			<div class="h3 fw-normal"><?= (($GLOBALS['TITLE'])?:$arResult['SETTINGS']['PROPERTY_TITLE_VALUE']);?></div>
			<p class="text-plus c-yadarkgray"><?= $arResult['SETTINGS']['DETAIL_TEXT'];?></p>
		</div>
	</div>
	<div class="row mt-3" style="margin-top: -40px; display: none" role="success" style="margin-bottom: 5rem!important;"> 
		<div class="col">
			<div class="p-3 bg-yalightyellow c-yablack text-center  b-radius-yaradius-15">
				Спасибо за вашу заявку!<br />
				Мы свяжемся с Вами в ближайшее время.
			</div>
		</div>
	</div>
	<div class="row my-3" style="margin-top: -40px; display: none" role="error">
		<div class="col">
			<div class="p-3 bg-yalightred c-yablack text-center  b-radius-yaradius-15">
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
					<div class="col-12 mb-3">
						<div class="form-group">
							<input 
								type="text" 
								class="form-control  b-radius-yaradius-15" 
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
								class="form-control  b-radius-yaradius-15" 
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
								type="phone" 
								class="form-control  b-radius-yaradius-15" 
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
						<div 
							id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_modal" 
							mode="single" 
							api_data="dealerships" 
							get_params="mode=all"
							select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_modal"
							parent_name="code"
							parent_var="SELECTED_DEALERSHIP_CODE--_modal"
							placeholder="Автосалон<?= (($arItem['REQUIRED'])?'*':'');?>"
							input_name="<?= $arItem['SID'];?>"
							name="yugavto-multiselect"
							<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
								required="Y"
							<?php } // if REQUIRED ?>
							></div>
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
						<div 
							id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_modal" 
							mode="single" 
							api_data="dealerships" 
							get_params="tag=service"
							select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_modal"
							parent_name="code"
							parent_var="SELECTED_DEALERSHIP_CODE--_modal"
							placeholder="Автосалон<?= (($arItem['REQUIRED'])?'*':'');?>"
							input_name="<?= $arItem['SID'];?>"
							name="yugavto-multiselect"
							<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
								required="Y"
							<?php } // if REQUIRED ?>
							></div>
						<?php
						}
						break;

					case 'DEALERSHIP_NEW':
						?>
						<div 
							id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_modal" 
							mode="single" 
							api_data="dealerships" 
							get_params="mode=new"
							select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_modal"
							parent_name="code"
							parent_var="SELECTED_DEALERSHIP_CODE--_modal"
							placeholder="Автосалон<?= (($arItem['REQUIRED'])?'*':'');?>"
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
							id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_modal" 
							mode="single" 
							api_data="dealerships" 
							get_params="mode=used"
							select_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_modal"
							parent_name="code"
							parent_var="SELECTED_DEALERSHIP_CODE--_modal"
							placeholder="Автосалон<?= (($arItem['REQUIRED'])?'*':'');?>"
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
							id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_modal" 
							mode="single" 
							api_data="brands" 
							select_var="SELECTED_BRAND--<?= $arResult['arForm']['SID'];?>_modal"
							parent_name="dealership"
							parent_var="SELECTED_DEALERSHIP--<?= $arResult['arForm']['SID'];?>_modal"
							placeholder="Марка<?= (($arItem['REQUIRED'])?'*':'');?>"
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
							id="yugavto-multiselect-<?= $arResult['arForm']['SID'];?>-<?= $arItem['SID'];?>_modal" 
							mode="single" 
							api_data="models" 
							select_var="SELECTED_MODEL--<?= $arResult['arForm']['SID'];?>_modal"
							parent_name="brand"
							parent_var="SELECTED_BRAND--<?= $arResult['arForm']['SID'];?>_modal"
							placeholder="Модель<?= (($arItem['REQUIRED'])?'*':'');?>"
							input_name="<?= $arItem['SID'];?>"
							name="yugavto-multiselect"
							<?php if ( $arItem['REQUIRED'] == 'Y' ) { ?>
								required="Y"
							<?php } // if REQUIRED ?>
							></div>
						<?php
						break;

				case 'COMMENT':
					?>
					<div class="col-12 mb-3">
						<div class="form-group">
							<textarea
								class="form-control  b-radius-yaradius-15"
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
					<div class="col-12 mb-3">
						<div class="form-group">
							<input 
								type="text" 
								class="form-control  b-radius-yaradius-15" 
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

			} // switch FIELD ?>

		<?php } // foreach FIELDS ?>

		<div class="col-6">
			<div class="form-group">
				<a 
					href="#" 
					class="d-block text-center c-yalightblack c-h-yalightblack bg-yayellow text-decoration-none  b-radius-yaradius-15 but d-flex justify-content-center align-items-center" role="sendForm"
					data-name="Сайт | <?= $arResult['SETTINGS']['NAME'];?> | Модальная"
					role="sendForm"
					><?= $arResult['arForm']['BUTTON'];?></a>
			</div>
		</div>
		<div class="col-12 mt-4 form-agree text-minus-minus c-yamiddlegray">
			<div class="form-check">
				<input class="form-check-input" type="checkbox" value="" id="AGRYY_<?= $arResult['arForm']['ID'];?>" name="AGRYY" />
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

<?php 
	foreach ( glob($_SERVER['DOCUMENT_ROOT'].'/local/vue-apps/dealerships-multiselect/dist/js/*.js') as $file ) {

		$arF = explode('/', $file);
		$this->addExternalJS('/local/vue-apps/dealerships-multiselect/dist/js/'.$arF[count($arF)-1]);
	}
?>