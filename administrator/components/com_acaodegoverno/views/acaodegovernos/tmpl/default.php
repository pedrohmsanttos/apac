<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

//$diretor = new DiretorHelper();

JHtml::_('formbehavior.chosen', 'select');
 
$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);
?>
<form action="index.php?option=com_acaodegoverno&view=acaodegovernos" method="post" id="adminForm" name="adminForm">
	<div class="row-fluid">
		<div class="span6">
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
				<?php echo JHtml::_('grid.sort','Título', 'titulo',$listDirn, $listOrder) ;?>
			</th>
			<th width="5%">
				<?php echo JHtml::_('grid.sort','Ícone','imagem', $listDirn, $listOrder) ;?>
			</th>
			<th width="5%">
				<?php echo JHtml::_('grid.sort','Conteúdo','conteudo', $listDirn, $listOrder) ;?>
			</th>
			<th width="5%">
				<?php echo JHtml::_('grid.sort','Link detalhamento da ação','link_detalhamentoacao', $listDirn, $listOrder) ;?>
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
					$link = JRoute::_('index.php?option=com_acaodegoverno&task=acaodegoverno.edit&id=' . $row->id);
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
							<?php echo JHtml::_('jgrid.published', $row->published, $i, 'acaodegovernos.', true, 'cb'); ?>
						</td>
						<td align="center">
							<a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
								<?php echo empty($row->titulo)? '-' : substr($row->titulo,0, 10) . ' ...'; ?>
							</a>
						</td>
						<td align="center">
							<?php echo empty($row->imagem)? '-': substr($row->imagem,0,10) . ' ...'; ?>
						</td>
						<td align="center">
							<?php echo empty($row->conteudo)? '-' : substr(strip_tags($row->conteudo,'<p><br><br /><strong>'),0,25).' ...'; ?>
						</td>
						<td align="center">
							<?php echo empty($row->link_detalhamentoacao)? '-' : substr($row->link_detalhamentoacao, 0, 10) . ' ...'; ?>
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
</form>