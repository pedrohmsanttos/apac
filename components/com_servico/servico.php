<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JLoader::register('ArquivoHelper', JPATH_COMPONENT . '/helpers/servico.php');

require_once 'helper.php';

$controller = JControllerLegacy::getInstance('Servico');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();