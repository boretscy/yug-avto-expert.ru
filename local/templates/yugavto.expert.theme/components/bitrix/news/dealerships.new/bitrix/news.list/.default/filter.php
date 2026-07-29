<div class="container my-5">
	<div class="row dealerships-filter">
		<div class="col-4 col-md-3">
			<div class="dealerships-filter-select position-relative">
				<a href="#" class="d-block p-2 ps-4 b-radius-small b-yablue text-decoration-none c-yablack c-h-yablack position-relative bg-circle" role="dealerships-filter-select-button">
					<span id="dealerships-filter-select-cities-title"><?= $arResult['FILTER']['CITY_TITLE'];?></span>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<ul class="list-unstyled dealerships-filter-select-list bg-yawhite b-radius-small shadow p-4">
                    <li class="dealerships-filter-select-list-item ">
                        <a
                                href="<?= $arResult['FILTER']['CITIES_CLEAR_LINK'];?>"
                                role="dealerships-filter-select-city"
                                class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block" >
                            <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#cross"></use></svg>
                            Все
                        </a>
                    </li>
                    <hr />
                    <?php foreach ( $arResult['FILTER']['CITIES'] as $k => $item ) { ?>
					<li class="dealerships-filter-select-list-item ">
						<a 
							href="<?= $item['LINK'];?>" 
							role="dealerships-filter-select-city" 
							class="c-yablack c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block" >
							<!--<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#map"></use></svg>-->
							<?= $item['NAME'];?>
						</a>
					</li>
					<?php } // foreach CITIES ?>
				</ul>
			</div>
		</div>
		<div class="col-4 col-md-3">
			<div class="dealerships-filter-select position-relative">
				<a href="#" class="d-block p-2 ps-4 b-radius-small b-yablue text-decoration-none c-yablack c-h-yablack position-relative bg-circle" role="dealerships-filter-select-button">
					<span id="dealerships-filter-select-brands-title"><?= $arResult['FILTER']['BRAND_TITLE'];?></span>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<ul class="list-unstyled dealerships-filter-select-list bg-yawhite b-radius-small shadow p-4">
                    <li class="dealerships-filter-select-list-item ">
                        <a
                                href="<?= $arResult['FILTER']['BRANDS_CLEAR_LINK'];?>"
                                role="dealerships-filter-select-brand"
                                class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block" >
                            <svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#cross"></use></svg>
                            Все
                        </a>
                    </li>
                    <hr />
                    <?php foreach ( $arResult['FILTER']['BRANDS'] as $item ) { ?>
					<li class="dealerships-filter-select-list-item ">
						<a 
							href="<?= $item['LINK'];?>" 
							role="dealerships-filter-select-brand" 
							class="c-yablack c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block" >
							<!-- <img src="<?= $item['PICTURE'];?>" alt="<?= $item['NAME'];?>" class="b-yagray b-radius-small" />-->
							<?= $item['NAME'];?>
						</a>
					</li>
					<?php } // foreach BRANDS ?>

				</ul>
			</div>
		</div>
		<div class="col-4 col-md-1">
            <a href="<?= $arResult['FILTER']['CLEAR_LINK'];?>" class="d-block w-100 p-2 text-center b-radius-small b-yayellow text-decoration-none c-yablack c-h-yablack offers-filter-cancel bg-circle">
				<span>Все</span>
			</a>
		</div>

        <div class="col-12 col-md-2">
			<ul class="list-inline dealerships-filter-tags">
				<?php foreach ($arResult['FILTER']['TAGS'] as $item ) { ?>
				<li class="list-inline-item me-3 pt-2">
					<a 
						href="<?= $item['LINK'];?>" 
						class="<?= (($arResult['FILTER']['TAG_TITLE']==$item['NAME'])?'c-yablue c-h-yadarkblue':'c-yablackgray c-h-yadarkgray');?> py-2 text-decoration-none offers-filter-tags-item">
						<?= $item['NAME'];?>
					</a>
				</li>
				<?php } // foreach TAGS ?>
			</ul>
		</div>
		<?php foreach ( $arResult['FILTER']['MODES'] as $item ) { ?>
		<div class="col-6 col-md dealerships-filter-mode">
			<a 
				href="<?= $item['LINK'];?>" 
				class="d-block w-100 p-2 text-center b-radius-small <?= (($arResult['MODE']==$item['CODE'])?'b-yayellow':'b-yawhite');?> text-decoration-none c-yablack c-h-yablack"
				>
				<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#ds-<?= $item['CODE'];?>"></use></svg>
				<span><?= $item['NAME'];?></span>
			</a>
		</div>
		<?php } // foreach MODES ?>


	<?php // YApp::sp( $arResult['FILTER'] ); ?>
	</div>
</div>
