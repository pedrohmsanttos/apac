<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

require_once 'agenda_helper_class.php';
require_once 'helper.php';

$controller = JControllerLegacy::getInstance('Agenda');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
