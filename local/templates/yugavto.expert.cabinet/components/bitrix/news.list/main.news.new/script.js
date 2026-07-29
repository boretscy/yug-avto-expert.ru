
const swiper_news_on_main = new Swiper('.swiper-news-on-main', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-news-on-main-button-next',
        prevEl: '.swiper-news-on-main-button-prev',
    },
    slidesPerView: 2,
    spaceBetween: 24,
    slidesPerGroup: 1,

    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10
        },
        750: {
            slidesPerView: 2,
            spaceBetween: 24
        },
    }
});