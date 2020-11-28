<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class GovernadorModelGovernadores extends JModelList
{

	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'nome',
				'published'
			);
		}
 
		parent::__construct($config);
	}
 
	protected function getListQuery()
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
                ->from($db->quoteName('#__governador'));
		$search = $this->getState('filter.search');
 
		if (!empty($search))
		{
			$like = $db->quote('%' . $search . '%');
			$query->where('nome LIKE ' . $like);
		}
 
		$published = $this->getState('filter.published');
 
		if (is_numeric($published))
		{
			$query->where('published = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(published IN (0, 1))');
		}
 
		$orderCol	= $this->state->get('list.ordering', 'nome');
		$orderDirn 	= $this->state->get('list.direction', 'asc');
 
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
 
		return $query;
	}
}