<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('formbehavior.chosen', 'select');
JHtml::_('jquery.framework', false);

$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);
?>
<div class="row-fluid">
	<div class="span12">
		
		<a href="index.php?option=com_contato&view=setor" >
			<div class="btn-wrapper pull-right" id="toolbar-unpublish" style="margin-left:5px;">
				<button class="btn btn-small button-unpublish">
				<span class="icon-folder-open" aria-hidden="true"></span>
				Setores</button>
			</div>
		</a>
		
		<a href="index.php?option=com_contato&view=relatorio">
			<div class="btn-wrapper pull-right" id="toolbar-unpublish" style="margin-left:5px;">
				<button class="btn btn-small button-unpublish">
				<span class="icon-bars" aria-hidden="true"></span>
				Relatórios</button>
			</div>
		</a>
		&nbsp
	</div>
</div>

<form action="index.php?option=com_contato&view=contatos" method="post" id="adminForm" name="adminForm">
	<div class="row-fluid">
		<div class="span6">
			<?php echo JText::_('Filtros'); ?>
			<?php
				$filtros = JLayoutHelper::render(
					'joomla.searchtools.default',
					array('view' => $this)
				);
				$filtros = str_replace("<option value=\"0\">N&atilde;o publicado</option>","",$filtros);
				$filtros = str_replace("<option value=\"1\">Publicado</option>","",$filtros);
				//var_dump($filtros);die;
				echo $filtros;
			?>
		</div>
	</div>
	<table class="table table-striped table-hover">
		<thead>
		<tr>
			<th width="5%">
				<?php echo JHtml::_('grid.checkall'); ?>
			</th>
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'ID', 'id', $listDirn, $listOrder); ?>
			</th>
			<th width="15%">
				<?php echo JHtml::_('grid.sort', 'Setor', 'setor', $listDirn, $listOrder); ?>
			</th>
			<th width="10%">
				<?php echo JHtml::_('grid.sort', 'Data/Hora', 'created', $listDirn, $listOrder); ?>
			</th>
			<th width="25%">
				<?php echo JHtml::_('grid.sort', 'Nome', 'nome', $listDirn, $listOrder); ?>
			</th>
			<th width="40%">
				<?php echo JHtml::_('grid.sort', 'Mensagem', 'mensagem', $listDirn, $listOrder); ?>
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
					$link = JRoute::_('index.php?option=com_contato&task=contato.edit&id=' . $row->id);
				?>
					<tr>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td>
							<?php echo $row->id; ?>
						</td>
						<td align="center">
							<?php echo $row->setor; ?>
						</td>
						<td>
							<?php echo date("d/m/Y h:i", strtotime($row->created));
									//date_format($row->created, 'd/m/y'); ?>
						</td>
						<td>
							<a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
								<?php echo $row->nome; ?>
							</a>
						</td>
						<td>
							<?php echo $row->mensagem; ?>
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