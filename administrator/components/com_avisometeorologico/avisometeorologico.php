<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Set some global property
$document = JFactory::getDocument();

// Access check: is this user allowed to access the backend of this component?
if (!JFactory::getUser()->authorise('core.manage', 'com_avisometeorologico'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Require helper file
JLoader::register('AvisometeorologicoHelper', JPATH_COMPONENT . '/helpers/avisometeorologico.php');

// Get an instance of the controller prefixed by Avisometeorologico
$controller = JControllerLegacy::getInstance('Avisometeorologico');

// Perform the Request task
$controller->execute(JFactory::getApplication()->input->get('task'));

// Redirect if set by the controller
$controller->redirect();
