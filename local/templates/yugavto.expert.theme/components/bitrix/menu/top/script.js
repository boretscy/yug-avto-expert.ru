$(document).on('mouseover', '[role="submenu"]', function(e) {
    $('.submenu[data-menu="'+$(this).data('menu')+'"]').show().siblings('.submenu').hide()
        return false
})
$('.bg-yablue').mouseover( function() {
    $('.submenu').hide()
})

jQuery(function($){
	$(document).mouseup( function(e){ // событие клика по веб-документу
		var el = $( '.submenu' ); // тут указываем ID элемента
		if ( !el.is(e.target) // если клик был не по нашему блоку
		    && el.has(e.target).length === 0 ) { // и не по его дочерним элементам
		el.hide(); // скрываем его
		}
	});
});

jQuery(function($){
    $(document).mouseover( function(e){ // событие клика по веб-документу
        var el = $( '.submenu' ); // тут указываем ID элемента
        if (el.is(e.target)) // если наведение было не по нашему блоку
        {
            $('.submenu').hide() // скрываем его
        }
    });
});
jQuery(function($){
	$(document).mouseup( function(e){ // событие клика по веб-документу
		var el = $( '.top-menu-cities, .top-menu-cities-list' ); // тут указываем ID элемента
		if ( !el.is(e.target) // если клик был не по нашему блоку
		    && el.has(e.target).length === 0 ) { // и не по его дочерним элементам
		$('.top-menu-cities-list').addClass('d-none'); // скрываем его
		}
	});
});

$(document).on('click', '[role="submenu-mobile"]', function() {
    $(this).children('.submenu-mobile').fadeToggle(0)
})
$(document).on('click', '.top-menu [role="menu"]', function() {
    $('.mobile.top-menu .menu').fadeToggle(0)
    $('.menu-cover.mobile').fadeToggle(0)
})
$(document).on('click', '.menu-cover.mobile', function() {
    $('.mobile.top-menu .menu').hide(0)
    $('.menu-cover.mobile').hide(0)
})


$(document).on('click', '.top-menu-cities-item', function() {
    
    if ( $(this).data('city') == 'all' ) {
        $('.top-menu-cities-item input').attr('checked', true);
    } else {
        $(this).find('input').attr('checked', typeof $(this).find('input').attr('checked') == 'undefined');
    }

    CONNECTOR.CITIES = [];
    $(this).parent().find('.top-menu-cities-item input').each(function(i,e) {
        if ( typeof $(e).attr('checked') != 'undefined' ) CONNECTOR.CITIES.push( $(e).parent().parent().data('name') );
    })
    if ( CONNECTOR.CITIES.length == 0 ) {
        $('.top-menu-cities-item input').attr('checked', true);
        $(this).parent().find('.top-menu-cities-item input').each(function(i,e) {
            if ( typeof $(e).attr('checked') != 'undefined' ) CONNECTOR.CITIES.push( $(e).parent().parent().data('name') );
        })
    }

    $('.top-menu-cities span').text( ((CONNECTOR.CITIES.length>1)?CONNECTOR.CITIES_TITLE[CONNECTOR.CITIES.length]:CONNECTOR.CITIES[0]) );

    CONNECTOR.SELECTED_CITY = [... CONNECTOR.CITIES];
    let now = new Date();
    let time = now.getTime();
    let expireTime = time+3600;
    now.setTime(expireTime);
    setCookie('SELECTED_CITY', JSON.stringify(CONNECTOR.SELECTED_CITY), {
        'max-age': now.toUTCString()
    });
});
$(document).on('click', '[role="top-menu-cities"], #YappsShowroom .top-menu-cities', function() {
    $('.top-menu-cities-list').toggleClass('d-none');
    return false;
});

let CIS_FAVORITES = [... CONNECTOR.CIS_FAVORITES];
let CIS_COMPARE = [... CONNECTOR.CIS_COMPARE];
setInterval(() => {
    if ( CIS_FAVORITES.length != CONNECTOR.CIS_FAVORITES ) {
        CIS_FAVORITES = [... CONNECTOR.CIS_FAVORITES];
        if ( CONNECTOR.CIS_FAVORITES.length > 0 ) {
            $('[role="topmmenufavorites"] span').removeClass('d-none').text(CONNECTOR.CIS_FAVORITES.length);
        } else {
            $('[role="topmmenufavorites"] span').addClass('d-none');
        }
    }
    if ( CIS_COMPARE.length != CONNECTOR.CIS_COMPARE ) {
        CIS_COMPARE = [... CONNECTOR.CIS_COMPARE];
        if ( CONNECTOR.CIS_COMPARE.length > 0 ) {
            $('[role="topmmenucompare"] span').removeClass('d-none').text(CONNECTOR.CIS_COMPARE.length);
        } else {
            $('[role="topmmenucompare"] span').addClass('d-none');

        }
    }
}, 100);

