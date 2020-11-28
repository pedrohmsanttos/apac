<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted Access');

JHtml::_('formbehavior.chosen', 'select');

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', '.multipleTags', null, array('placeholder_text_multiple' => JText::_('JOPTION_SELECT_TAG')));
JHtml::_('formbehavior.chosen', '.multipleCategories', null, array('placeholder_text_multiple' => JText::_('JOPTION_SELECT_CATEGORY')));
JHtml::_('formbehavior.chosen', '.multipleAccessLevels', null, array('placeholder_text_multiple' => JText::_('JOPTION_SELECT_ACCESS')));
JHtml::_('formbehavior.chosen', '.multipleAuthors', null, array('placeholder_text_multiple' => JText::_('JOPTION_SELECT_AUTHOR')));
JHtml::_('formbehavior.chosen', 'select');

$app       = JFactory::getApplication();
$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->escape($this->state->get('list.ordering'));
$listDirn  = $this->escape($this->state->get('list.direction'));
$saveOrder = $listOrder == 'a.ordering';
$columns   = 10;

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
	$saveOrderingUrl = 'index.php?option=com_content&task=articles.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'articleList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$listOrder     = $this->escape($this->filter_order);
$listDirn      = $this->escape($this->filter_order_Dir);

require_once 'helper.php';

$user   = JFactory::getUser();
$groups = $user->get('groups');
$group_blacklist_array = array();

foreach ($groups as $id_group) {

		if($id_group != '8'){
			$group_alias = getGroupAlias($id_group);
			$group_blacklist_array = getBlacklist($group_alias);
		}

}

?>
<form action="index.php?option=com_aviso&view=avisos" method="post" id="adminForm" name="adminForm">
  <div id="j-sidebar-container" class="span2">
  		<?php echo JHtmlSidebar::render(); ?>
  	</div>
  <div id="j-main-container" class="span10">
	<div class="row-fluid">
		<div class="span8">
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
      <th width="1%" class="nowrap center hidden-phone">
        <?php echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
      </th>
			<th width="1%">#</th>
      <th width="2%">
        <?php echo JHtml::_('grid.checkall'); ?>
      </th>
      <th width="5%">
        <?php echo JHtml::_('grid.sort', 'Estado', 'published', $listDirn, $listOrder); ?>
      </th>
      <th width="55%">
        <?php echo JHtml::_('grid.sort', 'Título', 'Titulo', $listDirn, $listOrder); ?>
      </th>
      <th width="35%">
				<?php echo JHtml::_('grid.sort', 'Identificador', 'identificador', $listDirn, $listOrder); ?>
			</th>
      <th width="2%">
        <?php echo JHtml::_('grid.sort', 'ID', 'id', $listDirn, $listOrder); ?>
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
						/*controle de perfil de usuario*/
						if (in_array($row->tipo, $group_blacklist_array)) {
							    unset($row);
									$row->blacklist = 0;
							} else {
								  $row->blacklist = 1;
							}

  					$link = JRoute::_('index.php?option=com_aviso&task=aviso.edit&id=' . $row->id);
            $ordering  = ($listOrder == 'ordering');
  				?>
					<tr class="row<?php echo $i % 2; ?>">
						<?php if($row->blacklist): ?>
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
									<?php echo $this->pagination->getRowOffset($i); ?>
						</td>
						<td>
									<?php echo JHtml::_('grid.id', $i, $row->id); ?>
						</td>
            <td align="center">
              <?php echo JHtml::_('jgrid.published', $row->published, $i, 'avisos.', true, 'cb'); ?>
            </td>
            <td>
              <a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
                <?php echo $row->titulo; ?>
              </a>
            </td>
						<td>
							<a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
								<?php echo $row->identificador; ?>
							</a>
						</td>
            <td align="center">
              <?php echo $row->id; ?>
            </td>
					</tr>
					 <?php endif; ?>
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
</form>
