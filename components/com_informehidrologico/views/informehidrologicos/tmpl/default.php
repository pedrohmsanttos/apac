<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Informehidrologico
 * @author     Matheus Felipe <matheusfelipe.moreira@gmail.com>
 * @copyright  2018 Matheus Felipe
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');
JHtml::_('bootstrap.tooltip');
JHtml::_('behavior.multiselect');
JHtml::_('formbehavior.chosen', 'select');

$user       = JFactory::getUser();
$userId     = $user->get('id');
$listOrder  = $this->state->get('list.ordering');
$listDirn   = $this->state->get('list.direction');
$canCreate  = $user->authorise('core.create', 'com_informehidrologico') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'informehidrologicoform.xml');
$canEdit    = $user->authorise('core.edit', 'com_informehidrologico') && file_exists(JPATH_COMPONENT . DIRECTORY_SEPARATOR . 'models' . DIRECTORY_SEPARATOR . 'forms' . DIRECTORY_SEPARATOR . 'informehidrologicoform.xml');
$canCheckin = $user->authorise('core.manage', 'com_informehidrologico');
$canChange  = $user->authorise('core.edit.state', 'com_informehidrologico');
$canDelete  = $user->authorise('core.delete', 'com_informehidrologico');
?>

<form action="<?php echo htmlspecialchars(JUri::getInstance()->toString()); ?>" method="post"
      name="adminForm" id="adminForm">

	
	<table class="table table-striped" id="informehidrologicoList">
		<thead>
		<tr>
							<th class=''>
				<?php echo JHtml::_('grid.sort',  'Registro', 'a.id', $listDirn, $listOrder); ?>
				</th>
				<th class="center">
					<?php echo JText::_('Informe hidrologico'); ?>
				</th>

				<th class="center">
					<?php echo JText::_('Publicado'); ?>
				</th>

				<th class="center">
					<?php echo JText::_('Tipo(s)'); ?>
				</th>

				<th class="center">
					<?php echo JText::_('Link'); ?>
				</th>

							<?php if ($canEdit || $canDelete): ?>
					<th class="center">
				<?php echo JText::_('Ações'); ?>
				</th>
				<?php endif; ?>

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
		<?php foreach ($this->items as $i => $item) : ?>
			<?php $canEdit = $user->authorise('core.edit', 'com_informehidrologico'); ?>

							<?php if (!$canEdit && $user->authorise('core.edit.own', 'com_informehidrologico')): ?>
					<?php $canEdit = JFactory::getUser()->id == $item->created_by; ?>
				<?php endif; ?>

			<tr class="row<?php echo $i % 2; ?>">

							<td>
								<?php echo $item->id; ?>
							</td>

							<td>
								<?php echo $item->titulo; ?>
							</td>

							<td>
								<?php echo $item->publicacao; ?>
							</td>

							<td>
								<?php echo $item->tipo; ?>
							</td>

							<td>
								<a href="uploads/<?php echo $item->arquivo;?>" title="<?php echo $item->titulo ?>">
									Baixar informe
								</a>
							</td>

								<?php if ($canEdit || $canDelete): ?>
					<td class="center">
						<?php if ($canEdit): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_informehidrologico&task=informehidrologicoform.edit&id=' . $item->id, false, 2); ?>" class="btn btn-mini" type="button"><i class="icon-edit" ></i></a>
						<?php endif; ?>
						<?php if ($canDelete): ?>
							<a href="<?php echo JRoute::_('index.php?option=com_informehidrologico&task=informehidrologicoform.remove&id=' . $item->id, false, 2); ?>" class="btn btn-mini delete-button" type="button"><i class="icon-trash" ></i></a>
						<?php endif; ?>
					</td>
				<?php endif; ?>

			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>

	<?php if ($canCreate) : ?>
		<a href="<?php echo JRoute::_('index.php?option=com_informehidrologico&task=informehidrologicoform.edit&id=0', false, 0); ?>"
		   class="btn btn-success btn-small"><i
				class="icon-plus"></i>
			<?php echo JText::_('COM_INFORMEHIDROLOGICO_ADD_ITEM'); ?></a>
	<?php endif; ?>

	<input type="hidden" name="task" value=""/>
	<input type="hidden" name="boxchecked" value="0"/>
	<input type="hidden" name="filter_order" value="<?php echo $listOrder; ?>"/>
	<input type="hidden" name="filter_order_Dir" value="<?php echo $listDirn; ?>"/>
	<?php echo JHtml::_('form.token'); ?>
</form>

<?php if($canDelete) : ?>
<script type="text/javascript">

	jQuery(document).ready(function () {
		jQuery('.delete-button').click(deleteItem);
	});

	function deleteItem() {

		if (!confirm("<?php echo JText::_('COM_INFORMEHIDROLOGICO_DELETE_MESSAGE'); ?>")) {
			return false;
		}
	}
</script>
<?php endif; ?>
