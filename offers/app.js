/////////// FILTER
$(document).mouseup( function(e){ // событие клика по веб-документу
    let div = $('.filter-droplist'); // тут указываем ID элемента
    let container = $('.filter-dropcontainer'); 
    if ( !div.is(e.target)
        && div.has(e.target).length === 0
        && !container.is(e.target)
        && container.has(e.target).length === 0) { // и не по его дочерним элементам
        div.addClass('d-none'); // скрываем его
    }
});
$(document).on('click', '[data-action="expandFilter"]', function() {
    $('.blue-cover').toggleClass('active');
    $('.filter .collapse').toggleClass('d-none d-flex');
    return false;
});
$(document).on('click', '.filter-dropcontainer', function() {
    $(this).find('.filter-droplist').toggleClass('d-none d-block');
    $(this).find('img').toggleClass('rotate-180');
});
$(document).on('click', '[data-action="expandBrands"]', function() {
    $('.brands-list-item.hidden').toggleClass('d-none');
    $(this).find('span').toggleClass('d-none');
    $(this).find('img').toggleClass('rotate-180');
    return false;
});


let makeUrl = function( url, params ) {
    url += ( url.indexOf('?') < 0 ) ? '?' : '&';
    let tmp = [];
    for ( let k in params ) tmp.push( k+'='+params[k] );
    url += tmp.join('&');
    return url;
}
let formatNumber = function(q) {
    var Price = new Intl.NumberFormat('ru', { currency: 'RUR' })
    return Price.format(Number(q))
}

