<?php defined('_JEXEC') or die; ?>
<style type="text/css">
    #container footer .wrap-social-boxes .fb
    {
        <?php if(! empty($redesSociais->imagem_fundo)): ?>
            background: url('<?php echo JURI::base().$redesSociais->imagem_fundo ?>') 0 -230px no-repeat !important;
        <?php endif;?>
    }
</style>
<h3 class="title-section"><?php echo $redesSociais->titulo?></h3>
<div class="wrap-social-boxes">
    <a class="no-decor" target="_blank" href="<?php echo $redesSociais->facebook?>">
        <div class="fb">
            <p>
                <i class="icon icon-fb"></i>
                /<?php echo end(explode('/', $redesSociais->facebook)); ?>
            </p>
            <div class="wrap-fb-like">
                <div class="fb-like" data-href="<?php echo $redesSociais->facebook?>" data-adapt-container-width="true" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true"></div>
            </div>
        </div>
    </a>
    <a class="no-decor" target="_blank" href="<?php echo $redesSociais->instagram?>">
        <div class="mobile-four six columns nopaddingL">
            <div class="ig">
                <p>
                    <i class="icon icon-ig"></i>
                    /<?php echo end(explode('/', $redesSociais->instagram)); ?>
                </p>
            </div>
        </div>
    </a>
    <a class="no-decor" target="_blank" href="<?php echo $redesSociais->youtube?>" >
        <div class="mobile-four six columns nopaddingR">
            <div class="yt">
                <p>
                    <i class="icon icon-yt"></i>
                    /<?php echo end(explode('/', $redesSociais->youtube)); ?>
                </p>
            </div>
        </div>
    </a>
</div>