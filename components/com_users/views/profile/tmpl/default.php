<?php
   /**
    * @package     Joomla.Site
    * @subpackage  com_users
    *
    * @copyright   Copyright (C) 2005 - 2018 Open Source Matters, Inc. All rights reserved.
    * @license     GNU General Public License version 2 or later; see LICENSE.txt
    */
   
   defined('_JEXEC') or die;
   
   ?>
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
   #jform_com_fields_telefone{
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
   #jform_com_fields_outros_contatos{
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
   background: #ffdd00;
   border: none;
   text-decoration:none;
   padding-top: 16px;
   padding-right: 35px;
   padding-bottom: 16px;
   padding-left: 35px; }
   .control-group{
   padding-left: 340px;
   }
   .control-label{
   padding-bottom: 15px;
   }
</style>
<div class="profile<?php echo $this->pageclass_sfx; ?>">
   <div class="card text-center">
      <div class="card-header">
         <h3 style="text-align: center;">Perfil Usuário</h3>
      </div>
      <div class="card-body">
         <?php if ($this->params->get('show_page_heading')) : ?>
         <div class="page-header">
            <h1>
               <?php echo $this->escape($this->params->get('page_heading')); ?>
            </h1>
         </div>
         <?php endif; ?>
         <?php echo $this->loadTemplate('core'); ?>
         <?php echo $this->loadTemplate('custom'); ?>
        
         
         <?php if (JFactory::getUser()->id == $this->data->id) : ?>
         <ul class="btn-toolbar pull-right">
            <li class="btn-group">
               <a class="btn" href="<?php echo JRoute::_('index.php?option=com_users&task=profile.edit&user_id=' . (int) $this->data->id); ?>">
               <span class="icon-user"></span>
               <?php echo JText::_('COM_USERS_EDIT_PROFILE'); ?>
               </a>
            </li>
         </ul>
         <?php endif; ?> 
      </div>
     
   </div>
    
</div>