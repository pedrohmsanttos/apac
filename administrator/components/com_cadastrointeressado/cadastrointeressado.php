<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Cadastrointeressado
 * @author     Lerisson Freitas <lerisson.freitas@inhalt.com.br>
 * @copyright  2019 Lerisson Freitas
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_cadastrointeressado'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Cadastrointeressado', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('CadastrointeressadoHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'cadastrointeressado.php');

$controller = JControllerLegacy::getInstance('Cadastrointeressado');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
