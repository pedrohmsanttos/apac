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
<div class="reset-confirm<?php echo $this->pageclass_sfx; ?>">
	<style>

	#jform_com_fields_tipo_pessoa{
        border-style: none;
        border-color: none;
        border-image: none;
	}

   .fieldset{
        border-style: none;
        border-color: none;
        border-image: none;
    }

    #jform_name{
        font-size: 15px;
        line-height: 1.5;
        color: #666;
        /* display: block; */
        /* width: 100%; */
        background: #e6e6e6;
        height: 50px;
        border-radius: 25px;
        outline: none;
        border: none;
        padding: 0 30px 0 38px;
    }

    .validate-username{
        font-size: 15px;
        line-height: 1.5;
        color: #666;
        /* display: block; */
        /* width: 100%; */
        background: #e6e6e6;
        height: 50px;
        border-radius: 25px;
        outline: none;
        border: none;
        padding: 0 30px 0 38px;
    }

   .validate-email{
        font-size: 15px;
        line-height: 1.5;
        color: #666;
        /* display: block; */
        /* width: 100%; */
        background: #e6e6e6;
        height: 50px;
        border-radius: 25px;
        outline: none;
        border: none;
        padding: 0 30px 0 38px;
    }

   .validate-password { 
        font-size: 15px;
        line-height: 1.5;
        color: #666;
        /* display: block; */
        /* width: 100%; */
        background: #e6e6e6;
        height: 50px;
        border-radius: 25px;
        outline: none;
        border: none;
        padding: 0 30px 0 38px;
    }

   #jform_com_fields_endereco{
    
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
   #jform_com_fields_cpf_cnpj{
    
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
   #jform_token{
    
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
   #jform_username{
    
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
</style>
<div class="card text-center">
      <div class="card-header">
         <h3 style="text-align: center;">Redefinir senha do Usuário - Confirmação</h3>
      </div>
      <div class="card-body">
	<?php if ($this->params->get('show_page_heading')) : ?>
		<div class="page-header">
			<h1>
				<?php echo $this->escape($this->params->get('page_heading')); ?>
			</h1>
		</div>
	<?php endif; ?>
	<form action="<?php echo JRoute::_('index.php?option=com_users&task=reset.confirm'); ?>" method="post" class="form-validate form-horizontal well">
		<?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
			<fieldset class="fieldset">
				<p><?php echo JText::_($fieldset->label); ?></p><br>
				<?php foreach ($this->form->getFieldset($fieldset->name) as $name => $field) : ?>
                    <?php if($field->fieldname != 'username'): ?>
                        <div class="control-group">
                            <div class="control-label" style="padding-left: 20px; padding-bottom: 20px;">
                                <?php echo $field->label; ?>
                            </div>
                            <div class="controls" style="padding-left: 20px; padding-bottom: 20px;">
                                <?php echo $field->input; ?>
							</div>
						</div>
                    <?php else: ?>
                        <div class="control-group">
                            <div class="control-label" style="padding-left: 20px; padding-bottom: 20px;">
                                <label id="jform_username-lbl" for="jform_username" class="hasPopover required" title="" data-content="Informe seu e-mail" data-original-title="E-mail do Usuário">
								E-mail<span class="star">&nbsp;*</span></label>
                            </div>
                            <div class="controls" style="padding-left: 20px; padding-bottom: 20px;">
                                <input type="email" name="jform[username]" id="jform_username" value="" class="required" size="30" required="required" aria-required="true" aria-invalid="false">
							</div>
						</div>
                    <?php endif;?>
				<?php endforeach; ?>
			</fieldset>
		<?php endforeach; ?>
		<div class="control-group">
			<div class="controls" style="
    padding-left: 20px;
    padding-bottom: 20px;">
				<br>
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
