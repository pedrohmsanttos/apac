<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Licitacoes
 * @author     Pedro Santos <phmsanttos@gmail.com>
 * @copyright  2018 Pedro Santos
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access
defined('_JEXEC') or die;

// Access check.
if (!JFactory::getUser()->authorise('core.manage', 'com_licitacoes'))
{
	throw new Exception(JText::_('JERROR_ALERTNOAUTHOR'));
}

// Include dependancies
jimport('joomla.application.component.controller');

JLoader::registerPrefix('Licitacoes', JPATH_COMPONENT_ADMINISTRATOR);
JLoader::register('LicitacoesHelper', JPATH_COMPONENT_ADMINISTRATOR . DIRECTORY_SEPARATOR . 'helpers' . DIRECTORY_SEPARATOR . 'licitacoes.php');

$controller = JControllerLegacy::getInstance('Licitacoes');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
