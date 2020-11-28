<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Licitacoes
 * @author     Pedro Santos <phmsanttos@gmail.com>
 * @copyright  2018 Pedro Santos
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Licitacoes records.
 *
 * @since  1.6
 */
class LicitacoesModelLicitacoes extends JModelList
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
				'publicado', 'a.publicado',
				'titulo', 'a.titulo',
				'resumo', 'a.resumo',
				'data_licitacao', 'a.data_licitacao',
				'numero_processo', 'a.numero_processo',
				'ano_processo', 'a.ano_processo',
				'modalidade', 'a.modalidade',
				'numero_modalidade', 'a.numero_modalidade',
				'ano_modalidade', 'a.ano_modalidade',
				'objeto', 'a.objeto',
				'data_publicacao', 'a.data_publicacao',
				'nome_modalidade', 'modalidade_licitacao.nome'
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
        // List state information.
        parent::populateState('a.ordering', 'asc');

        $context = $this->getUserStateFromRequest($this->context . '.context', 'context', 'com_content.article', 'CMD');
        $this->setState('filter.context', $context);

        // Split context into component and optional section
        $parts = FieldsHelper::extract($context);

        if ($parts)
        {
            $this->setState('filter.component', $parts[0]);
            $this->setState('filter.section', $parts[1]);
        }
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
		$query->from('#__licitacoes AS a');
                
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

		$query->select('modalidade_licitacao.nome AS nome_modalidade');
		$query->join('LEFT', '#__modalidade_licitacao AS modalidade_licitacao ON modalidade_licitacao.id::varchar  = a.modalidade');
                

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


		$numero_processo = $this->getState('filter.numero_processo');

		if (trim($numero_processo) != "")
		{
			$query->where("a.numero_processo = '" . $numero_processo ."'");
		}
		

		$ano_processo = $this->getState('filter.ano_processo');

		if (is_numeric($ano_processo))
		{
			$query->where("a.ano_processo = '" . (int) $ano_processo ."'");
		}

		$autor = $this->getState('filter.autor');

		if (is_numeric($autor))
		{
			$query->where("created_by.id = " . (int) $autor);
		}

		$modalidade = $this->getState('filter.modalidade');

		if (is_numeric($modalidade))
		{
			$query->where("a.modalidade = '" . (int) $modalidade ."'");
		}

		$data_licitacao = $this->getState('filter.data_licitacao');
		//var_dump($data_licitacao);die();
		if ( !empty( $data_licitacao) && $data_licitacao != '0000-00-00 00:00:00' )
		{
			$query->where("a.data_licitacao = '" . $data_licitacao . "'");
		}
		
		$data_publicacao = $this->getState('filter.data_publicacao');

		if ( !empty( $data_publicacao) && $data_publicacao != '0000-00-00 00:00:00')
		{
			$query->where("a.data_publicacao = '" . $data_publicacao . "'");
		}

		
		$objeto = $this->getState('filter.objeto_processo');

		if ( !empty( $objeto ))
		{
			$query->where("a.resumo LIKE '%" . $objeto . "%'");
		}


		$enviado = $this->getState('filter.enviado');

		if (!empty($enviado) && trim($enviado) == 's')
		{
			$query->where('le.enviado = 1');
			
		}else if (!empty($enviado) && trim($enviado) == 'n')
		{
			$query->where('(le.enviado is null OR le.enviado = 0)');
		
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
				$query->where('a.titulo ilike ' . $search);
				
			}
		}

		// echo $query->__toString();
		// var_dump($search);die;

		// echo "SEARCH ::: " . $search;die;
                
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', "a.id");
		$orderDirn = $this->state->get('list.direction', "ASC");

		if ($orderCol && $orderDirn)
		{
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

		//  echo $query->__toString();die;

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
}
