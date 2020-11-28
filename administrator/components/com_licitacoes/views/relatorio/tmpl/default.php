<?php
    defined('_JEXEC') or die('Restricted access');
    JHtml::_('behavior.formvalidation')
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.0/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.2.js"></script>
<script src="http://code.jquery.com/ui/1.9.0/jquery-ui.js"></script>
<script>

function gerarRelatorio(){
    var processo    = $("#processo").val();
    var ano         = $("#ano").val();
    var tipo        = $("#tipo").val();
    var documento   = $("#documento").val();
    var nome        = $("#nome").val();
    var pessoa      = $("#pessoa").val();
    
    window.location.href = 'index.php?option=com_licitacoes&view=relatorio&processo='+processo+'&ano='+ano+'&tipo='+tipo+'&documento='+documento+'&nome='+nome+'&pessoa='+pessoa;
}

function limparRelatorio(){
    window.location.href = 'index.php?option=com_licitacoes&view=relatorio&processo=&ano=&tipo=&documento=&nome=&pessoa=';
}

$(function() {

    $('#adminForm').on('submit', function(e){
        e.preventDefault();
    });

    $( "#gerar" ).on( "click", function( event ) {

        var processo    = $("#processo").val();
        var ano         = $("#ano").val();
        var tipo        = $("#tipo").val();
        var documento   = $("#documento").val();
        var nome        = $("#nome").val();
        var pessoa      = $("#pessoa").val();

        gerarRelatorio();

        // //Consulta de Pessoas Físicas ou Jurídicas
        // if(tipo != "" && tipo == "3"){
        //     gerarRelatorio();
        // }
        // //Empresas que baixaram o edital ou Histórico de Downloads
        // else if(tipo != "" && (tipo == "1" || tipo == "2") ){
        //     if (processo != "" && ano != "" && tipo != "") {
        //         gerarRelatorio();
        //     }
        // }

        
    });

    $( "#limpar" ).on( "click", function( event ) {
      limparRelatorio();
    });

    $("#tipo").on("change",function(){
        var tipo = $(this).val();

        if(tipo == "3"){
            $("#relatorioInteressados").show();
        }else{
            $("#relatorioInteressados").hide();
            $("#documento").val("");
            $("#nome").val("");
            $("#pessoa").val("");
        }
        
    });

    jQuery(".somenteNumero").bind("keyup blur focus", function(e) {
            e.preventDefault();
            var expre = /[^\d]/g;
            jQuery(this).val(jQuery(this).val().replace(expre,''));
        });


    $("#tipo").change();

});
</script>

<?php 
    $display = "none";
    if($this->documento != "" || $this->nome != "" || $this->pessoa != ""){
        $display = "block";
    }

    $tituloInteressados = "";

    if($this->tipo != "" ){
        $tituloInteressados .= " ( ";
        if($this->processo != ""){
            $tituloInteressados .= " Processo: " . $this->processo . "|";
        }

        else if($this->ano != ""){
            $tituloInteressados .= " Ano: " . $this->ano . "|";
        }

        else if($this->pessoa != ""){
            if($this->pessoa == "f"){
                $tituloInteressados .= " Pessoa: Física";
            }else{
                $tituloInteressados .= " Pessoa: Jurídica";
            }
            $tituloInteressados .= "|";
        }

        else if($this->documento != ""){
            $tituloInteressados .= " CPF/CNPJ: " . $this->documento . "|";
        }

        else if($this->nome != ""){
            $tituloInteressados .= " Nome/Razão Social: " . $this->nome . "|";
        }

        if($tituloInteressados != ""){
            $tituloInteressados = rtrim($tituloInteressados,"|");
            $tituloInteressados .= ")";
        }
    }
?>

