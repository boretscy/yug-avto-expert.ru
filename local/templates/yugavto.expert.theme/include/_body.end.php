<script type="text/javascript">
(function() {
    var widgetsLoaded = false;
    function loadWidgets() {
        if (widgetsLoaded) return;
        widgetsLoaded = true;

        // 1. Загрузка Calltouch
        (function(w,d,n,c){w.CalltouchDataObject=n;w[n]=function(){w[n]["callbacks"].push(arguments)};if(!w[n]["callbacks"]){w[n]["callbacks"]=[]}w[n]["loaded"]=false;if(typeof c!=="object"){c=[c]}w[n]["counters"]=c;for(var i=0;i<c.length;i+=1){p(c[i])}function p(cId){var a=d.getElementsByTagName("script")[0],s=d.createElement("script"),i=function(){a.parentNode.insertBefore(s,a)},m=typeof Array.prototype.find === 'function',n=m?"init-min.js":"init.js";s.type="text/javascript";s.async=true;s.src="https://mod.calltouch.ru/"+n+"?id="+cId;if(w.opera=="[object Opera]"){d.addEventListener("DOMContentLoaded",i,false)}else{i()}}})(window,document,"ct","e94ad128");

        // 2. Загрузка Widgets3-script (с PHP-монолита)
        var t = 'ef6541490c8bb9d481d37020b6a1953e',
            r = location.href, 
            s = document.createElement('script');
        s.type = 'text/javascript';
        s.charset = 'utf-8';
        s.src = 'https://apps.yug-avto.ru/API/get/widgets3-script/'+'?token='+t+'&r='+r;
        document.body.append(s);

        // 3. Загрузка Talk-Me
        (function c(d,w,m,i) {
            window.supportAPIMethod = m;
            var s = d.createElement('script');
            s.id = 'supportScript'; 
            var id = '1195b982f1aff86949235a3e32305b5f';
            s.src = (!i ? 'https://lcab.talk-me.ru/support/support.js' : 'https://static.site-chat.me/support/support.int.js') + '?h=' + id;
            s.onerror = i ? undefined : function(){c(d,w,m,true)};
            w[m] = w[m] || function(){(w[m].q = w[m].q || []).push(arguments);};
            (d.head || d.body).appendChild(s);
        })(document,window,'TalkMe');
    }

    // Запуск загрузки по первому действию пользователя
    var triggerEvents = ['scroll', 'mousemove', 'touchstart', 'click'];
    triggerEvents.forEach(function(ev) {
        window.addEventListener(ev, loadWidgets, { once: true, passive: true });
    });
})();
</script>