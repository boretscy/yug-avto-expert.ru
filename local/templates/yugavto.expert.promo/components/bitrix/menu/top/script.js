$(document).on('mouseover', '[role="submenu"]', function(e) {
    $('.submenu[data-menu="'+$(this).data('menu')+'"]').show().siblings('.submenu').hide()
        return false
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
        var el = $( '.single_menu' ); // тут указываем ID элемента
        if (el.is(e.target)) // если наведение было не по нашему блоку
        {
            $('.submenu').hide() // скрываем его
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


$('a[role="scroll"]').click(function() {
    console.log( $('div[data-scroll="' + $(this).data('scroll') + '"]') )
    $('html, body').animate({ scrollTop: $('div[data-scroll="' + $(this).data('scroll') + '"]').offset().top }, 500);
    $('.mobile.top-menu .menu').hide(0)
    $('.menu-cover.mobile').hide(0)

    return false
});