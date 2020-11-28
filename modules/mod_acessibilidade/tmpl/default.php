<?php defined('_JEXEC') or die; ?>
<script>
    // Read cookie
    function getCookie(strCookie)
    {
        var strName = strCookie + "=";
        var arrCookies = document.cookie.split(';');
        for (var i = 0; i < arrCookies.length; i++) {
            var strValorCookie = arrCookies[i];
            while (strValorCookie.charAt(0) == ' ') {
                strValorCookie = strValorCookie.substring(1, strValorCookie.length);
            }
            if (strValorCookie.indexOf(strName) == 0) {
                return strValorCookie.substring(strName.length, strValorCookie.length);
            }
        }
        return '';
    }

    // Set cookie
    function setCookie(name, value, expires, path, domain, secure)
    {
        // set time, it's in milliseconds
        var today = new Date();
        today.setTime( today.getTime() );

        /* if the expires variable is set, make the correct expires time, the current script below will set
        it for x number of days, to make it for hours, delete * 24, for minutes, delete * 60 * 24 */
        path = '/';
        if ( expires ) {
            expires = expires * 1000 * 60 * 60 * 24;
        }
        var expires_date = new Date( today.getTime() + (expires) );
        document.cookie = name + "=" +escape( value ) +
        ( ( expires ) ? ";expires=" + expires_date.toGMTString() : "" ) +
        ( ( path ) ? ";path=" + path : "" ) +
        ( ( domain ) ? ";domain=" + domain : "" ) +
        ( ( secure ) ? ";secure" : "" );
    }

    // Erase cookie
    function eraseCookie(name)
    {
        setCookie(name, '', -1);
    }

    jQuery.noConflict();
    (function( $ ) {
      $(function() {
        //Pega a temperatura
            $.ajax({
            url: 'http://api.weatherunlocked.com/api/current/-8.05428,-34.8813?app_id=6ec55f2f&app_key=ebefdb91fcc7ba69d7bbc624a7534ec4',
            type: 'GET',
            crossDomain: true,
            dataType: 'text',
            success: function(data) {
                let jsonObject = JSON.parse(data);
                //$( ".weather" ).empty();
                //$( ".weather" ).append( jsonObject.temp_c+"° C" );
            }
            });

        //aumenta o tamanho da fonte

            $("#aumentar-fonte").click(function () {
                var size = $("*").css('font-size');

                size = size.replace('px', '');
                size = parseInt(size) + 1;

                $("*").animate({'font-size' : size + 'px'});
                return false;
            });

            $("#diminuir-fonte").click(function () {
                var size = $("*").css('font-size');

                size = size.replace('px', '');
                size = parseInt(size) - 1;

                $("*").animate({'font-size' : size + 'px'});
                return false;
            });

        //controle de contraste
            // var cookieContrast = getCookie("highContrast");
            // if (cookieContrast == "highContrast"){
            //     $("body").addClass("highContrast");
            // }
            // $("a.highContrast").click(function(){
            //     var x = getCookie("highContrast");
            //     if (x == "highContrast") {
            //         $("body").removeClass("highContrast");
            //         eraseCookie("highContrast");
            //     } else {
            //         $("body").addClass("highContrast");
            //         setCookie("highContrast", "highContrast");
            //     }
            //     return (false);
            // });

      });
    })(jQuery);
</script>


    <ul class="weather" style="padding-left: 345px;">
        <?php
        $index = true;
        foreach($previsoes as $previsao):
        ?>
        <li class="previsao <?php if($index){echo('ativo');$index=false;}?>">
            <div class="center">
                <span class="regiao"><?php echo($previsao->messoregiao);?></span>
                <span class="max"><?php echo($previsao->tempMin.'°C');?></span>
                <span class="min"><?php echo($previsao->tempMax.'°C');?></span>
            </div>  
        </li>  
        <?php
        endforeach;
        ?>
    </ul>

<ul class="social-list">
    <li><a target="_blank" href="<?php echo $redesSociais->facebook; ?>"></a></li>
    <li><a target="_blank" href="<?php echo $redesSociais->instagram; ?>"></a></li>
    <li><a target="_blank" href="<?php echo $redesSociais->twitter; ?>"></a></li>
    <li><a target="_blank" href="<?php echo $redesSociais->youtube; ?>"></a></li>
</ul>
<ul class="accessibility">
    <li><a id="aumentar-fonte" href="javascript:void(0);">A+</a></li>
    <li><a id="diminuir-fonte" href="javascript:void(0);">A-</a></li>
    <li><a id="acessibilidade" href="<?php echo $linkArtigoAcessb;?>">Acessibilidade</a></li>
    <li><a href="javascript:void(0);" class="change-contrast">Alto Contraste</a></li>
    <li><a href="<?php echo $linkArtigoMap; ?>">Mapa do Site</a></li>
</ul>

<script>
var index = 0;

function nextprevisao(){

    if(0 === document.getElementsByClassName('previsao').length)
    {
        clearInterval(trocaPrevisao);
    }
    else{
        if(index >= document.getElementsByClassName('previsao').length)
        {
            index = 0;
        }
        if (document.getElementsByClassName('ativo', 'previsao').length > 0){
            document.getElementsByClassName('previsao')[index].setAttribute('class','previsao ativo');
            document.getElementsByClassName('ativo')[0].setAttribute('class','previsao');
        }
        else
        {
            document.getElementsByClassName('previsao')[index].setAttribute('class','previsao ativo');
        }

        if(document.getElementsByClassName('ativo').length == 0)
        {
            document.getElementsByClassName('previsao')[0].setAttribute('class','previsao ativo');
        }
        ++index;
    }
}

var trocaPrevisao = setInterval(nextprevisao, 5000);
</script>