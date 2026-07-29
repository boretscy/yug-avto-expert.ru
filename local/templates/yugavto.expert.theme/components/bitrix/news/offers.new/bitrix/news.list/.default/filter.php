<div class="container my-5">
	<div class="row mb-3">

		<div class="col-4 col-md-3">
			<div class="offers-filter-select position-relative">
				<a href="#" class="d-block p-2 ps-4 b-radius-small b-yablue text-decoration-none c-yablack c-h-yablack position-relative bg-circle" role="offers-filter-select-button">
					<span id="offers-filter-select-brands-title"><?= $arResult['FILTER']['BRANDS_TITLE'];?></span>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<ul class="list-unstyled offers-filter-select-list bg-yalightgray b-radius-small shadow p-4">
					<?php foreach ( $arResult['FILTER']['BRANDS'] as $item ) { ?>
					<li class="offers-filter-select-list-item ">
						<a 
							href="<?= $item['LINK'];?>" 
							class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block">
							<img src="<?= $item['PICTURE'];?>" alt="<?= $item['NAME'];?>" class="b-yagray b-radius-small" />
							<?= $item['NAME'];?>
						</a>
					</li>
					<?php } // foreach BRANDS ?>
					<hr />
					<li class="offers-filter-select-list-item ">
						<a 
							href="<?= $arResult['FILTER']['BRANDS_CLEAR_LINK'];?>" 
							class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block">
							<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#cross"></use></svg>
							Все
						</a>
					</li>
				</ul>
			</div>
		</div>
		
		<div class="col-4 col-md-3">
			<div class="offers-filter-select position-relative">
				<a href="#" class="d-block p-2 ps-4 b-radius-small b-yablue text-decoration-none c-yablack c-h-yablack position-relative bg-circle" role="offers-filter-select-button">
					<span id="offers-filter-select-category-title"><?= $arResult['FILTER']['DEALERSHIPS_TITLE'];?></span>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<ul class="list-unstyled offers-filter-select-list bg-yalightgray b-radius-small shadow p-4">
					<?php foreach ( $arResult['FILTER']['DEALERSHIPS'] as $item ) { ?>
					<li class="offers-filter-select-list-item ">
						<a 
							href="<?= $item['LINK'];?>" 
							class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block">
							<img src="<?= $item['PICTURE'];?>" alt="<?= $item['NAME'];?>" class="b-yagray b-radius-small" />
							<?= $item['NAME'];?>
						</a>
					</li>
					<?php } // foreach DEALERSHIPS ?>
					<hr />
					<li class="offers-filter-select-list-item ">
						<a 
							href="<?= $arResult['FILTER']['DEALERSHIPS_CLEAR_LINK'];?>" 
							class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block">
							<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#cross"></use></svg>
							Все
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-4 col-md-1">
			<a href="<?= $arResult['FILTER']['CLEAR_LINK'];?>" class="d-block w-100 p-2 text-center b-radius-small b-yadarkblue text-decoration-none c-yablack c-h-yablack offers-filter-cancel bg-circle">
				<span>Показать</span>
			</a>
		</div>
		<div class="col-4 col-md-1">
			<a href="<?= $arResult['FILTER']['CLEAR_LINK'];?>" class="d-block w-100 p-2 text-center b-radius-small b-yayellow text-decoration-none c-yablack c-h-yablack offers-filter-cancel bg-circle">
				<span>Все</span>
			</a>
		</div>

		<div class="col-12 col-md">
			<ul class="list-inline offers-filter-tags">
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

	</div>

</div>