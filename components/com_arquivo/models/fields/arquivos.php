<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');

class JFormFieldArquivo extends JFormFieldList
{
	protected $type = 'Arquivo';
 
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,titulo');
		$query->from('#__arquivo');
		$db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();
 
		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->id, $message->greeting);
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}