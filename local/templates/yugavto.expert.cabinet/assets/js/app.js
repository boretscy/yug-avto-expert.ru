function objectsEqual(o1, o2) {
    const entries1 = Object.entries(o1);
    const entries2 = Object.entries(o2);
    if (entries1.length !== entries2.length) {
        return false;
    }
    for (let i = 0; i < entries1.length; ++i) {
        // Ключи
        if (entries1[i][0] !== entries2[i][0]) {
            return false;
        }
        // Значения
        if (entries1[i][1] !== entries2[i][1]) {
            return false;
        }
    }

    return true;
}
function getCookie(name) {
    var matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}
function setCookie(name, value, options = {}) {

    options = {
        path: '/',
        // при необходимости добавьте другие значения по умолчанию
        ...options
    };
  
    if (options.expires instanceof Date) {
        options.expires = options.expires.toUTCString();
    }
  
    var updatedCookie = encodeURIComponent(name) + "=" + encodeURIComponent(value);
  
    for (var optionKey in options) {
        updatedCookie += "; " + optionKey;
        var optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += "=" + optionValue;
        }
    }
  
    document.cookie = updatedCookie;
}
function deleteCookie(name) {
    setCookie(name, "", {
        'max-age': -1
    })
}


let form, sendData = {}, flag = true
$(document).on('click', '[role="sendForm"]', function() {
    
    flag = true
    form = $(this).parent().parent().parent()
    
    $(form).find('input, select, textarea').each( function( i, e ) {
        if ( $(e).attr('required') && !$(e).val() ) {
            flag = false
            $(e).addClass('is-invalid')
        } else if ( $(e).attr('required') && !!$(e).val() ) {
            $(e).addClass('is-valid')
        }
        sendData[$(e).attr('name')] = $(e).val()
    })
    if ( form.find('input[name="AGRYY"]').length > 0 && !$(form.find('input[name="AGRYY"]')).is(':checked') ) {
        flag = false
        $(form.find('input[name="AGRYY"]')).addClass('is-invalid')
    }

    if ( flag ) {

        $(form).find('.form-cover').removeClass('d-none').addClass('d-flex')
        sendData.SOURCE = location.href
        
        $.ajax({
            type: 'POST',
            url: '/api/cabinet/',
            data: sendData,
            success: (data) => { 
                res = JSON.parse( data )
                
                if ( res.status == 'success'  ) {

                    form.parent().find('[role="success"], [role="error"], [role="description"]').hide()
                    form.parent().find('[role="success"]').show()
                    form.parent().parent().find('.blue-cover').toggleClass('sended')
                    form.hide()

                } else {
                    
                    form.parent().find('[role="success"], [role="error"]').hide()
                    form.parent().find('[role="error"]').show()
                }

                setTimeout(() => {
                    
                    form.parent().find('[role="success"], [role="error"]').hide()
                    form.parent().find('[role="description"]').show()
                    form.parent().parent().find('.blue-cover').toggleClass('sended')
                    form.show()

                }, 5000);

                $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')
            },
            error: () => { 
                console.log( 'error' ); 
                res = {status: 'error', description: 'Ошибка на сервере'}
                
                form.parent().find('[role="success"], [role="error"]').hide()
                form.parent().find('[role="error"]').show()

                $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')
            }
        });
    }

    return false;
})





$(document).mouseup( function(e){ // событие клика по веб-документу
    let div = $('.filter-droplist'); // тут указываем ID элемента
    let container = $('.filter-dropcontainer'); 
    if ( !div.is(e.target)
        && div.has(e.target).length === 0
        && !container.is(e.target)
        && container.has(e.target).length === 0) { // и не по его дочерним элементам
        div.addClass('d-none'); // скрываем его
        $(container).find('.filter-dropdown').removeClass('filter-dropdown-opened');
    }
});
$(document).on('click', '.form .form-card .filter-dropcontainer', function() {
    $(this).find('.filter-dropdown').toggleClass('filter-dropdown-opened');
    $(this).find('.filter-droplist').toggleClass('d-none d-block');
    $(this).find('img').toggleClass('rotate-180');
});
$(document).on('click', '.form .form-card .filter-dropcontainer .filter-droplist-item', function() {

    $(this).siblings().removeClass('bg-yalightgray selected fw-bold');
    $(this).toggleClass('bg-yalightgray selected fw-bold');
    $(this).parent().parent().parent().siblings('input').val($(this).data('value'));
    $($(this).parent().siblings().find('span')[0]).text( (($(this).hasClass('selected'))?$(this).data('text'):$(this).data('title')+'(все)'));
    $(this).parent().addClass('d-none');


    return false;
});

