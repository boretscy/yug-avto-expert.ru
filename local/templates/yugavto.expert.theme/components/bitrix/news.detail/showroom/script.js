function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}
function FormatPhoneOut(q) {
    q = FormatPhoneIn(q)
    return '+' + '7' + ' (' + q[1] + q[2] + q[3] + ') ' + q[4] + q[5] + q[6] + '-' + q[7] + q[8] + '-' + q[9] + q[10];
}
function FormatPhoneIn(q) {
    q = String(q).replace(/[^\d;]/g, '')
    if ( q.length == 10 ) q = '7'+q
    if ( q.length == 7 ) q = '7861'+q
    return '7'+q.slice(1);
}
function Format(q) {

    var Price = new Intl.NumberFormat('ru', { currency: 'RUR' })
    return Price.format(Number(q))
}
function dealershipMapInit(coords = [45,45], name = 'Юг-Авто') {

    if ( typeof dealershipMap != 'undefined' ) dealershipMap.destroy()
    
    dealershipMap = new ymaps.Map('dealershipMap', {

        center: [coords[0], coords[1]],
        zoom: 15
    }, {
        searchControlProvider: 'yandex#search'
    });
    dealershipMap.behaviors.disable('scrollZoom');
    dealershipMap.geoObjects.add(new ymaps.Placemark(
        [coords[0], coords[1]],
        {balloonContent: name, iconCaption: name},
        {preset: "islands#darkBlueDotIconWithCaption"}
    ))
}


var dealershipMap
ymaps.ready(dealershipMap)

let CIS_DEALERSHIP = null, NEW_CIS_DEALERSHIP = null, 
    slide = '', 
    dealership = null, offers = [], 
    CIS_DETAIL_PAGE = false, 
    NEW_CIS_VEHICLE_ID = null, CIS_VEHICLE_ID = null, others = [], CIS_VEHICLE_NAME = null

