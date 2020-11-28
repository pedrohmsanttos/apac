<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
JHtml::_('jquery.framework', false);

?>
<script>
jQuery.noConflict();
(function( $ ) {
  $(function() {
    $("#jform_setor").attr("readonly", false);
    $("#jform_status").attr("readonly", false);
  });
})(jQuery);
</script>
<style>
    select{
        width: 100%;
    }
</style>
<form action="<?php echo JRoute::_('index.php?option=com_contato&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend>Contato</legend>
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
    <input type="hidden" name="task" value="contato.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>
