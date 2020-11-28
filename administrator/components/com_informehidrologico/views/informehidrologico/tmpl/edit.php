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
JHtml::_('behavior.tooltip');
JHtml::_('behavior.formvalidation');
JHtml::_('formbehavior.chosen', 'select');
JHtml::_('behavior.keepalive');

// Import CSS
$document = JFactory::getDocument();
$document->addStyleSheet(JUri::root() . 'media/com_informehidrologico/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	js('input:hidden.tipo').each(function(){
		var name = js(this).attr('name');
		if(name.indexOf('tipohidden')){
			js('#jform_tipo option[value="'+js(this).val()+'"]').attr('selected',true);
		}
	});
	js("#jform_tipo").trigger("liszt:updated");
	});

	Joomla.submitbutton = function (task) {
		if (task == 'informehidrologico.cancel') {
			Joomla.submitform(task, document.getElementById('informehidrologico-form'));
		}
		else {
			
			if (task != 'informehidrologico.cancel' && document.formvalidator.isValid(document.id('informehidrologico-form'))) {
				
				Joomla.submitform(task, document.getElementById('informehidrologico-form'));
			}
			else {
				alert('Por favor preencher os campos obrigatórios!');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_informehidrologico&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="informehidrologico-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_INFORMEHIDROLOGICO_TITLE_INFORMEHIDROLOGICO', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

									<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php echo $this->form->renderField('created_by'); ?>
				<?php echo $this->form->renderField('state'); ?>
				<?php echo $this->form->renderField('modified_by'); ?>				<?php echo $this->form->renderField('titulo'); ?>
				<?php echo $this->form->renderField('tipo'); ?>
				

			<?php
				foreach((array)$this->item->tipo as $value): 
					if(!is_array($value)):
						echo '<input type="hidden" class="tipo" name="jform[tipohidden]['.$value.']" value="'.$value.'" />';
					endif;
				endforeach;
			?>				<?php echo $this->form->renderField('observacao'); ?>
				<?php echo $this->form->renderField('tags'); ?>
				<?php echo $this->form->renderField('arquivo'); ?>

				<?php if (!empty($this->item->arquivo)) : ?>
					<?php $arquivoFiles = array(); ?>
					<?php foreach ((array)$this->item->arquivo as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . 'uploads' . DIRECTORY_SEPARATOR . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $arquivoFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[arquivo_hidden]" id="jform_arquivo_hidden" value="<?php echo implode(',', $arquivoFiles); ?>" />
				<?php endif; ?>				<?php echo $this->form->renderField('publicacao'); ?>


					<?php if ($this->state->params->get('save_history', 1)) : ?>
					<div class="control-group">
						<div class="control-label"><?php echo $this->form->getLabel('version_note'); ?></div>
						<div class="controls"><?php echo $this->form->getInput('version_note'); ?></div>
					</div>
					<?php endif; ?>
				</fieldset>
			</div>
		</div>
		<?php echo JHtml::_('bootstrap.endTab'); ?>

		

		<?php echo JHtml::_('bootstrap.endTabSet'); ?>

		<input type="hidden" name="task" value=""/>
		<?php echo JHtml::_('form.token'); ?>

	</div>
</form>
