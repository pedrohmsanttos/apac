<?php
/**
 * @version     1.0.0
 * @package     com_envio_de_artigos_1.0.0
 * @copyright   Copyright (C) 2018. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Matheus Felipe <matheus.felipe@inhalt.com.br> - https://www.developer-url.com
 */

// No direct access
defined('_JEXEC') or die;
?>
<?php $listOrder = $this->listOrder; ?>
<?php $listDirn = $this->listDirn; ?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		jQuery(".icon-enviarEmail").removeClass('icon-enviarEmail');
		jQuery(".icon-gerarPDF").removeClass('icon-gerarPDF');
	});

	Joomla.submitbutton = function (task) {
		if (task == 'artigos.enviarEmail') 
		{
			var aux = 0;
			jQuery("input[name='cid[]']").each( function () {
				if(jQuery(this).prop("checked") == true){
					aux++;
				}       
			});

			if(aux > 1){
				alert("Selecione apenas um item!")
			}else{
				Joomla.submitform(task, document.getElementById('adminForm'));
			}

		}else{
			Joomla.submitform(task, document.getElementById('adminForm'));
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_envio_de_artigos&view=artigos'); ?>" method="post" name="adminForm" id="adminForm" data-list-order="<?php echo $listOrder; ?>">
	<?php if(!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif;?>
			<div id="filter-bar" class="btn-toolbar">
				<div class="filter-search btn-group pull-left">
					<label for="filter_search" class="element-invisible"><?php echo JText::_('JSEARCH_FILTER');?></label>
					<input type="text" name="filter_search" id="filter_search" placeholder="<?php echo JText::_('JSEARCH_FILTER'); ?>..." value="<?php echo $this->escape($this->state->get('filter.search')); ?>" title="<?php echo JText::_('JSEARCH_FILTER'); ?>" />
				</div>
				<button class="btn hasTooltip" type="submit" title="<?php echo JText::_('JSEARCH_FILTER_SUBMIT'); ?>"><?php echo JText::_('JSEARCH_FILTER'); ?></button>
				<button class="btn hasTooltip" type="button" title="<?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?>"><?php echo JText::_('JSEARCH_FILTER_CLEAR'); ?></button>

				<div class="btn-group pull-right hidden-phone">
					<label for="limit" class="element-invisible"><?php echo JText::_('JFIELD_PLG_SEARCH_SEARCHLIMIT_DESC');?></label>
					<?php echo $this->pagination->getLimitBox(); ?>
				</div>
				
			</div>
			<div class="clearfix"> </div>
			<table class="table table-striped" id="artigoList">
				<thead>
					<tr>
						<th width="1%" class="nowrap center">
							<?php echo JHtml::_('grid.checkall'); ?>
						</th>
						<th class="left">
							<?php echo JHtml::_('grid.sort',  'id', 'c.id', $listDirn, $listOrder); ?>
						</th>
						<th class="left">
							<?php echo JHtml::_('grid.sort',  'Titulo', 'c.title', $listDirn, $listOrder); ?>
						</th>
						<th class="left">
							<?php echo JHtml::_('grid.sort',  'Enviado', 'enviado', $listDirn, $listOrder); ?>
						</th>
					</tr>
				</thead>
				<tbody>
				<?php
				foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate	= $this->user->authorise('core.create',		'com_envio_de_artigos');
					$canEdit	= $this->user->authorise('core.edit',		'com_envio_de_artigos');
					$canCheckin	= $this->user->authorise('core.manage',		'com_envio_de_artigos');
					$canChange	= $this->user->authorise('core.edit.state',	'com_envio_de_artigos');
					
					?>
					<tr class="row<?php echo $i % 2; ?>">
						<td class="center">
							<?php echo JHtml::_('grid.id', $i, $item->id); ?>
						</td>
						<td class="center">
							<?php echo $item->id; ?>
						</td>
						<td>
							<?php echo $item->title; ?>
						</td>
						<td style="text-align: center">
							<?php echo (!empty($item->enviado) && trim($item->enviado == "1")) ? "<p class='icon-publish'></p>" : "<p class='icon-unpublish'></p>"; ?>
						</td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<div class="pagination center">
				<?php echo $this->pagination->getListFooter(); ?>
			</div>
			<input type="hidden" name="task" value="" />
			<input type="hidden" name="boxchecked" value="0" />
			<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>" />
			<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>" />
			<?php echo JHtml::_('form.token'); ?>
		</div>
	</div>
</form>
