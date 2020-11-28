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
                <?php foreach ($orgaos as $orgao): ?>                    
                    <div class="mobile-four six columns"><!-- item -->
                        <div class="item-orgao">
                            <header>
                                <h2><?php echo $orgao->titulo; ?></h2>
                                <small><?php echo $orgao->subtitulo; ?></small>
                            </header>
                            <div class="item-orgao-content">
                                <?php echo strip_tags($orgao->conteudo, '<p><br><br/><strong>'); ?>
                            </div>
                            <footer>
                                <a target="_blank" href="index.php?option=com_diretor&id=<?php echo $orgao->link_maisinfo; ?>&orgao=<?php echo $orgao->id; ?>" title="Mais Informações">Mais Informações</a>
                                <a target="_blank" href="<?php echo $orgao->link_acessowebsite; ?>" title="Acessar o website">Acessar o website</a>
                                <a href="mailto:<?php echo $orgao->link_email; ?>" title="Enviar e-mail">Enviar e-mail</a>

                            </footer>
                        </div>
                    </div><!-- item -->
                <?php endforeach ?>
            </div><!-- fim row -->

        </div>

    </div>

</div>
<strong></strong>