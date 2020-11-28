<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JLoader::register('PrefeituraHelper', JPATH_COMPONENT . '/helpers/prefeitura.php');
 
$controller = JControllerLegacy::getInstance('Prefeitura');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();