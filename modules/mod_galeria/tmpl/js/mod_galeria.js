jQuery.noConflict();
(function($) {
    $(function() {
        //lightbox das imgs
        $('.imageGallery a').simpleLightbox();

        //ação veja mais
        $(".esconde").hide();
        $(".botao-veja-mais").click(function() {
            $(".esconde").toggle();
        });
        //ação veja mais
        $(".esconde-3").hide();
        $(".botao-veja-mais-3").click(function() {
            $(".esconde-3").toggle();
        });
        //ação veja mais
        $(".esconde-2").hide();
        $(".botao-veja-mais-2").click(function() {
            $(".esconde-2").toggle();
        });
    });
})(jQuery);