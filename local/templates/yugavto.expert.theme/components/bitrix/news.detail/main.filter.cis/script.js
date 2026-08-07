CONNECTOR.getWorld = function ( q = 1, f = 'a' ) {

    let res = {
        'c': ['цвет', 'цвета', 'цветов'],
        'a': ['автомобиль', 'автомобиля', 'автомобилей'],
        'n': ['новый', 'новых', 'новых']
    }
    let t = [
        [1],
        [2,3,4]
    ]
    for (let i=2; i<=300; i++) {
        t[0].push(i*10+1)
        t[1].push(i*10+2)
        t[1].push(i*10+3)
        t[1].push(i*10+4)
    }

    if ( t[0].indexOf(Number(q)) >= 0 ) return res[f][0]
    if ( t[1].indexOf(Number(q)) >= 0 ) return res[f][1]
    return res[f][2]
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
        if ( minRange+1 < maxRange) {
            CONNECTOR.MAIN_FILTER.price = [parseInt(rangeInput_price[0].value), parseInt(rangeInput_price[1].value)];
            CONNECTOR.MAIN_FILTER.getData({
                brands: ( CONNECTOR.MAIN_FILTER.brands.length == 0 ),
                models: ( CONNECTOR.MAIN_FILTER.models.length == 0 )
            });
        } else {
            e.stopPropagation()
        }
    });
    e.addEventListener('touchend', (e) => {
        let minRange = parseInt(rangeInput_price[0].value);
        let maxRange = parseInt(rangeInput_price[1].value);
        if ( minRange+1 < maxRange) {
            CONNECTOR.MAIN_FILTER.price = [parseInt(rangeInput_price[0].value), parseInt(rangeInput_price[1].value)];
            CONNECTOR.MAIN_FILTER.getData({
                brands: ( CONNECTOR.MAIN_FILTER.brands.length == 0 ),
                models: ( CONNECTOR.MAIN_FILTER.models.length == 0 )
            });
        } else {
            e.stopPropagation()
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
        if ( minView+1 < maxView) {
            CONNECTOR.MAIN_FILTER.price = [parseInt(rangeInput_price[0].value), parseInt(rangeInput_price[1].value)];
            CONNECTOR.MAIN_FILTER.getData({
                brands: ( CONNECTOR.MAIN_FILTER.brands.length == 0 ),
                models: ( CONNECTOR.MAIN_FILTER.models.length == 0 )
            });
        } else {
            e.stopPropagation()
        }
    });
});




