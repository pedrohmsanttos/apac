<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AgendaModelAgendas extends JModelList
{

	/**
	 * Constructor.
	 *
	 * @param   array  $config  An optional associative array of configuration settings.
	 *
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'titulo',
				'published'
			);
		}
 
		parent::__construct($config);
	}
 
	protected function getListQuery()
	{

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		// if(empty($this->getState('filter.search')) ) {

			$query->select('*');
			$query->from('#__agenda');

		// } else {
		
		// 	// Create the base select statement.
		// 	$query->select('*')
		// 			->from($db->quoteName('#__agenda'));
	
	
		// 	// Filter: like / search
		// 	$search = $this->getState('filter.search');
	
		// 	if (!empty($search))
		// 	{
		// 		$like = $db->quote('%' . $search . '%');
		// 		$query->where('titulo LIKE ' . $like);
		// 	}
	
		// 	// Filter by published state
		// 	$published = $this->getState('filter.published');
	
		// 	if (is_numeric($published))
		// 	{
		// 		$query->where('published = ' . (int) $published);
		// 	}
		// 	elseif ($published === '')
		// 	{
		// 		$query->where('(published IN (0, 1))');
		// 	}
	
		// 	// Add the list ordering clause.
		// 	$orderCol	= $this->state->get('list.ordering', 'titulo');
		// 	$orderDirn 	= $this->state->get('list.direction', 'asc');
	
		// 	$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
		
		// }

		return $query;
	}
}