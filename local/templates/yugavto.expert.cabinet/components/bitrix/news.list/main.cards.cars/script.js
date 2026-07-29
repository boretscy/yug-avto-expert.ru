function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

let count = new Intl.NumberFormat('ru', { currency: 'RUR' }), SELECTED_CITY_TOP = [... CONNECTOR.SELECTED_CITY];

getCISCounts = function() {
    
    $.get("https://apps.yug-avto.ru/API/get/cis/count/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&!dealership=1489&city="+CONNECTOR.SELECTED_CITY.toString(), function(data){
        $('[role="carcount"][data-section="PASS"]').text(count.format(Number(data)));
    });
    // $.get("https://apps.yug-avto.ru/API/get/cis/count/used/?token=34b5ac8b71018c0bc7e5c050ed90b243&dealership=1489&city="+CONNECTOR.SELECTED_CITY.toString(), function(data){
    //     $('[role="carcount"][data-section="COMM"]').text(count.format(data));
    // });

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