<?php
$vehicleMode = $vehicleMode ?? $POST['entity'] ?? $query['entity'] ?? 'used';
$item['_general'] = $item['_general'] ?? $item['general'] ?? [];
$item['_tags'] = $item['_tags'] ?? [];
$item['id'] = $item['ext_id'] ?? $item['id'];
$item['offer_link'] = $item['offer_link'] ?? true;
$data['FAVORITES'] = $data['FAVORITES'] ?? ( json_decode($_COOKIE['CIS_FAVORITES'], true) ) ?: [];
$data['COMPARE'] = $data['COMPARE'] ?? ( json_decode($_COOKIE['CIS_COMPARE'], true) ) ?: [];
?>
<div class="b-radius-yaradius-25 b-yagray vehicle-card mb-4 text-start w-100">
	<div class="vehicle-card-images position-relative">
		<a href="/cars/<?= $vehicleMode;?>/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" role="vehicle-image">
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
					href="#" 
					role="toggle-fav-com" 
					data-target="CIS_FAVORITES" 
					data-vehicle="<?= $item['id'];?>"
					aria-label="Избранное"
					class="ms-1 b-radius-yaradius-7 hint--bottom-left <?= ((in_array($item['id'], $data['FAVORITES']))?'bg-yayellow':'bg-yawhite');?> vehicle-card-discount-item"
					><img src="/cars/used/assets/images/svg/favorites.svg" /></a>
				<a 
					href="#" 
					role="toggle-fav-com" 
					data-target="CIS_COMPARE" 
					data-vehicle="<?= $item['id'];?>"
					aria-label="Сравнение"
					class="ms-1 b-radius-yaradius-7 hint--bottom-left <?= ((in_array($item['id'], $data['COMPARE']))?'bg-yayellow':'bg-yawhite');?>  vehicle-card-discount-item"
					><img src="/cars/used/assets/images/svg/compare.svg" /></a>
			</div>
		</div>
		<?php if (!empty($item['images'])) { ?>
		<div class="m-3 vehicle-card-images-row position-absolute d-flex justify-content-between">
			<?php foreach ( $item['images'] as $k => $i ) { ?>
			<span class="vehicle-card-images-row-item <?= (($k==0)?'active':'');?>" data-index="<?=$k;?>"></span>
			<?php } ?>
		</div>
		<?php } ?>
	</div>
	<div class="vehicle-card-content p-3">
		<a 
			href="/cars/<?= $vehicleMode;?>/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/" 
			class="c-yablack c-h-yablack text-decoration-none h5 line-height-one d-block vehicle-card-content-title fw-bold"
			><?= $item['brand']['name'];?> <?= $item['model']['name'];?> <?= (($item['equipment'])?:'');?></a>
		<div class="vehicle-card-futures">
			<?php foreach ( $item['_tags'] as $tag ) { ?>
				<a href="#" onclick="return false" class="hint--top-right" aria-label="<?= $tag['name'];?>" role="not-cover"><img src="<?= $tag['icon'];?>" /></a>
			<?php } ?>
		</div>
		<div class="vehicle-card-specification my-3 c-yadarkgray text-minus-minus">
			<?php foreach (array_chunk($item['_general'], 3) as $s_row) { ?>
			<div>
				<?php foreach ( $s_row as $i ) { ?>
					<?php if ( $i ) { ?><span class="vehicle-card-specification-item pe-2 me-2"><?= $i;?></span><?php } ?>
				<?php } ?>
			</div>
			<?php } ?>
		</div>
		<div class="vehicle-card-status text-uppercase my-3 c-yadarkgray text-minus-minus"><?= $item['status']['name'];?></div>
		<div class="vehicle-card-price my-3 d-flex justify-content-between">
			<span class="text-plus c-yablack fw-bold"><?= number_format($item['min_price'], 0, '.', ' ');?> ₽</span>
			<?php if ( $item['min_price'] < $item['price'] ) { ?>
			<span class="text-plus c-yadarkgray text-decoration-line-through"><?= number_format($item['price'], 0, '.', ' ');?> ₽</span>
			<?php } ?>
		</div>
		<div class="">
			<a
				href="/cars/<?= $vehicleMode;?>/<?= $item['brand']['code'];?>/<?= $item['model']['code'];?>/<?= $item['id'];?>/"
				class="c-yablack c-h-yablack text-decoration-none d-block text-center b-radius-yaradius-15 bg-yayellow bg-h-yadarkyellow vehicle-card-button"
				data-vehicle-name="<?= $item['brand']['name'];?> <?= $item['model']['name'];?> <?= (($item['equipment'])?:'');?>"
				data-vehicle-id="<?= $item['id'];?>"
				data-action="set-vehicle"
				<?php if ( !$item['offer_link'] ) { ?>
				data-remodal-target="offer-modal"
				<?php } ?>
				>Получить предложение</a>
		</div>
	</div>
</div>
