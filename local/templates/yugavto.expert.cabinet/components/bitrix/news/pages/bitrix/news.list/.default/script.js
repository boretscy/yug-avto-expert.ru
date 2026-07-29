const swiper_cis_others = new Swiper('.swiper-cis-others', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-cis-others-button-next',
        prevEl: '.swiper-cis-others-button-prev',
    },
    slidesPerView: 4,
    spaceBetween: 25,
    
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
            slidesPerView: 4,
            spaceBetween: 25
        },
    }
})