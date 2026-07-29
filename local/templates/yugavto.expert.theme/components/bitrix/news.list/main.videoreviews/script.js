var videoreview_code = null;

const swiper_videoreviews_on_main = new Swiper('.swiper-videoreviews-on-main', {
    pagination: {
        el: ".swiper-pagination",
        type: "fraction",
    },
    navigation: {
        nextEl: '.swiper-videoreviews-on-main-button-next',
        prevEl: '.swiper-videoreviews-on-main-button-prev',
    },
    slidesPerView: 2,
    spaceBetween: 25,
    slidesPerGroup: 2,

    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10,
        },
        900: {
            slidesPerView: 2,
            spaceBetween: 25,
        },
    }
});



$(document).on('click', '[role="open-videoreview"]', function() {
    videoreview_code = $(this).data('code');
});

$(document).on('opened', '.remodal.videoreview-modal', function () {
    
    let iframe_html = '<iframe width="860" height="515" ';
    iframe_html += 'src="https://www.youtube.com/embed/'+videoreview_code+'" ';
    iframe_html += 'title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';

    $('.remodal.videoreview-modal .col').html( iframe_html );
});
