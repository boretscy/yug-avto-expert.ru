<div class="container my-5">
	<div class="row my-3">
		<div class="col-6 col-md">
			<div class="news-filter-select position-relative">
				<a href="#" class="d-block p-2 ps-4 b-radius-small b-yablue text-decoration-none c-yablack c-h-yablack position-relative fw-bold" role="news-filter-select-button">
					<span id="news-filter-select-brands-title"><?= $arResult['FILTER']['BRANDS_TITLE'];?></span>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<ul class="list-unstyled news-filter-select-list bg-yalightgray b-radius-small shadow p-4">
					<?php foreach ( $arResult['FILTER']['BRANDS'] as $item ) { ?>
					<li class="news-filter-select-list-item ">
						<a 
							href="<?= $item['LINK'];?>" 
							class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block">
							<img src="<?= $item['PICTURE'];?>" alt="<?= $item['NAME'];?>" class="b-yagray b-radius-small" />
							<?= $item['NAME'];?>
						</a>
					</li>
					<?php } // foreach BRANDS ?>
					<hr />
					<li class="news-filter-select-list-item ">
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
		<div class="col-6 col-md">
			<div class="news-filter-select position-relative">
				<a href="#" class="d-block p-2 ps-4 b-radius-small b-yablue text-decoration-none c-yablack c-h-yablack position-relative fw-bold" role="news-filter-select-button">
					<span id="news-filter-select-category-title"><?= $arResult['FILTER']['CATEGORIES_TITLE'];?></span>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<ul class="list-unstyled news-filter-select-list bg-yalightgray b-radius-small shadow p-4">
					<?php foreach ( $arResult['FILTER']['CATEGORIES'] as $item ) { ?>
					<li class="news-filter-select-list-item ">
						<a 
							href="<?= $item['LINK'];?>" 
							class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block">
							<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#<?= $item['ICON'];?>"></use></svg>
							<?= $item['NAME'];?>
						</a>
					</li>
					<?php } // foreach CATEGORIES ?>
					<hr />
					<li class="news-filter-select-list-item ">
						<a 
							href="<?= $arResult['FILTER']['CATEGORIES_CLEAR_LINK'];?>" 
							class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block">
							<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#cross"></use></svg>
							Все
						</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="col-6 col-md">
			<div class="news-filter-select position-relative">
				<a href="#" class="d-block p-2 ps-4 b-radius-small b-yablue text-decoration-none c-yablack c-h-yablack position-relative fw-bold" role="news-filter-select-button">
					<span id="news-filter-select-category-title"><?= $arResult['FILTER']['DEALERSHIPS_TITLE'];?></span>
					<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-down"></use></svg>
				</a>
				<ul class="list-unstyled news-filter-select-list bg-yalightgray b-radius-small shadow p-4">
					<?php foreach ( $arResult['FILTER']['DEALERSHIPS'] as $item ) { ?>
					<li class="news-filter-select-list-item ">
						<a 
							href="<?= $item['LINK'];?>" 
							class="c-yamiddlegray c-h-yablackgray py-2 text-decoration-none text-minus-minus text-uppercase d-block">
							<img src="<?= $item['PICTURE'];?>" alt="<?= $item['NAME'];?>" class="b-yagray b-radius-small" />
							<?= $item['NAME'];?>
						</a>
					</li>
					<?php } // foreach CATEGORIES ?>
					<hr />
					<li class="news-filter-select-list-item ">
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
		<div class="col-6 col-md-1 text-end" style="padding-top: 10px;">
			<a href="<?= $arResult['FILTER']['CLEAR_LINK'];?>" class="b-radius-small b-yagray news-filter-cancel">
				<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#cross"></use></svg>
			</a>
		</div>
	</div>
</div>