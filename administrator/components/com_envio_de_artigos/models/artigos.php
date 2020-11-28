<?php
/**
 * @version     1.0.0
 * @package     com_envio_de_artigos_1.0.0
 * @copyright   Copyright (C) 2018. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Matheus Felipe <matheus.felipe@inhalt.com.br> - https://www.developer-url.com
 */

defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Envio_de_artigos model
 */
class Envio_de_artigosModelArtigos extends JModelList
{
	/**
	 * @var		int		An array with the filtering columns
	 */
	protected	$filter_fields	= null;
	
    /**
     * Constructor
     *
     * @param    array    		An optional associative array of configuration settings
	 *
     * @see      JController
     * @since    1.6
     */
    public function __construct($config = array())
    {
        if (empty($config['filter_fields']))
        {
            $config['filter_fields'] = array(
				'id', 'c.id',
				'title', 'c.title',
				'enviado', 'enviado',
            );
        }

        parent::__construct($config);
    }

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return	JDatabaseQuery
	 * @since	1.6
	 */
	protected function getListQuery()
	{
		$query	= $this->_db->getQuery(true);

		$query->select('c.id, c.title');
		$query->from('#__content AS c');
		
		$query->select('le.enviado AS "enviado"')
			->join('LEFT', $this->_db->qn('lista_emails', 'le') . ' ON c.id = le.id_item AND le.tipo_item = \'ARTIGO\'');
			
		$query->where($this->_db->qn('c.state') . ' = 1');
		
		// Search for this word
		$searchWord = $_POST['filter_search'];

		// Search in these columns
		$searchColumns = array(
            'c.title',
			'c.id'
        );
		$db = JFactory::getDbo();
		if (!empty($searchWord))
		{
			if (stripos($searchWord, 'id:') === 0)
			{
				// Build the ID search
				$idPart = (int) substr($searchWord, 3);
				$query->where($this->_db->qn('c.id') . ' = ' . $this->_db->q($idPart));
			}
			else
			{
				// Build the search query from the search word and search columns
				$search = $this->_db->qn('%' . $searchWord. '%');
				$query->where('c.title ilike \'%'.$searchWord.'%\'');
			}
		}

		// Filter by published state
		$published = $_POST['filter_published'];
		
		if (!empty($published) && trim($published) == '1')
		{
			$query->where('le.enviado = 1');
			
		}else if (!empty($enviado) && trim($enviado) == '0')
		{
			$query->where('(le.enviado is null OR le.enviado = 0)');
		}

		// Add the list ordering clause
        $orderCol	= $this->state->get('list.ordering');
        $orderDirn	= $this->state->get('list.direction');

        if ($orderCol && $orderDirn)
        {
            $query->order($this->_db->escape($orderCol.' '.$orderDirn));
        }

		
		return $query;
	}

	/** Method to get an array of data items
	 *
	 * @return  mixed An array of data on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();

		include_once JPATH_COMPONENT_ADMINISTRATOR . '/helpers/form/artigo.php';

		$form = new FormArtigoEnvio_de_artigos;

		$fieldOptions = $form->getFieldOptions();

		foreach ($items as $i => $item)
		{
			foreach ($item as $key => $value)
			{
				// Don't apply to the state
				if ($key == 'state')
				{
					continue;
				}

				// If this field has options
				if (isset($fieldOptions[$key]))
				{
					// Update the item key with the field option
					$item->{$key} = JText::_($fieldOptions[$key][$value]);
				}
			}

			$items[$i] = $item;
		}

		return $items;
	}
}
