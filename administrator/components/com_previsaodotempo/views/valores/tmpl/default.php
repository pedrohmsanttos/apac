<?php defined('_JEXEC') or die('Restricted access');?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script>
  <?php
    if(isset($_GET['f'])){
      echo "window.location.href = 'index.php?option=com_previsaodotempo&view=valores';";
    }
  ?>

  function changeSetor(f, id){
    var variavel    = document.getElementById("variavel").value;
    var valor       = document.getElementById("valor").value;
    if(f === "del"){
      valor = id;
    }else{
      if(variavel == '' || variavel == 0 || valor == ''){
        alert("Variavel não pode ser vazio!");
        window.reload();
      }
    }
    
    window.location.href = 'index.php?option=com_previsaodotempo&view=valores&f='+f+'&variavel='+variavel+'&valor='+valor;
  }

  $(function() {
    $('#adminForm').on('submit', function(e){
      e.preventDefault();
    });
  });
</script>
<form method="post" action="index.php?option=com_previsaodotempo&view=valores" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend>Adicionar valor</legend>
            <div class="row-fluid">
                <div class="span6">
                        <div class="control-group">
                            <div class="control-label">
                              Variavel:
                            </div>
                            <div class="controls">
                              <select name="variavel" id="variavel">
                                <option value="0">Selecione uma variavel</option>
                                <?php foreach ($this->variaveis as $variavel) : ?>
                                  <option value="<?php echo($variavel->id);?>"> <?php echo($variavel->nome);?></option>
                                <?php endforeach; ?>
                              </select>
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="control-label">
                              Valor:
                            </div>
                            <div class="controls">
                              <input type="text" name="valor" id="valor" class="calendario" />
                            </div>
                        </div>

                        <div class="control-group">
                          <div class="control-label">
                            Cadastrar:
                          </div>
                          <div class="controls">
                            <button id="gerar" class="btn btn-small button-new btn-success" onclick="changeSetor('add')">
                              <span class="icon-new icon-white" aria-hidden="true"></span>
                              Adicionar
                            </button>
                          </div>
                        </div>

                        <div class="control-group">
                          <div class="control-label">
                            Valores:
                          </div>
                          <div class="controls">
                          <style type="text/css">
                              .tg  {border-collapse:collapse;border-spacing:0;min-width: 350px;}
                              .tg td{font-family:Arial, sans-serif;font-size:14px;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
                              .tg th{font-family:Arial, sans-serif;font-size:14px;font-weight:normal;padding:10px 5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;}
                              .tg .tg-yw4l{vertical-align:top}
                              </style>

                              <table class="tg">
                              <tr>
                                <th class="tg-yw4l">Variavel</th>
                                <th class="tg-yw4l">Valor</th>
                                <th class="tg-yw4l">Ação</th>
                              </tr>

                              <?php if(!empty($this->valores)) :  ?>

                              <?php foreach ($this->valores as $item => $value) : ?>
                                <tr>
                                  <td><center><?php echo $value->variavel; ?></center></td>
                                  <td><center><?php echo $value->valor; ?></center></td>
                                  <td>
                                    <center>
                                    <button id="gerar" class="btn btn-small button-new btn-danger" onclick="changeSetor('del', '<?php echo $value->id; ?>')">
                                      <span class="icon-remove icon-white" aria-hidden="true"></span>
                                      Deletar
                                    </button>
                                  </td>
                                </tr>
                              <?php endforeach; ?>
                            <?php else: ?>
                              <tr>
                                <td colspan="3"><center>Nenhum valor cadastrado.</center></td>
                              </tr>
                            <?php endif; ?>


                              </table>
                          </div>
                        </div>

                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="contato.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>
