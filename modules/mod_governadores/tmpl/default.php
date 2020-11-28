<?php defined('_JEXEC') or die; ?>

 <div id="content" class="internal page-governo governo-galeria_governadores">

        <div class="page-content">


            <div class="row">
                <?php foreach ($vetorPaginado as $governador) : ?>
                    <div class="governador-item mobile-four two columns">
                        <div class="governador-item-content">
                                <img src="<?php echo $governador->imagem; ?>" alt="" />
                            <div class="governador-content">
                                <h3><?php echo $governador->nome; ?></h3>
                                <h4>Ano: <?php echo $governador->ano; ?></h4>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>

            <!-- paginacao -->
            <div class="row">

                <div class="mobile-four twelve columns">

                    <div class="pagination">
                        <?php if($paginaAtual > 1): ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_content&view=article&id='.$idArtigo.'&catid='.$idCatArtigo.'&page='.$paginaAnterior.''); ?>" title="" class="btn btn-prev"><span>Anterior</span></a>
                        <?php endif; ?>

                            <?php for ($i=1; $i <= $totalPagina; $i++): ?>
                                <?php if($i != $paginaAtual): ?>
                                    <a href="<?php echo JRoute::_('index.php?option=com_content&view=article&id='.$idArtigo.'&catid='.$idCatArtigo.'&page='.$i.''); ?>" class="item-pagination" title="<?php echo $i ?>"><?php echo $i ?></a>
                                <?php else: ?>
                                    <span class="current"><?php echo $i ?></span>
                                <?php endif; ?>
                            <?php endfor; ?>

                        <?php if($paginaAtual != $totalPagina): ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_content&view=article&id='.$idArtigo.'&catid='.$idCatArtigo.'&page='.$paginaProxima.''); ?>" title="" class="btn btn-next"><span>Próximo</span></a>
                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>

    </div>
