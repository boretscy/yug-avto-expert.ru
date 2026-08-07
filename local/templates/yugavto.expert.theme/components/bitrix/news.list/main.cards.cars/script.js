function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

let count = new Intl.NumberFormat('ru', { currency: 'RUR' }), SELECTED_CITY_TOP = [... CONNECTOR.SELECTED_CITY];

getCISCounts = function() {
    
    $.get("https://apps.yug-avto.ru/API/get/cis/count/used/?token=ef6541490c8bb9d481d37020b6a1953e&city="+CONNECTOR.SELECTED_CITY.toString(), function(data){
        $('[role="carcount"][data-section="PASS"]').text(count.format(Number(data)));
        $('[role="carcount"][data-section="COMM"]').text(count.format(Number(data)));
    });

    let url = '/api/main_cards_links/';
    let data = {};
    data.city = CONNECTOR.SELECTED_CITY;

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: (resp) => {
            let res = JSON.parse(resp);
            $('.car-cards__item[data-section="PASS"]').attr('href', res.pass);
            $('.car-cards__item[data-section="COMM"]').attr('href', res.comm);
        },
        error: () => { 
        }
    });
}

getCISCounts();
setInterval(() => {
    if ( !objectsEqual( SELECTED_CITY_TOP, CONNECTOR.SELECTED_CITY ) ) {
        SELECTED_CITY_TOP = [... CONNECTOR.SELECTED_CITY];
        getCISCounts()
    }
}, 100);