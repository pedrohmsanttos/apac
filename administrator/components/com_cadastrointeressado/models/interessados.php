<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Cadastrointeressado
 * @author     Lerisson Freitas <lerisson.freitas@inhalt.com.br>
 * @copyright  2019 Lerisson Freitas
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
defined('_JEXEC') or die;

jimport('joomla.application.component.modellist');

/**
 * Methods supporting a list of Cadastrointeressado records.
 *
 * @since  1.6
 */
class CadastrointeressadoModelInteressados extends JModelList
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
				'nome', 'a.nome', 
				'data_criacao', 'a.data_criacao',
				'pertencegoverno', 'a.pertencegoverno',
				'situacao', 'a.situacao',
			);
		}

		parent::__construct($config);
	}

    
    public function getTipoUser()
	{
		$user   = JFactory::getUser();
		$db     = JFactory::getDBO();
		$userid = $user->get('id');
		$groups = JAccess::getGroupsByUser($userid);
		$groupid_list		= '(' . implode(',', $groups) . ')'; 
		$query  = $db->getQuery(true);
		$query->select('id, title');
		$query->from('#__usergroups');
		$query->where('id IN ' .$groupid_list);
		$db->setQuery($query);
		$rows= $db->loadRowList();
		return $rows[0];

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
        parent::populateState('data_criacao', 'DESC');

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
		
		$query->from('"#__cadastrointeressado" AS a');
                
		// Join over the users for the checked out user
		$query->select("uc.name AS uEditor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Join over the user field 'created_by'
		$query->select('"created_by".name AS "created_by"');
		$query->join('LEFT', '#__users AS "created_by" ON "created_by".id = a."created_by"');

		// Join over the user field 'modified_by'
		$query->select('"modified_by".name AS "modified_by"');
		$query->join('LEFT', '#__users AS "modified_by" ON "modified_by".id = a."modified_by"');
                
		// Filter by governo
		$governo = $this->getState('filter.pertencegoverno');
		
		if (!empty($governo) && trim($governo) == 's')
		{
			$query->where('a.pertencegoverno ='."'1'");
			
		}else if (!empty($governo) && trim($governo) == 'n')
		{
			
			$query->where('a.pertencegoverno ='."'0'");
		
		}

		// Filter by Situação
		$situacao = $this->getState('filter.situacao');
		
		if (!empty($situacao) && trim($situacao) == 'ativo')
		{
			$query->where('a.situacao ='."'1'");
			
		}else if (!empty($situacao) && trim($situacao) == 'inativo')
		{
			
			$query->where('a.situacao ='."'0'");
		
		}

		
		// Filter by Boletim
		$boletim = $this->getState('filter.boletins');
		
		if (!empty($boletim) && trim($boletim) == 'noticia')
		{
			$query->where('a.noticias ='."'1'");
			
		}else if (!empty($boletim) && trim($boletim) == 'licitacao')
		{
			
			$query->where('a.licitacoes ='."'1'");
		
		}
		else if (!empty($boletim) && trim($boletim) == 'previsao')
		{
			
			$query->where('a.previsao_tempo ='."'1'");
		
		}
		else if (!empty($boletim) && trim($boletim) == 'avisosM')
		{
			
			$query->where('a.boletim like'."'%".'"meteorologia_avisos":["'."%'"); 
		
		}
		else if (!empty($boletim) && trim($boletim) == 'avisosH')
		{
			
			$query->where('a.boletim like'."'%".'"hidrologia_avisos":["'."%'"); 
		
		}
		else if (!empty($boletim) && trim($boletim) == 'informesM')
		{
			
			$query->where('a.boletim like'."'%".'"meteorologia_informes":["'."%'"); 
		
		}
		else if (!empty($boletim) && trim($boletim) == 'informesH')
		{
			
			$query->where('a.boletim like'."'%".'"hidrologia_informes":["'."%'"); 
		
		}
		
		// Filter by published state
		$published = $this->getState('filter.state');

		if (is_numeric($published))
		{
			$query->where('a.state = ' . (int) $published);
		}
		elseif ($published === '')
		{
			$query->where('(a.state IN (1))');
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
				$query->where('( a.nome LIKE ' . $search . ' )');
			}
		}
                
		// Add the list ordering clause.
		$orderCol  = $this->state->get('list.ordering', 'data_criacao');
		$orderDirn = $this->state->get('list.direction', 'DESC');
		
		if ($orderCol && $orderDirn)
		{
			if (trim($this->getTipoUser()[1])=="Super Users" || trim($this->getTipoUser()[1]) == "Administrator" || trim($this->getTipoUser()[1])=="Comunicação Autorizados"){
				$query->where("(a.confidencial IN ('1','0'))");
			}else{
				$query->where('a.confidencial = ' . "'0'");
			}
			
			$query->order($db->escape($orderCol . ' ' . $orderDirn));
		}

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
                
		foreach ($items as $oneItem)
		{

				// Get the title of every option selected.

				$options = explode(',', $oneItem->observacao);

				$options_text = array();

				foreach ((array) $options as $option)
				{
					$options_text[] = JText::_($option);
				}

				$oneItem->observacao = !empty($options_text) ? implode(',', $options_text) : $oneItem->observacao;

				// Get the title of every option selected.

				$options = explode(',', $oneItem->situacao);

				$options_text = array();

				foreach ((array) $options as $option)
				{	
					if (!empty($option) && $option = 1){
						$options_text[] = JText::_('Ativo');	
					}else{
						$options_text[] = JText::_('Inativo');
					}
				}

				$oneItem->situacao = !empty($options_text) ? implode(',', $options_text) : $oneItem->situacao;

				
				$options = explode(',', $oneItem->data_criacao);

				$options_text = array();

				foreach ((array) $options as $option)
				{	$date = date_create($option);
					$options_text[] = JText::_(date_format($date, 'd/m/Y'));
				
				}

				$oneItem->data_criacao = !empty($options_text) ? implode(',', $options_text) : $oneItem->data_criacao;

				
				// Get the title of every option selected.

				$options = explode(',', $oneItem->noticias);

				$options_text = array();

				foreach ((array) $options as $option)
				{
					if (!empty($option) && $option = 1){
						$options_text[] = JText::_('Sim');	
					}else{
						$options_text[] = JText::_('Não');
					}
				}

				$oneItem->noticias = !empty($options_text) ? implode(',', $options_text) : $oneItem->noticias;

				// Get the title of every option selected.

				$options = explode(',', $oneItem->licitacoes);

				$options_text = array();

				foreach ((array) $options as $option)
				{
					if (!empty($option) && $option = 1){
						$options_text[] = JText::_('Sim');	
					}else{
						$options_text[] = JText::_('Não');
					}
				}

				$oneItem->licitacoes = !empty($options_text) ? implode(',', $options_text) : $oneItem->licitacoes;

				$options = explode(',', $oneItem->pertencegoverno);

				$options_text = array();
				//var_dump( $options_text);die;
				foreach ((array) $options as $option)
				{
					
					if (!empty($option) && $option = 1){
						$options_text[] = JText::_('Sim');	
					}else{
						$options_text[] = JText::_('Não');
					}
				}

				$oneItem->pertencegoverno = !empty($options_text) ? implode(',', $options_text) : $oneItem->pertencegoverno;
		}

		return $items;
	}
}
