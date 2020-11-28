<?php
	defined('_JEXEC') or die('Restricted access');
	JHtml::_('formbehavior.chosen', 'select');
	JHtml::_('jquery.framework', false);
    require_once 'helper.php';

	$user   = JFactory::getUser();
	$groups = $user->get('groups');
	$group_blacklist_array = array();
    $current_user = JFactory::getUser();

	$anexos = getAnexosById($this->item->id);

?>

<input type="hidden" name="max_upload_attempts" id="max_upload_attempts" value="<?php echo JComponentHelper::getParams('com_avisohidrologico')->get('max_upload_attempts');?>" />

<style type="text/css">.system-message-container{display:none}.wf-editor-container,.js-editor-tinymce{width: 750px} .chzn-container,.chzn-container-multi{ width: 220px !important;}.input-append{width: 165px !important;}</style>
<script language="javascript" type="text/javascript">
	function tableOrdering( order, dir, task )
	{
		var form = document.adminForm;
		form.filter_order.value = order;
		form.filter_order_Dir.value = dir;
		document.adminForm.submit( task );
	}
</script>
<form enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_avisohidrologico&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <input type="hidden" name="created" value="<?php echo date("Y-m-d H:i:s");?>" />
    <input type="hidden" name="id" value="<?php echo $this->item->id;?>" />
    <input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
	<input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
	<input type="hidden" id="max_file_size" value="<?php echo return_bytes(ini_get("upload_max_filesize")); ?>" />

		<div class="tabbable"> <!-- Only required for left/right tabs -->
		  <ul class="nav nav-tabs">
		    <li class="active"><a href="#tab1" data-toggle="tab">Avisos</a></li>
		    <li><a href="#tab2" data-toggle="tab">Anexos</a></li>
		  </ul>
		  <div class="tab-content">
		    <div class="tab-pane active" id="tab1">
					<div class="form-horizontal">
							<fieldset class="adminform">
									<legend>Aviso Hidrológico</legend>
									<div class="row-fluid">
											<div class="span6">
													<?php foreach ($this->form->getFieldset() as $field): ?>
														<?php if($field->type != 'File'): ?>
															<div class="control-group">
																	<?php if($field->name == 'jform[regioes][]'): ?>
																		<script>
																			jQuery.noConflict();
																			(function( $ ) {
																				$(function() {
																					<?php foreach (explode(",",$field->value) as $key_value) : ?>
																						$("#jform_regioes option[value='<?php echo $key_value ?>']").prop("selected","selected");
																					<?php endforeach; ?>
																					$('#jform_regioes').trigger("liszt:updated");
																				});
																			})(jQuery);
																		</script>
																<?php endif ?>
																	<div class="control-label"><?php echo $field->label; ?></div>
																	<div class="controls">
																		<?php echo $field->input; ?>
																	</div>
															</div>
														<?php endif ?>
													<?php endforeach; ?>
											</div>
									</div>
							</fieldset>
					</div>
		    </div>
		    <div class="tab-pane" id="tab2">
					<p>
						<div class="span6">
							<p>
								<input class="btn btn-small button-new btn-success" type="button" id="btnAdd" value="Novo" onclick="addSampleRow('tblSample')">
								<input class="btn btn-small button-new btn-danger" type="button" id="btnDelete" value="Remover selecionado" onclick="removeSampleRow('tblSample')">
							</p>
							<br/>

							<div id="alert-td" colspan="5" style="display: none;">
								<div class="alert">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<h4 class="alert-heading">Mensagem</h4>
									<div class="alert-message">Nenhum anexo encontrado.</div>
								</div>
							</div>


							<table id="tblSample" class="table table-striped" style="width:100%">

								<tr>
									<th>#</th>
									<th>Título</th>
									<th>Data</th>
									<th>Usuário</th>
									<th>Opções</th>
								</tr>

								<?php if(empty($anexos) && !empty($this->item->id)): ?>
									<td colspan="5">
										<div class="alert">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<h4 class="alert-heading">Mensagem</h4>
												<div class="alert-message">Nenhum anexo encontrado.</div>
										</div>
									</td>
								<?php else: ?>

									
									<?php if(!empty($anexos)) : ?>
										<?php foreach ($anexos as $anexo): ?>
											<tr>
												<td data="<?php echo $anexo->id ?>"><input data="<?php echo $anexo->id ?>" type="checkbox"></td>
												<td>
													<input type="text" name="jform[titulos][]" value="<?php echo $anexo->titulo ?>" onfocusout="checaTitulo(this,true)">
													<input type="hidden" name="jform[titulo_old][]" value="<?php echo $anexo->titulo ?>">
													<input type="hidden" name="jform[anexo_id][]" value="<?php echo $anexo->id ?>">
												</td>
												<td><?php echo preparaData($anexo->created) ?></td>
												<td><?php echo getUsernameById($anexo->id_user) ?></td>
												<td><input type="file" onchange="checaMimeType(this)" name="jform[arquivo][]" value="<?php echo $anexo->arquivo ?>"> (<?php echo $anexo->arquivo ?>)</td>
											</tr>
										<?php endforeach; ?>
							  	<?php endif;?>
							  <?php endif;?>
							</table>

						</div>
					</p>
		    </div>
		  </div>
		</div>
    <input type="hidden" name="task" value="avisohidrologico.edit" />
    <input type="hidden" name="jform[arquivos_deletados]" id="jform[arquivos_deletados]" />
    <?php echo JHtml::_('form.token'); ?>
