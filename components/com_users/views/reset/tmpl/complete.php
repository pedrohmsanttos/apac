<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_users
 *
 * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JHtml::_('behavior.keepalive');
JHtml::_('behavior.formvalidator');

?>
<div class="reset-complete<?php echo $this->pageclass_sfx; ?>">
	<style type="text/css">
		#jform_password1{
	    
	   font-size: 15px;
	   line-height: 1.5;
	   color: #666;
	   /* display: block; */
	   /* width: 100%; */
	   background: #e6e6e6;
	   width: 340px;
	   height: 50px;
	   border-radius: 25px;
	   outline: none;
	   border: none;
	   padding: 0 30px 0 38px;
	   }
	   #jform_password2{
	    
	   font-size: 15px;
	   line-height: 1.5;
	   color: #666;
	   /* display: block; */
	   /* width: 100%; */
	   background: #e6e6e6;
	   height: 50px;
	   width: 340px;
	   border-radius: 25px;
	   outline: none;
	   border: none;
	   padding: 0 30px 0 38px;
	   }
	   .btn-primary{font-size: 15px;
	   line-height: 1.5;
	   color: #040404;
	   text-transform: uppercase;
	   width: 20%;
	   height: 50px;
	   border-radius: 25px;
	   background: #ffdd00;
	   border: none;}
	   .btn{font-size: 15px;
	   line-height: 1.5;
	   color: #040404;
	   text-transform: uppercase;
	   height: 50px;
	   border-radius: 25px;
	   background: #e6e6e6;
	   border: none;
	   text-decoration:none;
	   padding-top: 16px;
	   padding-right: 35px;
	   padding-bottom: 16px;
	   padding-left: 35px; }
	   .fieldset{
   border-style: none;
   border-color: none;
   border-image: none;
   } 
	</style>
	<div class="card text-center">
      <div class="card-header">
         <h3 style="text-align: center;">Redefinir senha do Usuário</h3>
      </div>
      <div class="card-body">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
	<form action="<?php echo JRoute::_('index.php?option=com_users&task=reset.complete'); ?>" method="post" class="form-validate form-horizontal well">
		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
			<fieldset class="fieldset">
				<p><?php echo JText::_($fieldset->label); ?></p><br>
				<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
					<div class="control-group">
						<div class="control-label" style="
    padding-left: 20px;
    padding-bottom: 20px;">
							<?php echo $field->label; ?>
						</div>
						<div class="controls" style="
    padding-left: 20px;
    padding-bottom: 20px;">
							<?php echo $field->input; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</fieldset>
		<?php endforeach; ?>
		<div class="control-group">
			<div class="controls" style="
    padding-left: 20px;
    padding-bottom: 20px;">
				<button type="submit" class=" btn-primary validate">
					<?php echo JText::_('JSUBMIT'); ?>
				</button>
			</div>
		</div>
		<?php echo JHtml::_('form.token'); ?>
	</form>
	</div>
   </div>
</div>
