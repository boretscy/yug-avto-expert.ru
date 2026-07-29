<?php if ( $filter['city'] && !is_array($filter['city']) ) $city = $app->getCityAlias($filter['city']); ?>
<div class="b-radius-yaradius-25 b-yagray vehicle-card mb-4">
    <div class="vehicle-card-images position-relative">
        <a href="<?= $app->Conf()['baseUrl'];?>/<?= (($city)?$city.'/':'');?><?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" role="vehicle-image">
            <?php if ( !empty($item['images']) ) { ?>
                <?php foreach ( $item['images'] as $k => $i ) { ?>
                <div 
                    class="vehicle-card-images-item-container" 
                    style="<?= (($k!=0)?'display:none;':'');?>" 
                    data-index="<?= $k;?>">
                    <img 
                        src="<?= (($i['preview'])?:$i['preview_large']);?>"
                        class="vehicle-card-images-item-container-image"
                        alt="<?= $item['brand']['name'];?> <?= $item['model']['name'];?>"
                        loading="<?= ($k==0)?'eager':'lazy';?>"
                    >
                </div>
                <?php } ?>
            <?php } else { ?>
                <img src="https://<?= YApp::GO_API_DOMAIN ?>/upload/Cis/bodies/<?= $item['body']['code'];?>_sm.webp" class="w-100" />
            <?php } ?>
        </a>
        <div class="m-3 vehicle-card-discount-row position-absolute d-flex justify-content-between">
            <div>
                <?php if ( $item['min_price'] < $item['price'] ) { ?>
                <span class="b-radius-yaradius-10 bg-yawhite c-yadarkgray vehicle-card-discount-item">до <strong><?= number_format($item['price']-$item['min_price'], 0, '.', ' ');?></strong> ₽</span>
                <?php } ?>
            </div>
            <div class="text-end">
                <a 
                    href="?action=delete&vehicle=<?= $item['id'];?>" 
                    aria-label="Убрать"
                    class="ms-1 b-radius-yaradius-7 bg-yawhite vehicle-card-discount-item hint--bottom-left"
                    ><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/trash.svg" style="display: inline-block;width: auto;height: auto;" /></a>
            </div>
        </div>
        <div class="m-3 vehicle-card-images-row position-absolute d-flex justify-content-between">
            <?php if ( !empty($item['images']) ) { ?>
                <?php foreach ( $item['images'] as $k => $i ) { ?>
                <span class="vehicle-card-images-row-item <?= (($k==0)?'active':'');?>" data-index="<?=$k;?>"></span>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div class="vehicle-card-content p-3">
        <a 
            href="<?= $app->Conf()['baseUrl'];?>/<?= (($city)?$city.'/':'');?><?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" 
            class="c-yalightblack c-h-yalightblack text-decoration-none h5 line-height-one d-block fw-bold vehicle-card-content-title"
            ><div class="h5 line-height-one d-block fw-bold"><?= $item['brand']['name'];?> <?= $item['model']['name'];?></div></a>
        <div class="vehicle-card-price mt-2 d-flex justify-content-between">
            <span class="text-plus c-yalightblack fw-bold"><?= number_format($item['min_price'], 0, '.', ' ');?> ₽</span>
            <?php if ( $item['min_price'] < $item['price'] ) { ?>
            <span class="text-plus c-yadarkgray text-decoration-line-through"><?= number_format($item['price'], 0, '.', ' ');?> ₽</span>
            <?php } ?>
        </div>
        <hr />
        <div class="d-flex justify-content-between align-items-center" data-index="0">
            <span>Технические параметры</span>
        </div>
        <ul class="list-unstyled compare-body-items text-minus c-yadarkgray" data-index="0">
            <li class="py-2"><?= $item['body']['name'];?>&nbsp;</li>
            <li class="py-2"><?= $item['general'][2]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['specifications'][7]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['power'];?>&nbsp;</li>
            <li class="py-2"><?= $item['engine']['name'];?>&nbsp;</li>
            <li class="py-2"><?= $item['specifications'][2]['value'];?> - <?= $item['specifications'][4]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['specifications'][0]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['_general'][0];?>&nbsp;</li>
        </ul>
        <hr />
        <div class="justify-content-between align-items-center" data-index="1">
            <span>Размеры</span>
        </div>
        <ul class="list-unstyled compare-body-items text-minus c-yadarkgray" data-index="1">
            <li class="py-2"><?= $item['specifications'][8]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['specifications'][9]['value'];?>&nbsp;</li>
            <li class="py-2"><?= $item['specifications'][10]['value'];?>&nbsp;</li>
        </ul>
        <hr />
        <div class="">
            <a
                href="<?= $app->Conf()['baseUrl'];?>/<?= (($filter['city']&&count($filter['city'])==1)?$app->getCityAlias($filter['city'][]).'/':'');?><?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/"
                class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow vehicle-card-button"
                data-vehicle-name="<?= $item['brand']['name'];?> <?= $item['model']['name'];?>"
                data-vehicle-id="<?= $item['id'];?>"
                data-action="set-vehicle"
                <?php if ( !$item['offer_link'] ) { ?>
                data-remodal-target="offer-modal"
                <?php } ?>
                >Подробнее</a>
        </div>
    </div>
</div>