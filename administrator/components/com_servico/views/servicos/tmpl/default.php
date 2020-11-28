<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$categoria = new ServicosHelper();

//JHtml::_('formbehavior.chosen', 'select');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', '.multipleTags', null, array('placeholder_text_multiple' => JText::_('JOPTION_SELECT_TAG')));
JHtml::_('formbehavior.chosen', '.multipleCategories', null, array('placeholder_text_multiple' => JText::_('JOPTION_SELECT_CATEGORY')));
JHtml::_('formbehavior.chosen', '.multipleAccessLevels', null, array('placeholder_text_multiple' => JText::_('JOPTION_SELECT_ACCESS')));
JHtml::_('formbehavior.chosen', '.multipleAuthors', null, array('placeholder_text_multiple' => JText::_('JOPTION_SELECT_AUTHOR')));
JHtml::_('formbehavior.chosen', 'select');
 
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'ordering';

// save ording
if (strpos($listOrder, 'publish_up') !== false)
{
	$orderingColumn = 'publish_up';
}
elseif (strpos($listOrder, 'publish_down') !== false)
{
	$orderingColumn = 'publish_down';
}
elseif (strpos($listOrder, 'modified') !== false)
{
	$orderingColumn = 'modified';
}
else
{
	$orderingColumn = 'created';
}

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_servico&task=servicos.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'servicoList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

?>

<form action="index.php?option=com_servico&view=servicos" method="post" id="adminForm" name="adminForm">
<div class="row-fluid">
	<div id="j-sidebar-container">
		<?php echo $this->sidebar ?>
	</div>
<div id="j-main-container" class="span10 j-toggle-main">
	<div class="row-fluid">
		<div class="span12">
			<?php echo JText::_('Filtros'); ?>
			<?php
				echo JLayoutHelper::render(
					'joomla.searchtools.default',
					array('view' => $this)
				);
			?>
		</div>
	</div>
	<table class="table table-striped table-hover" id="servicoList">
		<thead>
		<tr>
			<!--th width="1%">#</th-->
			<th width="1%" class="nowrap center hidden-phone">
				<?php echo JHtml::_('searchtools.sort', '', 'ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
			</th>
			<th width="2%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			<th width="2%">
				<?php echo JHtml::_('grid.sort', 'ID', 'id', $listDirn, $listOrder); ?>
			</th>
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'Publicado', 'published', $listDirn, $listOrder); ?>
			</th>
			<th width="30%">
				<?php echo JHtml::_('grid.sort', 'Título', 'titulo', $listDirn, $listOrder); ?>
			</th>
			<th width="15%">
				<?php echo JHtml::_('grid.sort', 'Subtítulo', 'subtitulo', $listDirn, $listOrder); ?>
			</th>
			<th width="25%">
				<?php echo JHtml::_('grid.sort', 'Categoria', 'catid', $listDirn, $listOrder); ?>
			</th>
			<th width="45%">
				<?php echo JHtml::_('grid.sort', 'Mais Info', 'link_maisinfo', $listDirn, $listOrder); ?>
			</th>
			<th>
				Ordem
			<th>
		</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="5">
					<?php echo $this->pagination->getListFooter(); ?>
				</td>
			</tr>
		</tfoot>
		<tbody>
			<?php if (!empty($this->items)) : ?>
				<?php foreach ($this->items as $i => $row) :
					$ordering   = ($listOrder == 'ordering'); 
					$link = JRoute::_('index.php?option=com_servico&task=servico.edit&id=' . $row->id);
				?> 
					<tr>
						<!--td>
							<?php //echo $this->pagination->getRowOffset($i); ?>
						</td-->
						<td class="order nowrap center hidden-phone">
						<?php
							$iconClass = '';
							if (!$saveOrder) {
								$iconClass = ' inactive tip-top hasTooltip" title="' . JHtml::tooltipText('JORDERINGDISABLED');
							}
						?>
							<span class="sortable-handler <?php echo $iconClass ?>">
								<span class="icon-menu"></span>
							</span>
							<?php if ($saveOrder) : ?>
							<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order " />
							<?php endif; ?>
						</td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td align="center">
							<?php echo $row->id; ?>
						</td>
						<td align="center">
							<?php echo JHtml::_('jgrid.published', $row->published, $i, 'servicos.', true, 'cb'); ?>
						</td>
						<td>
							<a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
								<?php echo empty($row->titulo)? '-' : $row->titulo; ?>
							</a>
						</td>
						<td>
							<?php echo $row->subtitulo; ?>
						</td>
						<td>
							<?php echo $categoria::getNomeCategoria($row->catid)->title; ?>
						</td>
						<td>
							<?php echo empty($row->link_maisinfo)? '-' : substr($row->link_maisinfo, 0, 20) . ' ...'; ?>
						</td>
						<td>
							<?php echo $row->ordering; ?>
						</td>
					</tr>
				<?php endforeach; ?>
			<?php endif; ?>
		</tbody>
	</table>
	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
					
	<?php echo JHtml::_('form.token'); ?>	
</div>
</div>				
</form>