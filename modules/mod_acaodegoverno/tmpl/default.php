<?php defined('_JEXEC') or die; ?>

<div class="page-content">
    <div class="row">
        <div class="mobile-four twoelve columns">
            <header>
                <span class="icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </span>
                <?php echo $params->get('descricao'); ?>
            </header>

            <div class="row">
                <?php foreach ($acaogovernos as $acaogoverno => $row): ?>
                    <div class="six columns">
                        <div class="acao-governo">
                            <header>
                                <span>
                                    <img style="max-width:100px;float:left;padding-top:5%" src="<?php echo $row->imagem; ?>">
                                </span>
                                <h2><?php echo $row->titulo; ?></h2>
                            </header>
                            <div class="acao-governo-content">
                                <p>
                                    <?php echo strip_tags($row->conteudo, '<p><br><br/><strong>'); ?>
                                </p>
                            </div>
                           <!--  <footer>
                                <a target="_blank" href="<?php echo $row->link; ?>" title="">Detalhamento das ações</a>
                            </footer> -->
                        </div>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </div>
</div>

