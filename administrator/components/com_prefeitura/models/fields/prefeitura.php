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
		$query->select('#__prefeitura.id as id,nome,#__categories.title as category,catid');		$query->from('#__prefeitura');
		$query->leftJoin('#__categories on catid=#__categories.id');		// Retrieve only published items		$query->where('#__prefeitura.published = 1');		$db->setQuery((string) $query);
		$prefeituras = $db->loadObjectList();
		$options  = array();
 
		if ($prefeituras)
		{
			foreach ($prefeituras as $prefeitura)
			{
				$options[] = JHtml::_('select.option', $prefeitura->id, $prefeitura->nome .				                      ($prefeitura->catid ? ' (' . $prefeitura->category . ')' : ''));			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}