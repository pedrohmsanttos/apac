<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');

class JFormFieldAgenda extends JFormFieldList
{
	
	protected $type = 'Agenda';
 
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from('#__agenda');
		$db->setQuery((string) $query);
		$eventos = $db->loadObjectList();
		$options  = array();
 
		if ($eventos)
		{
			foreach ($eventos as $evento)
			{
				$options[] = JHtml::_('select.option', $evento->id, $evento->titulo);
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}