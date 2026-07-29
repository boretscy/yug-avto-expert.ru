$(document).on('click', '[role="historyGroup"]', function() {
    
    $('.history-item[data="'+$(this).data('group')+'"], .history-item-delimiter[data="'+$(this).data('group')+'"]').toggleClass('history-group-active');
    $(this).toggleClass('history-group-active');
    return false;
});