<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JLoader::register('SecretarioHelper',  __DIR__.DIRECTORY_SEPARATOR.'helpers'.DIRECTORY_SEPARATOR.'secretario.php');

// Get an instance of the controller prefixed by Secretaria
$controller = JControllerLegacy::getInstance('Secretario');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