$(document).on('click', 'a[data-form]', function() {
    $('.forms-modal-cover').addClass('active');
    $('.forms-modal').removeClass('active');
    $('.forms-modal[data-form="'+$(this).data('form')+'"]').addClass('active');

    return false;
});
$(document).on('click', 'a.forms-modal-close, .forms-modal-cover', function() {
    $('.forms-modal-cover').removeClass('active');
    $('.forms-modal').removeClass('active');

    return false;
});
$(document).on('click', '[role="setDealership"]', function() {
    $('.forms-modal[data-form="'+$(this).data('form')+'"] .form .form-card .filter-dropcontainer .filter-droplist-item').removeClass('bg-yalightgray selected fw-bold');
    $('.forms-modal[data-form="'+$(this).data('form')+'"] .form .form-card .filter-dropcontainer .filter-droplist-item[data-value="'+$(this).data('dealership')+'"]').addClass('bg-yalightgray selected fw-bold');
    $($('.forms-modal[data-form="'+$(this).data('form')+'"] .form .form-card .filter-dropcontainer').find('span')[0]).text($('.forms-modal[data-form="'+$(this).data('form')+'"] .form .form-card .filter-dropcontainer .filter-droplist-item[data-value="'+$(this).data('dealership')+'"]').data('text'))
    $('.forms-modal[data-form="'+$(this).data('form')+'"] .form .form-card input[name="DEALERSHIP"]').val($(this).data('dealership'));
});




/* CABINET */
var swiperVehicleThumbs = new Swiper(".vehicle-swiper-thumbs", {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
});
var swiperVehicle = new Swiper(".vehicle-swiper", {
    spaceBetween: 10,
    navigation: {
        nextEl: ".vehicle-swiper-next",
        prevEl: ".vehicle-swiper-prev",
    },
    thumbs: {
      swiper: swiperVehicleThumbs,
    },
});
$(document).on('click', '[role="offerConfim"]', function() {
    $('[role="confim-action"]').addClass('d-none');
    $('[role="confim-action"][data-action="'+$(this).data('action')+'"]').removeClass('d-none');
    $('[data-remodal-id="cabinet-offer-confirm"] input[name="ACTION"]').val($(this).data('action'));
    $('[data-remodal-id="cabinet-offer-confirm"] input[name="VIN"]').val($(this).data('vin'));
    $('[data-remodal-id="cabinet-offer-confirm"] input[name="DOC"]').val($(this).data('doc'));
});
$(document).on('click', 'label[for="reason4"], input#reason4', function() {
    $('[data-remodal-id="cabinet-me-delete"] input[name="COMMENT"]').attr('disabled', false);
});
// $(document).on('click', 'label[for="reason1"], input#reason1, label[for="reason2"], input#reason2, label[for="reason3"], input#reason3', function() {
//     $('[data-remodal-id="cabinet-me-delete"] input[name="COMMENT"]').attr('disabled', true);
// });


const validators = {
    fio: (v) => /^[А-Яа-яЁё\s]+$/.test(v.trim()),
    email: (v) => /^\S+@\S+\.\S+$/.test(v),
    password: (v) => /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^\w\s]).{12,}$/.test(v),
    confirmPassword: () => inputs.password.value === inputs.confirmPassword.value
};

$('input.form-check-input[role="enableSubmit"]').on('change', function() {
    if ( $(this).is(':checked') ) {
        $(this).closest('form').find('button[type="submit"]').removeClass('bg-yadisabled').attr('disabled', false);

    } else {
        $(this).closest('form').find('button[type="submit"]').addClass('bg-yadisabled').attr('disabled', true);
    }
});