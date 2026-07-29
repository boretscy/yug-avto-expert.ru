<div class="remodal text-start" data-remodal-id="trade-in-modal">
	<button data-remodal-action="close" class="remodal-close"></button>
    <div class="row mt-3" style="margin-top: -40px; display: none" role="success"> 
		<div class="col">
			<div class="p-3 bg-yalightyellow c-yablack text-center  b-radius-yaradius-15">
				<noindex>Спасибо за вашу заявку!<br>
				Мы свяжемся с Вами в ближайшее время.</noindex>
			</div>
		</div>
	</div>
    <div class="row my-3" style="margin-top: -40px; display: none" role="error">
		<div class="col">
			<div class="p-3 bg-yalightred c-yablack text-center  b-radius-yaradius-15">
				<noindex>Ой, что-то пошло не так.<br>
				Повторите попытку позднее.</noindex>
			</div>
		</div>
	</div>
    <form data-mode="<?= $app->Conf()['Api']['mode'];?>">
        <input type="hidden" name="form" value="Оценим ваш автомобиль" />
        <div class="row">
            <div class="col-12 mb-3">
                <h4 class="fw-bold"><noindex>Оценим ваш автомобиль</noindex></h4>
            </div>
            <div class="col-12 mb-3">
                <p><noindex>Укажите свой автомобиль и получите его оценочную стоимость.</noindex></p>
            </div>
            <div class="col-12 mb-3">
                <div class="form-group">
                    <input type="text" class="form-control  b-radius-yaradius-15 px-3" placeholder="Имя *" name="name" required />
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="form-group">
                    <input type="phone" class="form-control  b-radius-yaradius-15 px-3" name="phone"required placeholder="+7 ___ ___ __ __ *" data-phone-pattern="+7 ___ ___ __ __" maxlength="16">
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="form-group">
                    <input type="text" class="form-control  b-radius-yaradius-15 px-3" placeholder="Ваш автомобиль" name="car" />
                </div>
            </div>
            <?php /*
            <div class="col-12 mb-3">
                <div class="form-group">
                    <input type="number" class="form-control  b-radius-yaradius-15 px-3" placeholder="Год выпуска *" name="year" required />
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="form-group">
                    <input type="text" class="form-control  b-radius-yaradius-15 px-3" placeholder="Состояние" name="condition" />
                </div>
            </div>
            */ ?>
            <div class="col-md-6 mb-3">
                <div class="form-group">
                    <a 
                        href="#" 
                        role="not-cover"
                        class="d-block text-center c-yalightblack c-h-yalightblack bg-yayellow text-decoration-none  b-radius-yaradius-15 but d-flex justify-content-center align-items-center" 
                        data-url="<?= $app->Conf()['baseUrl'];?>/api/"
                        action="sendShowroomForm"
                        rel=“nofollow”
                        ><noindex>Отправить</noindex></a>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="showroom-trade-in-aggry" name="aggry" />
                    <label class="form-check-label text-minus-minus" for="showroom-trade-in-aggry">
                        <noindex>Нажимая кнопку, я подтверждаю свое ознакомление с <a href="/about/personal-data-policy.php" target="_blank" class="text-decoration-none c-yablue c-h-yadarkblue">политикой обработки персональных данных</a> и даю согласие на их обработку</noindex>
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>