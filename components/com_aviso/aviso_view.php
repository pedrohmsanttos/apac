<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 

?>
<?php if(!$avisoExpirado): ?>
  <div id="content" class="descubra-pe internal page-governo contato governo-mapa_do_trabalho governo mapa_do_site secretarias servicos orgaos governo-prefeituras governo-governador">
   <div class="page-content">
      <div class="row">
          <div class="mobile-four twelve columns">
            <header>
              <span class="icon">
                  <i class="fa fa-exclamation-triangle"></i>
              </span>
              Aviso expirado em <?php echo preparaData2($aviso->validade)[0] . ' às '.preparaData2($aviso->validade)[1] ?>.
            </header>
          </div>
      </div>
    </div>
  </div>
<?php endif; ?>

<div class="row">

    <div class="mobile-four eight columns">
        <div class="page-content">
            <h4><?php if($aviso->regioes != ''): ?>
                Regiões: <?php echo $aviso->regioes; ?><br>
                <?php endif; ?>
                Tipo: <?php echo $aviso->category_title; ?><br>
                Publicado: <?php echo date("d/m/Y H:i", strtotime($aviso->created)); ?></h4>
            <?php echo $aviso->conteudo ?>
        </div>
    </div>

    <div class="three push-one columns">
        <div class="right-sidebar" style="margin-top: 10px;">

            <div class="sidebar-box">
                <h3 class="title">Dados</h3>
                <div class="content">
                    <p>
                        <strong>Validade:</strong> <?php echo preparaData2($aviso->validade)[0] . ' - '.preparaData2($aviso->validade)[1] ?><br />
                    </p>
                </div>
            </div>

            <?php if(! empty($anexos)): ?>
                <div class="sidebar-box">
                    <h3 class="title">Arquivos</h3>
                    <div class="content">
                        <ul>
                          <?php foreach ($anexos as $anexo) :?>
                            <li>
                                <h3 style="padding: 5px; margin-top: 10px;">
                                    <a href="images/media/<?php echo $anexo->arquivo;?>" title="<?php echo $anexo->titulo ?>">
                                      <?php echo $anexo->titulo ?>
                                    </a>
                                  </h3>
                            </li>
                          <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
          <?php endif; ?>
        </div>
    </div>

</div><br><br><br><br><br><br>
