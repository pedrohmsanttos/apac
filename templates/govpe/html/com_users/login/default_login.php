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
<div class="login<?php echo $this->pageclass_sfx; ?>">
<style>
				 .fieldset{
					border-style: none;
					border-color: none;
					border-image: none;
				 }  
				   .validate-username{
					font-family: Poppins-Medium;
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

					.validate-password{
					font-family: Poppins-Medium;
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
								
					.btn-primary{font-size: 15px;
					line-height: 1.5;
					color: #040404;
					text-transform: uppercase;
					width: 50%;
					height: 50px;
					border-radius: 25px;
					background: #ffdd00;
					border: none;}
					
				   </style>
<?php if ($this->params->get('show_page_heading')) : ?>
<div class="page-header">
   <h1>
      <?php echo $this->escape($this->params->get('page_heading')); ?>
   </h1>
</div>
<?php endif; ?>
<?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
<div class="login-description">
   <?php endif; ?>
   <?php if ($this->params->get('logindescription_show') == 1) : ?>
   <?php echo $this->params->get('login_description'); ?>
   <?php endif; ?>
   <?php if ($this->params->get('login_image') != '') : ?>
   <img src="<?php echo $this->escape($this->params->get('login_image')); ?>" class="login-image" alt="<?php echo JText::_('COM_USERS_LOGIN_IMAGE_ALT'); ?>" />
   <?php endif; ?>
   <?php if (($this->params->get('logindescription_show') == 1 && str_replace(' ', '', $this->params->get('login_description')) != '') || $this->params->get('login_image') != '') : ?>
</div>
<?php endif; ?>
<div class="card text-center">
   <div class="card-header">
      <h3 style="text-align: center;">Login</h3>
   </div>
   <div class="card-body">
      <form action="<?php echo JRoute::_('index.php?option=com_users&task=user.login'); ?>" method="post" class="form-validate form-horizontal well">
      <fieldset class="fieldset">
            <div class="control-group" style="padding-left: 340px;">
               <div class="control-label">
				  <label id="username-lbl" for="username" class="required invalid">E-mail<span class="star">&nbsp;*</span></label>
			   </div>
			   <br>
               <div class="controls">
			         <input type="text" name="username" id="username" value="" class="validate-username required invalid" size="25" required="required" aria-required="true" autofocus="" aria-invalid="true">
               </div>
            </div>
			<br>
            <div class="control-group" style="padding-left: 340px;">
                <div class="control-label">
				    <label id="password-lbl" for="password" class="required">Senha<span class="star">&nbsp;*</span></label>
			    </div>
			    <br>
                <div class="controls">
			        <input type="password" name="password" id="password" value="" class="validate-password required" size="25" maxlength="99" required="required" aria-required="true">  
                </div>
            </div>
			<br>
            <div class="control-group" style="padding-left: 340px;">
                <div class="control-label">
                    <label for="remember">
				    <input id="remember" type="checkbox" name="remember" class="inputbox" value="yes">Lembrar-me</label>
               </div>
               <br>
            </div>
            <div class="controls" style="text-align: center;">
                <button type="submit" class="btn-primary">Entrar</button>
            </div>
            <?php $return = $this->form->getValue('return', '', $this->params->get('login_redirect_url', $this->params->get('login_redirect_menuitem'))); ?>
            <input type="hidden" name="return" value="<?php echo base64_encode($return); ?>" />
            <?php echo JHtml::_('form.token'); ?>        
        </fieldset>
      </form>
   </div>
   <div class="card-body" style="padding-left: 340px;">
      <ul class="nav nav-tabs nav-stacked">
         <li>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=reset'); ?>">
            <?php echo JText::_('COM_USERS_LOGIN_RESET'); ?>
            </a>
         </li>
         <?php $usersConfig = JComponentHelper::getParams('com_users'); ?>
         <?php if ($usersConfig->get('allowUserRegistration')) : ?>
         <li>
            <a href="<?php echo JRoute::_('index.php?option=com_users&view=registration'); ?>">
            <?php echo JText::_('COM_USERS_LOGIN_REGISTER'); ?>
            </a>
         </li>
         <?php endif; ?>
      </ul>
   </div>
   <br>
</div>