<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Set some global property
$document = JFactory::getDocument();

// Access check: is this user allowed to access the backend of this component?
if (!JFactory::getUser()->authorise('core.manage', 'com_avisohidrologico'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Require helper file
JLoader::register('AvisohidrologicoHelper', JPATH_COMPONENT . '/helpers/avisohidrologico.php');

// Get an instance of the controller prefixed by Avisohidrologico
$controller = JControllerLegacy::getInstance('Avisohidrologico');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
