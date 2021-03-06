<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldAviso extends JFormFieldList
{

	protected $type = 'Aviso';

	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,identificador,titulo');
		$query->from('#__aviso');
		$db->setQuery((string) $query);
		$messages = $db->loadObjectList();
		$options  = array();

		if ($messages)
		{
			foreach ($messages as $message)
			{
				$options[] = JHtml::_('select.option', $message->id, $message->identificador);
			}
		}

		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}

}
