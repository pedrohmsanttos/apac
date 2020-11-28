<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldAvisometeorologico extends JFormFieldList
{

	protected $type = 'Avisometeorologico';

	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('id,identificador,titulo');
		$query->from('#__avisometeorologico');
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
