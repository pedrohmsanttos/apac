<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

require_once ('helper.php');


JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query
    ->select('a.title,a.created,a.id,a.catid,a.images,a.created,c.title as category_title, a.introtext as text')
    ->from($db->quoteName('#__content', 'a'))
    ->join('INNER', $db->quoteName('#__categories', 'c') . ' ON (' . $db->quoteName('c.id') . ' = ' . $db->quoteName('a.catid') . ')')
    ->where($db->quoteName('a.publish_up').'<= now() and '.$db->quoteName('a.state').' =1 AND '.$db->quoteName('c.path') . ' LIKE \'%blog%\'',"OR")
    ->where($db->quoteName('a.publish_up').'<= now() and '.$db->quoteName('a.state').' =1 AND '.$db->quoteName('c.path') . ' LIKE \'%noticia%\'')
    ->order($db->quoteName('a.created') . ' DESC');
$db->setQuery($query);
$allArticles = $db->loadObjectList();

?>
<div class="page-content">
  <div class="row">
      <div class="mobile-four twelve columns">
          <div class="blog-list">
							<?php
								$paginaAtual   = JFactory::getApplication()->input->get('page',1, 'int');
								$paginaAnterior = $paginaAtual - 1;
								$paginaProxima = $paginaAtual + 1;
								if($paginaAnterior <= 0) $paginaAnterior = 1;

								$vetorPaginado = paginacao($allArticles,$paginaAtual,5)->vetor;
								$totalPagina   = paginacao($allArticles,$paginaAtual,5)->total_paginas;
							 ?>
							<?php foreach($vetorPaginado as $allarticle_item): ?>
                  <div class="post row">
                      <div class="post-img mobile-four two columns">
        									<?php if(! empty( json_decode($allarticle_item->images)->image_intro ) ) : ?>
                              <img src="<?php echo json_decode($allarticle_item->images)->image_intro ?>" alt="" />
        									<?php else: ?>
        											<img style="visibility: hidden;" src="images/logo.png" alt="" />
        									<?php endif; ?>
		                   </div>
                      <div class="post-header mobile-four eight columns">
		                      <small class="categories">
                            <a href="index.php?option=com_content&view=category&id=<?php echo $allarticle_item->catid; ?>" title="">
												       <?php echo $allarticle_item->category_title; ?>
											      </a>
                          </small>
                          <h2>
											       <a href="index.php?option=com_content&view=article&id=<?php echo $allarticle_item->id; ?>&catid=<?php echo $allarticle_item->catid; ?>" title="">
												        <?php echo $allarticle_item->title ?>
											       </a>
										     </h2>
                         <p>
											     <a href="index.php?option=com_content&view=article&id=<?php echo $allarticle_item->id; ?>&catid=<?php echo $allarticle_item->catid; ?>" title=""> <?php echo limitaString(strip_tags($allarticle_item->text),247); ?></a>
										     </p>

                         <?php $tags = getTagsByArticleId($allarticle_item->id); ?>
                          <?php if(!empty($tags)): ?>
                             <small class="tags">TAGS:
                               <?php foreach ($tags as $tag): ?>
                                 <a href="index.php?option=com_buscasite&tagid=<?php echo $tag->id ?>" title=""><?php echo $tag->title ?></a>
                               <?php endforeach; ?>
                             </small>
                          <?php endif; ?>

		                   </div>
                       <div class="post-footer mobile-four two columns">
                         <ul class="datetime">
                           <li>
                             <i class="icon icon-calendar"></i>
													   <?php echo str2dataArr($allarticle_item->created)[0]; ?>
                           </li>
                           <li>
                             <i class="icon icon-time"></i>
													   <?php echo str2dataArr($allarticle_item->created)[1]; ?>
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
              <?php if($paginaAtual > 1): ?>
                <a href="<?php echo JRoute::_('index.php?option=com_content&view=featured&page='.$paginaAnterior.''); ?>" title="" class="btn btn-prev"><span>Anterior</span></a>
              <?php endif; ?>

              <?php for ($i=1; $i <= $totalPagina; $i++): ?>
              	<?php if($i != $paginaAtual): ?>
                  <a href="<?php echo JRoute::_('index.php?option=com_content&view=featured&page='.$i.''); ?>" class="item-pagination" title="<?php echo $i ?>"><?php echo $i ?></a>
              	<?php else: ?>
              		<span class="current"><?php echo $i ?></span>
              	<?php endif; ?>
              <?php endfor; ?>
    					<?php if($paginaAtual != $totalPagina): ?>
                <a href="<?php echo JRoute::_('index.php?option=com_content&view=featured&page='.$paginaProxima.''); ?>" title="" class="btn btn-next"><span>Próximo</span></a>
    					<?php endif; ?>
            </div>
          </div>
        </div>
    		<!-- paginacao -->
  </div>
