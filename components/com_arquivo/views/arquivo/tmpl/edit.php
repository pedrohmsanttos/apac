<?php
 
// No direct access
defined('_JEXEC') or die('Restricted access');

?>

<form  enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_arquivo&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend><?php echo $title." Arquivo"; ?></legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
                            <div class="control-label"><?php echo $field->label; ?></div>
                            <div class="controls"><?php echo $field->input; ?></div>
                                <?php if($field->type == 'File' && $field->value !=''): ?>
                                    <div class="controls">
                                     Arquivo salvo: <i><?php echo $field->value; ?></i>
                                    </div>
                                <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="arquivo.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>