</form>
<script type="text/javascript">
var contador = 1;

function addSampleRow(id)
{

    var objTable = document.getElementById(id);
    var objRow   = objTable.insertRow(objTable.rows.length);
    var objCell1 = objRow.insertCell(0);
    var objCell2 = objRow.insertCell(1);
	var objCell3 = objRow.insertCell(2);
	var objCell4 = objRow.insertCell(3);
	var objCell5 = objRow.insertCell(4);

    var objInputCheckBox  = document.createElement("input");
    objInputCheckBox.type = "checkbox";
    objCell1.appendChild(objInputCheckBox);

	var objInputTittle  = document.createElement("input");
    objInputTittle.type = "text";
	objInputTittle.name = "jform[titulos][]";

	objInputTittle.addEventListener("focusout", function(){
		checaTitulo(this);
	}, false);

    objCell2.appendChild(objInputTittle);

	var dataStr = new Date().toLocaleString();

	objCell3.innerHTML = dataStr.substring(0, dataStr.length - 3);
	objCell4.innerHTML = "<?php echo JFactory::getUser(JFactory::getUser()->id)->get('username') ?>";

	var objInputFile  = document.createElement("input");
    objInputFile.type = "file";
	objInputFile.name = "jform[arquivo][]";
	
	objInputFile.addEventListener("change", function(){
		checaMimeType(this);
	}, false);

    objCell5.appendChild(objInputFile);

	contador++;
}

function removeSampleRow(id)
{
    var objTable = document.getElementById(id);
    var iRow     = objTable.rows.length;
		var counter  = 0;
	if (objTable.rows.length > 1) {
		for (var i = 0; i < objTable.rows.length; i++) {

			var chk = objTable.rows[i].cells[0].childNodes[0];
			if (chk.checked) {
				objTable.deleteRow(i);
				if(chk.getAttribute("data") != null){
					var arquivos_deletados = document.getElementById('jform[arquivos_deletados]').value;
					if(arquivos_deletados == ''){
						document.getElementById('jform[arquivos_deletados]').value = chk.getAttribute("data");
					} else {
						 arquivos_deletados += "*"+chk.getAttribute("data");
						 document.getElementById('jform[arquivos_deletados]').value = arquivos_deletados;
					}
				}
				iRow--;
				i--;
				counter = counter + 1;
			}
		}

		if (counter == 0) {
			alert("Selecione a linha que deseja excluir.");
		}
	}else{
		alert("Não há linhas sendo adicionadas.");
	}
}
</script>
<script type="text/javascript">
Joomla.submitbutton = function(task)
{
	if (task == '')
	{
		return false;
	}
	else
	{
		var isValid=true;
		var action = task.split('.');

		if (action[1] != 'cancel' && action[1] != 'close')
		{
			var jform_titulo   = document.getElementById('jform_titulo').value;
			var jform_inicio   = document.getElementById('jform_inicio').value;
			var jform_validade = document.getElementById('jform_validade').value;

			if(jform_titulo   == '' ||
			   jform_inicio   == '' || 
			   jform_validade == '')
			{
			   isValid = false;
			}
		}
	
		if (isValid)
		{
			Joomla.submitform(task);
			return true;
		}
		else
		{
			alert("Por favor, preencher dados obrigatórios");
			return false;
		}
	}
}
</script>
<script type="text/javascript">
Array.prototype.contem = function(obj) 
{
    var i = this.length;
    while (i--) {
        if (this[i] === obj) {
            return true;
        }
    }
    return false;
}