const range_price = $('[data-range="price"] .range-selected');
const rangeInput_price = $('[data-range="price"][role="range"] .range-input input');
const rangeView_price = $('[data-range="price"][role="view"] .range-view input');
rangeInput_price.each( function(i,e) {
    e.addEventListener('input', (e) => {
        let minRange = parseInt(rangeInput_price[0].value);
        let maxRange = parseInt(rangeInput_price[1].value);
        let min = parseInt(rangeInput_price[0].min);
        let max = parseInt(rangeInput_price[1].max);
        rangeView_price[0].value = String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_price[1].value = String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        $(range_price).css('left', (minRange-min)/(max-min)*100+'%');
        $(range_price).css('right', (max-maxRange)/(max-min)*100+'%');
    });
    e.addEventListener('mouseup', (e) => {
        let minRange = parseInt(rangeInput_price[0].value);
        let maxRange = parseInt(rangeInput_price[1].value);
        if ( minRange != parseInt($(range_price).data('min')) || maxRange != parseInt($(range_price).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl( $(range_price).data('url'), {'price': minRange+','+maxRange});
        }
    });
    e.addEventListener('touchend', (e) => {
        let minRange = parseInt(rangeInput_price[0].value);
        let maxRange = parseInt(rangeInput_price[1].value);
        if ( minRange != parseInt($(range_price).data('min')) || maxRange != parseInt($(range_price).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl( $(range_price).data('url'), {'price': minRange+','+maxRange});
        }
    });
});
rangeView_price.each( function(i,e) {
    e.addEventListener('input', (e) => {
        rangeView_price[0].value = String(rangeView_price[0].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_price[1].value = String(rangeView_price[1].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        let minView = parseInt( String(rangeView_price[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_price[1].value).replace(/\D/g, "") );
        let min = parseInt(rangeInput_price[0].min);
        let max = parseInt(rangeInput_price[1].max);
        if ( minView>=min && maxView<=max ) {
            rangeInput_price[0].value = minView;
            rangeInput_price[1].value = maxView;
            $(range_price).css('left', (minView-min)/(max-min)*100+'%');
            $(range_price).css('right', (max-maxView)/(max-min)*100+'%');
        }
    });
    e.addEventListener('blur', (e) => {
        let minView = parseInt( String(rangeView_price[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_price[1].value).replace(/\D/g, "") );
        if ( minView != parseInt($(range_price).data('min')) || maxView != parseInt($(range_price).data('max')) ) window.location = makeUrl( $(range_price).data('url'), {'price': minView+','+maxView});
    });
});

const range_volume = $('[data-range="volume"] .range-selected');
const rangeInput_volume = $('[data-range="volume"][role="range"] .range-input input');
const rangeView_volume = $('[data-range="volume"][role="view"] .range-view input');
rangeInput_volume.each( function(i,e) {
    e.addEventListener('input', (e) => {
        let minRange = parseInt(rangeInput_volume[0].value);
        let maxRange = parseInt(rangeInput_volume[1].value);
        let min = parseInt(rangeInput_volume[0].min);
        let max = parseInt(rangeInput_volume[1].max);
        rangeView_volume[0].value = String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_volume[1].value = String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        $(range_volume).css('left', (minRange-min)/(max-min)*100+'%');
        $(range_volume).css('right', (max-maxRange)/(max-min)*100+'%');
    });
    e.addEventListener('mouseup', (e) => {
        let minRange = parseInt(rangeInput_volume[0].value);
        let maxRange = parseInt(rangeInput_volume[1].value);
        if ( minRange != parseInt($(range_volume).data('min')) || maxRange != parseInt($(range_volume).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl( $(range_volume).data('url'), {'volume': minRange+','+maxRange});
        }
    });
    e.addEventListener('=touchend', (e) => {
        let minRange = parseInt(rangeInput_volume[0].value);
        let maxRange = parseInt(rangeInput_volume[1].value);
        if ( minRange != parseInt($(range_volume).data('min')) || maxRange != parseInt($(range_volume).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl( $(range_volume).data('url'), {'volume': minRange+','+maxRange});
        }
    });
});
rangeView_volume.each( function(i,e) {
    e.addEventListener('input', (e) => {
        rangeView_volume[0].value = String(rangeView_volume[0].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_volume[1].value = String(rangeView_volume[1].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        let minView = parseInt( String(rangeView_volume[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_volume[1].value).replace(/\D/g, "") );
        let min = parseInt(rangeInput_volume[0].min);
        let max = parseInt(rangeInput_volume[1].max);
        if ( minView>=min && maxView<=max ) {
            rangeInput_volume[0].value = minView;
            rangeInput_volume[1].value = maxView;
            $(range_volume).css('left', (minView-min)/(max-min)*100+'%');
            $(range_volume).css('right', (max-maxView)/(max-min)*100+'%');
        }
    });
    e.addEventListener('blur', (e) => {
        let minView = parseInt( String(rangeView_volume[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_volume[1].value).replace(/\D/g, "") );
        if ( minView != parseInt($(range_volume).data('min')) || maxView != parseInt($(range_volume).data('max')) ) window.location = makeUrl( $(range_volume).data('url'), {'volume': minView+','+maxView});
    });
});

const range_power = $('[data-range="power"] .range-selected');
const rangeInput_power = $('[data-range="power"][role="range"] .range-input input');
const rangeView_power = $('[data-range="power"][role="view"] .range-view input');
rangeInput_power.each( function(i,e) {
    e.addEventListener('input', (e) => {
        let minRange = parseInt(rangeInput_power[0].value);
        let maxRange = parseInt(rangeInput_power[1].value);
        let min = parseInt(rangeInput_power[0].min);
        let max = parseInt(rangeInput_power[1].max);
        rangeView_power[0].value = String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_power[1].value = String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        $(range_power).css('left', (minRange-min)/(max-min)*100+'%');
        $(range_power).css('right', (max-maxRange)/(max-min)*100+'%');
    });
    e.addEventListener('mouseup', (e) => {
        let minRange = parseInt(rangeInput_power[0].value);
        let maxRange = parseInt(rangeInput_power[1].value);
        if ( minRange != parseInt($(range_power).data('min')) || maxRange != parseInt($(range_power).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl( $(range_power).data('url'), {'power': minRange+','+maxRange});
        }
    });
    e.addEventListener('touchend', (e) => {
        let minRange = parseInt(rangeInput_power[0].value);
        let maxRange = parseInt(rangeInput_power[1].value);
        if ( minRange != parseInt($(range_power).data('min')) || maxRange != parseInt($(range_power).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl( $(range_power).data('url'), {'power': minRange+','+maxRange});
        }
    });
});
rangeView_power.each( function(i,e) {
    e.addEventListener('input', (e) => {
        rangeView_power[0].value = String(rangeView_power[0].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_power[1].value = String(rangeView_power[1].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        let minView = parseInt( String(rangeView_power[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_power[1].value).replace(/\D/g, "") );
        let min = parseInt(rangeInput_power[0].min);
        let max = parseInt(rangeInput_power[1].max);
        if ( minView>=min && maxView<=max ) {
            rangeInput_power[0].value = minView;
            rangeInput_power[1].value = maxView;
            $(range_power).css('left', (minView-min)/(max-min)*100+'%');
            $(range_power).css('right', (max-maxView)/(max-min)*100+'%');
        }
    });
    e.addEventListener('blur', (e) => {
        let minView = parseInt( String(rangeView_power[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_power[1].value).replace(/\D/g, "") );
        if ( minView != parseInt($(range_power).data('min')) || maxView != parseInt($(range_power).data('max')) ) window.location = makeUrl( $(range_power).data('url'), {'power': minView+','+maxView});
    });
});

const range_year = $('[data-range="year"] .range-selected');
const rangeInput_year = $('[data-range="year"][role="range"] .range-input input');
const rangeView_year = $('[data-range="year"][role="view"] .range-view input');
rangeInput_year.each( function(i,e) {
    e.addEventListener('input', (e) => {
        let minRange = parseInt(rangeInput_year[0].value);
        let maxRange = parseInt(rangeInput_year[1].value);
        let min = parseInt(rangeInput_year[0].min);
        let max = parseInt(rangeInput_year[1].max);
        rangeView_year[0].value = String(minRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_year[1].value = String(maxRange).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        $(range_year).css('left', (minRange-min)/(max-min)*100+'%');
        $(range_year).css('right', (max-maxRange)/(max-min)*100+'%');
    });
    e.addEventListener('mouseup', (e) => {
        let minRange = parseInt(rangeInput_year[0].value);
        let maxRange = parseInt(rangeInput_year[1].value);
        if ( minRange != parseInt($(range_year).data('min')) || maxRange != parseInt($(range_year).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl( $(range_year).data('url'), {'year': minRange+','+maxRange});
        }
    });
    e.addEventListener('touchend', (e) => {
        let minRange = parseInt(rangeInput_year[0].value);
        let maxRange = parseInt(rangeInput_year[1].value);
        if ( minRange != parseInt($(range_year).data('min')) || maxRange != parseInt($(range_year).data('max')) ) {
            $('#YappsShowroom .cover').removeClass('d-none');
            window.location = makeUrl( $(range_year).data('url'), {'year': minRange+','+maxRange});
        }
    });
});
rangeView_year.each( function(i,e) {
    e.addEventListener('input', (e) => {
        rangeView_year[0].value = String(rangeView_year[0].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        rangeView_year[1].value = String(rangeView_year[1].value).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ");
        let minView = parseInt( String(rangeView_year[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_year[1].value).replace(/\D/g, "") );
        let min = parseInt(rangeInput_year[0].min);
        let max = parseInt(rangeInput_year[1].max);
        if ( minView>=min && maxView<=max ) {
            rangeInput_year[0].value = minView;
            rangeInput_year[1].value = maxView;
            $(range_year).css('left', (minView-min)/(max-min)*100+'%');
            $(range_year).css('right', (max-maxView)/(max-min)*100+'%');
        }
    });
    e.addEventListener('blur', (e) => {
        let minView = parseInt( String(rangeView_year[0].value).replace(/\D/g, "") );
        let maxView = parseInt( String(rangeView_year[1].value).replace(/\D/g, "") );
        if ( minView != parseInt($(range_year).data('min')) || maxView != parseInt($(range_year).data('max')) ) window.location = makeUrl( $(range_year).data('url'), {'year': minView+','+maxView});
    });
});







// VEHICLE
// if ( $('.vehicle-title .list-inline').length > 0 ) {
//     let vehicleTitlePosition = $('.vehicle-title').offset();
//     $(document).scroll(function() {
//         if ($(this).scrollTop() >= vehicleTitlePosition.top) {
//             $('.vehicle-title .list-inline').addClass('d-none');
//             $('.vehicle-title').scroll()
//         } else if ($(this).scrollTop() < vehicleTitlePosition.top) {
//             $('.vehicle-title .list-inline').removeClass('d-none');
//         }
//     });
// }

$(document).on('click', '.vehicle-tabs-title-item', function() {
    if ( $(this).hasClass('b-b-yalightgray') ) {
        $('.vehicle-tabs-title-item').toggleClass('c-yadarkgray b-b-yalightgray b-b-yayellow');
        $('.vehicle-tabs-content').toggleClass('active');
    }
    return false;
});
$(document).on('click', '.vehicle-tabs-content-accordeon-title', function() {
    $(this).find('img').toggleClass('rotate-180');
    $('.vehicle-options').each( (i,e) => {
        if ( $(e).data('index') == $(this).data('index') ) {
            $(e).slideToggle(200);
        } else {
            $(e).slideUp(200);
            $('.vehicle-tabs-content-accordeon-title[data-index="'+$(e).data('index')+'"]').find('img').removeClass('rotate-180');
        }
    });
});
$(document).on('click', '.toggle-vehicle-options[role="open"]', () => {
    $('.vehicle-tabs-content-accordeon-title').find('img').addClass('rotate-180');
    $('.vehicle-options').each( function(i,e) {
        $(e).slideDown(200);
    });
    $('.toggle-vehicle-options').toggleClass('d-none');
});
$(document).on('click', '.toggle-vehicle-options[role="hide"]', () => {
    $('.vehicle-tabs-content-accordeon-title').find('img').removeClass('rotate-180');
    $('.vehicle-options').each( function(i,e) {
        $(e).slideUp(200);
    });
    $('.toggle-vehicle-options').toggleClass('d-none');
});

$(document).on('click', '.vehicle-discounts-item', function() {
    
    $(this).toggleClass('active');
    $(this).find('.vehicle-discounts-item-check').toggleClass('bg-yayellow bg-yalightgray');
    $(this).find('.vehicle-discounts-item-check img').toggleClass('d-none');

    let minPrice = parseInt( String($(this).data('min')).replace(/\D/g, "") );
    let price = parseInt( String($(this).data('price')).replace(/\D/g, "") );
    let discount = 0;

    $('.vehicle-discounts-item.active').each( function(i,e) {
        discount += parseInt( String($(this).data('sum')).replace(/\D/g, "") );
    });
    if ( price - discount < minPrice ) discount = price - minPrice;

    $('[role="min-price"]').text( formatNumber(price-discount)+' ₽' );
});

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
    // pagination: {
    //     el: ".swiper-pagination",
    //     clickable: true
    // },
    thumbs: {
      swiper: swiperVehicleThumbs,
    },
});
var swiperVehicleRecomended = new Swiper(".vehicle-recomended-swiper", {
    spaceBetween: 24,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesProgress: true,
    navigation: {
        nextEl: ".vehicle-recomended-swiper-next",
        prevEl: ".vehicle-recomended-swiper-prev",
    },
    breakpoints: {
        320: {
            slidesPerView: 1,
            spaceBetween: 10,
            slidesPerGroup: 1,
        },
        768: {
            slidesPerView: 2,
            spaceBetween: 24,
            slidesPerGroup: 6,
        },
        1024: {
            slidesPerView: 3,
            spaceBetween: 24,
            slidesPerGroup: 4,
        },
        1440: {
            slidesPerView: 4,
            spaceBetween: 24,
            slidesPerGroup: 6,
        }
    },
});





///////////// Vehicle card
$(document).on('mouseover', '.vehicle-card-images-row-item', function() {
    $(this).parent().parent().find('[role="vehicle-image"] img').hide()
    $(this).parent().parent().find('[role="vehicle-image"] img[data-index="'+$(this).data('index')+'"]').show()
    $(this).siblings('.vehicle-card-images-row-item').removeClass('active');
    $(this).addClass('active');
});
$(document).on('click', '[role="setDealership"]', function() {
    window['SELECTED_DEALERSHIP_CODE--_line'] = $(this).data('dealership')
    window['SELECTED_DEALERSHIP_CODE--_block'] = $(this).data('dealership')
    window['SELECTED_DEALERSHIP_CODE--_modal'] = $(this).data('dealership')
});






$(document).on('click', '[data-action="set-vehicle"]', function() {
    $('[data-remodal-id="offer-modal"]').find('input[name="vehicle"]').val($(this).data('vehicle-id'));
    $('[data-remodal-id="offer-modal"]').find('h4 span').text('на '+$(this).data('vehicle-name'));
});
$(document).on('click', '[action="sendShowroomForm"]', function() {
    
    let form, sendData = [], flag = true

    form = $(this).parent().parent().parent().parent()

    $(form).find('input, select, textarea').each( function( i, e ) {
        if ( $(e).attr('required') && !$(e).val() ) {
            flag = false
            $(e).addClass('is-invalid')
        }
        // sendData[$(e).attr('name')] = $(e).val()
    })
    if ( !$(form.find('input[name="aggry"]')).is(':checked') ) {
        flag = false
        $(form.find('input[name="aggry"]')).addClass('is-invalid')
    }

    if ( flag ) {

        sendData.push({name: 'src', value: window.location.href})
        sendData.push({name: 'AppName', value: 'Cis'})
        sendData.push({name: 'form', value: $(form).find('input[name="form"]').val()})
        sendData.push({name: 'mode', value: $(form).data('mode')})
        sendData.push({name: 'name', value: $(form).find('input[name="name"]').val()})
        sendData.push({name: 'phone', value: $(form).find('input[name="phone"]').val()})
        if ( typeof $(form).find('input[name="vehicle"]').val() !== 'undefined' ) sendData.push({name: 'vehicle', value: $(form).find('input[name="vehicle"]').val()})
        if ( typeof $(form).find('select[name="dealership"]').val() !== 'undefined' ) sendData.push({name: 'dealership', value: $(form).find('select[name="dealership"]').val()})
        if ( typeof $(form).find('input[name="car"]').val() !== 'undefined' ) sendData.push({name: 'car', value: $(form).find('input[name="car"]').val()})
        if ( typeof $(form).find('input[name="year"]').val() !== 'undefined' ) sendData.push({name: 'year', value: $(form).find('input[name="year"]').val()})
        if ( typeof $(form).find('input[name="condition"]').val() !== 'undefined' ) sendData.push({name: 'condition', value: $(form).find('input[name="condition"]').val()})
        
        $.ajax({
            type: 'POST',
            url: 'https://apps.yug-avto.ru/API/get/cis/send/?token=34b5ac8b71018c0bc7e5c050ed90b243',
            data: sendData,
            success: (data) => { 
                res = JSON.parse( data )

                console.log( sendData )
                
                if ( res.status  ) {

                    form.parent().find('[role="success"], [role="error"], [role="description"]').hide()
                    form.parent().find('[role="success"]').show()
                    form.hide()

                    $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')

                    var CallTouchURL = 'https://api.calltouch.ru/calls-service/RestAPI/requests/20930/register/';
					CallTouchURL += '?subject=Формы - '+sendData[2].value;
					CallTouchURL += '&sessionId='+window['call_value_e94ad128']
					CallTouchURL += '&fio='+sendData[4].value;
					CallTouchURL += '&phoneNumber='+sendData[5].value.replace(/[^\d;]/g, '');
                    
                    let request = new XMLHttpRequest();
                    request.open('GET', CallTouchURL, true);
                    request.send();

                    // ym(31748036,'reachGoal',$(form).data('sid'))

                } else {
                    
                    form.parent().find('[role="success"], [role="error"]').hide()
                    form.parent().find('[role="error"]').show()
                }

                setTimeout(() => {
                    
                    form.parent().find('[role="success"], [role="error"]').hide()
                    form.parent().find('[role="description"]').show()
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






$(document).on('click', '.vehicles-more-button', function () {
    let total = Number($(this).data('total')), current = Number($(this).data('current'));
    let next = current + 1;
    let baseUrl = $(this).data('app-url');
    $.post(
        baseUrl + '/api/',
        {
            url: $(this).data('url'),
            next: next
        }
    ).done( (data) => {
        $('.vehicle-list').append(data);
        $(this).data('current', next);
        if ( next == total ) $(this).parent().parent().addClass('d-none');
        // $('.vehicles-pagination [role="pagination"][data-page="'+next+'"]').toggleClass('c-yayellow c-h-yayellow c-yadarkgray c-h-yadarkgray');
    })
    return false;
});

function getCityName( q ) {

    switch ( q ) {
        case 'krasnodar': return 'Краснодар'; break;
        case 'maykop': return 'Майкоп'; break;
        case 'novorossiysk': return 'Новороссийск'; break;
        case 'yablonovskiy': return 'Яблоновский'; break;
        default: return '';
    }
}
function getCityAlias( q ) {

    switch ( q ) {
        case 'Краснодар': return 'krasnodar'; break;
        case 'Майкоп': return 'maykop'; break;
        case 'Новороссийск': return 'novorossiysk'; break;
        case 'Яблоновский': return 'yablonovskiy'; break;
        default: return '';
    }
}
function buildQuery( o ) {

    let res = [];
    for ( let i in o ) res.push( i+'='+o[i] );

    return res.join('&');
}

function buildCityLink( c ) {
    
    let path = location.pathname.split('/'), city = '', t = [];
    let parts = window.location.search.substr(1).split("&");
    let $_GET = {};
    for (let i = 0; i < parts.length; i++) {
        let temp = parts[i].split("=");
        $_GET[decodeURIComponent(temp[0])] = decodeURIComponent(temp[1]);
    }
    for ( let i in $_GET ) {
        if ( !i.length || !$_GET[i].length ) delete $_GET[i];
    }
    
    switch( JSON.parse(c).length ) {
        case 0:
            path.splice(3, 1);
            if ( typeof $_GET.city != 'undefined' ) delete $_GET.city;
            break;
        case 1:
            path.splice(3, 0, JSON.parse(c)[0]);
            if ( typeof $_GET.city != 'undefined' ) delete $_GET.city;
            break;
        default:
            switch ( path[3] ) {
                case 'krasnodar':
                case 'maykop':
                case 'novorossiysk':
                case 'yablonovskiy':
                    path.splice(3, 1);
                    break;
            }
            JSON.parse(c).forEach(e => {
                t.push( getCityName(e) );
            });
            $_GET.city = t.join(',');
            break;
    }
    return path.join('/')+((Object.keys($_GET).length!=0)?'?'+buildQuery($_GET):'');
}





var swiperCompare= new Swiper(".swiper-compare", {
    freeMode: true,
    scrollbar: {
        el: ".swiper-scrollbar",
        hide: true,
    },
    navigation: {
        nextEl: ".compare-nav-next",
        prevEl: ".compare-nav-prev",
    },
    breakpoints: {
        575.98: {
            slidesPerView: 1.3,
            spaceBetween: 10,
        },
        767.98: {
            slidesPerView: 1.3,
            spaceBetween: 24,
        },
        991.98: {
            slidesPerView: 1.8,
            spaceBetween: 24,
        },
        1199.98: {
            slidesPerView: 2.9,
            spaceBetween: 24,
        }
    },
});
$(document).on('click', '.compare-body-title', function() {
    $('.compare-body-items[data-index="'+$(this).data('index')+'"]').toggleClass('d-none')
    $(this).find('img').toggleClass('rotate-180')
});


CONNECTOR.RELOAD = setInterval(() => {
    if ( getCookie('SELECTED_CITY') != CONNECTOR.SELECTED_CITY ) {

        $('#YappsShowroom .cover').removeClass('d-none');
        window.location.href = buildCityLink(getCookie('SELECTED_CITY'));
        clearInterval(CONNECTOR.RELOAD);
    }
}, 100);
$(document).on('click', '#YappsShowroom a:not([role="not-cover"])', () => {
    $('#YappsShowroom .cover').removeClass('d-none')
});