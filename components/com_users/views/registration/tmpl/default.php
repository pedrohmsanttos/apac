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
<div class="registration<?php echo $this->pageclass_sfx; ?>">
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
   background: #e6e6e6;
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
<?php if ($this->params->get('show_page_heading')) : ?>
<div class="page-header">
   <h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
</div>
<?php endif; ?>
<div class="card text-center">
   <div class="card-header">
      <h3 style="text-align: center;">Cadastro de Usuário</h3>
   </div>
   <div class="card-body">
      <form id="member-registration" action="<?php echo JRoute::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate form-horizontal well" enctype="multipart/form-data">
         <?php // Iterate through the form fieldsets and display each one. ?>
         <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
         <?php $fields = $this->form->getFieldset($fieldset->name); ?>
         <?php if (count($fields)) : ?>
         <fieldset  class = "fieldset">
            <?php // If the fieldset has a label set, display it as the legend. ?>
            <?php if (isset($fieldset->label)) : ?>
            <?php endif; ?>
            <?php // Iterate through the fields in the set and display them. ?>
            <?php foreach ($fields as $field) : ?>
            <?php // If the field is hidden, just display the input. ?>
            <?php if ($field->hidden) : ?>
            <?php echo $field->input; ?>
            <?php else : ?>
            <div class="control-group">
               <div class="control-label">
                  <?php echo $field->label; ?>
                  <?php if (!$field->required && $field->type !== 'Spacer') : ?>
                  <span class="optional"><?php echo JText::_('COM_USERS_OPTIONAL'); ?></span>
                  <?php endif; ?>
               </div>
               <div class="controls">
                  <?php echo $field->input; ?>
               </div>
               <br>
            </div>
            <?php endif; ?>
            <?php endforeach; ?>
         </fieldset>
         <?php endif; ?>
         <?php endforeach; ?>
         <div class="control-group" style="padding-left:340px;">
            <div class="controls">
               <button type="submit" class="btn-primary validate">
               <?php echo JText::_('JREGISTER'); ?>
			   </button>
			  
               <a class=" btn" href="<?php echo JRoute::_(''); ?>" title="<?php echo JText::_('JCANCEL'); ?>">
               <?php echo JText::_('JCANCEL'); ?>
               </a>
               <input type="hidden" name="option" value="com_users" />
               <input type="hidden" name="task" value="registration.register" />
            </div>
         </div>
         <?php echo JHtml::_('form.token'); ?>
      </form>
   </div>
</div>
<script language="javascript" type="text/javascript">
document.getElementById('jform_com_fields_cpf_cnpj').disabled=true;
tipo1 = document.getElementById("jform_com_fields_tipo_pessoa0");
tipo2 = document.getElementById("jform_com_fields_tipo_pessoa1");
cpf = document.getElementById("jform_com_fields_cpf_cnpj");
tel = document.getElementById("jform_com_fields_telefone");
tag1 = document.createAttribute("onkeypress");
tag1.value = "mascaraMutuario(this,cpfCnpj)";
tag3 = document.createAttribute("onclick");
tag3.value = "if(document.getElementById('jform_com_fields_cpf_cnpj').disabled==true){saida = document.getElementById('jform_com_fields_cpf_cnpj');  saida.disabled=false; }";
tag4 = document.createAttribute("onclick");
tag4.value = "if(document.getElementById('jform_com_fields_cpf_cnpj').disabled==true){saida = document.getElementById('jform_com_fields_cpf_cnpj');  saida.disabled=false;}";
cpf.setAttributeNode(tag1);
tag2 = document.createAttribute("onkeypress");
tag2.value = "mascaraMutuario(this,telefone)";
tel.setAttributeNode(tag2);
tipo1.setAttributeNode(tag3);
tipo2.setAttributeNode(tag4);

document.getElementById("jform_com_fields_tipo_pessoa0").addEventListener("click", saida1);
document.getElementById("jform_com_fields_tipo_pessoa1").addEventListener("click", saida2);

function saida1(){
   saida = document.getElementById('jform_com_fields_cpf_cnpj');
   saida.maxLength = 14;
   tag1 = document.createAttribute("onkeypress");
   tag1.value = "mascaraMutuario(this,cpfCnpj)";
   saida.setAttributeNode(tag1);
   saida.setAttributeNode(tag1);

   
}
function saida2(){
   saida = document.getElementById('jform_com_fields_cpf_cnpj');
   saida.maxLength = 18;
   tag1 = document.createAttribute("onkeypress");
   tag1.value = "mascaraMutuario(this,cnpj)";
   saida.setAttributeNode(tag1);
   saida.setAttributeNode(tag1);

   
}

function mascaraMutuario(o,f){
    v_obj=o
    v_fun=f
    setTimeout('execmascara()',1)
}
 
function execmascara(){
    v_obj.value=v_fun(v_obj.value)
}
 
function cpfCnpj(v){
 
    //Remove tudo o que não é dígito
    v=v.replace(/\D/g,"")
 
    if (v.length <= 11) { //CPF
 
         v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
         v=v.replace(/(\d{3})(\d)/,"$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
         v=v.replace(/(\d{3})(\d)/,"$1.$2") //Coloca um ponto entre o terceiro e o quarto dígitos
         //de novo (para o segundo bloco de números)
         v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2") //Coloca um hífen entre o terceiro e o quarto dígitos

 
    } else { //CNPJ
 
         v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
         v=v.replace(/^(\d{2})(\d)/,"$1.$2") //Coloca ponto entre o segundo e o terceiro dígitos
         v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
         v=v.replace(/\.(\d{3})(\d)/,".$1/$2") //Coloca uma barra entre o oitavo e o nono dígitos
         v=v.replace(/(\d{4})(\d)/,"$1-$2") //Coloca um hífen depois do bloco de quatro dígitos
 
    }
 
    return v
 
}

function cnpj(v){
 
    //Remove tudo o que não é dígito
    v=v.replace(/\D/g,"")
    //CNPJ
 
         v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
         v=v.replace(/^(\d{2})(\d)/,"$1.$2") //Coloca ponto entre o segundo e o terceiro dígitos
         v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3") //Coloca ponto entre o quinto e o sexto dígitos
         v=v.replace(/\.(\d{3})(\d)/,".$1/$2") //Coloca uma barra entre o oitavo e o nono dígitos
         v=v.replace(/(\d{4})(\d)/,"$1-$2") //Coloca um hífen depois do bloco de quatro dígitos
 
   
 
    return v
 
}

function telefone(v){
v=v.replace(/\D/g,"") //Remove tudo o que não é dígito
v=v.replace(/^(\d\d)(\d)/g,"($1) $2") //Coloca parênteses em volta dos dois primeiros dígitos
v=v.replace(/(\d{5})(\d)/,"$1-$2") //Coloca hífen entre o quarto e o quinto dígitos
return v
}
</script>