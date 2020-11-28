jQuery.noConflict();
(function( $ ) {
  $(function() {

    $(".change-contrast").unbind('click');
    $('.change-contrast').on('click', function() {
      $('body').toggleClass("contrast");
    });

    $('.menu-governo').on('click', '.btn-governo-menu-toogle', function() {
        const menu = $('.menu-governo').find('.collapse-menu');
        if ( !menu.is(':visible') ) {
            menu.show();
            $(this).find('.fa').toggleClass('fa-caret-up', 'fa-caret-down');
        } else {
            menu.hide();
            $(this).find('.fa').toggleClass('fa-caret-down', 'fa-caret-up');
        }
    });

     if ( $('#tabs').length ) {
        var myTabs = tabs({
            el: '#tabs',
            tabNavigationLinks: '.c-tabs-nav__link',
            tabContentContainers: '.c-tab'
        });
        myTabs.init();
    }

    if ( $('#tabs_agenda').length ) {
        var myTabsAgenda = tabs({
            el: '#tabs_agenda',
            tabNavigationLinks: '.c-tabs_agenda-nav__link',
            tabContentContainers: '.c-tab_agenda'
        });
        myTabsAgenda.init();
    }

    if ( $('.btn-agenda').length ) {
        $(document).on('click', '.btn-agenda', function(e) {
            e.preventDefault();
            var _parent = $(this).closest('article');
            _parent.find('.resumo').toggle();
            _parent.find('.detail').toggle();
        });
    }

    $(".show-menu").unbind('click');
    $(".show-menu").bind('click',function () {
        $(this).toggleClass("is-active");
        $(".side-menu").toggleClass("mostrar");
        $(".aux-menu").toggleClass("mostrar");
    });

    if($(".page-title").text() == 'Mapa do Trabalho'){
        $(".menu-governo").hide();
    }

  });
    window.i = 0;
})(jQuery);

 (function(d, s, id) {
    
    var js, fjs = d.getElementsByTagName(s)[0];
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.8&appId=1922752594625313";
    fjs.parentNode.insertBefore(js, fjs);
    
    if(typeof fbq === 'undefined') {
        !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
        n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
        document,'script','https://connect.facebook.net/en_US/fbevents.js');

        fbq('track', 'PageView');
    }
    else {
        fbq('track', 'PageView');
    }

 }(document, 'script', 'facebook-jssdk'));

