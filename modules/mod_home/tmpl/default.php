<style type="text/css">
.page-header{
    display: none;
}
</style>
<div id="content">
    <div class="row">
        <div class="mobile-four twelve columns nopadding">
            <div class="home">
                <!-- Módulo de destaque -->
                <?php if(! empty($module_bannerdestaqueSlideshow)) : ?>
                    <?php echo $renderer->render($module_bannerdestaqueSlideshow); ?>
                <?php elseif(! empty($module_bannerdestaque)): ?>
                    <?php echo $renderer->render($module_bannerdestaque); ?>
                <?php endif;?>
                <!-- -->

                <!-- Módulo de serviços -->
                <?php if(! empty($renderer->render($module_servicos))): ?>
                    <?php echo $renderer->render($module_servicos); ?>
                <?php endif;?>
                <!-- -->

                <!-- Módulo de aceontece -->
                <?php if(!empty($renderer->render($module_acontece))): ?>
                    <?php echo $renderer->render($module_acontece); ?>
                <?php endif;?>
                <!-- -->

            </div>
        </div>
    </div>
</div>