<form method="post" action="index.php?option=com_licitacoes&view=relatorio" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend>Licitações - Downloads do Edital - Filtro</legend>
            <div class="row-fluid">
                <div class="span6">
                        <div class="control-group">
                            <div class="control-label">
                              Número do Processo:
                            </div>
                            <div class="controls">
                              <input type="text" class="required"  name="processo" id="processo" class="" value="<?php echo ($this->processo != "" ? $this->processo : ''); ?>" />
                            </div>
                        </div>

                        <div class="control-group">
                            <div class="control-label">
                              Ano:
                            </div>
                            <div class="controls">
                              <input type="text" class="required" name="ano" id="ano" class="somenteNumero" value="<?php echo ($this->ano != "" ? $this->ano : ''); ?>" />
                            </div>
                        </div>

                        <div id="relatorioInteressados" style="display:<?php echo $display ?>">
                            <div class="control-group">
                                <div class="control-label">
                                    CPF/CNPJ:
                                </div>
                                <div class="controls">
                                <input type="text" class="required"  name="documento" id="documento" class="somenteNumero" value="<?php echo ($this->documento != "" ? $this->documento : ''); ?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="control-label">
                                    Nome/Razão Social:
                                </div>
                                <div class="controls">
                                <input type="text" class="required" name="nome" id="nome" class="" value="<?php echo ($this->nome != "" ? $this->nome : ''); ?>" />
                                </div>
                            </div>

                            <div class="control-group">
                                <div class="control-label">
                                    Pessoa:
                                </div>
                                <div class="controls">
                                    <select name="pessoa" id="pessoa" class="required"  aria-required="true" style="width: 100%;">
                                        <option value="" <?php echo ($this->pessoa == "" ? ' selected="selected"' : ''); ?>></option>
                                        <option value="f" <?php echo ($this->pessoa == "f" ? ' selected="selected"' : ''); ?>>Física</option>
                                        <option value="j" <?php echo ($this->pessoa == "j" ? ' selected="selected"' : ''); ?>>Jurídica</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        

                        <div class="control-group">
                            <div class="control-label">
                              Tipo Relatório:
                            </div>
                            <div class="controls">
                              <select name="tipo" id="tipo" class="required"  aria-required="true" style="width: 100%;">
                                  <option value="" <?php echo ($this->tipo == "" ? ' selected="selected"' : ''); ?>></option>
                                  <option value="1" <?php echo ($this->tipo == 1 ? ' selected="selected"' : ''); ?>>Empresas que baixaram o edital</option>
                                  <option value="2" <?php echo ($this->tipo == 2 ? ' selected="selected"' : ''); ?>>Histórico de Downloads</option>
                                  <option value="3" <?php echo ($this->tipo == 3 ? ' selected="selected"' : ''); ?>>Consulta de Interessados</option>
                              </select>
                            </div>
                        </div>

                        <div class="control-group">
                          <div class="control-label">
                            Opções:
                          </div>
                          <div class="controls">
                            <button id="gerar" class="btn btn-small button-new btn-success">
                              <span class="icon-new icon-white" aria-hidden="true"></span>
                              Gerar
                            </button>
                            <button id="limpar" class="btn btn-small button-new">
                              Limpar
                            </button>
                          </div>
                        </div>

                        <div class="control-group">
                          <div class="control-label">
                            Relatório:
                          </div>
                          <div class="controls">
                              <style type="text/css">
                                  .tg  {
                                      border-collapse:collapse;
                                      border-spacing:0;
                                      min-width: 700px;
                                  }
                                  .tg td{
                                      font-family:Arial, sans-serif;
                                      font-size:14px;
                                      padding:10px;
                                      border-style:solid;
                                      border-width:1px;
                                      overflow:hidden;
                                      word-break:normal;
                                  }
                                  .tg th{
                                      font-family:Arial, sans-serif;
                                      font-size:14px;
                                      font-weight:normal;
                                      padding:10px;
                                      border-style:solid;
                                      border-width:1px;
                                      overflow:hidden;
                                      word-break:normal;
                                      background: rgb(201, 201, 201)
                                  }
                                  .tg .tg-yw4l{vertical-align:top}
                                  .title  {
                                      border-collapse:collapse;
                                      border-spacing:0;
                                      vertical-align: 8px;
                                      background: rgb(20, 162, 200);
                                      font-family:Arial, sans-serif;
                                      font-size:14px;
                                      font-weight:normal;
                                      padding:10px 144.5px;
                                      border-style:solid;
                                      border-width:1px;
                                      overflow:hidden;
                                      word-break:normal;
                                  }
                              </style>

                              <?php
                              if(isset($this->tipo) && $this->tipo == '1'){
                              ?>
                              <?php if(!empty($this->item)) :  ?>
                              <input type="hidden" id="tituloRel" value="<?php echo $this->item[0]->titulo; ?>">
                              <table class="tg" id="tab_customers">
                                <tr>
                                    <td colspan="2" class="title"><strong>DOWNLOAD EDITAL - <?php echo $this->item[0]->titulo; ?></strong></td>
                                </tr>
                                <tr>
                                  <th class="tg-yw4l">CPF/CNPJ</th>
                                  <th class="tg-yw4l">Nome/Razão Social</th>
                                </tr>
                              <?php $total = 0; ?>

                              <?php foreach ($this->item as $item => $value) : 
                                    var_dump($this->item);?>
                                <?php if(trim($value->documento_usuario) != "" && trim($value->nome_razao) != ""): ?>
                                    <?php $total++; ?>
                                    <tr>
                                        <td><center><?php echo $value->documento_usuario ?></center></td>
                                        <td><center><?php echo $value->nome_razao ?></center></td>
                                    </tr>
                                <?php endif; ?>
                              <?php endforeach; ?>
                              <?php else: ?>
                                <tr>
                                    <td colspan="2"><label style="color: #394d71!important;font-weight: bold!important;">Nenhum Resultado Encontrado.</label></td>
                                </tr>
                              <?php endif; ?>
                              <?php if($total > 0){ ?>
                                  <tr>
                                      <td colspan="2"><center>Total: <?php echo " " . $total . " Interessados"; ?> </center></td>
                                  </tr>
                                      </table>
                                      <br/>
                                      <div style="min-width: 700px;">
                                          <center>
                                              <a onclick="createPDF();" target="_blank" id="imprimir" class="btn btn-small button-new btn-info">
                                                  Imprimir
                                              </a>
                                          </center>
                                      </div>
                                      <?php
                                  }
                              }
                              else if(isset($this->tipo) && $this->tipo == '2'){

                              ?>
                              <?php if(!empty($this->item)) :  ?>
                              <input type="hidden" id="tituloRel" value="<?php echo $this->item[0]->titulo; ?>">
                              <table class="tg" id="tab_customers">
                                  <tr>
                                      <td colspan="3" class="title"><strong>DONWLOAD EDITAL - <?php echo $this->item[0]->titulo; ?></strong></td>
                                  </tr>
                                  <tr>
                                      <th class="tg-yw4l">CPF/CNPJ</th>
                                      <th class="tg-yw4l">Nome/Razão Social</th>
                                      <th class="tg-yw4l">Data</th>
                                  </tr>


                              <?php foreach ($this->item as $item => $value) : ?>
                              <?php if(trim($value->documento_usuario) != "" && trim($value->nome_razao) != "" && trim($value->data_download) != ""): ?>
                                <?php $total++; ?>
                                    <tr>
                                        <td><center><?php echo $value->documento_usuario ?></center></td>
                                        <td><center><?php echo $value->nome_razao ?></center></td>
                                        <td><center><?php echo $value->data_download ?></center></td>
                                    </tr>
                                <?php endif; ?>
                              <?php endforeach; ?>
                              <?php else: ?>
                                <tr>
                                    <td colspan="2"><label style="color: #394d71!important;font-weight: bold!important;">Nenhum Resultado Encontrado.</label></td>
                                </tr>
                              <?php endif; ?>
                              </table>
                              <br/>
                              <?php if($total > 0) { ?>
                                      <div style="min-width: 700px;">
                                          <center>
                                              <a onclick="createPDF();" target="_blank" id="imprimir" class="btn btn-small button-new btn-info">
                                                  Imprimir
                                              </a>
                                          </center>
                                      </div>
                                      <?php
                                  }
                              }else if(isset($this->tipo) && $this->tipo == '3'){
                                  ?>
                              <?php if(!empty($this->item)) :  ?>
                              <input type="hidden" id="tituloRel" value="LISTA DOS INTERESSADOS">
                              <table class="tg" id="tab_customers">
                                <tr>
                                    <td colspan="5" class="title"><strong>LISTA DOS INTERESSADOS <?php echo $tituloInteressados;  ?></strong></td>
                                </tr>
                                <tr>
                                  <th class="tg-yw4l">Nome/Razão Social</th>
                                  <th class="tg-yw4l">Tipo</th>
                                  <th class="tg-yw4l">CPF/CNPJ</th>
                                  <th class="tg-yw4l">Telefone</th>
                                  <th class="tg-yw4l">Data de Cadastro</th>
                                </tr>
                              <?php $total = 0; ?>

                              <?php foreach ($this->item as $item => $value) : ?>
                                <?php if(trim($value->documento_usuario) != "" && trim($value->nome_razao) != "" && trim($value->tipo_users) != "" && trim($value->telefone_users) != ""): ?>
                                    <?php $total++; ?>
                                    <tr>
                                        <td><center><?php echo $value->nome_razao ?></center></td>
                                        <td><center><?php echo ($value->tipo_users == "f") ? "Física" : "Jurídica" ?></center></td>
                                        <td><center><?php echo $value->documento_usuario ?></center></td>
                                        <td><center><?php echo $value->telefone_users ?></center></td>
                                        <td><center><?php echo  date("d/m/Y H:i:s", strtotime(str_replace("-","/", $value->registerDate)))  ?></center></td>
                                    </tr>
                                <?php endif; ?>
                              <?php endforeach; ?>
                              <?php else: ?>
                                <tr>
                                    <td colspan="5"><label style="color: #394d71!important;font-weight: bold!important;">Nenhum Resultado Encontrado.</label></td>
                                </tr>
                              <?php endif; ?>
                              <?php if($total > 0){ ?>
                                  <tr>
                                      <td colspan="5"><center>Total: <?php echo " " . $total . " Interessados"; ?> </center></td>
                                  </tr>
                                      </table>
                                      <br/>
                                      <div style="min-width: 700px;">
                                          <center>
                                              <a onclick="createPDF();" target="_blank" id="imprimir" class="btn btn-small button-new btn-info">
                                                  Imprimir
                                              </a>
                                          </center>
                                      </div>
                                      <?php
                                  }

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
        var arquivo = $('#tituloRel').val();
        arquivo = arquivo + "  --  " + dia + "-" + mes + "-" + ano;
        $('#renderPDF').createPdf({
            'fileName' : arquivo + '.pdf'
        });
    }
</script>