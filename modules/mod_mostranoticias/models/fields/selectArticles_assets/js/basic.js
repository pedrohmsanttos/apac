jQuery(function ($) {
	$('.msg-ok').hide();

	$('.escolhe-artigo').click(function (e) {

		var id_artigo   = $(this).data( "id");
		var acao_artigo = $(this).data( "acao");

		var tipo_banner = $(this).data("type-banner");
		var tituloDoArtigo = $('.id-artigo-'+tipo_banner+'-'+id_artigo).text();

		var input_id_artigo = document.getElementById('jform[params]['+tipo_banner+']');
		var input_titulo_artigo =  document.getElementById(tipo_banner+"_title");
			
		input_id_artigo.value = id_artigo;
		input_titulo_artigo.value = tituloDoArtigo;

		$('.msg-ok').toggle();

		setTimeout(function(){
			$.modal.close();
		}, 1500);
		
	});

	$('#basic-modal-selecionar-artigo').click(function (e) {
		$('#basic-modal-selecionar-artigo-content').modal();
		return false;
	});
	
	$('#basic-modal-selecionar-artigo-left-banner').click(function (e) {
		$('#basic-modal-selecionar-artigo-content-left-banner').modal();
		return false;
	});
	
	$('#basic-modal-selecionar-artigo-right-banner').click(function (e) {
		$('#basic-modal-selecionar-artigo-content-right-banner').modal();
		return false;
	});

});

module.exports = function rawurldecode (str) {
  return decodeURIComponent((str + '')
    .replace(/%(?![\da-f]{2})/gi, function () {
      return '%25'
    }))
}