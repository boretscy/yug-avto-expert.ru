document.addEventListener('DOMContentLoaded', () => {
   /* document.querySelectorAll('.spoiler__container').forEach(spoiler => spoiler.addEventListener('click', e => {
         spoiler.classList.toggle('--is-open');
    }))*/

    document.querySelectorAll('.spoiler__header').forEach(spoiler => spoiler.addEventListener('click', e => {
        spoiler.parentElement.classList.toggle('--is-open');
    }))
    
    /*Форма обратной связи, скрытое поле*/
    document.querySelectorAll('.form--hidden').forEach(hidden => hidden.addEventListener('click', e => {
        hidden.parentElement.classList.add('--is-open');
        document.querySelectorAll('.close').forEach(close => close.addEventListener('click', e => {
            hidden.parentElement.classList.remove('--is-open');
        }))
    }))
    /*Форма обратной связи, скрытое поле*/
})

let form, sendData = {}, flag = true
$(document).on('click', '[role="sendForm"]', function() {
    
    flag = true

    if ( $(this).data('form') == 'FORM.BLOCK.SEMIBLUE' ) {
        form = $(this).parent().parent().parent().parent()
        sendData.FORM = $(this).data('name')
    } else {
        form = $(this).parent().parent().parent()
        sendData.FORM = $(this).data('name')
    }
    
    $(form).find('input, select, textarea').each( function( i, e ) {
        if ( $(e).attr('required') && !$(e).val() ) {
            flag = false
            $(e).addClass('is-invalid')
        }
        sendData[$(e).attr('name')] = $(e).val()
    })
    if ( !$(form.find('input[name="AGRYY"]')).is(':checked') ) {
        flag = false
        $(form.find('input[name="AGRYY"]')).addClass('is-invalid')
    }

    sendData.URL = location.href

    if ( flag ) {

        $(form).find('.form-cover').removeClass('d-none').addClass('d-flex')
        
        $.ajax({
            type: 'POST',
            url: '/api/send/',
            data: sendData,
            success: (data) => { 
                res = JSON.parse( data )
                
                if ( res.status == 'success'  ) {

                    form.parent().find('[role="success"], [role="error"], [role="description"]').hide()
                    form.parent().find('[role="success"]').show()
                    form.hide()

                    $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')
                    $(form).parent().siblings('.blue-cover').height(40);

                    var CallTouchURL = 'https://api.calltouch.ru/calls-service/RestAPI/requests/20930/register/';
					CallTouchURL += '?subject=Формы лендинга - '+sendData.FORM;
					CallTouchURL += '&sessionId='+window['call_value_e94ad128']
					CallTouchURL += '&fio='+sendData.NAME;
					CallTouchURL += '&phoneNumber='+sendData.PHONE.replace(/[^\d;]/g, '');
                    
                    let request = new XMLHttpRequest();
                    request.open('GET', CallTouchURL, true);
                    request.send();

                    ym(31748036,'reachGoal',$(form).data('sid'))

                } else {
                    
                    form.parent().find('[role="success"], [role="error"]').hide()
                    form.parent().find('[role="error"]').show()
                }

                setTimeout(() => {
                    
                    form.parent().find('[role="success"], [role="error"]').hide()
                    form.parent().find('[role="description"]').show()
                    $(form).parent().siblings('.blue-cover').height(280);
                    form.show()

                }, 5000);

                $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')
            },
            error: () => { 
                console.log( 'error' ); 
                res = {status: 'error', description: 'Ошибка на сервере'}
                
                form.parent().find('[role="success"], [role="error"]').hide()
                form.parent().find('[role="error"]').show()

                $(form).find('.form-cover').removeClass('d-flex').addClass('d-none')
            }
        });
    }

    return false;
})

$(document).on('click', 'a[href^="tel"], a[href^="phone"]', function() {
    ym(31748036,'reachGoal','PHONE_CLICK')
})
