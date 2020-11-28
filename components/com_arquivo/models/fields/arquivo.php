<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_arquivo
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');
 
/**
 * Arquivo Form Field class for the Arquivo component
 *
 * @since  0.0.1
 */
class JFormFieldArquivo extends JFormFieldList
{
	/**
	 * The field type.
	 *
	 * @var         string
	 */
	protected $type = 'Arquivo';
 
	/**
	 * Method to get a list of options for a list input.
	 *
	 * @return  array  An array of JHtml options.
	 */
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('#__arquivo.id as id,titulo,#__categories.title as category,catid');		$query->from('#__arquivo');
		$query->leftJoin('#__categories on catid=#__categories.id');		// Retrieve only published items		$query->where('#__arquivo.published = 1');		$db->setQuery((string) $query);
		$arquivos = $db->loadObjectList();
		$options  = array();
 
		if ($arquivos)
		{
			foreach ($arquivos as $arquivo)
			{
				$options[] = JHtml::_('select.option', $arquivo->id, $arquivo->titulo .				                      ($arquivo->catid ? ' (' . $arquivo->category . ')' : ''));			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}