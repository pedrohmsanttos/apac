<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisoModelAvisos extends JModelList
{

	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'titulo',
				'identificador',
				'ordering', 'ordering',
				'published'
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
								->from($db->quoteName('#__aviso'));

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
		elseif ($published === '')
		{
			$query->where('(published IN (0, 1))');
		}

		// Add the list ordering clause.
		$orderCol	= $this->state->get('list.ordering', 'ordering');
		$orderDirn 	= $this->state->get('list.direction', 'asc');

		$saveOrder = $listOrder == 'ordering';

		$query->order($db->escape($orderCol) . ' ' . $db->escape($orderDirn));

		if ($saveOrder)
		{
		    $saveOrderingUrl = 'index.php?option=com_aviso&task=aviso.saveOrderAjax&tmpl=component';
		    JHtml::_('sortablelist.sortable', 'itemList', 'adminForm', strtolower($listDirn), $saveOrderingUrl);
		}

		// $query->order($db->escape($this->getState('list.ordering', 'ordering')).' '.$db->escape($this->getState('list.direction', 'ASC')));

		return $query;
	}
	protected function populateState($ordering = null, $direction = null)
	{
		parent::populateState('ordering', 'ASC');
  }
	protected function getSortFields()
	{
		return array(
			'a.ordering'     => JText::_('JGRID_HEADING_ORDERING'),
			'a.state'        => JText::_('JSTATUS'),
			'a.title'        => JText::_('JGLOBAL_TITLE'),
			'category_title' => JText::_('JCATEGORY'),
			'access_level'   => JText::_('JGRID_HEADING_ACCESS'),
			'a.created_by'   => JText::_('JAUTHOR'),
			'language'       => JText::_('JGRID_HEADING_LANGUAGE'),
			'a.created'      => JText::_('JDATE'),
			'a.id'           => JText::_('JGRID_HEADING_ID'),
			'a.featured'     => JText::_('JFEATURED')
		);
	}
}
