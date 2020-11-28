<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Licitacoes
 * @author     Pedro Santos <phmsanttos@gmail.com>
 * @copyright  2018 Pedro Santos
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

require_once 'helper.php';

$anexos = getAnexosById($this->item->id);



// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_licitacoes/css/form.css');

$document->addScript(JUri::root() . 'administrator/components/com_licitacoes/assets/js/angular.min.js');
$document->addScript(JUri::root() . 'administrator/components/com_licitacoes/assets/js/script.js');
?>
<script type="text/javascript">
    jQuery(document).ready(function(){
        jQuery(".somenteNumero").bind("keyup blur focus", function(e) {
            e.preventDefault();
            var expre = /[^\d]/g;
            jQuery(this).val(jQuery(this).val().replace(expre,''));
        });
    });

	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'licitacao.cancel') {
			Joomla.submitform(task, document.getElementById('licitacao-form'));
		}
		else {
			
			if (task != 'licitacao.cancel' && document.formvalidator.isValid(document.id('licitacao-form'))) {
				
				Joomla.submitform(task, document.getElementById('licitacao-form'));
			}
			else {
				alert('<?php echo $this->escape(JText::_('JGLOBAL_VALIDATION_FORM_FAILED')); ?>');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_licitacoes&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="licitacao-form" class="form-validate">

    <input type="hidden" id="max_file_size" value="<?php echo return_bytes(ini_get("upload_max_filesize")); ?>" />

	<div class="form-horizontal"  ng-app="Interessados">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_LICITACOES_TITLE_LICITACAO', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('state'); ?>
				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>
                <?php echo $this->form->renderField('publicado'); ?>
				<?php echo $this->form->renderField('titulo'); ?>
				<?php echo $this->form->renderField('resumo'); ?>
				<?php echo $this->form->renderField('data_licitacao'); ?>
				<?php echo $this->form->renderField('numero_processo'); ?>
				<?php echo $this->form->renderField('ano_processo'); ?>
				<?php echo $this->form->renderField('modalidade'); ?>
				<?php echo $this->form->renderField('numero_modalidade'); ?>
				<?php echo $this->form->renderField('ano_modalidade'); ?>
				<?php echo $this->form->renderField('objeto'); ?>
				<?php echo $this->form->renderField('data_publicacao'); ?>


					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>
        <?php echo JHtml::_('bootstrap.addTab', 'myTab', 'generall', JText::_('Documentos Relacionados', false)); ?>
        <p>
						<div class="span10">
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
									<th>Ordem</th>
									<th>Tipo</th>
									<th>Data</th>
									<th>Usuário</th>
									<th>Arquivo</th>
								</tr>

								<?php if(empty($anexos) && !empty($this->item->id)): ?>
									<td colspan="8" id="mensagem">
										<div class="alert">
												<button type="button" class="close" data-dismiss="alert">×</button>
												<h4 class="alert-heading">Mensagem</h4>
												<div class="alert-message">Nenhum anexo encontrado.</div>
										</div>
									</td>
								<?php else: ?>
									<?php if(!empty($anexos)) : ?>
                                        <?php $aux = 0; ?>
										<?php foreach ($anexos as $anexo): ?>
                                            <tr>
												<td data="<?php echo $anexo->id ?>"><input data="<?php echo $anexo->id ?>" type="checkbox"></td>
												<td>
													<input type="text" name="jform[titulo_arquivo][]" value="<?php echo $anexo->titulo ?>" onfocusout="checaTitulo(this,true)">
													<input type="hidden" name="jform[titulo_arquivo_old][]" value="<?php echo $anexo->titulo ?>">
													<input type="hidden" name="jform[anexo_id][]" value="<?php echo $anexo->id ?>">
												</td>
                                                <td><input type="text" name="jform[ordering_arquivo][]" value="<?php echo $anexo->ordering ?>" style="width: 25px;"></td>
                                                <td>
												<p>
													<input type="radio" value="0" id="tipo" name="jform[tipo][<?php echo $aux ?>]" <?php echo ($anexo->tipo == "0") ? "checked" : "" ?> style="float:left">
													<label style="float: right;">Comum</label>
												</p>
												<p style="float:left">
													<input type="radio" value="1" name="jform[tipo][<?php echo $aux ?>]" <?php echo ($anexo->tipo == "1") ? "checked" : "" ?> >
													<label style="float: right;">Edital</label>
												</p>
                                                    
                                                </td>
												<td><?php echo preparaData($anexo->checked_out_time) ?></td>
												<td><?php echo getUsernameById($anexo->created_by) ?></td>
												<td><input onchange="checaMimeType(this)" type="file" name="jform[arquivo][]" value="<?php echo $anexo->arquivo ?>"> (<?php echo $anexo->arquivo ?>)</td>
											</tr>
                                            <?php $aux++; ?>
										<?php endforeach; ?>
							  	<?php endif;?>
							  <?php endif;?>
							</table>

						</div>
					</p>
        
        <?php echo JHtml::_('bootstrap.endTab'); ?>

        <?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
        <input type="hidden" name="jform[arquivos_deletados]" id="jform[arquivos_deletados]" />
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>

<script type="text/javascript">
var contador = 1;

function isValidDate(dateString)
	{
		// First check for the pattern
		var regex_date = /^\d{4}\-\d{1,2}\-\d{1,2}$/;

		if(!regex_date.test(dateString))
		{
			return false;
		}

		// Parse the date parts to integers
		var parts   = dateString.split("-");
		var day     = parseInt(parts[2], 10);
		var month   = parseInt(parts[1], 10);
		var year    = parseInt(parts[0], 10);

		// Check the ranges of month and year
		if(year < 1000 || year > 3000 || month == 0 || month > 12)
		{
			return false;
		}

		var monthLength = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];

		// Adjust for leap years
		if(year % 400 == 0 || (year % 100 != 0 && year % 4 == 0))
		{
			monthLength[1] = 29;
		}

		// Check the range of the day
		return day > 0 && day <= monthLength[month - 1];
	}

	jQuery(function($){ 
		$("#jform_data_publicacao").on('change', function() {
			var data = document.getElementById('jform_data_publicacao').value;
			if(!isValidDate(data)){
				alert('Data da publicação invalida!');
				document.getElementById('jform_data_publicacao').value = '';
			}
		});
		$("#jform_data_licitacao").on('change', function() {
			var data = document.getElementById('jform_data_licitacao').value;
			if(!isValidDate(data)){
				alert('Data da licitação invalida!');
				document.getElementById('jform_data_licitacao').value = '';
			}
		});
	});
	
function addSampleRow(id)
{
	jQuery("#mensagem").hide();

    var objTable        = document.getElementById(id);
    var objRow          = objTable.insertRow(objTable.rows.length);
    var objCell_ID      = objRow.insertCell(0);
    var objCell_Titulo  = objRow.insertCell(1);
    var objCell_Ordem   = objRow.insertCell(2);
    var objCell_Tipo    = objRow.insertCell(3);
	var objCell_Data    = objRow.insertCell(4);
	var objCell_Usuario = objRow.insertCell(5);
	var objCell_Arquivo = objRow.insertCell(6);

    // CELULA DO ID //
    var objInputCheckBox  = document.createElement("input");
    objInputCheckBox.type = "checkbox";
    objCell_ID.appendChild(objInputCheckBox);
    // FIM DA CELULA DO ID //

    // CELULA DO TITULO //
	var objInputTittle  = document.createElement("input");
    objInputTittle.type = "text";
	objInputTittle.name = "jform[titulo_arquivo][]";
	objInputTittle.addEventListener("focusout", function(){
		checaTitulo(this);
	}, false);

    objCell_Titulo.appendChild(objInputTittle);
    // FIM DA CELULA DO TITULO //

    // CELULA DO ORDEM //
	var objInputOrdem  = document.createElement("input");
    objInputOrdem.type = "text";
	objInputOrdem.name = "jform[ordering_arquivo][]";
	objInputOrdem.style = "width: 25px;"
	
    objCell_Ordem.appendChild(objInputOrdem);
    // FIM DA CELULA DO ORDEM //

    // CELULA DO TIPO //
    var aux = document.querySelectorAll('tr').length - 19;

	// CELULA DO TIPO //
	var html = "<p>";
	html += '<input type="radio" value="0" name="jform[tipo]['+aux+']" style="float:left" checked><label style="float: right;">Comum</label>';
	html +="</p>";

	html += '<p style="float:left">';
	html += '<input type="radio" value="1" name="jform[tipo]['+aux+']"><label style="float: right;">Edital</label>';
	html +=	"</p>";		
		
    objCell_Tipo.innerHTML = jQuery.trim(html);
    // FIM DA CELULA DO TIPO //

    // CELULA DA DATA //
	var dataStr = new Date().toLocaleString();
	objCell_Data.innerHTML = dataStr.substring(0, dataStr.length - 3);
    //FIM DA CELULA DA DATA //

    // CELULA DO USUÁRIO //
	objCell_Usuario.innerHTML = "<?php echo JFactory::getUser(JFactory::getUser()->id)->get('username') ?>";

    // CELULA DO ARQUIVO //
	var objInputFile  = document.createElement("input");
    objInputFile.type = "file";
	objInputFile.name = "jform[arquivo][]";
	
	objInputFile.addEventListener("change", function(){
		checaMimeType(this);
	}, false);

    objCell_Arquivo.appendChild(objInputFile);
    // FIM DA CELULA DO ARQUIVO //

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
	  
    }
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas2image@1.0.5/canvas2image.min.js"></script>
<script language="javascript">
    function createPDF() {
        (function($){
            $.fn.createPdf = function(parametros) {
                var config = {
                    'fileName':'html-to-pdf'
                };

                if (parametros){
                    $.extend(config, parametros);
                }
                var quotes = document.getElementById('tab_customers');
                html2canvas(quotes, {
                    onrendered: function(canvas) {
                        var pdf = new jsPDF('p', 'pt', 'letter');
                        for (var i = 0; i <= quotes.clientHeight/980; i++) {
                            var srcImg  = canvas;
                            var sX      = 0;
                            var sY      = 980*i;
                            var sWidth  = 900;
                            var sHeight = 980;
                            var dX      = 0;
                            var dY      = 0;
                            var dWidth  = 900;
                            var dHeight = 980;
                            window.onePageCanvas = document.createElement("canvas");
                            onePageCanvas.setAttribute('width', 900);
                            onePageCanvas.setAttribute('height', 980);
                            var ctx = onePageCanvas.getContext('2d');
                            ctx.drawImage(srcImg,sX,sY,sWidth,sHeight,dX,dY,dWidth,dHeight);
                            var canvasDataURL = onePageCanvas.toDataURL("image/png", 1.0);
                            var width         = onePageCanvas.width;
                            var height        = onePageCanvas.clientHeight;
                            if (i > 0) {
                                pdf.addPage(612, 791);
                            }
                            pdf.setPage(i+1);
                            pdf.addImage(canvasDataURL, 'PNG', 20, 40, (width*.62), (height*.62));
                        }
                        pdf.save(config.fileName);
                    }
                });
            };
        })(jQuery);

        var data = new Date();
        var dia  = data.getDate();
        var mes  = data.getMonth() + 1;
        var ano  = data.getFullYear();
        var arquivo = jQuery('#tituloRel').val();
        arquivo = arquivo + "  --  " + dia + "-" + mes + "-" + ano;
        jQuery('#renderPDF').createPdf({
            'fileName' : arquivo + '.pdf'
        });
		//jform_data_publicacao
    }
</script>