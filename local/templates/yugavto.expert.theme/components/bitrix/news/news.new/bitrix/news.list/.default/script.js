$(document).on('click', '[role="news-filter-select-button"]', function() {
    $(this).siblings('.news-filter-select-list').toggle();
    return false;
});

$(document).on('click', '.filter-dropcontainer', function() {
    $(this).find('.filter-dropdown').toggleClass('filter-dropdown-opened');
    $(this).find('.filter-droplist').toggleClass('d-none d-block');
    $(this).find('img').toggleClass('rotate-180');
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