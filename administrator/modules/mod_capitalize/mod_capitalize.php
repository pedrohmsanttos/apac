<?php defined('_JEXEC') or die; JHtml::_('jquery.framework');?>

<script type="text/javascript">
(function($)
{
	$(document).ready(function()
	{
		$('.menu-component').each(function() {

		    var splitStr = $(this).text().toLowerCase().split(' ');
		    for (var i = 0; i < splitStr.length; i++) {
		       splitStr[i] = splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
		   }
		   $(this).text( splitStr.join(' '));

			 if($(this).attr("href") == "index.php?option=com_busca") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_agenda") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_aviso") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_governador") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_acaodegoverno") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_prefeitura") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_secretaria") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_secretario") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_telefone") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_redirect") $(this).parent().remove();

		});

		$('.dropdown-toggle').each(function() {

			 if($(this).attr("href") == "index.php?option=com_finder") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_banners") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_contact") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_newsfeeds") $(this).parent().remove();
			 if($(this).attr("href") == "index.php?option=com_messages") $(this).parent().remove();

		});

		$('.no-dropdown').each(function() {

			if($(this).attr("href") == "index.php?option=com_finder") $(this).parent().remove();
			if($(this).attr("href") == "index.php?option=com_postinstall") $(this).parent().remove();
			if($(this).attr("href") == "index.php?option=com_redirect") $(this).parent().remove();
			if($(this).attr("href") == "index.php?option=com_search") $(this).parent().remove();
			if($(this).attr("href") == "index.php?option=com_associations") $(this).parent().remove();

		});



	});

})(jQuery);

</script>
