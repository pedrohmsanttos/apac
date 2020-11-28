<?php defined('_JEXEC') or die; ?>
 <div class="page-content">
    <div class="row">
        <div class="mobile-four twelve columns">
            <header>
                <span class="icon">
                    <i class="fa fa-exclamation-triangle"></i>
                </span>
                <?php echo $params->get('descricao_pagina'); ?>
            </header>
        </div>
    </div>
    <?php if($params->get('exibir_1') == '1'): ?>
        <div class="row">
            <div class="mobile-four twelve columns">
                <h3 class="title"><?php echo $params->get('titulo_1'); ?></h3>
                <div class="albuns">
                    <div class="row">
                        <?php $contador = 0; ?>
                        <?php foreach ($arquivos_categoria_1 as $arq1) : ?>
                            <div class="mobile-four six columns item-album-container">
                                <?php echo $galHelper::htmlPeloFormato($arq1->arquivo,'images/media/'.$arq1->arquivo,$arq1->titulo,$contador,$arq1->link,$arq1->formato);?>
                                <?php $contador++; ?>
                            </div>
                        <?php endforeach; ?>
                        
                    </div>
                    <div class="row">
                        <div class="mobile-four twelve columns">
                            <a class="btn btn-more botao-veja-mais">
                                <i class="icon icon-album"></i>
                                Veja Todos os Álbuns
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if($params->get('exibir_2') == '1'): ?>
        <div class="row">
            <div class="mobile-four twelve columns">
                <h3 class="title"><?php echo $params->get('titulo_2'); ?></h3>
                <div class="albuns">
                    <div class="row">
                        <?php $contador = 0; ?>
                        <?php foreach ($arquivos_categoria_2 as $arq2) : ?>
                            <div class="mobile-four six columns item-album-container">
                                    <?php echo $galHelper::htmlPeloFormato($arq2->arquivo,'images/media/'.$arq2->arquivo,$arq2->titulo,$contador,$arq2->link,$arq2->formato);?>
                                    <?php $contador++; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="row">
                        <div class="mobile-four twelve columns">
                            <a class="btn btn-more botao-veja-mais-2">
                                <i class="icon icon-video"></i>
                                Ver Todos os Videos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>

    <?php if($params->get('exibir_3') == '1'): ?>
        <div class="row">
            <div class="mobile-four twelve columns">
                <h3 class="title"><?php echo $params->get('titulo_3'); ?></h3>
                <div class="albuns">
                    <div class="row">
                        
                        <?php $contador = 0; ?>
                        <?php foreach ( $arquivos_categoria_3 as $arq3) : ?>
                            <div class="mobile-four six columns item-album-container">
                                        <?php echo $galHelper::htmlPeloFormato($arq3->arquivo,'images/media/'.$arq3->arquivo,$arq3->titulo,$contador,$arq3->link,$arq3->formato);?>
                                        <?php $contador++; ?>
                            </div>
                        <?php endforeach; ?>
                        
                    </div>
                    <div class="row">
                        <div class="mobile-four twelve columns">
                            <a class="btn btn-more botao-veja-mais-3">
                                <i class="icon icon-audio"></i>
                                Ver Todos os Áudios
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif;?>
</div>