$('a[role="scroll"]').click(function() {

    console.log($('.offer-cis'))

    $('html, body').animate({ scrollTop: $('.offer-cis').offset().top }, 200);
    return false;
});