<?php
    $expand = true;
    if ( $filter['filter']!='expand' && ($select['code']=='brand'||$select['code']=='model'||$select['code']=='dealership')) $expand = false;
    foreach ( $data['filter']['dropLists'][$select['list']] as $k => $item ) {
        foreach ( $select['select_fields'] as $field ) {
            if ( in_array($item[$field], explode(',', $filter[$select['code']])) ) $data['filter']['dropLists'][$select['list']][$k]['selected'] = true;
        }
    }
?>
<div class="filter-dropcontainer position-relative">
    <div class="b-radius-yaradius-15 bg-yalightgray filter-dropdown d-flex justify-content-between c-yalightblack position-relative">
        <?php if ( $select['code'] == 'mode' ) { ?>
            <?= $app->Conf()['Api']['name'];?>
        <?php } else { ?>
            <span><?= $select['name'];?></span>
            <?php if ( $filter[$select['code']] && count(explode(',', $filter[$select['code']])) != 0 ) { ?>
            <span><?= count(explode(',', $filter[$select['code']]));?> выбрано</span>
            <?php } ?>
        <?php } ?>
        <span><img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/drop-corner.svg" /></span>
    </div>
    <div class="filter-droplist bg-yawhite w-100 position-absolute d-none">
        <?php foreach ( $data['filter']['dropLists'][$select['list']] as $item ) { ?>
            <?php if ( $item['code'] != 'none' ) { ?>
            <a href="<?= $app->makeFilterUrl($filter, [$select['code']=>$item[(($select['url_field'])?:'code')]], false, $expand);?>" 
                class="filter-droplist-item py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray <?= (($item['selected'])?'bg-yalightgray selected fw-bold':'');?>"
                data-name="<?= $select['list'];?>"
                data-value="<?= $item['code'];?>"
                ><?= $item['name'];?></a>
            <?php } else { ?>
            <span class="filter-droplist-item not-link py-2 d-block c-yadarkgray c-ch-yadarkgray text-decoration-none bg-h-yalightgray"><?= $item['name'];?></span>
            <?php } ?>
        <?php } ?>
    </div>
</div>