function checaMimeType(inputFile)
{
	var file = inputFile.files[0];
	var max_file_size = parseInt(document.getElementById('max_file_size').value);

    if (file) {

      //valida os tipos e formatos de arquivos
      var extension = file.name.split('.').pop().toLowerCase();
      var blackList = ['image/png','image/jpeg','application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-excel','application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.presentationml.presentation','application/wps-office.docx','application/vnd.oasis.opendocument.text','application/vnd.oasis.opendocument.spreadsheet','application/vnd.oasis.opendocument.presentation'];

      if(!blackList.contem(file.type)) {
		inputFile.value = null;
		alert('Formato de arquivo não permitido.');
		console.log(file.type);
      } else if(extension == 'php' || extension == 'exe'){
      	inputFile.value = null;
		alert('Formato de arquivo não permitido.');
      } else if(file.size > max_file_size){
      	inputFile.value = null;
		alert('Tamanho do arquivo superior ao permitido.');
      }

      //checar duplicidade de arquivo antes do envio
      var inputFiles = document.getElementsByName("jform[arquivo][]");
      var cont = 0;
	  /*
      inputFiles.forEach(function(input_file){
      	var currentFiles = input_file.files;
      	for (var i = currentFiles.length - 1; i >= 0; i--) {
      		if(file.name == currentFiles[i].name){
      			cont++;
      			if(cont > 1){ // para não aparecer o alert pra ele mesmo
      				inputFile.value = null;
      				alert('Arquivo já cadastrado.');
      			}
      		}
      	}

      });*/


    }
}
</script>
<script type="text/javascript">
function checaTitulo(inputText,preventAlert = false)
{
	var titulo = inputText.value;
	inputText.style.borderColor = "#ccc";
	var xhttp = new XMLHttpRequest();
	document.getElementById("alert-td").style.display='none';
	var titulos  = document.getElementsByName("jform[titulos][]");
	var titulos_old  = document.getElementsByName("jform[titulos_old][]");
	var contador = 0;
	var contador_old = 0;

  	xhttp.onreadystatechange = function() {
	    if (this.readyState == 4 && this.status == 200) {

	        var respArr = JSON.parse(this.responseText);
			/*
			titulos.forEach(function(tituloInput) {

				if(tituloInput.value == titulo && tituloInput.value != ''){
					contador++;
					if(contador>1){
						mostraAlert = true;
						if(!preventAlert){
							alert('Já existe um título igual a submeter cadastrado.');
							tituloInput.value = '';
							tituloInput.focus();
						}
						return false;
					}
				}
		    	
			});


		    if(respArr['data']['find'] == true && !preventAlert){
		     	alert(respArr['message']+'. No servidor.');
		     	inputText.focus();
	    	}*/


	    }
    };

	xhttp.open("GET", "components/com_avisohidrologico/views/avisohidrologico/tmpl/ws.php?titulo="+titulo, true);
	xhttp.send();

}
</script>
<script type="text/javascript">
	jQuery.noConflict();
	(function( $ ) {
	  $(function() {
		$("input").attr('maxlength','1000');
		$("textarea").attr('maxlength','1000');
	  });
	})(jQuery);
</script>