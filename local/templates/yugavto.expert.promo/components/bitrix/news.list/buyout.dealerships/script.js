var dealershipsMap;

ymaps.ready(firstInit);

function firstInit() {
    setTimeout(() => {
        dealershipsMapInit('all')
    }, 500);
}

function dealershipsMapInit( city = 'all' ) {

    if ( typeof dealershipsMap != 'undefined' ) dealershipsMap.destroy()

    dealershipsMap = new ymaps.Map('dealershipsMap', {

        center: EXPERT_MAP_DEALERSHIPS[city].CENTER,
        zoom: EXPERT_MAP_DEALERSHIPS[city].ZOOM
    }, {
        searchControlProvider: 'yandex#search'
    });

    dealershipsMap.behaviors.disable('scrollZoom');

    objectManager = new ymaps.ObjectManager();

    EXPERT_MAP_DEALERSHIPS[city].ITEMS.forEach((i) => {
        dealershipsMap.geoObjects.add(
            new ymaps.Placemark(
                [
                    i.COORDS.LAT,
                    i.COORDS.LON
                ],
                {
                    balloonContent: i.NAME,
                    // iconCaption: i.NAME,
                    hintContent: i.NAME,
                    balloonContentHeader: i.NAME,
                    balloonContentBody: i.BALLOON.CONTENT,
                    balloonContentFooter: i.BALLOON.FOOTER,
                },
                {
                    preset: "islands#darkBlueDotIconWithCaption"
                }
            )
        )
    });
}

$(document).on('click', '[role="toggleCity"]', function() {
    $('[role="toggleCity"]').removeClass('c-yablue c-h-yablue b-yayellow')
    $(this).addClass('c-yablue c-h-yablue b-yayellow')
    dealershipsMapInit($(this).data('city'))
    return false
})


