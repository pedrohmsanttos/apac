<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Previsaodotempo helper.
 *
 * @since  1.6
 */
class PrevisaodotempoHelper
{
	/**
	 * Configure the Linkbar.
	 *
	 * @param   string  $vName  string
	 *
	 * @return void
	 */
	public static function addSubmenu($vName = '')
	{
		JHtmlSidebar::addEntry(
			JText::_('Previsões'),
			'index.php?option=com_previsaodotempo&view=previsoes',
			$vName == 'previsoes'
		);

		JHtmlSidebar::addEntry(
			JText::_('Mesorregiões'),
			'index.php?option=com_previsaodotempo&view=mesorregioes',
			$vName == 'mesoregioes'
		);

		JHtmlSidebar::addEntry(
			JText::_('Variáveis'),
			'index.php?option=com_previsaodotempo&view=variaveis',
			$vName == 'variaveis'
		);

		JHtmlSidebar::addEntry(
			JText::_('Variáveis - Valores'),
			'index.php?option=com_previsaodotempo&view=valores',
			$vName == 'valores'
		);

		JHtmlSidebar::addEntry(
			JText::_('Ícones'),
			'index.php?option=com_previsaodotempo&view=icones',
			$vName == 'icones'
		);
	}

	/**
	 * Gets the files attached to an item
	 *
	 * @param   int     $pk     The item's id
	 *
	 * @param   string  $table  The table's name
	 *
	 * @param   string  $field  The field's name
	 *
	 * @return  array  The files
	 */
	public static function getFiles($pk, $table, $field)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query
			->select($field)
			->from($table)
			->where('id = ' . (int) $pk);

		$db->setQuery($query);

		return explode(',', $db->loadResult());
	}

	/**
	 * Gets a list of the actions that can be performed.
	 *
	 * @return    JObject
	 *
	 * @since    1.6
	 */
	public static function getActions()
	{
		$user   = JFactory::getUser();
		$result = new JObject;

		$assetName = 'com_previsaodotempo';

		$actions = array(
			'core.admin', 'core.manage', 'core.create', 'core.edit', 'core.edit.own', 'core.edit.state', 'core.delete'
		);

		foreach ($actions as $action)
		{
			$result->set($action, $user->authorise($action, $assetName));
		}

		return $result;
	}
}

