<?php defined('_JEXEC') or die('Restricted access');?>
<style type="text/css"> .chzn-container,.chzn-container-multi{ width: 220px !important;}</style>
<form  enctype="multipart/form-data" action="<?php echo JRoute::_('index.php?option=com_arquivo&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <input type="hidden" name="id" value="<?php echo $this->item->id ?>" />
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
                              <div class="controls alert-message">
                                <small>Arquivo salvo: <i><strong><?php echo $field->value; ?></strong></i></small>
                                <input type="hidden" name="jform[arquivo]" value="<?php echo $field->value; ?>" />
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
