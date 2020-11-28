<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Informehidrologico
 * @author     Matheus Felipe <matheusfelipe.moreira@gmail.com>
 * @copyright  2018 Matheus Felipe
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Informehidrologico', JPATH_COMPONENT);
JLoader::register('InformehidrologicoController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Informehidrologico');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
