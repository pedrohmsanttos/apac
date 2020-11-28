<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

$categoria = new CategoriaHelper();

JHtml::_('formbehavior.chosen', 'select');
 
$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);

?>
<form action="index.php?option=com_agenda&view=agendas" method="post" id="adminForm" name="adminForm">
	<div class="row-fluid">
		<div id="j-sidebar-container">
			<?php echo $this->sidebar; ?>
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
			<table class="table table-striped table-hover">
				<thead>
				<tr>
					<th width="1%">#</th>
					<th width="2%">
						<?php echo JHtml::_('grid.checkall'); ?>
					</th>
					<th width="2%">
						<?php echo JHtml::_('grid.sort', 'Publicado', 'published', $listDirn, $listOrder); ?>
					</th>
					<th width="2%">
						<?php echo JHtml::_('grid.sort', 'ID', 'id', $listDirn, $listOrder); ?>
					</th>
					<th width="45%">
						<?php echo JHtml::_('grid.sort', 'Título', 'titulo', $listDirn, $listOrder); ?>
					</th>
					<th width="20%">
						<?php echo JHtml::_('grid.sort', 'Categoria', 'catid', $listDirn, $listOrder); ?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('grid.sort', 'Hora', 'data', $listDirn, $listOrder); ?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('grid.sort', 'Data', 'data', $listDirn, $listOrder); ?>
					</th>
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
							$link = JRoute::_('index.php?option=com_agenda&task=agenda.edit&id=' . $row->id);
						?> 
							<tr>
								<td>
									<?php echo $this->pagination->getRowOffset($i); ?>
								</td>
								<td>
									<?php echo JHtml::_('grid.id', $i, $row->id); ?>
								</td>
								<td align="center">
									<?php echo JHtml::_('jgrid.published', $row->published, $i, 'agendas.', true, 'cb'); ?>
								</td>
								<td align="center">
									<?php echo $row->id; ?>
								</td>
								<td>
									<a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
										<?php echo empty($row->titulo)? '-' : substr($row->titulo,0, 100); ?>
									</a>
								</td>
								<td>
									<?php echo $categoria::getNomeCategoria($row->catid)->title; ?>
								</td>
								<td>
									<?php echo str2dataArr($row->data)[1]; ?>
								</td>
								<td>
									<?php echo str2dataArr($row->data)[0]; ?>
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
		</div>					
		<?php echo JHtml::_('form.token'); ?>
	</div>					
</form>