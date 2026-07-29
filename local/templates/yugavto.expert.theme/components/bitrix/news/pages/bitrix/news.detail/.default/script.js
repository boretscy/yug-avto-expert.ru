const swiper_cis_new = new Swiper('.swiper-cis-new', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-cis-new-button-next',
        prevEl: '.swiper-cis-new-button-prev',
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

const swiper_cis_used = new Swiper('.swiper-cis-used', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-cis-used-button-next',
        prevEl: '.swiper-cis-used-button-prev',
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

$(document).on('click', '[role="cisToggle"]', function() {
    $('.'+$(this).data('cis')).show().siblings('[role="cis"]').hide()
    $('[role="cisToggle"]').removeClass('b-yayellow')
    $(this).addClass('b-yayellow')

    return false;
})