const swiper_on_main = new Swiper('.swiper-on-main', {
    loop: true,
    pagination: {
        el: '.swiper-pagination',
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-on-main-button-next',
        prevEl: '.swiper-on-main-button-prev',
    },
    effect: 'fade',
    autoplay: {
        delay: 5000,
        disableOnInteraction: false,
    },
});