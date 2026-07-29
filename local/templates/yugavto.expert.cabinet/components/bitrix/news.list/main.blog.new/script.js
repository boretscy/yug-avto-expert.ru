
const swiper_blog_on_main = new Swiper('.swiper-blog-on-main', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-blog-on-main-button-next',
        prevEl: '.swiper-blog-on-main-button-prev',
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