<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_previsaodotempo'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Previsaodotempo', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('PrevisaodotempoHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'previsaodotempo.php');

$controller = JControllerLegacy::getInstance('Previsaodotempo');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
