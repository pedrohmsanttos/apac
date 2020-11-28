<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_informemeteorologico
 * @author     Matheus Felipe <matheusfelipe.moreira@gmail.com>
 * @copyright  2018 Matheus Felipe
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_informemeteorologico'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Informemeteorologico', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('InformemeteorologicoHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'informemeteorologico.php');

$controller = JControllerLegacy::getInstance('Informemeteorologico');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
