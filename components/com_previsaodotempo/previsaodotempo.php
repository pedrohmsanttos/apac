<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

defined('_JEXEC') or die;

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Previsaodotempo', JPATH_COMPONENT);
JLoader::register('PrevisaodotempoController', JPATH_COMPONENT . '/controller.php');


// Execute the task.
$controller = JControllerLegacy::getInstance('Previsaodotempo');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
