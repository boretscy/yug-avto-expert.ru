<div class="b-radius-yaradius-25 bg-yagradient cta-card mb-4 p-4 position-relative">
    <div class="cta-card-icon b-radius-yaradius-15 bg-yawhite p-4 d-inline-block">
        <img src="<?= $app->Conf()['baseUrl'];?>/assets/images/svg/cta_<?= $item['code'];?>.svg?3" />
    </div>
    <div class="my-5 w-100"></div>
    <div class="cta-card-title my-5">
        <div class="fw-bolder c-yadarkgray text-uppercase" style="font-size:<?= $item['sizes'][0];?>px;"><?= $item['title1'];?></div>
        <div class="c-yadarkgray text-uppercase" style="font-size:<?= $item['sizes'][1];?>px;"><?= $item['title2'];?></div>
        <div class="fw-bolder c-yadarkgray text-uppercase" style="font-size:<?= $item['sizes'][2];?>px;"><?= $item['title3'];?></div>
    </div>
    <div class="cta-card-text my-5 c-yadarkgray"><?= $item['text'];?></div>
        <a
            href="#"
            role="not-cover"
            class="c-yawhite c-h-yawhite text-decoration-none d-block text-center b-radius-yaradius-15 bg-yadarkgray bg-h-yalightblack cta-card-button position-absolute"
            data-remodal-target="<?= $item['code'];?>-modal"
            ><?= $item['button'];?></a>
</div>