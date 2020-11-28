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
		if (task == 'mesorregioes.cancel')
        {
			window.location = "index.php?option=com_previsaodotempo&view=mesorregioes";    
		}
        else 
        {	
			if (task != 'mesorregioes.cancel' && document.formvalidator.isValid(document.id('mesorregiao-form'))) 
            {				
				Joomla.submitform(task, document.getElementById('mesorregiao-form'));
			}
			else 
            {
				alert('Formulário inválido');
			}
		}
	}
</script>

<form action="<?php echo JRoute::_('index.php?option=com_previsaodotempo&view=mesorregiao&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="mesorregiao-form" enctype="multipart/form-data">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend>Mesorregião</legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                        </div>
                        <?php if($field->name == 'jform[geojson]') : ?>
                            <?php if (!is_array($field)) : ?>
                                <a href="<?php echo JRoute::_(JUri::root() . 'uploads' . DIRECTORY_SEPARATOR . $this->item->geojson, false);?>"><?php echo $this->item->geojson; ?></a> | 
                                <?php $arquivoFiles[] = $fileSingle; ?>
                            <?php endif; ?>
                            <script>
                                document.getElementById("jform_geojson").removeAttribute("required");
                                var element = document.getElementById("jform_geojson");
                                element.removeAttribute("required");
                                element.classList.remove("required");
                            </script>
                            <input type="hidden" name="jform[old_geojson]" id="jform_old_geojson" value="<?php echo $this->item->geojson; ?>" />
                        <?php endif; ?>	
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="mesorregiao.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>