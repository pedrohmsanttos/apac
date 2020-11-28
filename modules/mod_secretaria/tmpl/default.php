<?php defined('_JEXEC') or die; ?>

<div class="page-content">
    <div class="row">
        <div class="mobile-four twelve columns">
            <header>
                <span class="icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </span>
                <?php echo $params->get('descricao'); ?>
            </header>
            <div class="row">
                <?php foreach ($secretarias as $secretaria): ?>
                    <div class="mobile-four six columns">
                        <div class="item-secretaria">
                            <header>
                                <h2><?php echo $secretaria->titulo; ?></h2>
                                <small><?php echo $secretaria->subtitulo; ?></small>
                            </header>
                            <div class="item-secretaria-content">
                                <?php echo strip_tags($secretaria->conteudo,'<p><br><br/><strong>'); ?>
                            </div>
                            <footer>
                                <a target="_blank" href="index.php?option=com_secretario&id=<?php echo $secretaria->link_maisinfo; ?>&secretaria=<?php echo $secretaria->id; ?>" title="Mais Informações">Mais Informações</a>
                                <a target="_blank" href="<?php echo $secretaria->link_acessowebsite; ?>" title="Acessar o website">Acessar o website</a>
                                <a target="_blank" href="mailto:<?php echo $secretaria->link_email; ?>" title="Enviar e-mail">Enviar e-mail</a>
                            </footer>
                        </div>
                    </div>
                <?php endforeach  ?>
            </div>
        </div>
    </div>
</div>