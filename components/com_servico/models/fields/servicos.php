<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
JFormHelper::loadFieldClass('list');

class JFormFieldServico extends JFormFieldList
{
	protected $type = 'Servico';
 
	protected function getOptions()
	{
		$db    = JFactory::getDBO();
		$query = $db->getQuery(true);
		$query->select('s.id as id, s.titulo,c.title as category, s.catid');		$query->from('#__servico', 's');
		$query->leftJoin('#__categories as c on s.catid = c.id');		// Retrieve only published items		$query->where('#__servico.published = 1');		$db->setQuery((string) $query);
		$servicos = $db->loadObjectList();
		$options  = array();
 
		if ($servicos)
		{
			foreach ($servicos as $servico)
			{
				$options[] = JHtml::_('select.option', $servico->id, $servico->titulo .	($servico->catid ? ' (' . $servico->category . ')' : ''));			
			}
		}
 
		$options = array_merge(parent::getOptions(), $options);
 
		return $options;
	}
}