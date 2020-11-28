<style type="text/css">
    .post-header{display: inline !important;}
    .post-footer{display: inline !important;}
</style>
    <div id="content" class="internal page-governo blog">
        <div class="page-content">

            <div class="row">

                <div class="mobile-four twelve columns">

                    <div class="blog-list">
                        <?php foreach ($artigos as $artigo) : ?>
                            <div class="post row">
                                <div class="post-img mobile-four two columns">
                                    <figure>
                                        <img src="<?php echo json_decode($artigo->images)->image_intro ?>" alt="" />
                                    </figure>
                                </div>
                                <div class="post-header mobile-four eight columns">
                                    <small class="categories">
                                        <a href="index.php?option=com_content&view=category&id=<?php echo $artigo->catid; ?>" title=""><?php echo $artigo->cat_title ?></a>
                                    </small>
                                    <h2><a href="index.php?option=com_content&view=article&id=<?php echo $artigo->id; ?>&catid=<?php echo $artigo->catid; ?>" title=""><?php echo $artigo->title ?></a></h2>
                                    <p><a href="index.php?option=com_content&view=article&id=<?php echo $artigo->id; ?>&catid=<?php echo $artigo->catid; ?>" title=""><?php echo limitaString2(strip_tags($artigo->introtext),247); ?></a></p>
                                    <!-- <small class="tags">TAGS: <a href="./blog-interna.php" title="">Fernando de noronha</a><a href="./blog-interna.php" title="">governo de pernambuco</a></small> -->
                                </div>
                                <div class="post-footer mobile-four two columns">
                                    <ul class="datetime">
                                        <li>
                                            <i class="icon icon-calendar"></i> <?php echo str2dataArr2($artigo->created)[0]; ?>
                                        </li>
                                        <li>
                                            <i class="icon icon-time"></i> <?php echo str2dataArr2($artigo->created)[1]; ?>
                                        </li>
                                    </ul>
                                    <div class="addthis_inline_share_toolbox"></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                </div>

            </div>

            <!-- paginacao -->
            <div class="row">

                <div class="mobile-four twelve columns">

                    <div class="pagination">
                      <a class="btn" href="<?php echo JRoute::_('index.php?option=com_content&view=featured&page=1'); ?>"><i class="fa fa-backward" aria-hidden="true"></i></a>
                        <?php if($paginaAtual > 1): ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_content&view=featured&page='.$paginaAnterior.''); ?>" title="" class="btn btn-prev"><span>Anterior</span></a>
                        <?php endif; ?>

                            <?php for ($i=1; $i <= $totalPagina; $i++): ?>
                                <?php if(($i != $paginaAtual) && ($i>$paginaAtual-8) && ($i<$paginaAtual+8)): ?>
                                    <a href="<?php echo JRoute::_('index.php?option=com_content&view=featured&page='.$i.''); ?>" class="item-pagination" title="<?php echo $i ?>"><?php echo $i ?></a>
                                <?php else: ?>
                  <?php if($i==$paginaAtual): ?>
                                    <span class="current"><?php echo $i ?></span>
                <?php endif; ?>
                                <?php endif; ?>
                            <?php endfor; ?>

                        <?php if($paginaAtual != $totalPagina): ?>
                            <a href="<?php echo JRoute::_('index.php?option=com_content&view=featured&page='.$paginaProxima.''); ?>" title="" class="btn btn-next"><span>Próximo</span></a>
                        <?php endif; ?>
                            <a class="btn" href="<?php echo JRoute::_('index.php?option=com_content&view=featured&page='.$totalPagina); ?>"><i class="fa fa-forward" aria-hidden="true"></i></a>
                    </div>

                </div>

            </div>

        <!-- paginacao -->

        </div>

    </div>