CONNECTOR.MAIN_FILTER.getData = function(update) {

    $('.main-cis-filter [role="link"]').html('<a href="#" class="d-block text-center c-yalightblack c-h-yalightblack bg-h-yayellow bg-yadarkyellow text-decoration-none b-radius-yaradius-15 but-lg fw-bold">...</a>');

    let url = '/api/main_filter/';
    let data = {};
    data.brands = [];
    data.models = [];
    if ( CONNECTOR.MAIN_FILTER.price.length > 0 ) data.price = CONNECTOR.MAIN_FILTER.price;
    data.city = CONNECTOR.SELECTED_CITY.join();
    data.entity = 'used';
    data.param = update.param || null;

    CONNECTOR.MAIN_FILTER.brands.forEach(e => {
        data.brands.push( CONNECTOR.MAIN_FILTER.DATA.dropLists.brands[e] );
    });
    CONNECTOR.MAIN_FILTER.models.forEach(e => {
        data.models.push( CONNECTOR.MAIN_FILTER.DATA.dropLists.models[e] );
    });

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: (resp) => {
            if ( update.data ) {
                CONNECTOR.MAIN_FILTER.DATA = JSON.parse(resp);
                $('.main-cis-filter [role="toggle"]').removeClass('disabled').find('a').removeClass('c-yadarkgray c-h-yadarkgray c-yagray c-h-yagray').addClass('c-yalightblack c-h-yalightblack');
                $('.main-cis-filter [role="toggle"][data-section="pass"] a').removeClass('c-yalightblack c-h-yalightblack').addClass('c-yadarkgray c-h-yadarkgray');

                if ( !CONNECTOR.MAIN_FILTER.DATA.counts.pass ) $('.main-cis-filter [role="toggle"][data-section="pass"]').addClass('disabled').find('a').addClass('c-yagray c-h-yagray').removeClass('c-yadarkgray c-h-yadarkgray');
                if ( !CONNECTOR.MAIN_FILTER.DATA.counts.comm ) $('.main-cis-filter [role="toggle"][data-section="comm"]').addClass('disabled').find('a').addClass('c-yagray c-h-yagray').removeClass('c-yalightblack c-h-yalightblack');
                if ( !CONNECTOR.MAIN_FILTER.DATA.counts.prem ) $('.main-cis-filter [role="toggle"][data-section="prem"]').addClass('disabled').find('a').addClass('c-yagray c-h-yagray').removeClass('c-yalightblack c-h-yalightblack');
            }
            if ( update.brands ) {
                CONNECTOR.MAIN_FILTER.DATA.dropLists.brands = JSON.parse(resp).dropLists.brands;
                CONNECTOR.MAIN_FILTER.renderSelect('brands');
                CONNECTOR.MAIN_FILTER.renderSelect('models');
                CONNECTOR.MAIN_FILTER.renderBrands();
            }
            if ( update.models ) {
                CONNECTOR.MAIN_FILTER.DATA.dropLists.models = JSON.parse(resp).dropLists.models;
                CONNECTOR.MAIN_FILTER.renderSelect('models');
            }
            if ( update.price ) {
                CONNECTOR.MAIN_FILTER.renderPrice( JSON.parse(resp).ranges.price )
            }

            CONNECTOR.MAIN_FILTER.renderDropdowns();
            CONNECTOR.MAIN_FILTER.renderLink(JSON.parse(resp).totalCount, data.param);
            
        },
        error: () => { 
        }
    });
}

