<?php
	defined('_JEXEC') or die('Restricted access');
	JHtml::_('formbehavior.chosen', 'select');
  require_once 'helper.php';

	$user   = JFactory::getUser();
	$groups = $user->get('groups');
	$group_blacklist_array = array();

	foreach ($groups as $id_group) {
			if($id_group != '8'){
					$group_alias = getGroupAlias($id_group);
				$group_blacklist_array = getBlacklist($group_alias);
			}
	 }

?>

<style type="text/css">.system-message-container{display:none}.wf-editor-container,.js-editor-tinymce{width: 750px} .chzn-container,.chzn-container-multi{ width: 220px !important;}.input-append{width: 165px !important;}</style>
<script language="javascript" type="text/javascript">
	function tableOrdering( order, dir, task )
	{
		var form = document.adminForm;
		form.filter_order.value = order;
		form.filter_order_Dir.value = dir;
		document.adminForm.submit( task );
	}
	jQuery.noConflict();
	(function( $ ) {
	  $(function() {

			<?php foreach ($group_blacklist_array as $group_blacklist_array_item): ?>
				$("#jform_tipo option[value='<?php echo $group_blacklist_array_item ?>']").remove();
			<?php endforeach; ?>

			$('#jform_tipo').trigger("liszt:updated");

	  });
	})(jQuery);
</script>
<form action="<?php echo JRoute::_('index.php?option=com_aviso&layout=edit&id=' . (int) $this->item->id); ?>"
    method="post" name="adminForm" id="adminForm">
    <input type="hidden" name="created" value="<?php echo date("Y-m-d H:i:s");?>" />
    <input type="hidden" name="id" value="<?php echo $this->item->id;?>" />
    <input type="hidden" name="filter_order" value="<?php echo $this->sortColumn; ?>" />
	  <input type="hidden" name="filter_order_Dir" value="<?php echo $this->sortDirection; ?>" />
    <div class="form-horizontal">
        <fieldset class="adminform">
            <legend>Aviso</legend>
            <div class="row-fluid">
                <div class="span6">
                    <?php foreach ($this->form->getFieldset() as $field): ?>
                        <div class="control-group">
													<?php if($field->name == 'jform[regioes][]'): ?>
															<script>
																jQuery.noConflict();
																(function( $ ) {
																  $(function() {
																		<?php foreach (explode(",",$field->value) as $key_value) : ?>
																			$("#jform_regioes option[value='<?php echo $key_value ?>']").prop("selected","selected");
																		<?php endforeach; ?>
																		$('#jform_regioes').trigger("liszt:updated");
																	});
																})(jQuery);
															</script>
													<?php endif ?>
                            <div class="control-label"><?php echo $field->label; ?></div>
														<div class="controls">
															<?php echo $field->input; ?>
														</div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </fieldset>
    </div>
    <input type="hidden" name="task" value="aviso.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>
