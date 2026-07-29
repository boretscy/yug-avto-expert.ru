$(document).on('click', '[role="news-filter-select-button"]', function() {
    $(this).siblings('.news-filter-select-list').toggle();
    return false;
});