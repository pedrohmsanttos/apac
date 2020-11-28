<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldPrefeitura extends JFormFieldList
{
	protected $type = 'Prefeitura';
 
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,nome');
		$query->from('#__prefeitura');
		$db->setQuery((string) $query);
		$prefeituras = $db->loadObjectList();
		$options  = array();
 
		if ($prefeituras)
		{
			foreach ($prefeituras as $prefeitura)
			{
				$options[] = JHtml::_('select.option', $prefeitura->id, $prefeitura->nome);
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}