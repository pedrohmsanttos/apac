<?php defined('_JEXEC') or die; ?>
<style type="text/css">
.moduletable > h3:nth-child(1) {display: none;}
</style>
 <div class="page-content">
    <div class="row">
        <div class="mobile-four twelve columns">
            <h3 class="title"><?php echo $params->get('titulo_1'); ?></h3>
            <div class="albuns">
                <div class="row">
                    <?php $contador = 0; ?>
                    <?php foreach ($arquivos as $arquivo) : ?>
                        <div class="mobile-four four columns">
                            <?php echo $blocoHelper::htmlPeloFormato($arquivo->arquivo,'images/media/'.$arquivo->arquivo,$arquivo->titulo,$arquivo->link,$arquivo->formato);?>
                            <?php $contador++; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
