<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');


JHtml::_('formbehavior.chosen', 'select');
 
$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);
?>
<form action="index.php?option=com_secretario&view=secretarios" method="post" id="adminForm" name="adminForm">
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
					<th width="1%">
						<?php echo JHtml::_('grid.checkall'); ?>
					</th>
					<th width="1%">
						<?php echo JHtml::_('grid.sort', 'ID', 'id', $listDirn, $listOrder); ?>
					</th>
					<th width="1%">
						<?php echo JHtml::_('grid.sort', 'Publicado', 'published', $listDirn, $listOrder); ?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('grid.sort','Secretario', 'nome_secretario',$listDirn, $listOrder); ?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('grid.sort','Endereço secretario','endereco_secretario', $listDirn, $listOrder); ?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('grid.sort','Sobre secretario','sobre_secretario', $listDirn, $listOrder); ?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('grid.sort','Atribuições','atribuicoes_secretaria', $listDirn, $listOrder); ?>
					</th>
					<th width="5%">
						<?php echo JHtml::_('grid.sort','Website','link_sitesecretaria', $listDirn, $listOrder); ?>
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
							$link = JRoute::_('index.php?option=com_secretario&task=secretario.edit&id=' . $row->id);
						?> 					
							<tr>
								<td>
									<?php echo $this->pagination->getRowOffset($i); ?>
								</td>
								<td>
									<?php echo JHtml::_('grid.id', $i, $row->id); ?>
								</td>
								<td align="center">
									<?php echo $row->id; ?>
								</td>
								<td align="center">
									<?php echo JHtml::_('jgrid.published', $row->published, $i, 'secretarias.', true, 'cb'); ?>
								</td>
								<td align="center">
									<a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
										<?php echo empty($row->nome_secretario)? '-' : substr($row->nome_secretario,0,25); ?>
									</a>
								</td>
								<td>
									<?php echo empty($row->endereco_secretario)? '-' : substr(strip_tags($row->endereco_secretario,'<p><br><br /><strong>'),0, 20) . ' ...'; ?>
								</td>						
								<td align="center">
									<?php echo empty($row->sobre_secretario)? '-' : substr(strip_tags($row->sobre_secretario,'<p><br><br /><strong>'),0, 20) . ' ...'; ?>
								</td>
								<td align="center">
									<?php echo empty($row->atribuicoes_secretaria)? '-' : substr(strip_tags($row->atribuicoes_secretaria,'<p><br><br /><strong>'),0, 20) . ' ...'; ?>
								</td>
								<td align="center">
									<?php echo empty($row->link_sitesecretaria)? '-' : substr($row->link_sitesecretaria, 0, 15) . ' ...' ; ?>
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