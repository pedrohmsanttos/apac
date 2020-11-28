<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Informehidrologico
 * @author     Matheus Felipe <matheusfelipe.moreira@gmail.com>
 * @copyright  2018 Matheus Felipe
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Informehidrologico records.
 *
 * @since  1.6
 */
class InformehidrologicoModelInformehidrologicos extends JModelList
{
    
/**
	* Constructor.
	*
	* @param   array  $config  An optional associative array of configuration settings.
	*
	* @see        JController
	* @since      1.6
	*/
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id', 'a.id',
				'ordering', 'a.ordering',
				'state', 'a.state',
				'created_by', 'a.created_by',
				'modified_by', 'a.modified_by',
				'titulo', 'a.titulo',
				'tipo', 'a.tipo',
				'observacao', 'a.observacao',
				'tags', 'a.tags',
				'arquivo', 'a.arquivo',
				'publicacao', 'a.publicacao',
			);
		}

		parent::__construct($config);
	}
        
	/**
	 * Method to auto-populate the model state.
	 *
	 * Note. Calling getState in this method will result in recursion.
	 *
	 * @param   string  $ordering   Elements order
	 * @param   string  $direction  Order direction
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function populateState($ordering = null, $direction = null)
	{
		
		// Initialise variables.
		$app = JFactory::getApplication('administrator');

		// Load the filter state.
		$search = $app->getUserStateFromRequest($this->context . '.filter.search', 'filter_search');
		$this->setState('filter.search', $search);

		$published = $app->getUserStateFromRequest($this->context . '.filter.state', 'filter_published', '', 'string');
		$this->setState('filter.state', $published);
		
		// Load the parameters.
		$params = JComponentHelper::getParams('com_informehidrologico');
		$this->setState('params', $params);

		// List state information.
		parent::populateState('a.id', 'asc');
	}

	/**
	 * Method to get a store id based on model configuration state.
	 *
	 * This is necessary because the model is used by the component and
	 * different modules that might need different sets of data or different
	 * ordering requirements.
	 *
	 * @param   string  $id  A prefix for the store id.
	 *
	 * @return   string A store id.
	 *
	 * @since    1.6
	 */
	protected function getStoreId($id = '')
	{
		// Compile the store id.
		$id .= ':' . $this->getState('filter.search');
		$id .= ':' . $this->getState('filter.state');

		return parent::getStoreId($id);                
	}

	/**
	 * Build an SQL query to load the list data.
	 *
	 * @return   JDatabaseQuery
	 *
	 * @since    1.6
	 */
	protected function getListQuery()
	{
		// Create a new query object.
		$db    = $this->getDbo();
		$query = $db->getQuery(true);

		// Select the required fields from the table.
		$query->select(
			$this->getState(
				'list.select', 'DISTINCT a.*'
			)
		);
		$query->from('#__informehidrologico AS a');
                
		// Join over the users for the checked out user
		$query->select("uc.name AS uEditor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		$query->select(' le.enviado AS "enviado"')
			->join('LEFT', $db->quoteName('lista_emails', 'le') . ' ON a.id = le.id_item');

		// Join over the user field 'modified_by'
		$query->select('modified_by.name AS modified_by');
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
                

		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (0, 1))');
		}

		// Filter by search in title
		$search = $this->getState('filter.search');

		if (!empty($search))
		{
			if (stripos($search, 'id:') === 0)
			{
				$query->where('a.id = ' . (int) substr($search, 3));
			}
			else
			{
				$search = $db->Quote('%' . $db->escape($search, true) . '%');
				$query->where('a.titulo ILIKE ' . $search);				
			}
		}

		// Filter by status
		$tipo = $this->getState('filter.tipo');
 
		if (is_numeric($tipo))
		{
			$query->where('a.tipo = \'' . $tipo.'\'', 'AND');
		}

		// Filter: like / tags
		$tags = $this->getState('filter.tags');
		
		if (!empty($tags))
		{
			$like = '';
			foreach($tags as $index => $value){
				if($index == 0){
					$like .= "'%".$value."%";
				}else{
					$like .= $value."%";
				}
			}
			$like .= "'";
			$query->where('a.tags LIKE ' . $like, 'AND');
		}

		// Filter: autor
		$autor = $this->getState('filter.autor');
 
		if (!empty($autor))
		{
			$query->where('a.created_by = ' . $autor , 'AND');
		}

		$enviado = $this->getState('filter.enviado');

		if (!empty($enviado) && trim($enviado) == 's')
		{
			$query->where('le.enviado = 1');
			
		}else if (!empty($enviado) && trim($enviado) == 'n')
		{
			$query->where('(le.enviado is null OR le.enviado = 0)');
		
		}

		// Filter: date
		$inicio = $this->getState('filter.dta_ini');
		$fim = $this->getState('filter.dta_end');
		$agora_date = new DateTime();
		$agora_date = $agora_date->format('Y-m-d');
		$fim_date   = new DateTime($fim);
		$fim_date->add(new DateInterval('P1D'));
		$ini_date   = new DateTime($inicio);

		if($inicio == '' && $fim != ''){
			$query->where("a.publicacao < '".$fim."'");
		} else if( (strtotime($agora_date) < strtotime($fim_date)) || (strtotime($fim_date) < strtotime($ini_date)) ) {
			// data fora do range
			$fim = $agora_date->format('Y-m-d');
			$inicio = $inicio;
			$query->where("a.publicacao between  '". $ini_date->format('Y-m-d')  ."' and '" . $fim ."'");
		} else if($inicio != '' && $fim != '') {
			$fim    = $this->manipulaData($fim, 1);
			$inicio = $inicio;
			$query->where("a.publicacao between  '". $ini_date->format('Y-m-d') ."' and '" . $fim_date->format('Y-m-d') ."'");
		}
                
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering');
		$orderDirn = $this->state->get('list.direction');

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		// echo $query->__toString();die;

		return $query;
	}

	/**
	 * Get an array of data items
	 *
	 * @return mixed Array of data items on success, false on failure.
	 */
	public function getItems()
	{
		$items = parent::getItems();
                

		return $items;
	}

	public function manipulaData($str, $dias = 0)
	{
			if(empty($str)) return '';
			$pieces = explode("-", $str);
			return $pieces[2] + $dias.'-'.$pieces[1].'-'.$pieces[0];
	}
}
