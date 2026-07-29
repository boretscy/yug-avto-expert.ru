
const swiper_offer_on_main = new Swiper('.swiper-offer-on-main', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-offer-on-main-button-next',
        prevEl: '.swiper-offer-on-main-button-prev',
    },
    slidesPerView: 2,
    spaceBetween: 25,
    slidesPerGroup: 2,

    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        750: {
            slidesPerView: 2,
            spaceBetween: 25
        },
        1024: {
            slidesPerView: 2,
            spaceBetween: 25
        },
    }
});