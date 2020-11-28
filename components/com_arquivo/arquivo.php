<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JLoader::register('ArquivoHelper', JPATH_COMPONENT . '/helpers/arquivo.php');
 
$controller = JControllerLegacy::getInstance('Arquivo');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();