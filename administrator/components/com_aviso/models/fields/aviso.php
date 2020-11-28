<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_aviso
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

/**
 * Aviso Form Field class for the Aviso component
 *
 * @since  0.0.1
 */
class JFormFieldAviso extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Aviso';

	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('#__aviso.id as id,identificador,#__categories.title as category,catid');
		$query->from('#__aviso');
		$query->leftJoin('#__categories on catid=#__categories.id');
		// Retrieve only published items
		$query->where('#__aviso.published = 1');
		$db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();

		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->id, $message->identificador .
				                      ($message->catid ? ' (' . $message->category . ')' : ''));
			}
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