setInterval(() => { 

    NEW_CIS_DEALERSHIP = getCookie( 'CIS_DEALERSHIP' )
    CIS_DETAIL_PAGE = getCookie( 'CIS_DETAIL_PAGE' )
    NEW_CIS_VEHICLE_ID = getCookie('CIS_VEHICLE_ID')
    CIS_VEHICLE_NAME = getCookie('CIS_VEHICLE_NAME')

    if ( Number(CIS_DETAIL_PAGE) ) {
        
        if ( NEW_CIS_DEALERSHIP != CIS_DEALERSHIP ) {
            
            CIS_DEALERSHIP = NEW_CIS_DEALERSHIP
            if ( typeof swiper_cis_offers != 'undefined' ) swiper_cis_offers.destroy(true, true)
            $.get('/api/offers?dealership='+CIS_DEALERSHIP, function(data) {
                
                offers = JSON.parse(data)
                if ( offers.length ) {

                    $('.cis-offers').show()

                    slide = ''
                    JSON.parse(data).forEach(item => {
                        
                        slide += '<div class="swiper-slide"><div class="b-radius-small b-yagray bg-yawhite offer-item">'
                        slide += '<a href="'+item.DETAIL_PAGE_URL+'" alt="'+item.NAME+'" class=" text-decoration-none c-yablack c-h-yadarkgray">'
                        slide += '<img src="'+item.PREVIEW_PICTURE+'" alt="'+item.NAME+'" class="w-100 b-b-yagray fix-h__img" />'
                        
                        slide += '<div class="row mt-3 с-yamiddlegray">'
                        
                        slide += '<div class="col ps-4 text-start">'
                        item.TAG.forEach(tag => {
                            slide += '<span class="me-2 text-minus-minus c-yamiddlegray offers-item-tag">'+tag+'</span>'
                        })
                        slide += '</div>'
                        
                        slide += '<div class="col text-end pe-4">'
                        if ( item.ACTIVE_TO ) slide += '<span class="text-minus c-yamiddlegray">до '+item.ACTIVE_TO+'</span>'
                        slide += '</div>'
        
                        slide += '</div>'
        
                        slide += '<div class="row mb-3 fix_h">'
                        slide += '<div class="col-10 d-block mt-2 px-4 offers-item-title text-start">'+item.NAME+'</div>'
                        
                        slide += '<div class="col-2">'
                        slide += '<svg xmlns="http://www.w3.org/2000/svg"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#corner-right"></use></svg>'
                        slide += '</div>'

                        slide += '</div>'
        
        
                        slide += '</div></div>'
                    })
        
                    $('[role="cis-offers-swiper"]').html(slide)
        
                    const swiper_cis_offers = new Swiper('.swiper-cis-offers', {
                        pagination: {
                            el: ".swiper-pagination",
                            type: "fraction",
                        },
                        navigation: {
                            nextEl: '.swiper-cis-offers-button-next',
                            prevEl: '.swiper-cis-offers-button-prev',
                        },
                        slidesPerView: 3,
                        spaceBetween: 25,
                        slidesPerGroup: 3,
                        
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
                                slidesPerView: 3,
                                spaceBetween: 25
                            },
                        }
                    })
                }
                
            })
    
            $.get('/api/dealership?code='+CIS_DEALERSHIP, function(data) {
                
                dealership = JSON.parse(data)
                // console.log( dealership )

                $('.cis-dealership').show()
                
                $('[role="cis-offers-title"] span').text(dealership.NAME)
                $('[role="cis-dealership-title"] span').html('<a href="'+dealership.DETAIL_PAGE_URL+'" alt="'+dealership.NAME+'">'+dealership.NAME+'</a>')
                $('.cis-dealership-image').html('<picture class="w-100"><source srcset="'+dealership.PIC_MOBILE_PREVIEW+'" media="(max-width:500px)"><source srcset="'+dealership.PIC_TABLET_PREVIEW+'" media="(max-width:768px)"><img src="'+dealership.PIC_DESKTOP_PREVIEW+'"class="w-100"></picture>')

                $('.cis-dealership-address').text(dealership.PROPERTY_ADDRESS_VALUE)
                $('.cis-dealership-link').attr('href', dealership.DETAIL_PAGE_URL).attr('alt', dealership.NAME).text(dealership.NAME)
                $('.cis-dealership-link-map').attr('href', 'https://yandex.ru/maps/?ll='+dealership.PROPERTY_COORDS_LON_VALUE+','+dealership.PROPERTY_COORDS_LAT_VALUE+'&z=15&mode=routes&rtext=~'+dealership.PROPERTY_COORDS_LAT_VALUE+','+dealership.PROPERTY_COORDS_LON_VALUE+'&rtt=auto&ruri=~').attr('alt', dealership.NAME)
                
                if ( dealership.WORK[0] ) {
                    $('.cis-dealership-work-dealer-description').text(dealership.WORK[0].DESCRIPTION+':')
                    $('.cis-dealership-work-dealer-value').text(dealership.WORK[0].VALUE)
                }
                if ( dealership.WORK[1] ) {
                    $('.cis-dealership-work-service-description').text(dealership.WORK[1].DESCRIPTION+':')
                    $('.cis-dealership-work-service-value').text(dealership.WORK[1].VALUE)
                }
    
                $('.cis-dealership-site').attr('href', dealership.SITE).text(dealership.SITE.split('://')[1])
                $('.cis-dealership-phone').attr('href', 'tel:'+FormatPhoneIn(dealership.PROPERTY_PHONE_VALUE)).text(FormatPhoneOut(dealership.PROPERTY_PHONE_VALUE))
    
                $('.cis-dealership-logo img').attr('src', dealership.LOGO).attr('alt', dealership.NAME)
    
                dealershipMapInit( 
                    [
                        Number(dealership.PROPERTY_COORDS_LAT_VALUE),
                        Number(dealership.PROPERTY_COORDS_LON_VALUE),
                    ],
                    dealership.NAME
                )
            })
        }

        // if ( NEW_CIS_VEHICLE_ID != CIS_VEHICLE_ID ) {

        //     CIS_VEHICLE_ID = NEW_CIS_VEHICLE_ID
        //     if ( typeof swiper_cis_others != 'undefined' ) swiper_cis_others.destroy(true, true)
        //     $.get('https://apps.yug-avto.ru/API/get/cis/others/new/'+CIS_VEHICLE_ID+'?token=34b5ac8b71018c0bc7e5c050ed90b243', function(data) {
                
        //         others = JSON.parse(data)
        //         if ( others.length ) {
                    
        //             $('.cis-others').show()

        //             slide = ''
        //             others.forEach((item) => {

        //                 slide += '<div class="swiper-slide">'
        //                 slide += '<div class="available__grid-item__detail-cis">'
        //                 slide += '<div class="grid-item__head">'
        //                 slide += '<a href="'+item.link+'" class="grid-item__head-img"><img src="'+item.image+'" alt="'+item.name+'"></a>'
        //                 slide += '</div>'
        //                 slide += '<div  class="head_items-box">'
        //                 slide += '<div class="head_items">'
        //                 slide += '<a href="'+item.link+'" class="grid-item__title">'+item.name+'</a>'
        //                 slide += '</div>'
        //                     slide += '<div class="model__grid-card__content--list">'
        //                 item.general.forEach((i) => {
        //                     slide += '<span  class="model__grid-card__content--list-item">'+i+'</span>'
        //                 })
        //                 slide += '</div>'
        //                 slide += '<div  class="model__grid-card__footer">'
        //                 slide += '<div  class="model__grid-card__content--price">'
        //                 slide += '<div  class="model__grid-card__content--price_curent">'+Format(item.price)+' <span  class="rub">₽</span></div>'
        //                 slide += '</div>'
        //                 slide += '<a href="'+item.link+'" class="button transparent w100"><span >ПОЛУЧИТЬ ПРЕДЛОЖЕНИЕ</span></a>'
        //                 slide += '</div>'
        //                 slide += '</div>'
        //                 slide += '</div>'
        //                 slide += '</div>'
        //             })
        
        //             $('[role="cis-others-swiper"]').html(slide)
        
        //             const swiper_cis_others = new Swiper('.swiper-cis-others', {
        //                 pagination: {
        //                     el: ".swiper-pagination",
        //                     type: "fraction",
        //                 },
        //                 navigation: {
        //                     nextEl: '.swiper-cis-others-button-next',
        //                     prevEl: '.swiper-cis-others-button-prev',
        //                 },
        //                 slidesPerView: 4,
        //                 spaceBetween: 25,
        //                 slidesPerGroup: 4,
                        
        //                 breakpoints: {
        //                     320: {
        //                         slidesPerView: 1,
        //                         spaceBetween: 10
        //                     },
        //                     750: {
        //                         slidesPerView: 2,
        //                         spaceBetween: 25
        //                     },
        //                     1024: {
        //                         slidesPerView: 4,
        //                         spaceBetween: 25
        //                     },
        //                 }
        //             })
        //         }
                
        //     })
        // }   
    
    } else {
        $('.cis-dealership, .cis-offers, .cis-others').hide()
    }
}, 500)