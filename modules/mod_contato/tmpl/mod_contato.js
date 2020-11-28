jQuery.noConflict();
(function( $ ) {
  $(function() {
    $( "#envia_contato" ).on( "click", function() {
      if(
          $("#nome").val().trim() != '' ||
          $("#email").val().trim() != '' ||
          $("#mensagem").val().trim() != '' ||
          $("#setor").val().trim() != ''
        )
        {

          var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
          if (!filter.test($("#email").val())) {
              $("#email").focus();
              alert("Por favor, informe um email válido.");
              return false;
          }else{
            $.post( "index.php?option=com_contato&task=save", {
              nome: encodeURI($("#nome").val()),
              email: encodeURI($("#email").val()),
              mensagem: encodeURI($("#mensagem").val()),
              setor: encodeURI($("#setor").val())
            })
            .done(function( data ) {
              alert(data.message);
              location.reload();// limpar os campos
            });
          }


        }
          else
        {
          alert("Campos obrigatórios não prenchidos.");
        }
    });
  });
})(jQuery);
