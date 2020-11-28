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

$canEdit = JFactory::getUser()->authorise('core.edit', 'com_informehidrologico');

if (!$canEdit && JFactory::getUser()->authorise('core.edit.own', 'com_informehidrologico'))
{
	$canEdit = JFactory::getUser()->id == $this->item->created_by;
}
?>

<div class="item_fields">

	<table class="table">
		

		<tr>
			<th><?php echo JText::_('COM_INFORMEHIDROLOGICO_FORM_LBL_INFORMEHIDROLOGICO_TITULO'); ?></th>
			<td><?php echo $this->item->titulo; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_INFORMEHIDROLOGICO_FORM_LBL_INFORMEHIDROLOGICO_TIPO'); ?></th>
			<td><?php echo $this->item->tipo; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_INFORMEHIDROLOGICO_FORM_LBL_INFORMEHIDROLOGICO_OBSERVACAO'); ?></th>
			<td><?php echo nl2br($this->item->observacao); ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_INFORMEHIDROLOGICO_FORM_LBL_INFORMEHIDROLOGICO_TAGS'); ?></th>
			<td><?php echo $this->item->tags; ?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_INFORMEHIDROLOGICO_FORM_LBL_INFORMEHIDROLOGICO_ARQUIVO'); ?></th>
			<td>
			<?php
			foreach ((array) $this->item->arquivo as $singleFile) : 
				if (!is_array($singleFile)) : 
					$uploadPath = 'uploads' . DIRECTORY_SEPARATOR . $singleFile;
					 echo '<a href="' . JRoute::_(JUri::root() . $uploadPath, false) . '" target="_blank">' . $singleFile . '</a> ';
				endif;
			endforeach;
		?></td>
		</tr>

		<tr>
			<th><?php echo JText::_('COM_INFORMEHIDROLOGICO_FORM_LBL_INFORMEHIDROLOGICO_PUBLICACAO'); ?></th>
			<td><?php echo $this->item->publicacao; ?></td>
		</tr>

	</table>

</div>

<?php if($canEdit && $this->item->checked_out == 0): ?>

	<a class="btn" href="<?php echo JRoute::_('index.php?option=com_informehidrologico&task=informehidrologico.edit&id='.$this->item->id); ?>"><?php echo JText::_("COM_INFORMEHIDROLOGICO_EDIT_ITEM"); ?></a>

<?php endif; ?>

<?php if (JFactory::getUser()->authorise('core.delete','com_informehidrologico.informehidrologico.'.$this->item->id)) : ?>

	<a class="btn btn-danger" href="#deleteModal" role="button" data-toggle="modal">
		<?php echo JText::_("COM_INFORMEHIDROLOGICO_DELETE_ITEM"); ?>
	</a>

	<div id="deleteModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="deleteModal" aria-hidden="true">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3><?php echo JText::_('COM_INFORMEHIDROLOGICO_DELETE_ITEM'); ?></h3>
		</div>
		<div class="modal-body">
			<p><?php echo JText::sprintf('COM_INFORMEHIDROLOGICO_DELETE_CONFIRM', $this->item->id); ?></p>
		</div>
		<div class="modal-footer">
			<button class="btn" data-dismiss="modal">Close</button>
			<a href="<?php echo JRoute::_('index.php?option=com_informehidrologico&task=informehidrologico.remove&id=' . $this->item->id, false, 2); ?>" class="btn btn-danger">
				<?php echo JText::_('COM_INFORMEHIDROLOGICO_DELETE_ITEM'); ?>
			</a>
		</div>
	</div>

<?php endif; ?>