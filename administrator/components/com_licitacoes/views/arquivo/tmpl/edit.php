<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Licitacoes
 * @author     Pedro Santos <phmsanttos@gmail.com>
 * @copyright  2018 Pedro Santos
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
$document->addStyleSheet(JUri::root() . 'media/com_licitacoes/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'arquivo.cancel') {
			window.location = "index.php?option=com_licitacoes&view=arquivos";
			// Joomla.submitform(task, document.getElementById('licitacao-form'));
		}
		else {
			
			if (task != 'arquivo.cancel' && document.formvalidator.isValid(document.id('arquivos-form'))) 
            {				
				Joomla.submitform(task, document.getElementById('arquivos-form'));
			}
			else 
            {
				alert('Formulário inválido');
			}
		}
	}
</script>

<form
	action="<?php echo JRoute::_('index.php?option=com_licitacoes&layout=edit&id=' . (int) $this->item->id); ?>"
	method="post" enctype="multipart/form-data" name="adminForm" id="arquivos-form" class="form-validate">

	<div class="form-horizontal">
		<?php echo JHtml::_('bootstrap.startTabSet', 'myTab', array('active' => 'general')); ?>

		<?php echo JHtml::_('bootstrap.addTab', 'myTab', 'general', JText::_('COM_LICITACOES_TITLE_LICITACAO', true)); ?>
		<div class="row-fluid">
			<div class="span10 form-horizontal">
				<fieldset class="adminform">

				<input type="hidden" name="jform[id]" value="<?php echo $this->item->id; ?>" />
				<input type="hidden" name="jform[ordering]" value="<?php echo $this->item->ordering; ?>" />
				<input type="hidden" name="jform[state]" value="<?php echo $this->item->state; ?>" />
				<input type="hidden" name="jform[checked_out]" value="<?php echo $this->item->checked_out; ?>" />
				<input type="hidden" name="jform[checked_out_time]" value="<?php echo $this->item->checked_out_time; ?>" />

				<?php //foreach ($this->form->getFieldset() as $field): ?>
	                

	                <!--<div class="control-group">
	                    <div class="control-label"><?php echo $field->label; ?></div>
	                    <div class="controls"><?php echo $field->input; ?></div>
	                </div> -->



	            <?php //endforeach; ?>

				<?php 

				echo $this->form->renderField('created_by'); 
				 echo $this->form->renderField('modified_by'); 		
				 echo $this->form->renderField('state'); 		
				 echo $this->form->renderField('titulo'); 
				 echo $this->form->renderField('id_licitacao'); 
				 echo $this->form->renderField('ordering'); 
				 echo $this->form->renderField('arquivo');  ?>

				 <?php if (!empty($this->item->arquivo)) : ?>
					<?php $arquivoFiles = array(); ?>
					<?php foreach ((array)$this->item->arquivo as $fileSingle) : ?>
						<?php if (!is_array($fileSingle)) : ?>
							<a href="<?php echo JRoute::_(JUri::root() . $fileSingle, false);?>"><?php echo $fileSingle; ?></a> | 
							<?php $arquivoFiles[] = $fileSingle; ?>
						<?php endif; ?>
					<?php endforeach; ?>
					<input type="hidden" name="jform[arquivo_hidden]" id="jform_arquivo_hidden" value="<?php echo implode(',', $arquivoFiles); ?>" />
				<?php endif; ?>	

				 <?php echo $this->form->renderField('tipo'); 

				 ?>
				
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