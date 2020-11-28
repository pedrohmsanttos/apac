<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('formbehavior.chosen', 'select');
JLoader::register('ArquivoHelper',  __DIR__.DIRECTORY_SEPARATOR.'arquivo_helper_class.php');
require_once 'arquivo_helper_class.php';

$controller = JControllerLegacy::getInstance('Arquivo');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
