<div class="col-xl-6">
    <div class="sticky-top" style="top: 7rem;">
        <div class="swiper vehicle-swiper position-relative">
            <div class="swiper-wrapper">
                <?php foreach ( $data['_images'] as $k => $item ) { ?>
                <div class="swiper-slide">
                    <a 
                        data-fancybox="gallery-<?= $data['id'];?>"
                        data-src="<?= $item['detail'];?>"
                        data-width="1522"
                        data-height="1200"
                        role="not-cover"
                        class="vehicle-full-image"
                        ><img 
                            src="<?= $item['detail'];?>" 
                            class="b-radius-yaradius-25" 
                            title="<?= $data['brand']['name'];?> <?= $data['model']['name'];?>  <?= (($data['equipment'])?:'');?>" 
                            alt="<?= $data['brand']['name'];?> <?= $data['model']['name'];?>  <?= (($data['equipment'])?:'');?>" 
                            <?= (($k==0)?'itemprop="image"':'');?> />
                        </a>
                </div>
                <?php } ?>
            </div>
            <div class="vehicle-swiper-next b-radius-c-yaradius b-yawhite d-flex justify-content-center align-items-center position-absolute"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/arrow-white.svg?2" /></div>
            <div class="vehicle-swiper-prev b-radius-c-yaradius b-yawhite d-flex justify-content-center align-items-center position-absolute"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/arrow-white.svg?2" class="rotate-180" /></div>
            <div class="vehicle-swiper-buttons-row position-absolute">
                <a 
                    href="#" 
                    action="toggle-fav-com" role="not-cover"
                    data-target="CIS_FAVORITES" 
                    data-vehicle="<?= $data['id'];?>"
                    aria-label="Избранное"
                    class="ms-1 b-radius-yaradius-7 hint--bottom-left <?= ((in_array($data['id'], $data['FAVORITES']))?'bg-yayellow':'bg-yawhite');?> vehicle-swiper-buttons-row-item"
                    ><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/favorites.svg" /></a>
                <a 
                    href="#" 
                    action="toggle-fav-com" role="not-cover"
                    data-target="CIS_COMPARE" 
                    data-vehicle="<?= $data['id'];?>"
                    aria-label="Сравнение"
                    class="ms-1 b-radius-yaradius-7 hint--bottom-left <?= ((in_array($data['id'], $data['COMPARE']))?'bg-yayellow':'bg-yawhite');?>  vehicle-swiper-buttons-row-item"
                    ><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/compare.svg" /></a>
                <div class="ms-1 b-radius-yaradius-7 bg-yawhite ya-share2" data-curtain data-shape="round" data-color-scheme="whiteblack" data-limit="0" data-more-button-type="short" data-services="messenger,vkontakte,odnoklassniki,telegram,twitter,viber,whatsapp,skype"></div>
            </div>
        </div>
        <div class="swiper vehicle-swiper-thumbs mt-4">
            <div class="swiper-wrapper">
                <?php foreach ( $data['_images'] as $item ) { ?>
                <div class="swiper-slide">
                    <img src="<?= $item['preview'];?>" class="b-radius-yaradius-15" />
                </div>
                <?php } ?>
                <?php /*
                <div class="vehicle-swiper-thumds-photo b-radius-yaradius-15 d-flex justify-content-center align-items-center c-yawhite fw-bold">
                    <span>+ <?= count($data['_images'])-4;?><br />фото</span>
                </div>
                */?>
            </div>
            <div class="vehicle-swiper-thumbs-next"></div>
            <div class="vehicle-swiper-thumbs-prev"></div>
        </div>
    </div>
</div>

