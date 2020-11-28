jQuery.noConflict();
(function( $ ) {
  $(function() {
		$('.banner-unslider').unslider(
		{
			autoplay: true,
			nav:false,
      arrows: {
        prev: '<a class="unslider-arrow prev"><i class="large material-icons">keyboard_arrow_left</i></a>',
        next: '<a class="unslider-arrow next"><i class="large material-icons">keyboard_arrow_right</i></a>'
      },
      speed:3000,
      delay:5000
		});
  });
})(jQuery);
