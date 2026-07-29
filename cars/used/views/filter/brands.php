<div class="container brands d-none d-lg-block">
    <div class="row">
        <div class="col px-4">
            <div class="brands-list my-2">
                <?php $brands_items = ( !empty($data['filter']['dropLists']['models']) ) ? $data['filter']['dropLists']['models'] : $data['brands']; ?>
                <?php $f_key = ( !empty($data['filter']['dropLists']['models']) ) ? 'model' : 'brand'; ?>
                <?php array_multisort(array_column($brands_items, 'vehicles'), SORT_DESC, SORT_NUMERIC, $brands_items); ?>
                <?php foreach ( $brands_items as $k => $item ) { ?>
                <div class="brands-list-item <?= (($k>13&&count($brands_items)>15)?'hidden d-none':'');?>">
                    <a 
                        href="<?= $app->makeFilterUrl($filter, [$f_key=>$item['code']]);?>"
                        class="c-yadarkgray c-h-yadarkgray text-decoration-none py-1 d-block"
                        >
                        <div class="row">
                            <div class="col-7"><?= $item['name'];?></div>
                            <div class="col d-flex justify-content-end"><span class="d-block text-center b-radius-yaradius-3 bg-yalightgray px-1 brands-list-item-count fw-bold"><?= $item['vehicles'];?></span></div>
                        </div>
                    </a>
                </div>
                <?php } ?>
                <?php if ( count($brands_items)>15 ) { ?>
                <div class="brands-list-item">
                    <a href="#" class="c-yadarkgray c-h-yadarkgray text-decoration-noned-block py-1 d-block" data-action="expandBrands" role="not-cover">
                        <div class="row">
                            <div class="col-7">
                                <span class="me-2">Все <?= ((!empty($data['filter']['dropLists']['models']))?'модели':'марки');?></span>
                                <span class="me-2 d-none">Скрыть</span>
                            </div>
                            <div class="col text-end"><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/drop-corner.svg" class="" /></div>
                        </div>
                    </a>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>