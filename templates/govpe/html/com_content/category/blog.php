<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2017 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
defined('_JEXEC') or die;

$jinput = JFactory::getApplication()->input;
$id_categoria = $jinput->get('id', '0', 'INT');
require_once ('helper.php');

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers');
JHtml::_('behavior.caption');

/*
$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('a.title,a.id,a.catid,a.images,a.created,c.title as category_title, a.introtext as text');
$query->from($db->quoteName('#__content', 'a'));
$query->join('INNER', $db->quoteName('#__categories', 'c') . ' ON (' . $db->quoteName('c.id') . ' = ' . $db->quoteName('a.catid') . ')');
$query->where($db->quoteName('a.publish_up').' <= now() and '.$db->quoteName('a.publish_down').' >= now() and '.$db->quoteName('c.id').'='.$id_categoria.' AND '.$db->quoteName('a.state').' = 1');
$query->order($db->quoteName('a.created') . ' DESC');
$db->setQuery($query);
$allArticles = $db->loadObjectList();
*/

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('a.title,a.id,a.catid,a.images,a.created,c.title as category_title, a.introtext as text');
$query->from($db->quoteName('#__content', 'a'));
$query->join('INNER', $db->quoteName('#__categories', 'c') . ' ON (' . $db->quoteName('c.id') . ' = ' . $db->quoteName('a.catid') . ')');
$query->where($db->quoteName('a.state').' = 1 and '.$db->quoteName('c.id').'='.(int)$id_categoria.' or '.$db->quoteName('c.parent_id').' = '.(int)$id_categoria);
$query->order($db->quoteName('a.created') . ' DESC');
$db->setQuery($query);
$allArticles = $db->loadObjectList();

?>
<style>
div.post-header.mobile-four.eight.columns > h2 > a, div.post-header.mobile-four.eight.columns > p > a{
   text-decoration:none;
 }
  div.post-header.mobile-four.eight.columns > h2 > a{
   color: #745E01;
 }
   div.post-header.mobile-four.eight.columns > p > a,.page-governo.blog.blog-interna .post small a{
   color: #393939;
 }
 div.post > div > small > a{
   color:#c09c02;
 }
 .blog-list .post {
	padding-top: 20px;
	padding-bottom: 20px;
	border-bottom: 1px solid #cfcfcf !important;
}
</style>
<div class="page-content">
  <div class="row">
    <div class="mobile-four twelve columns">
        <div class="noticia-list">
		        <?php if(! empty($allArticles)): ?>

							<?php
								$paginaAtual   = JFactory::getApplication()->input->get('page',1, 'int');
								$paginaAnterior = $paginaAtual - 1;
								$paginaProxima = $paginaAtual + 1;
								if($paginaAnterior <= 0) $paginaAnterior = 1;

								$vetorPaginado = paginacao($allArticles,$paginaAtual,3)->vetor;
								$totalPagina   = paginacao($allArticles,$paginaAtual,3)->total_paginas;
							 ?>
							<?php foreach($vetorPaginado as $intro_item): ?>
                  <div class="post row">
                      <div class="post-img mobile-four two columns">
                          <img src="<?php echo json_decode($intro_item->images)->image_intro ?>" alt="" />
                      </div>
		                  <div class="post-header mobile-four eight columns">
                        <small class="categories">
                            <a href="index.php?option=com_content&view=category&id=<?php echo $intro_item->catid; ?>" title="">
  					                   <?php echo $intro_item->category_title; ?>
  				                  </a>
                        </small>
  		                  <h2>
    											<a href="index.php?option=com_content&view=article&id=<?php echo $intro_item->id; ?>&catid=<?php echo $intro_item->catid; ?>" title="">
    												<?php echo $intro_item->title ?>
    											</a>
  										  </h2>
  		                  <p>
  											   <a href="index.php?option=com_content&view=article&id=<?php echo $intro_item->id; ?>&catid=<?php echo $intro_item->catid; ?>" title=""> <?php echo limitaString(strip_tags($intro_item->text),247); ?></a>
  										  </p>

                        <?php $tags = getTagsByArticleId($intro_item->id); ?>
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
      					                  <?php echo str2dataArr($intro_item->created)[0]; ?>
                              </li>
                              <li>
                                  <i class="icon icon-time"></i>
      					                  <?php echo str2dataArr($intro_item->created)[1]; ?>
                              </li>
                          </ul>
                          <div class="addthis_inline_share_toolbox"></div>
		                   </div>
		              </div>
							<?php endforeach; ?>
						<?php endif; ?>
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
                    <a href="<?php echo JRoute::_('index.php?option=com_content&view=featured&page='.$paginaProxima.''); ?>" title="" class="btn btn-next"><span>PrÃ³ximo</span></a>
              	<?php endif; ?>
            </div>
        </div>
    </div>
    <!-- fim paginacao -->
</div>
