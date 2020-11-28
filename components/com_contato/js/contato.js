$( document ).ready(function() {
	$(".page-title").text('Contato');
	$("#subtitulo-pagina").text('Registre aqui suas dúvidas, sugestões ou reclamações');
	$(".breadcrumb").hide();
});

var req = new Request.JSON({
	method: 'post',
	url: 'index.php?option=com_contato&task=save&format=json',
	onSuccess: function(r)
	{
		if (!r.success && r.message)
		{
			// Success flag is set to 'false' and main response message given
			// So you can alert it or insert it into some HTML element
			alert(r.message);
		}
 
		if (r.messages)
		{
			// All the enqueued messages of the $app object can simple be
			// rendered by the respective helper function of Joomla!
			// They will automatically be displayed at the messages section of the template
			Joomla.renderMessages(r.messages);
		}
 
		if (r.data)
		{
			// Here you can access all the data of your response
			alert(r.data.myfirstcustomparam);
			alert(r.data.mysecondcustomparam);
		}
	}.bind(this),
	onFailure: function(xhr)
	{
		// Reaching this point means that the Ajax request itself was not successful
		// So JResponseJson was never called
		alert('Ajax error');
	}.bind(this),
	onError: function(text, error)
	{
		// Reaching this point means that the Ajax request was answered by the server, but
		// the response was no valid JSON (this happens sometimes if there were PHP errors,
		// warnings or notices during the development process of a new Ajax request).
		alert(error + "\n\n" + text);
	}.bind(this)
});

req.post('anyparam=myvalue');