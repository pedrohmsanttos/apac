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
<fieldset class="fieldset" id="users-profile-core">
   <table class="table table-hover">
      <thead>
         <tr>
            <th scope="col">Campos</th>
            <th scope="col">Dados</th>
         </tr>
      </thead>
      <tbody>
         <tr>
            <th scope="row"><?php echo JText::_('COM_USERS_PROFILE_NAME_LABEL'); ?> </th>
            <td>
               <?php echo $this->data->name; ?>
            </td>
         </tr>
         <tr>
            <th scope="row"><?php echo JText::_('COM_USERS_PROFILE_USERNAME_LABEL'); ?></th>
            <td>
               <?php echo htmlspecialchars($this->data->username, ENT_COMPAT, 'UTF-8'); ?>
            </td>
         </tr>
         <tr>
            <th scope="row"><?php echo JText::_('COM_USERS_PROFILE_REGISTERED_DATE_LABEL'); ?></th>
            <td>
               <?php echo JHtml::_('date', $this->data->registerDate, JText::_('DATE_FORMAT_LC1')); ?>
            </td>
         </tr>
         <tr>
            <th scope="row"><?php echo JText::_('COM_USERS_PROFILE_LAST_VISITED_DATE_LABEL'); ?></th>
            <?php if ($this->data->lastvisitDate != $this->db->getNullDate()) : ?>
            <td>
               <?php echo JHtml::_('date', $this->data->lastvisitDate, JText::_('DATE_FORMAT_LC1')); ?>
            </td>
            <?php else : ?>
            <td>
               <?php echo JText::_('COM_USERS_PROFILE_NEVER_VISITED'); ?>
            </td>
            <?php endif; ?>
         </tr>
	
</fieldset>