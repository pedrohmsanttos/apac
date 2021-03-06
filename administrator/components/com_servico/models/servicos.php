<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ServicoModelServicos extends JModelList
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
				'subtitulo',
				'published',
				'ordering'
			);
		}
 
		parent::__construct($config);
	}
 
	protected function getListQuery()
	{

		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
 
		// Create the base select statement.
		$query->select('*')
                ->from($db->quoteName('#__servico'));
 
 
 		// Filter: like / search
		$search = $this->getState('filter.search');
 
		if (!empty($search))
		{
			$like = $db->quote('%' . $search . '%');
			$query->where('titulo LIKE ' . $like);
		}
 
		// Filter by published state
		$published = $this->getState('filter.published');
 
		if (is_numeric($published))
		{
			$query->where('published = ' . (int) $published);
		}
		else if($published != '*')
		{
			$query->where('published IN (0, 1)');
		}

		$tipo = $this->getState('filter.tipo');
 
		if (is_numeric($tipo))
		{
			$query->where('catid = ' . (int) $tipo, 'AND');
		}
 
		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'id');
		$orderDirn 	= $this->state->get('list.direction', 'asc');
 
		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));
 
		return $query;
	}
}