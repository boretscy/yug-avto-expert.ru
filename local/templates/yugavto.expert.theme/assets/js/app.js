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

CONNECTOR.SELECTED_CITY = JSON.parse(getCookie('SELECTED_CITY') || '[]');
CONNECTOR.CIS_FAVORITES = JSON.parse(getCookie('CIS_FAVORITES') || '[]');
CONNECTOR.CIS_COMPARE = JSON.parse(getCookie('CIS_COMPARE') || '[]');

$(document).on('click', '[role="toggle-fav-com"], [action="toggle-fav-com"]', function() {

    let vehicle = Number($(this).data('vehicle')), target = $(this).data('target');
    let indx = CONNECTOR[target].indexOf(vehicle);
    if ( indx >= 0 ) {
        CONNECTOR[target].splice(indx, 1);
    } else {
        CONNECTOR[target].push(vehicle);
    }
    $(this).toggleClass('bg-yawhite bg-yayellow');
    setCookie(target, JSON.stringify(CONNECTOR[target]), {'max-age': 3600*24*14});

    return false;
});

document.addEventListener('DOMContentLoaded', () => {
   /* document.querySelectorAll('.spoiler__container').forEach(spoiler => spoiler.addEventListener('click', e => {
         spoiler.classList.toggle('--is-open');
    }))*/

    document.querySelectorAll('.spoiler__header').forEach(spoiler => spoiler.addEventListener('click', e => {
        spoiler.parentElement.classList.toggle('--is-open');
    }))
    
    /*Форма обратной связи, скрытое поле*/
    document.querySelectorAll('.form--hidden').forEach(hidden => hidden.addEventListener('click', e => {
        hidden.parentElement.classList.add('--is-open');
        document.querySelectorAll('.close').forEach(close => close.addEventListener('click', e => {
            hidden.parentElement.classList.remove('--is-open');
        }))
    }))
    /*Форма обратной связи, скрытое поле*/
})

let form, sendData = {}, flag = true
$(document).on('click', '[role="sendForm"]', function() {
    
    flag = true

    if ( $(this).data('form') == 'FORM.BLOCK.SEMIBLUE' ) {
        form = $(this).parent().parent().parent().parent()
        sendData.FORM = $(this).data('name')
    } else {
        form = $(this).parent().parent().parent()
        sendData.FORM = $(this).data('name')
    }
    $(form).find('input, select, textarea').each( function( i, e ) {
        if ( $(e).attr('required') && !$(e).val() ) {
            flag = false
            $(e).addClass('is-invalid')
        } else if ( $(e).attr('required') && !!$(e).val() ) {
            $(e).addClass('is-valid')
        }
        sendData[$(e).attr('name')] = $(e).val()
    })
    if ( !$(form.find('input[name="AGRYY"]')).is(':checked') ) {
        flag = false
        $(form.find('input[name="AGRYY"]')).addClass('is-invalid')
    }

    if ( flag ) {

        $(form).find('.form-cover').removeClass('d-none').addClass('d-flex')
        sendData.SOURCE = location.href
        
        $.ajax({
            type: 'POST',
            url: '/api/send/',
            data: sendData,
            success: (data) => { 
                res = JSON.parse( data )
                
                if ( res.status == 'success'  ) {

                    form.parent().find('[role="success"], [role="error"], [role="description"]').hide()
                    form.parent().find('[role="success"]').show()
                    form.parent().parent().find('.blue-cover').toggleClass('sended')
                    form.hide()

                    $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')

                    var CallTouchURL = 'https://api.calltouch.ru/calls-service/RestAPI/requests/20930/register/';
					CallTouchURL += '?subject=Формы - '+sendData.FORM;
					CallTouchURL += '&sessionId='+window['call_value_e94ad128']
					CallTouchURL += '&fio='+sendData.NAME;
					CallTouchURL += '&phoneNumber='+sendData.PHONE.replace(/[^\d;]/g, '');
                    
                    let request = new XMLHttpRequest();
                    request.open('GET', CallTouchURL, true);
                    request.send();

                    ym(31748036,'reachGoal',$(form).data('sid'))

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

$(document).on('click', 'a[href^="tel"], a[href^="phone"]', function() {
    ym(31748036,'reachGoal','PHONE_CLICK')
});


$(document).on('click', '.up-button', function() {

    $('html, body').animate({
        scrollTop: $('body').offset().top
    }, 200);
    return false;
});
$(window).scroll(function() {
    if ( $(this).scrollTop() >= 100 ) {
        $('.up-button').removeClass('d-none')
    } else {
        $('.up-button').addClass('d-none')
    }
});



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