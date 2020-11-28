<?php defined('_JEXEC') or die; ?>
<div id="content" class="internal page-governo blog">
    <div class="page-content">
        <div class="row">
            <div class="mobile-twelve twelve columns" style="text-align: right;">
                <a href="component/buscavancada/" style="text-decoration: none;color: #1E90FF;font-size: 16px;font-weight: bold;">Busca avisos</a>
            </div>
        </div>
        <div class="row">
            <div class="mobile-four twelve columns">
                <div class="blog-list">
                  <?php foreach ($avisos as $aviso): ?>
                    <!-- inicio item -->
                      <div class="post row">
                          <div class="post-header mobile-four ten columns">
                              <small class="categories">
                                  <a title=""><?php echo $category->title ?></a>
                              </small>
                              <h2><a href="index.php?option=com_aviso&id=<?php echo $aviso->id?>&catid=<?php echo $aviso->tipo?>" title=""><?php echo $aviso->identificador .' - '. $aviso->titulo; ?></a></h2>
                              
                          </div>
                          <div class="post-footer mobile-four two columns">
                            <small style="margin-bottom: 5px;">Validade</small><br/>
                              <ul class="datetime">
                                  <li>
                                      <i class="icon icon-calendar"></i> <?php echo $avisoHelper::str2dataArr($aviso->validade)[0]; ?>
                                  </li>
                                  <li>
                                      <i class="icon icon-time"></i> <?php echo $avisoHelper::str2dataArr($aviso->validade)[1]; ?>
                                  </li>
                              </ul>
                              <div class="addthis_inline_share_toolbox"></div>
                          </div>
                      </div>
                    <!-- fim item -->
                  <?php endforeach; ?>
                </div>
            </div>
        </div>
        <!-- paginacao -->
              <div class="row">
                  <div class="mobile-four twelve columns">
                      <div class="pagination">

  						            <?php if($paginaAtual > 1): ?>
                          	            <a href="<?php echo JRoute::_($_SERVER['REQUEST_URI'].'?page='.$catid_page.'&id='.$idPaginaAtual.'&view=article&page='.$paginaAnterior.''); ?>" title="" class="btn btn-prev"><span>Anterior</span></a>
  						            <?php endif; ?>

            							<?php for ($i=1; $i <= $totalPagina; $i++): ?>
              								<?php if($i != $paginaAtual): ?>
              	                         <a href="<?php echo JRoute::_($_SERVER['REQUEST_URI'].'?page='.$catid_page.'&id='.$idPaginaAtual.'&view=article&page='.$i.''); ?>" class="item-pagination" title="<?php echo $i ?>"><?php echo $i ?></a>
              								<?php else: ?>
            									<span class="current"><?php echo $i ?></span>
            								<?php endif; ?>
            							<?php endfor; ?>

  						            <?php if($paginaAtual != $totalPagina): ?>
                          	 <a href="<?php echo JRoute::_($_SERVER['REQUEST_URI'].'?page='.$catid_page.'&id='.$idPaginaAtual.'&view=article&page='.$paginaProxima.''); ?>" title="" class="btn btn-next"><span>Próximo</span></a>
  						            <?php endif; ?>
                      </div>
                  </div>
              </div>
    		<!-- paginacao -->
    </div>
</div>
