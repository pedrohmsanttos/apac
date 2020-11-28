jQuery(function ($) {
	
	$('.esconde-modal').toggle('fast');

	$( "body" ).on( "click", ".salva-itens", function() {

		var aba_selecionada  = $(this).data("aba");
		var input_itens_aba  = document.getElementById('jform[params]['+aba_selecionada+']');
		var str_titulo_link  = '';

		$('[id^=titulo_'+aba_selecionada+']').each(function(i, inputLido){
			
			str_titulo_link += inputLido.value+'|';

		});

		str_titulo_link += '*';

		$('[id^=link_'+aba_selecionada+']').each(function(i, inputLido){

			str_titulo_link += encodeURI(inputLido.value)+'|';

		});
			
		document.getElementById('jform[params]['+aba_selecionada+']').value = str_titulo_link;

		SqueezeBox.close();

	});

	$( "body" ).on( "click", ".cancela-edicao", function() {
		SqueezeBox.close();
	});

});
