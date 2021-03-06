<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo Mesorregião
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
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
$document->addStyleSheet(JUri::root() . 'media/com_previsaodotempo/css/form.css');
?>
<script type="text/javascript">
	js = jQuery.noConflict();
	js(document).ready(function () {
		
	});

	Joomla.submitbutton = function (task) {
		if (task == 'variavel.cancel') 
        {
			window.location = "index.php?option=com_previsaodotempo&view=variaveis";
            
		}
        else 
        {	
			if (task != 'mesorregioes.cancel' && document.formvalidator.isValid(document.id('adminForm'))) 
            {				
				Joomla.submitform(task, document.getElementById('adminForm'));
			}
			else 
            {
				alert('Formulário inválido');
			}
		}
	}
</script>
<form action="<?php echo JRoute::_('index.php?option=com_previsaodotempo&view=variavel&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend>Adicionar Variavel</legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="variavel.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>