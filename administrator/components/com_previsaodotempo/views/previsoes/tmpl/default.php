<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
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
$document->addStyleSheet(JUri::root() . 'administrator/components/com_previsaodotempo/assets/css/previsaodotempo.css');
$document->addStyleSheet(JUri::root() . 'media/com_previsaodotempo/css/list.css');

$user      = JFactory::getUser();
$userId    = $user->get('id');
$listOrder = $this->state->get('list.ordering');
$listDirn  = $this->state->get('list.direction');
$canOrder  = $user->authorise('core.edit.state', 'com_previsaodotempo');
$saveOrder = $listOrder == 'a.id';

if ($saveOrder)
{
	$saveOrderingUrl = 'index.php?option=com_previsaodotempo&task=mesorregioes.saveOrderAjax&tmpl=component';
	JHtml::_('sortablelist.sortable', 'mesorregiaoList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
}

$sortFields = $this->getSortFields();
?>

<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		jQuery(".icon-enviarEmail").removeClass('icon-enviarEmail');
		jQuery(".icon-gerarPDF").removeClass('icon-gerarPDF');
	});

	Joomla.submitbutton = function (task) {
		if (task == 'previsoes.enviarEmail' || task == 'previsoes.gerarPDF') 
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

<form action="<?php echo JRoute::_('index.php?option=com_previsaodotempo&view=previsoes'); ?>" method="post"
	  name="adminForm" id="adminForm">
	<?php if (!empty($this->sidebar)): ?>
	<div id="j-sidebar-container" class="span2">
		<?php echo $this->sidebar; ?>
	</div>
	<div id="j-main-container" class="span10">
		<?php else : ?>
		<div id="j-main-container">
			<?php endif; ?>

			<?php 
				echo JLayoutHelper::render('joomla.searchtools.default', array('view' => $this));

				echo('*Busca pelas datas refere-se à um período de Data Válida');
			?>

			<div class="clearfix"></div>
			<table class="table table-striped" id="mesorregiaoList">
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
						<?php echo JHtml::_('searchtools.sort',  'COM_PREVISAODOTEMPO_PREVISOES_ID', 'a.id', $listDirn, $listOrder); ?>
					</th>

					<th class='left'>
						<?php echo JHtml::_('searchtools.sort',  'Tipo', 'a.tipo', $listDirn, $listOrder); ?>
					</th>

					<th class='left'>
						<?php echo JHtml::_('searchtools.sort',  'Data', 'a.checked_out_time', $listDirn, $listOrder); ?>
					</th>

					<th class='left'>
						<?php echo JHtml::_('searchtools.sort',  'Data Válida', 'a.datavlida', $listDirn, $listOrder); ?>
					</th>

					<th class='left'>
						<?php echo JHtml::_('searchtools.sort',  'Horário', 'a.horario', $listDirn, $listOrder); ?>
					</th>

					<th class='left'>
						<?php echo JHtml::_('searchtools.sort',  'Autor', 'a.created_by', $listDirn, $listOrder, null, 'desc'); ?>
					</th>
					<th class='left'>
						<?php echo JHtml::_('grid.sort', 'Enviado', 'enviado', $listDirn, $listOrder); ?>
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
					$canCreate  = $user->authorise('core.create', 'com_previsaodotempo');
					$canEdit    = $user->authorise('core.edit', 'com_previsaodotempo');
					$canCheckin = $user->authorise('core.manage', 'com_previsaodotempo');
					$canChange  = $user->authorise('core.edit.state', 'com_previsaodotempo');

					$link = JRoute::_('index.php?option=com_previsaodotempo&view=previsao&layout=edit&id=' . $item->id);
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
									<input type="text" style="display:none" name="order[]" size="5"
										   value="<?php echo $item->ordering; ?>" class="width-20 text-area-order "/>
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
								<?php echo JHtml::_('jgrid.published', $item->state, $i, 'previsoes.', $canChange, 'cb'); ?>
							</td>
						<?php endif; ?>

						<td>
							<a href="<?php echo $link; ?>" title="<?php echo "Alterar"; ?>">
								<?php echo $item->id; ?>
							</a>
						</td>

						<td>
							<?php echo $this->tipos[$item->tipo]; ?>
						</td>

						<td>
							<?php echo date("d/m/Y H:i", strtotime($item->checked_out_time)); ?>
						</td>

						<td>
							<?php if ($item->datavlida =="1970-01-01"){echo("");}else{echo date("d/m/Y", strtotime(str_replace("/", "-", $item->datavlida)));} ?>
						</td>

						<td>
							<?php echo $item->horario; ?>
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