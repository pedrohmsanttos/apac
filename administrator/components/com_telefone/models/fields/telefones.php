<?php
/*
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');
 
class JFormFieldTelefone extends JFormFieldList
{
	protected $type = 'Telefone';
 
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__telefone');
		$db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();
 
		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->id, $message->descricao);
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}
*/

/**
 * @package     Joomla.Administrator
 * @subpackage  com_telefone
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');
 
/**
 * telefone Form Field class for the telefone component
 *
 * @since  0.0.1
 */
class JFormFieldTelefone extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Telefone';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('#__telefone.id as id,descricao,#__categories.title as categoria,catid');
		$query->from('#__telefone');
		$query->leftJoin('#__categories on catid=#__categories.id');
		// Retrieve only published items
		$query->where('#__telefone.published = 1');
		$db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();
 
		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->id, $message->descricao .
				                      ($message->catid ? ' (' . $message->category . ')' : ''));
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}