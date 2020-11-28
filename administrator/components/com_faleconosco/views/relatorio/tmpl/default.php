<?php defined('_JEXEC') or die('Restricted access');?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script>

function gerarRelatorio(){
  var inicio = document.getElementById("inicio").value;
  var fim    = document.getElementById("fim").value;
  var status = document.getElementById("status").value;
  var setor  = document.getElementById("setor").value;
  var tipo   = document.getElementById("tipo").value;
  window.location.href = 'index.php?option=com_contato&view=relatorio&inicio='+inicio+'&fim='+fim+'&status='+status+'&setor='+setor+'&tipo='+tipo;
}

$(function() {

    $( ".calendario" ).datepicker({
        dateFormat: 'dd/mm/yy',
        dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado','Domingo'],
        dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
        dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
        monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
        monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez']
    });

    $('#adminForm').on('submit', function(e){
      e.preventDefault();
    });

    $( "#gerar" ).on( "click", function( event ) {
      gerarRelatorio();
    });
});
</script>
<form method="post" action="index.php?option=com_contato&view=relatorio" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend>Contato</legend>
            <div class="row-fluid">
                <div class="span6">
                        <div class="control-group">
                            <div class="control-label">
                              Início:
                            </div>
                            <div class="controls">
                              <input type="text" name="inicio" id="inicio" class="calendario" value="<?php echo($this->init); ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="control-label">
                              Fim:
                            </div>
                            <div class="controls">
                              <input type="text" name="fim" id="fim" class="calendario" value="<?php echo($this->fim); ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="control-label">
                              Tipo:
                            </div>
                            <div class="controls">
                              <select name="tipo" id="tipo" class="required" required="" aria-required="true" style="width: 100%;">
                                <option value="1" <?php echo ($this->tipo == 1 ? ' selected="selected"' : ''); ?>>Status</option>
                                <option value="2" <?php echo ($this->tipo == 2 ? ' selected="selected"' : ''); ?>>Demandas x Setor</option>
                              </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="control-label">
                              Status:
                            </div>
                            <div class="controls">
                              <select name="status" id="status" class="required" required="" aria-required="true" style="width: 100%;">
                                <option value="1" <?php echo ($this->status == 1 ? ' selected="selected"' : ''); ?>>Recebida</option>
                                <option value="2" <?php echo ($this->status == 2 ? ' selected="selected"' : ''); ?>>Encaminhada para setor responsável</option>
                                <option value="3" <?php echo ($this->status == 3 ? ' selected="selected"' : ''); ?>>Respondida ao cidadão</option>
                                <option value="4" <?php echo ($this->status == 4 ? ' selected="selected"' : ''); ?>>Respondida - solicitação não faz parte das atribuições da Apac</option>
                                <option value="5" <?php echo ($this->status == 5 ? ' selected="selected"' : ''); ?>>Solicitação não respondida</option>
                                <option value="6" <?php echo ($this->status == 6 ? ' selected="selected"' : ''); ?>>Spam</option>
                                </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="control-label">
                              Setor:
                            </div>
                            <div class="controls">
                              <select name="setor" id="setor" class="required" required="" aria-required="true" style="width: 100%;">
                                <option value="0" <?php echo ($this->setor == 0 ? ' selected="selected"' : ''); ?>>Nenhum</option>
                                <?php foreach ($this->setores as $item => $value) : ?>
                                  <option value="<?php echo $value->nome; ?>" <?php echo ($this->setor == $value->nome ? ' selected="selected"' : ''); ?> ><?php echo $value->nome; ?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                        </div>

                        <div class="control-group">
                          <div class="control-label">
                            Gerar:
                          </div>
                          <div class="controls">
                            <button id="gerar" class="btn btn-small button-new btn-success">
                              <span class="icon-new icon-white" aria-hidden="true"></span>
                              Gerar
                            </button>
                          </div>
                        </div>

                        <div class="control-group">
                          <div class="control-label">
                            Relatório:
                          </div>
                          <div class="controls">
                          <style type="text/css">
                              .tg  {border-collapse:collapse;border-spacing:0;min-width: 350px;}
                              .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
                              .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
                              .tg .tg-yw4l{vertical-align:top}
                              </style>

                              <?php
                              if(isset($this->tipo) && $this->tipo == '1'){
                              ?>
                              <table class="tg">
                                <tr>
                                  <th class="tg-yw4l">Demandas</th>
                                  <th class="tg-yw4l">Status</th>
                                </tr>

                              <?php if(!empty($this->item)) :  ?>

                              <?php foreach ($this->item as $item => $value) : ?>
                                <tr>
                                  <td><center><?php echo $value->quantidade ?></center></td>
                                  <td><center><?php echo $this->statusname[$value->status] ?></center></td>
                                </tr>
                              <?php endforeach; ?>
                              <?php else: ?>
                                <tr>
                                  <td colspan="3"><center>Nenhum Resultado Encontrado.</center></td>
                                </tr>
                              <?php endif; ?>
                              </table>
                              <?php
                              }else if(isset($this->tipo) && $this->tipo == '2'){
                              ?>
                              <table class="tg">
                                <tr>
                                  <th class="tg-yw4l">Demandas</th>
                                  <th class="tg-yw4l">Setor</th>
                                </tr>

                              <?php if(!empty($this->item)) :  ?>

                              <?php foreach ($this->item as $item => $value) : ?>
                                <tr>
                                  <td><center><?php echo $value->quantidade ?></center></td>
                                  <td><center><?php echo $value->setor ?></center></td>
                                </tr>
                              <?php endforeach; ?>
                              <?php else: ?>
                                <tr>
                                  <td colspan="3"><center>Nenhum Resultado Encontrado.</center></td>
                                </tr>
                              <?php endif; ?>
                              </table>
                              <?php
                              }
                              ?>

                          </div>
                        </div>

                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="contato.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>
