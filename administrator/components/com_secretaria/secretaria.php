<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JLoader::register('SecretariaHelper', JPATH_COMPONENT . '/helpers/secretaria.php');

require_once 'helper.php';
 
// Get an instance of the controller prefixed by Secretaria
$controller = JControllerLegacy::getInstance('Secretaria');
 
// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));
 
// Redirect if set by the controller
$controller->redirect();