CONNECTOR.MAIN_FILTER.renderSelect = function(e) {

    let url = '/api/main_filter_select/render/';

    $.ajax({
        type: 'POST',
        url: url,
        data: {items: CONNECTOR.MAIN_FILTER.DATA.dropLists[e], list: e},
        success: (resp) => {
            $('.main-cis-filter .filter-droplist[data-list="'+e+'"]').html(resp);
        },
        error: () => { 
        }
    });
}
CONNECTOR.MAIN_FILTER.renderPrice = function(range) {

    $(rangeInput_price[0]).attr('min', range.min).attr('max', range.max).val(range.value[0]);
    $(rangeInput_price[1]).attr('min', range.min).attr('max', range.max).val(range.value[1]);

    let perLeft = (range.value[0]-range.min)/(range.max-range.min), perRight = (range.max-range.value[1])/(range.max-range.min);
    $(rangeView_price[0]).attr('min', range.min).attr('max', range.max).val( String(range.value[0]).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ") );
    $(rangeView_price[1]).attr('min', range.min).attr('max', range.max).val( String(range.value[1]).replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ") );
    $(range_price).css('left',  'calc('+perLeft*100+'%)');
    $(range_price).css('right', 'calc('+perRight*100+'%)');
}
CONNECTOR.MAIN_FILTER.renderDropdowns = function() {

    if ( CONNECTOR.MAIN_FILTER.brands.length > 0 ) {
        $('.filter-dropdown[data-list="brands"] span span').text(' - '+CONNECTOR.MAIN_FILTER.brands.length+' выбрано');
    } else {
        $('.filter-dropdown[data-list="brands"] span span').text('(все)');
    }
    if ( CONNECTOR.MAIN_FILTER.models.length > 0 ) {
        $('.filter-dropdown[data-list="models"] span span').text(' - '+CONNECTOR.MAIN_FILTER.models.length+' выбрано');
    } else {
        $('.filter-dropdown[data-list="models"] span span').text('(все)');
    }
}
CONNECTOR.MAIN_FILTER.renderLink = function(count, param) {

    let url = '/api/main_filter_button/render/';
    let data = {};
    data.brands = [];
    data.models = [];
    if ( CONNECTOR.MAIN_FILTER.price.length > 0 ) data.price = CONNECTOR.MAIN_FILTER.price
    data.count = count;
    data.city = CONNECTOR.SELECTED_CITY.join();
    data.entity = 'used';
    data.param = param || null;

    CONNECTOR.MAIN_FILTER.brands.forEach(e => {
        data.brands.push( CONNECTOR.MAIN_FILTER.DATA.dropLists.brands[e] );
    });
    CONNECTOR.MAIN_FILTER.models.forEach(e => {
        data.models.push( CONNECTOR.MAIN_FILTER.DATA.dropLists.models[e] );
    });

    $.ajax({
        type: 'POST',
        url: url,
        data: data,
        success: (resp) => {
            $('.main-cis-filter [role="link"]').html(resp);
        },
        error: () => { 
        }
    });
}
CONNECTOR.MAIN_FILTER.renderBrands = function() {

    let url = '/api/main_filter_brands/render/';

    $.ajax({
        type: 'POST',
        url: url,
        data: {brands: CONNECTOR.MAIN_FILTER.DATA.dropLists.brands, entity: 'used', city: CONNECTOR.SELECTED_CITY.join(), in_city: CONNECTOR.MAIN_FILTER.DATA.in_city},
        success: (resp) => {
            $('.brands-on-main').html(resp)
        },
        error: () => { 
        }
    });
}


$(document).on('click', '.main-cis-filter .filter-dropcontainer .filter-droplist-item', function() {

    $(this).toggleClass('bg-yalightgray selected fw-bold');

    CONNECTOR.MAIN_FILTER[$(this).data('list')] = [];
    CONNECTOR.MAIN_FILTER[$(this).data('list')].push($(this).data('indx'));

    let update = {};
    update.price = true;
    update.models = ( typeof $(this).parent().data('children') != 'undefined' && $(this).parent().data('children') == 'models' );
    update.brands = false;
    CONNECTOR.MAIN_FILTER.price = [];
    CONNECTOR.MAIN_FILTER.getData(update);

    $('.main-cis-filter.form').find('.filter-droplist').addClass('d-none');
    $('.main-cis-filter.form').find('.filter-dropdown').removeClass('filter-dropdown-opened');

    return false;
});

$(document).on('click', '.main-cis-filter [role="toggle"]:not(.disabled)', function() {

    // $('.main-cis-filter [role="toggle"]:not(.disabled)').find('a').removeClass('c-yadarkgray c-h-yadarkgray').addClass('c-yalightblack c-h-yalightblack');
    // $(this).find('a').removeClass('c-yawhite c-h-yalightblack').addClass('c-yadarkgray c-h-yadarkgray');

    $('.main-cis-filter [role="toggle"]:not(.disabled)').find('a').removeClass('fw-bold');
    $(this).find('a').addClass('fw-bold');

    let update = {};
    update.price = true;
    update.models = true;
    update.brands = true;
    update.param = $(this).data('param');
    CONNECTOR.MAIN_FILTER.price = [];
    CONNECTOR.MAIN_FILTER.getData(update);

    return false;
});

let SELECTED_CITY_MAIN_FILTER = [... CONNECTOR.SELECTED_CITY];
setInterval(() => {
    if ( !objectsEqual( SELECTED_CITY_MAIN_FILTER, CONNECTOR.SELECTED_CITY ) ) {
        
        SELECTED_CITY_MAIN_FILTER = [... CONNECTOR.SELECTED_CITY];
        console.log(CONNECTOR.MAIN_FILTER.DATA)
        
        let update = {};
        update.price = true;
        update.models = true;
        update.brands = true;
        update.param = '';
        update.data = true;
        CONNECTOR.MAIN_FILTER.price = [];
        CONNECTOR.MAIN_FILTER.getData(update);
    }
}, 100);
