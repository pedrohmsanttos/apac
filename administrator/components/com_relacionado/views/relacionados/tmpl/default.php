<?php
defined('_JEXEC') or die('Restricted Access');

 
$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);

function getArtigos($ids){
	$db    = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('title')
		->from($db->quoteName('#__content'))
		->where('id in ('.$ids.')');

	$db->setQuery($query);
	$results = $db->loadObjectList();
	$retorno = array();
	foreach($results as $title){
		array_push($retorno, $title->title);
	}
	
	return implode(', ',$retorno);
}

function getAuthor($id){
	if(empty($id)) return ' ';
	$db    = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('name')
		->from($db->quoteName('#__users'))
		->where('id = '.$id);

	$db->setQuery($query);
	$results = $db->loadObjectList();
	$retorno = $results[0]->name;
	return $retorno;
}
?>
<form action="index.php?option=com_relacionado&view=Relacionados" method="post" id="adminForm" name="adminForm">
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
			<th width="5%">
				<?php echo JHtml::_('grid.sort', 'Publicado', 'published', $listDirn, $listOrder); ?>
			</th>
			<th width="2%">
				<?php echo JHtml::_('grid.sort', 'ID', 'id', $listDirn, $listOrder); ?>
			</th>
			<th width="20%">
				Título de Sidebar
			</th>
			<th width="5%">
				Ordem
			</th>
			<th width="20%">
				Páginas/Artigos
			</th>
			<th width="10%">
				Data de Criação
			</th>
			<th width="10%">
				Autor
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
					$link = JRoute::_('index.php?option=com_relacionado&task=relacionado.edit&id=' . $row->id);
				?> 
					<tr>
						<td>
							<?php echo $this->pagination->getRowOffset($i); ?>
						</td>
						<td>
							<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
						<td align="center">
							<?php echo JHtml::_('jgrid.published', $row->published, $i, 'relacionados.', true, 'cb'); ?>
						</td>
						<td align="center">
							<?php echo $row->id; ?>
						</td>
						<td>
							<a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
								<?php echo $row->titulo; ?>
							</a>
						</td>
						<td>
							<?php echo $row->ordering; ?>
						</td>
						<td>
							<?php echo getArtigos($row->artigos); ?>
						</td>
						<td>
							<?php echo date_format(date_create($row->created),"d/m/Y H:i"); ?>
						</td>
						<td>
							<?php echo getAuthor($row->user_id); ?>
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