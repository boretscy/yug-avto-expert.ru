<?php if ( $filter['city'] && !is_array($filter['city']) ) $city = $app->getCityAlias($filter['city']); 
$carBrand = $item['brand']['name'] ?? '';
$carModel = $item['model']['name'] ?? '';
$carYear = $item['year'] ?? '';
$carMileage = (!empty($item['mileage'])) ? number_format($item['mileage'], 0, '.', ' ') . ' км' : '';
$carEquipment = (!empty($item['equipment']) ? $item['equipment'] : '');

$carImgText = $carBrand . ' ' . $carModel;
?>
<div class="b-radius-yaradius-25 b-yagray vehicle-card mb-4" itemprop="itemListElement" itemscope itemtype="https://schema.org/Product">
    <meta itemprop="brand" content="<?= htmlspecialchars($item['brand']['name'] ?? '');?>" />
    <meta itemprop="model" content="<?= htmlspecialchars($item['model']['name'] ?? '');?>" />
    <div class="vehicle-card-images position-relative">
        <a href="<?= $app->Conf()['baseUrl'];?>/<?= (($city)?$city.'/':'');?><?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" role="vehicle-image" itemprop="url">
            <?php if ( !empty($item['images']) ) { ?>
                <?php foreach ( $item['images'] as $k => $i ) { ?>
                <div 
                    class="vehicle-card-images-item-container" 
                    style="<?= (($k!=0)?'display:none;':'');?>" 
                    data-index="<?= $k;?>">
                    <img 
                        src="<?= (($i['preview'])?:$i['preview_large']);?>"
                        class="vehicle-card-images-item-container-image"
                        alt="<?= htmlspecialchars(YApp::getCleanAltText($carImgText . (($k > 0) ? ' - ракурс ' . ($k + 1) : '')));?>"
                        title="<?= htmlspecialchars(YApp::getCleanAltText($carImgText . (($k > 0) ? ' - ракурс ' . ($k + 1) : '')));?>"
                        loading="<?= ($k==0)?'eager':'lazy';?>"
                        <?= (($k==0)?'itemprop="image"':'');?>
                    >
                </div>
                <?php } ?>
            <?php } else { ?>
                <img src="https://<?= YApp::GO_API_DOMAIN ?>/upload/Cis/bodies/<?= $item['body']['code'];?>_sm.webp" itemprop="image" class="w-100" alt="<?= htmlspecialchars(YApp::getCleanAltText($carImgText));?>" title="<?= htmlspecialchars(YApp::getCleanAltText($carImgText));?>" />
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
                    href="#" 
                    action="toggle-fav-com" role="not-cover"
                    data-target="CIS_FAVORITES" 
                    data-vehicle="<?= $item['id'];?>"
                    aria-label="Избранное"
                    class="ms-1 b-radius-yaradius-7 hint--bottom-left <?= ((in_array($item['id'], $data['FAVORITES']))?'bg-yayellow':'bg-yawhite');?> vehicle-card-discount-item"
                    ><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/favorites.svg" /></a>
                <a 
                    href="#" 
                    action="toggle-fav-com" role="not-cover"
                    data-target="CIS_COMPARE" 
                    data-vehicle="<?= $item['id'];?>"
                    aria-label="Сравнение"
                    class="ms-1 b-radius-yaradius-7 hint--bottom-left <?= ((in_array($item['id'], $data['COMPARE']))?'bg-yayellow':'bg-yawhite');?>  vehicle-card-discount-item"
                    ><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/compare.svg" /></a>
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
            class="c-yalightblack c-h-yalightblack text-decoration-none h5 line-height-one d-block fw-bold vehicle-card-content-title" itemprop="name"
            ><div class="h5 line-height-one d-block fw-bold"><?= $item['brand']['name'];?> <?= $item['model']['name'];?></div></a>
        <div class="vehicle-card-futures">
            <?php foreach ( $item['_tags'] as $tag ) { ?>
                <a href="#" onclick="return false" class="hint--top-right hint--medium" aria-label="<?= $tag['name'];?>" role="not-cover">
                    <img src="<?= $tag['icon'];?>" />
                </a>
            <?php } ?>
        </div>
        <div class="vehicle-card-specification my-3 c-yadarkgray" itemprop="description">
            <?php foreach (array_chunk($item['_general'], 3) as $s_row) { ?>
            <div>
                <?php foreach ( $s_row as $k => $i ) { ?>
                    <?php if ( $i ) { ?><span class="vehicle-card-specification-item pe-2"><?= $i;?>
                        <?php if ( $k < count($s_row)-1 ) { ?>
                        <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/card_bullet.svg?3" class="ms-2" title="<?= $i;?>" />
                        <?php } ?>
                    </span>
                    <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <div class="vehicle-card-status text-uppercase my-3 fw-bold <?= (($item['status']['id']==1)?'c-yablue':'c-yayellow');?>"><?= $item['status']['name'];?></div>
        <div class="vehicle-card-price my-3 d-flex justify-content-between" itemprop="offers" itemscope itemtype="https://schema.org/Offer">
            <meta itemprop="price" content="<?= $item['min_price'];?>">
            <meta itemprop="priceCurrency" content="RUB">
            <?php if ($item['status']['id'] == 1) { ?>
            <link itemprop="availability" href="https://schema.org/InStock">
            <?php } else { ?>
            <link itemprop="availability" href="https://schema.org/OutOfStock">
            <?php } ?>
            <span class="text-plus c-yalightblack fw-bold"><?= number_format($item['min_price'], 0, '.', ' ');?> ₽</span>
            <?php if ( $item['min_price'] < $item['price'] ) { ?>
            <span class="text-plus c-yadarkgray text-decoration-line-through"><?= number_format($item['price'], 0, '.', ' ');?> ₽</span>
            <?php } ?>
        </div>
        <div class="">
            <a
                href="<?= $app->Conf()['baseUrl'];?>/<?= (($city)?$city.'/':'');?><?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/"
                class="c-yalightblack c-h-yalightblack text-decoration-none text-uppercase d-block text-center b-radius-yaradius-15 bg-yayellow vehicle-card-button"
                data-vehicle-name="<?= $item['brand']['name'];?> <?= $item['model']['name'];?>"
                data-vehicle-id="<?= $item['id'];?>"
                data-action="set-vehicle"
                <?php if ( !$item['offer_link'] ) { ?>
                data-remodal-target="offer-modal"
                role="not-cover"
                <?php } ?>
                >Получить предложение</a>
        </div>
    </div>
</div>