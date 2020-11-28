<?php defined('_JEXEC') or die('Restricted access');?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script>
  <?php
    if(isset($_GET['f'])){
      echo "window.location.href = 'index.php?option=com_contato&view=setor';";
    }
  ?>

  function changeSetor(f, id){
    var nome    = document.getElementById("nome").value;
    if(f === "del"){
      nome = id;
    }
    window.location.href = 'index.php?option=com_contato&view=setor&f='+f+'&data='+nome;
  }

  $(function() {
    $('#adminForm').on('submit', function(e){
      e.preventDefault();
    });
});
</script>
<form method="post" action="index.php?option=com_contato&view=setor" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend>Adicionar setor</legend>
            <div class="row-fluid">
                <div class="span6">
                        <div class="control-group">
                            <div class="control-label">
                              Nome:
                            </div>
                            <div class="controls">
                              <input type="text" name="nome" id="nome" class="calendario" />
                            </div>
                        </div>

                        <div class="control-group">
                          <div class="control-label">
                            Cadastrar:
                          </div>
                          <div class="controls">
                            <button id="gerar" class="btn btn-small button-new btn-success" onclick="changeSetor('add')">
                              <span class="icon-new icon-white" aria-hidden="true"></span>
                              Salvar
                            </button>
                          </div>
                        </div>

                        <div class="control-group">
                          <div class="control-label">
                            Setores:
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
                                <th class="tg-yw4l">Setor</th>
                                <th class="tg-yw4l">Ação</th>
                              </tr>

                              <?php if(!empty($this->setores)) :  ?>

                              <?php foreach ($this->setores as $item => $value) : ?>
                                <tr>
                                  <td><center><?php echo $value->nome; ?></center></td>
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
                                <td colspan="3"><center>Nenhum setor cadastrado.</center></td>
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
