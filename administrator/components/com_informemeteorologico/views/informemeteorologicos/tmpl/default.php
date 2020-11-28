<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_informemeteorologico
 * @author     Matheus Felipe <matheusfelipe.moreira@gmail.com>
 * @copyright  2018 Matheus Felipe
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');



// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'administrator/components/com_informemeteorologico/assets/css/informemeteorologico.css');
$document->addStyleSheet(JUri::root() . 'media/com_informemeteorologico/css/list.css');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $user->authorise('core.edit.state', 'com_informemeteorologico');
$saveOrder = $listOrder == 'a.ordering';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_informemeteorologico&task=informemeteorologicos.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'informemeteorologicoList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();

function getCategoryName($id)
{
	if(empty($id)) return '';

	$db = JFactory::getDbo();
	$query = $db->getQuery(true);

	$query->select($db->quoteName(array('title')));
	$query->from($db->quoteName('#__categories'));
	$query->where('id='.$id);
	
	$db->setQuery($query);
	$categoryList = $db->loadObjectList();
	return $categoryList[0]->title;
}
?>

<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		jQuery(".icon-enviarEmail").removeClass('icon-enviarEmail');		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'informemeteorologicos.enviarEmail') 
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

<form action="<?php echo JRoute::_('index.php?option=com_informemeteorologico&view=informemeteorologicos'); ?>" method="post"
	  name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>

            <?php echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this)); ?>

			<div class="clearfix"></div>
			<table class="table table-striped" id="informemeteorologicoList">
				<thead>
				<tr>
					<?php if (isset($this->items[0]->ordering)): ?>
						<th width="1%" class="nowrap center hidden-phone">
                            <?php echo JHtml::_('searchtools.sort', '', 'a.ordering', $listDirn, $listOrder, null, 'asc', 'JGRID_HEADING_ORDERING', 'icon-menu-2'); ?>
                        </th>
					<?php endif; ?>
					<th width="1%" class="hidden-phone">
						<input type="checkbox" name="checkall-toggle" value=""
							   title="<?php echo JText::_('JGLOBAL_CHECK_ALL'); ?>" onclick="Joomla.checkAll(this)"/>
					</th>
					<?php if (isset($this->items[0]->state)): ?>
						<th width="1%" class="nowrap center">
								<?php echo JHtml::_('searchtools.sort', 'JSTATUS', 'a.state', $listDirn, $listOrder); ?>
						</th>
					<?php endif; ?>
					<th class='left'>
						<?php echo JHtml::_('searchtools.sort',  'COM_INFORMEMETEOROLOGICO_INFORMEMETEOROLOGICOS_ID', 'a.id', $listDirn, $listOrder); ?>
					</th>
					<th class='left'>
						<?php echo JHtml::_('searchtools.sort', 'Titulo', 'a.titulo', $listDirn, $listOrder); ?>
					</th>
					<th class='left'>
						<?php echo JHtml::_('searchtools.sort', 'Publicação', 'a.publicacao', $listDirn, $listOrder); ?>
					</th>
					<th class='left'>
						Tipo
					</th>
					<th class='left'>
						Usuário que cadastrou
					</th>
					<th class='left'>
						Enviado
					</th>
				</tr>
				</thead>
				<tfoot>
				<tr>
					<td colspan="<?php echo isset($this->items[0]) ? count(get_object_vars($this->items[0])) : 10; ?>">
						<?php echo $this->pagination->getListFooter(); ?>
					</td>
				</tr>
				</tfoot>
				<tbody>
				
				<?php foreach ($this->items as $i => $item) :
					$ordering   = ($listOrder == 'a.ordering');
					$canCreate  = $user->authorise('core.create', 'com_informemeteorologico');
					$canEdit    = $user->authorise('core.edit', 'com_informemeteorologico');
					$canCheckin = $user->authorise('core.manage', 'com_informemeteorologico');
					$canChange  = $user->authorise('core.edit.state', 'com_informemeteorologico');

					$link = JRoute::_('index.php?option=com_informemeteorologico&task=informemeteorologico.edit&id=' . $item->id);
					?>
					<tr class="row<?php echo $i % 2; ?>">

						<?php if (isset($this->items[0]->ordering)) : ?>
							<td class="order nowrap center hidden-phone">
								<?php if ($canChange) :
									$disableClassName = '';
									$disabledLabel    = '';

									if (!$saveOrder) :
										$disabledLabel    = JText::_('JORDERINGDISABLED');
										$disableClassName = 'inactive tip-top';
									endif; ?>
									<span class="sortable-handler hasTooltip <?php echo $disableClassName ?>"
										  title="<?php echo $disabledLabel ?>">
										<i class="icon-menu"></i>
									</span>
								<input type="text" style="display:none" name="order[]" size="5" value="<?php echo $item->ordering; ?>" class="width-20 text-area-order "/>
								<?php else : ?>
									<span class="sortable-handler inactive">
										<i class="icon-menu"></i>
									</span>
								<?php endif; ?>
							</td>
						<?php endif; ?>
							<td class="hidden-phone">
								<?php echo JHtml::_('grid.id', $i, $item->id); ?>
							</td>
						<?php if (isset($this->items[0]->state)): ?>
							<td class="center">
								<?php echo JHtml::_('jgrid.published', $item->state, $i, 'informemeteorologicos.', $canChange, 'cb'); ?>
							</td>	
						<?php endif; ?>
							<td>	
								<?php echo $item->id; ?>
							</td>
							<td>	
								<a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
									<?php echo $item->titulo; ?>
								</a>
							</td>
							<td>	
								<?php echo $item->publicacao; ?>
							</td>
							<td>	
								<?php echo getCategoryName($item->tipo); ?>
							</td>
							<td>	
								<?php echo $item->created_by; ?>
							</td>
							<td style="text-align: center">
								<?php echo (!empty($item->enviado) && trim($item->enviado == "1")) ? "<p class='icon-publish'></p>" : "<p class='icon-unpublish'></p>"; ?>
							</td>

					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>

			<input type="hidden" name="task" value=""/>
			<input type="hidden" name="boxchecked" value="0"/>
            <input type="hidden" name="list[fullorder]" value="<?php echo $listOrder; ?> <?php echo $listDirn; ?>"/>
			<?php echo JHtml::_('form.token'); ?>
		</div>
</form>
<script>
    window.toggleField = function (id, task, field) {

        var f = document.adminForm, i = 0, cbx, cb = f[ id ];

        if (!cb) return false;

        while (true) {
            cbx = f[ 'cb' + i ];

            if (!cbx) break;

            cbx.checked = false;
            i++;
        }

        var inputField   = document.createElement('input');

        inputField.type  = 'hidden';
        inputField.name  = 'field';
        inputField.value = field;
        f.appendChild(inputField);

        cb.checked = true;
        f.boxchecked.value = 1;
        window.submitform(task);

        return false;
    };
</script>