<?php defined('_JEXEC') or die('Restricted access'); ?>
<?php require_once 'helper.php'; ?>
<?php 
    $anexos = getAnexoByRelacionadoId($this->item->id); 
?>
<form enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_relacionado&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <input type="hidden" name="created" value="<?php echo date("Y-m-d H:i:s");?>" />
    <input type="hidden" name="id" value="<?php echo $this->item->id;?>" />
    <input type="hidden" name="username" id="username" value="<?php echo JFactory::getUser()->username;?>" />
    <input type="hidden" id="max_file_size" value="<?php echo return_bytes(ini_get("upload_max_filesize")); ?>" 
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend>Relacionado</legend>
            <div class="row-fluid">
                <div class="span12">
                    <div class="tabbable"> <!-- Only required for left/right tabs -->
                          <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab1" data-toggle="tab">Relacionado</a></li>
                            <li><a href="#tab2" data-toggle="tab">Anexos</a></li>
                          </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">

                                        <?php foreach ($this->form->getFieldset() as $field): ?>

                                            <?php if($field->name == 'jform[artigos][]'): ?>
                                                <script>
                                                /*
                                                    jQuery.noConflict();
                                                    (function( $ ) {
                                                        $(function() {
                                                            var values='<?php echo $field->value ?>';
                                                            //values = values.slice(1, -1);
                                                            // $.each(values.split(","), function(i,e){
                                                            //console.log(values);
                                                            $.each(values.split(","), function(i,e){
                                                                console.log($(".artigos option[value='" + e + "']").text());
                                                                $(".artigos option[value='" + e + "']").prop("selected", true);//selected
                                                                $(".artigos option[value='" + e + "']").attr("selected", true)
                                                                //nome = $("#jform_artigos option[value='" + e + "']").text();
                                                                //$('.chzn-choices').append('<li class="search-choice"><span>'+nome+'</span><a class="search-choice-close" data-option-array-index="0"></a></li>');
                                                                $('#jform_artigos').trigger("chosen:updated");
                                                            });
                                                            
                                                            var config = {
                                                                '.chosen-select'           : {},
                                                                '.chosen-select-deselect'  : { allow_single_deselect: true },
                                                                '.chosen-select-no-single' : { disable_search_threshold: 10 },
                                                                '.chosen-select-no-results': { no_results_text: 'Oops, nothing found!' },
                                                                '.chosen-select-rtl'       : { rtl: true },
                                                                '.chosen-select-width'     : { width: '95%' }
                                                                }
                                                                for (var selector in config) {
                                                                $(selector).chosen(config[selector]);
                                                                }
                                                        });
                                                    })(jQuery);*/
                                                </script>
                                                <script>
                                                    jQuery.noConflict();
                                                    (function( $ ) {
                                                        $(function() {
                                                            <?php foreach (explode(",",$field->value) as $key_value) : ?>
                                                                $(".artigos option[value='<?php echo $key_value ?>']").prop("selected","selected");
                                                                console.log('<?php echo $key_value ?>');
                                                            <?php endforeach; ?>
                                                            $('.artigos').trigger("liszt:updated");
                                                        });
                                                    })(jQuery);
                                                </script>
                                            <?php endif ?>


                                        <div class="control-group">
                                        <div class="control-label"><?php echo $field->label; ?></div>
                                        <div class="controls"><?php echo $field->input; ?></div>
                                        </div>

                                    <?php endforeach; ?>
                                </div>

                                <div class="tab-pane" id="tab2">

                                    <p>
                                        <input class="btn btn-small button-new btn-success adicionaLinhaRaiz" value=" + Adicionar Ítem Relacionado" type="button" onclick="adicionaLinhaRaiz()"> 

                                        <?php if(! empty($anexo)): echo count($anexos) ?> anexo(s) encontrado(s).
                                        <?php endif; ?>
                                    </p>


                                    
                                 <table id="tblSample" name="tblSample" class="tree table">

                                    <tr>
                                        <th>Título</th>
                                        <th>Data</th>
                                        <th>Usuário</th>
                                        <th>Arquivo/Url</th>
                                        <th>Ação</th>
                                    </tr>

                                    <?php if(! empty($anexos)) : ?>
                                        <?php 
                                            $i = 0;
                                            foreach ($anexos as $anexo):
                                            $i++;        
                                            if($anexo->tipo == 1)
                                            {
                                                echo('<script>
                                                    jQuery.noConflict();
                                                    (function( $ ) {
                                                        $(function() {
                                                    
                                                            $("#arquivo-"+'.$i.').show();
                                                            $("#url-"+'.$i.').hide();
                                                            document.getElementById(\'tipo-\'+'.$i.').value = 1;
                                                        });
                                                    })(jQuery);
                                                    </script>');
                                            }
                                            else
                                            {
                                                echo('<script>
                                                    jQuery.noConflict();
                                                        (function( $ ) {
                                                            $(function() {
                                                                $("#arquivo-"+'.$i.').hide();
                                                                $("#url-"+'.$i.').show();
                                                                document.getElementById(\'tipo-\'+'.$i.').value = 2;
                                                        });
                                                    })(jQuery);
                                                    </script>');
                                            }
                                        ?>

                                            <?php if($anexo->level_parent == 0) : ?>
                                                <?php if($anexo->level_id == 0) $anexo->level_id =1; ?>
                                                <tr class="expanded treegrid-<?php echo $anexo->level_id?> treegrid-<?php echo $anexo->id?>">
                                            <?php else : ?>
                                                <tr class="expanded treegrid-<?php echo $anexo->level_id?> treegrid-<?php echo $anexo->id?>  treegrid-parent-<?php echo $anexo->level_parent?>">
                                            <?php endif; ?>
                                                    <td>
                                                        <input name="jform[titulos][]" value="<?php echo $anexo->titulo?>" onchange="checaTitulo(this,true)" type="text">
                                                        <input name="jform[parent_id][]" value="<?php echo $anexo->parent_id?>" type="hidden">
                                                        <input name="jform[file_id][]" value="<?php echo $anexo->id;?>" type="hidden">
                                                        <input name="jform[nivel][]" value="<?php echo $anexo->level_id .'-'.$anexo->level_parent;?>" type="hidden">
                                                        <input name="jform[tipo][]" id="tipo-<?php echo $i; ?>" value="<?php echo $anexo->tipo; ?>" type="hidden">
                                                        <input name="jform[old_arquivos][]"  id="jform[old_arquivos][<?php echo $i; ?>]" value="<?php echo $anexo->arquivo;?>" type="hidden">
                                                    </td>
                                                    <td><?php echo preparaData($anexo->created)?></td>
                                                    <td><?php echo getUsernameById($anexo->id_user)?></td>
                                                    <td>
                                                        <div id="arquivo-<?php echo $i; ?>">
                                                            <button class="btn btn-small button-new" onclick="troca('<?php echo $i; ?>', 2)" type="button"><span class="icon-shuffle"> </span></button>
                                                            <input onchange="edit(<?php echo $i; ?>)" name="jform[arquivo][]" id="jform[arquivos][<?php echo $i; ?>]" value="<?php echo $anexo->arquivo; ?>" onchange="checaMimeType(this)" type="file">(<?php echo $anexo->arquivo; ?>)
                                                        </div>
                                                        <div id="url-<?php echo $i; ?>">
                                                            <button class="btn btn-small button-new" onclick="troca('<?php echo $i; ?>', 1)" type="button"><span class="icon-shuffle"> </span></button>
                                                            <input name="jform[url][]" id="jform[urls][<?php echo $i; ?>]" value="<?php echo $anexo->arquivo; ?>" type="text">
                                                        </div>
                                                    </td>
                                                    <td> <input class="btn btn-small button-new btn-danger" id="btnDelete" value="- Remover Linha" onclick="removeLinha('treegrid-<?php echo $anexo->level_id?>')" type="button"> <input class="btn btn-small button-new btn-success adicionaLinhaFilha" value="+ Adicionar Linha" onclick="adicionaLinhaFilha('treegrid-<?php echo $anexo->level_id?>')" type="button"></td>
                                                </tr>

                                        <?php endforeach; ?>
                                    <?php endif; ?>


                                  </table>        

                                </div>
                          </div>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="relacionado.edit" />
    <input type="hidden" name="jform[arquivos_deletados]" id="jform[arquivos_deletados]" />
    <?php echo JHtml::_('form.token'); ?>
</form>
<script>
function edit(id) {
    var fileInput = document.getElementById('jform[arquivos]['+id+']');   
    var filename = fileInput.files[0].name;
    document.getElementById('jform[old_arquivos]['+id+']').value = filename;
    checaMimeType(fileInput);
};
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
            var jform_artigos  = document.getElementById('jform_artigos').value;

            if(jform_titulo   == '' ||
               jform_artigos == '')
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
    jQuery.noConflict();
    (function( $ ) {
      $(function() {
        $("input").attr('maxlength','1000');
        $("textarea").attr('maxlength','1000');
      });
    })(jQuery);
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

      var extension = file.name.split('.').pop().toLowerCase();
      var blackList = ['image/png','image/jpeg','application/pdf','application/msword','application/vnd.openxmlformats-officedocument.wordprocessingml.document','application/vnd.ms-excel','application/vnd.ms-powerpoint','application/vnd.openxmlformats-officedocument.presentationml.presentation','application/wps-office.docx','application/vnd.oasis.opendocument.text','application/vnd.oasis.opendocument.spreadsheet','application/vnd.oasis.opendocument.presentation','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
        
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
    // document.getElementById("alert-td").style.display='none';

    var titulos  = document.getElementsByName("jform[titulos][]");
    var contador = 0;
    /*
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var respArr = JSON.parse(this.responseText);
            
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
            }

        }
    };*/
    xhttp.open("GET", "components/com_relacionado/views/relacionado/tmpl/ws.php?titulo="+titulo, true);
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