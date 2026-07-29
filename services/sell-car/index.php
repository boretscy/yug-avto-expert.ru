<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
LocalRedirect("/services/buyout/");
$APPLICATION->SetPageProperty("description", "Срочный выкуп авто всех моделей и года выпуска, в любом состоянии: неисправный, битый, аварийный, не на ходу, кредитный, в залоге, с ограничениями на регистрационные действия");
$APPLICATION->SetTitle("Срочный выкуп и оценка автомобиля в Юг-Авто Эксперт Краснодар, Новороссийск");
?><div class="container mt-3 my-5">
        <div class="row">
            <div class="col">
                <h1 class="h1 mb-3 fw-normal">Выкуп и оценка автомобиля</h1>
                    <p>Время пришло… Ваш автомобиль служил вам верой и правдой, но появились причины с ним расстаться. <strong>Юг-Авто Эксперт</strong> выкупит Ваш автомобиль по рыночной стоимости за 2 часа! </p>
                    <p>В любом автоцентре <strong>Юг-Авто Эксперт</strong> наши специалисты проведут объективную оценку транспортного средства с учетом его состояния, года выпуска, пробега и предложат вам ценовое предложение, превышающее рыночный минимум на 10%. Мы рассчитаем реальную рыночную стоимость и предоставим ее в виде отчета, со всеми необходимыми параметрами для понимания текущей рыночной конъюнктуры. Если цена вас устроит, заключается договор и производится выкуп автомобиля.</p>
            </div>
            <div class="row four-col">
                <div class="col-6 col-md-3 text-center">
                    <p><img width="100" src="/services/sell-car/o1.png" height="100" alt="" title=""></p>
                    <p><strong>Быстро</strong><br>
                        Выкуп авто за день</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <p><img width="100" src="/services/sell-car/o2.png" height="100" alt="" title=""></p>
                    <p><strong>Выгодно</strong><br>
                        Оценка авто по рыночной цене</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <p><img width="100" src="/services/sell-car/o3.png" height="100" alt="" title=""></p>
                    <p><strong>Удобно</strong><br>
                        Все документы оформляются нашими специалистами.</p>
                </div>
                <div class="col-6 col-md-3 text-center">
                    <p><img width="100" src="/services/sell-car/o4.png" height="100" alt="" title=""></p>
                    <p><strong>Надежно</strong><br>
                        Сделка осуществляется согласно всем требованиям законодательства РФ.</p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h2 class="my-4 h4">Какие автомобили мы выкупаем?</h2>
                    <ul>
                        <li>с запретом на регистрационные действия;</li>
                        <li>с обременением;</li>
                        <li>лизинговые машины, находящиеся в залоге;</li>
                        <li>неисправные;</li>
                        <li>конфискованные, в том числе кредитные или после ДТП;</li>
                        <li>с возможностью заключения сделки в день обращения.</li>
                    </ul>
                    <p>Обращаясь к нам, вам не придется тратить время на поиск покупателей, делать предпродажную подготовку, общаться с потенциальными покупателями. Работая по четко отлаженной схеме, скупка авто в Краснодаре, Новороссийске возможна в день обращения. Наш оценщик произведет осмотр транспортного средства и огласит стоимость а/м. Если вы согласны на сделку и все документы находятся в порядке, получение средств осуществляется любым удобным для вас способом.</p>
                    <h2 class="my-4 h4">Связаться с нами можно по телефону или путем подачи заявки на сайте. Мы выполним предварительный расчет стоимости транспортного средства и ответим на все интересующие вас вопросы.</h2>
                </div>
            </div>
        </div>
    </div>
<?$APPLICATION->IncludeComponent(
	"bitrix:form.result.new", 
	"form.block-blue", 
	array(
		"CACHE_TIME" => "3600",
		"CACHE_TYPE" => "A",
		"CHAIN_ITEM_LINK" => "",
		"CHAIN_ITEM_TEXT" => "",
		"COMPONENT_TEMPLATE" => "form.block-blue",
		"EDIT_URL" => "result_edit.php",
		"IGNORE_CUSTOM_TEMPLATE" => "N",
		"LIST_URL" => "result_list.php",
		"SEF_MODE" => "N",
		"SUCCESS_URL" => "",
		"USE_EXTENDED_ERRORS" => "N",
		"WEB_FORM_ID" => "11",
		"VARIABLE_ALIASES" => array(
			"WEB_FORM_ID" => "WEB_FORM_ID",
			"RESULT_ID" => "RESULT_ID",
		)
	),
	false
);?>
<div class="container my-5"></div>

<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>