<div class="container sorting">
    <div class="row text-minus">
        <div class="col-6 col-sm col-md-3 col-xl-2 position-relative filter-dropcontainer my-2">
            <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/sort.svg" />
            <div class="filter-dropdown d-inline-block c-yadarkgray">
                <span>
                    <?php if ($_GET['sort']=='price_up') { ?>
                    По возрастанию цены
                    <?php } elseif ($_GET['sort']=='price_down') { ?>
                    По убыванию цены
                    <?php } elseif ($_GET['sort']=='datetime_up') { ?>
                    По дате: новые
                    <?php } elseif ($_GET['sort']=='datetime_down') { ?>
                    По дате: старые
                    <?php } elseif ($_GET['sort']=='year_down') { ?>
                    По году: новее
                    <?php } elseif ($_GET['sort']=='year_up') { ?>
                    По году: старше
                    <?php } elseif ($_GET['sort']=='mileage_up') { ?>
                    По пробегу: меньше
                    <?php } elseif ($_GET['sort']=='mileage_down') { ?>
                    По пробегу: больше
                    <?php } else { ?>
                    Сортировка
                    <?php } ?>
                </span>
            </div>
            <div class="filter-droplist bg-yawhite w-100 position-absolute d-none">
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'price_up']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('price_up', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По возрастанию цены</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'price_down']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('price_down', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По убыванию цены</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'datetime_up']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('datetime_up', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По дате: новые</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'datetime_down']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('datetime_down', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По дате: старые</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'year_down']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('year_down', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По году: новее</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'year_up']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('year_up', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По году: старше</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'mileage_up']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('mileage_up', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По пробегу: меньше</a>
                <a href="<?= $app->makeFilterUrl($filter, ['sort'=>'mileage_down']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('mileage_down', explode(',', $_GET['sort'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >По пробегу: больше</a>
            </div>
        </div>
        <?php if ( $data['Discount'] || ($data['InStock']&&$data['OnWay']) ) { ?>
        <div class="col-6 col-sm col-md-3 col-xl-2 position-relative filter-dropcontainer text-end text-md-start my-2">
            <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/perpage.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['baseUrl'].'/assets/images/svg/perpage.svg');?>" />
            <div class="filter-dropdown d-inline-block c-yadarkgray">
                <span>
                    <?php if ($_GET['perpage']=='16') { ?>
                    Показывать по 16
                    <?php } elseif ($_GET['perpage']=='24') { ?>
                    Показывать по 24
                    <?php } elseif ($_GET['perpage']=='32') { ?>
                    Показывать по 32
                    <?php } elseif ($_GET['perpage']=='48') { ?>
                    Показывать по 48
                    <?php } elseif ($_GET['perpage']=='64') { ?>
                    Показывать по 64
                    <?php } else { ?>
                    Показывать по 24
                    <?php } ?>
                </span>
            </div>
            <div class="filter-droplist bg-yawhite w-100 position-absolute d-none">
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'16']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('16', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 16</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'24']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('24', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 24</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'32']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('32', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 32</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'48']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('48', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 48</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'64']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('64', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 64</a>
            </div>
        </div>
        <?php } ?>

        <?php if ( $data['Discount'] || ($data['InStock']&&$data['OnWay']) ) { ?>
        <div class="col-md-6 col-xl-8 text-end d-flex justify-content-center justify-content-md-end align-items-center my-2">
            
            <?php if (
                $data['Discount'] ||
                (
                    $data['InStock'] && $data['OnWay']
                )
                ) { ?> 
            <span class="b-radius-yaradius-7 bg-<?= ((!$filter['tag'])?'yayellow':'yalightgray');?> me-2 d-inline-block check d-flex justify-content-center align-items-center">
                <?php if (!$filter['tag']) { ?>
                <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/check.svg" />
                <?php } ?>
            </span>
            <span><a href="<?= $app->makeFilterUrl($filter, ['tag'=>null]);?>" class="c-yalightblack c-h-yadarkgray text-decoration-none">Всe</a></span>
            <?php } ?>
            
            <?php if ( $data['Discount'] ) { ?>
            <span class="b-radius-yaradius-7 bg-<?= ((in_array('discount',explode(',',$filter['tag'])))?'yayellow':'yalightgray');?> ms-4 ms-md-3 ms-lg-4 me-2 d-inline-block check d-flex justify-content-center align-items-center">
                <?php if ( in_array('discount',explode(',',$filter['tag'])) ) { ?>
                <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/check.svg" />
                <?php } ?>
            </span>
            <span><a href="<?= $app->makeFilterUrl($filter, ['tag'=>'discount']);?>" class="c-yalightblack c-h-yadarkgray text-decoration-none">Выгода</a></span>
            <?php } ?>

            <?php if ( $data['InStock'] && $data['OnWay']) { ?>
            <span class="b-radius-yaradius-7 bg-<?= ((in_array('instock',explode(',',$filter['tag'])))?'yayellow':'yalightgray');?> ms-4 ms-md-3 ms-lg-4 me-2 d-inline-block check d-flex justify-content-center align-items-center">
                <?php if ( in_array('instock',explode(',',$filter['tag'])) ) { ?>
                <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/check.svg" />
                <?php } ?>
            </span>
            <span><a href="<?= $app->makeFilterUrl($filter, ['tag'=>'instock']);?>" class="c-yalightblack c-h-yadarkgray text-decoration-none">В наличии</a></span>
            <span class="b-radius-yaradius-7 bg-<?= ((in_array('onway',explode(',',$filter['tag'])))?'yayellow':'yalightgray');?> ms-4 ms-md-3 ms-lg-4 me-2 d-inline-block check d-flex justify-content-center align-items-center">
                <?php if ( in_array('onway',explode(',',$filter['tag'])) ) { ?>
                <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/check.svg" />
                <?php } ?>
            </span>
            <span><a href="<?= $app->makeFilterUrl($filter, ['tag'=>'onway']);?>" class="c-yalightblack c-h-yadarkgray text-decoration-none">В пути</a></span>
            <?php } ?>

        </div>
        <?php } else { ?>
        <div class="col-md-5 col-xl-8 d-none d-md-block"></div>
        <div class="col-6 col-md-4 col-xl-2 position-relative filter-dropcontainer text-end my-2">
            <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/perpage.svg?<?= md5_file($_SERVER['DOCUMENT_ROOT'].$app->Conf()['baseUrl'].'/assets/images/svg/perpage.svg');?>" />
            <div class="filter-dropdown d-inline-block c-yadarkgray">
                <span>
                    <?php if ($_GET['perpage']=='16') { ?>
                    Показывать по 16
                    <?php /*
                    <?php } elseif ($_GET['perpage']=='24') { ?>
                    Показывать по 24
                    */ ?>
                    <?php } elseif ($_GET['perpage']=='32') { ?>
                    Показывать по 32
                    <?php } elseif ($_GET['perpage']=='48') { ?>
                    Показывать по 48
                    <?php } elseif ($_GET['perpage']=='64') { ?>
                    Показывать по 64
                    <?php } else { ?>
                    Показывать по 32
                    <?php } ?>
                </span>
            </div>
            <div class="filter-droplist bg-yawhite w-100 position-absolute d-none">
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'16']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('16', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 16</a>
                <?php /*
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'24']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('24', explode(',', $_GET['perpage']))||!$_GET['perpage'])?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 24</a>
                */ ?>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'32']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('32', explode(',', $_GET['perpage']))||!$_GET['perpage'])?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 32</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'48']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('48', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 48</a>
                <a href="<?= $app->makeFilterUrl($filter, ['perpage'=>'64']);?>" 
                    class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= ((in_array('64', explode(',', $_GET['perpage'])))?'bg-yalightgray selected fw-bold':'');?>"
                    >Показывать по 64</a>
            </div>
        </div>
        <?php } ?>
    </div>
</div>