<div class="col-xl-6">
    <div class="row mb-3 mt-4 mt-xl-0">
        <div class="col-md-6">
            <div class="h5 fw-bold"><?= (($data['equipment'])?:'&nbsp;');?></div>
            <?php /*
            <div class="text-minus c-yadarkgray">Комплектация:</div>
            */ ?>
            <ul class="list-unstyled text-minus mt-4" itemprop="description">
                <li class="d-flex justify-content-between"><span class="c-yadarkgray">Цвет кузова:</span><span><?= $data['general'][2]['value'];?></span></li>
                <hr class="my-2" /><li class="d-flex justify-content-between"><span class="c-yadarkgray">Год выпуска:</span><span><?= $data['general'][4]['value'];?></span></li>
                <hr class="my-2" /><li class="d-flex justify-content-between"><span class="c-yadarkgray">Кузов:</span><span><?= ((is_array($data['body']))?$data['body']['name']:'');?></span></li>
                <hr class="my-2" /><li class="d-flex justify-content-between"><span class="c-yadarkgray">Коробка:</span><span><?= ((is_array($data['transmission']))?$data['transmission']['name']:'');?></span></li>
                <hr class="my-2" /><li class="d-flex justify-content-between"><span class="c-yadarkgray">Топливо:</span><span><?= ((is_array($data['engine']))?$data['engine']['name']:'');?></span></li>
                <hr class="my-2" /><li class="d-flex justify-content-between"><span class="c-yadarkgray">Привод:</span><span><?= ((is_array($data['drive']))?$data['drive']['name']:'');?></span></li>
                <hr class="my-2" /><li class="d-flex justify-content-between"><span class="c-yadarkgray">Двигатель:</span><span><?= $data['general'][(($app->Conf['Api']['mode']=='new')?5:8)]['value'];?></span></li>
                <hr class="my-2" /><li class="d-flex justify-content-between"><span class="c-yadarkgray">Расход л/100км:</span><span><?= $data['specifications'][3]['value'];?> - <?= $data['specifications'][2]['value'];?></span></li>
                <?php if ( $app->Conf['Api']['mode']=='used' ) { ?>
                <hr class="my-2" /><li class="d-flex justify-content-between"><span class="c-yadarkgray">Пробег:</span><span><?= number_format($data['general'][5]['value'], 0, '.', ' ');?></span></li>
                <?php } ?>
            </ul>
        </div>
        <div class="col-md-6">
            <?php if ( $data['price']-$data['min_price'] > 0 ) { ?>
            <div class="h5 fw-bold">Выгода на авто</div>
            <div class="text-minus c-yadarkgray vehicle-discounts position-relative">
                Максимальная сумма выгод - <?= number_format($data['price']-$data['min_price'], 0, '.', ' ');?> ₽  <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/question.svg" />
                <div class="vehicle-discounts-disclamer bg-yawhite p-3 position-absolute">
                    Данная выгода действительна в случае приобретения автомобиля клиентом при условии использования специальных программ Производителя и/или ДЦ, а именно:<br />
                    <ul>
                        <?php foreach ( $data['discounts'] as $item ) { ?>
                        <?php /* <li><?= $item['name'];?></li> */ ?>
                        <li><?= str_ireplace(['Trade-in', 'Trade in'], 'Трейд-ин', $item['name']);?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <ul class="list-unstyled my-3">
                <?php foreach ( $data['discounts'] as $item) { ?>
                <li>
                    <div class="row vehicle-discounts-item active cursor-pointer" data-sum="<?= $item['sum'];?>" data-price="<?= $data['price'];?>" data-min="<?= $data['min_price'];?>">
                        <div class="col-8 text-minus d-flex justify-content-start align-items-center py-2">
                            <span class="b-radius-yaradius-7 bg-<?= (($item['active'])?'yayellow':'yalightgray');?> me-2 d-inline-block check d-flex justify-content-center align-items-center vehicle-discounts-item-check">
                                <?php if ( $item['active'] ) { ?>
                                <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/check.svg" />
                                <?php } ?>
                            </span>
                            <span><?= $item['description'];?></span>
                        </div>
                        <div class="col-4 fw-bold d-flex justify-content-end align-items-center"><?= number_format($item['sum'], 0, '.', ' ');?> ₽</div>
                    </div>
                </li>
                <?php } ?>
            </ul>
                <?php /* if ( $data['additional_equipment_price'] ) { ?>
                <div class="row py-1">
                    <div class="col-8">Доп. оборудование</div>
                    <div class="col-4 text-end">+ <?= number_format($data['additional_equipment_price'], 0, '.', ' ');?> ₽</div>
                </div>
                <?php } */ ?>
            <div class="row py-1">
                <div class="col-8">Цена без учета выгод</div>
                <div class="col-4 text-end" role="max-price"><?= number_format($data['price'], 0, '.', ' ');?> ₽</div>
            </div>
            <div class="row py-1 mb-5">
                <div class="col-8">Цена с учетом выгод</div>
                <div class="col-4 text-end fw-bold" role="min-price"><?= number_format($data['min_price'], 0, '.', ' ');?> ₽</div>
            </div>
            <?php } ?>
            <a
                href="#" role="not-cover"
                class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow vehicle-button mb-3"
                data-remodal-target="trade-in-modal"
                >Оценить автомобиль</a>
            <a
                href="#" role="not-cover"
                class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow vehicle-button"
                data-remodal-target="credit-modal"
                >Рассчитать кредит</a>
        </div>
    </div>
    <div class="row vehicle-futures my-3">
        <?php foreach ( $data['_tags'] as $tag ) { ?>
            <div class="col-2 text-center text-minus">
                <img src="<?= $tag['icon'];?>" />
                <p class="mt-2"><?= $tag['name'];?></p>
            </div>
        <?php } ?>  
    </div>
    <div class="row vehicle-tabs-title">
        <div class="col-<?= ((!empty($data['_additional']))?6:12);?> text-uppercase py-2 text-center b-b-yayellow b-border-2 vehicle-tabs-title-item cursor-pointer" data-tab="0">Характеристики и комплектация</div>
        <?php if ( !empty($data['_additional']) ) { ?>
        <div class="col-6 text-uppercase py-2 text-center c-yadarkgray b-b-yalightgray b-border-2 vehicle-tabs-title-item cursor-pointer" data-tab="1">Дополнительно</div>
        <?php } ?>
    </div>
    <div class="row vehicle-tabs-content active my-3" data-tab="0">
        <div class="col-12">
            <div class="row mb-2">
                <?php foreach ( $data['_specifications'] as $group ) { ?>
                    <div class="col-md-6">
                        <?php foreach ( $group as $item ) { ?>
                        <div class="row py-2">
                            <div class="col text-minus c-yadarkgray"><?= $item['name'];?></div>
                            <div class="col-5 text-end"><?= $item['value'];?></div>
                        </div>
                        <?php } ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if ( $data['options'] ) { ?>
        <div class="col-12">
            <div class="row">
                <?php foreach ( $data['options'] as $k => $group ) { ?>
                <div class="col-12 vehicle-tabs-content-accordeon-title" data-index="<?= $k;?>">
                    <div class="row">
                        <div class="col-8"><?= $group['group'];?></div>
                        <div class="col-4 d-flex align-items-center justify-content-end text-minus c-yadarkgray">
                            <?= count($group['options']);?> <?= $app::getWorld(count($group['options']), 'option');?>
                            <img src="/cars/used/assets/images/svg/drop-corner.svg" class="ms-2">
                        </div>
                    </div>
                    <ul class="list-unstyled vehicle-options"  data-index="<?= $k;?>">
                        <?php foreach ( $group['options'] as $item ) { ?>
                        <li class="py-1 c-yadarkgray text-minus"><?= $item;?></li>
                        <?php } ?>
                    </ul>
                    <hr />
                </div>
                <?php } ?>
                <div class="col-12 toggle-vehicle-options text-decoration-underline text-minus c-yadarkgray" role="open">Посмотреть все опции</div>
                <div class="col-12 toggle-vehicle-options text-decoration-underline text-minus c-yadarkgray d-none" role="hide">Скрыть</div>
            </div>
        </div>
        <?php } ?>
    </div>
    <?php if ( !empty($data['_additional']) ) { ?>
    <div class="row vehicle-tabs-content" data-tab="1">
        <div class="col-12">
            <div class="row my-3">
                <div class="col">
                    <ul class="list-unstyled">
                        <?php foreach ( $data['_additional'] as $item ) { ?>
                        <li class="py-1 c-yadarkgray text-minus"><?= $item;?></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
</div>