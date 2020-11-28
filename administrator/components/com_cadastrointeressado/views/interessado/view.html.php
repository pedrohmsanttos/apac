<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Cadastrointeressado
 * @author     Lerisson Freitas <lerisson.freitas@inhalt.com.br>
 * @copyright  2019 Lerisson Freitas
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View to edit
 *
 * @since  1.6
 */
class CadastrointeressadoViewInteressado extends JViewLegacy
{
	protected $state;

	protected $item;

	protected $form;
	protected $AvisosMeteorologicos; 
	protected $AvisosHidrologicos;
	protected $informesMeteorologicos;
	protected $informesHidrologicos;
	protected $tipoUser;

	/**
	 * Display the view
	 *
	 * @param   string  $tpl  Template name
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	public function display($tpl = null)
	{
		$this->state = $this->get('State');
		$this->item  = $this->get('Item');
		$this->form  = $this->get('Form');
		$this->avisosMeteorologicos = $this->getAvisosMeteorologicos();
		$this->avisosHidrologicos = $this->getAvisosHidrologicos();
		$this->informesMeteorologicos = $this->getInformesMeteorologicos();
		$this->informesHidrologicos = $this->getInformesHidrologicos();
		$this->tipoUser = $this->getTipoUser();
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		$this->addToolbar();
		parent::display($tpl);
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

	public function getAvisosMeteorologicos($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('id, extension,title,alias');
		$query->from($db->quoteName('#__categories'));
		$query->where('extension = ' . $db->q('com_avisometeorologico'), 'and');
    	$query->where('published = ' . $db->q('1'));
		
		
		
		//var_dump($query);die;
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		
		return $results;
	}

	public function getAvisosHidrologicos($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('id, extension,title,alias');
		$query->from($db->quoteName('#__categories'));
		$query->where('extension = ' . $db->q('com_avisohidrologico'), 'and');
    	$query->where('published = ' . $db->q('1'));
				
		
		
		
		//var_dump($query);die;
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();
		//var_dump($results);die;
		
		return $results;
	}

	public function getInformesMeteorologicos($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('id, extension,title,alias');
		$query->from($db->quoteName('#__categories'));
		$query->where('extension = ' . $db->q('com_informemeteorologico'), 'and');
    	$query->where('published = ' . $db->q('1'));
	
		
		
		//var_dump($query);die;
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		
		return $results;
	}

	public function getInformesHidrologicos($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('id, extension,title,alias');
		$query->from($db->quoteName('#__categories'));
		$query->where('extension = ' . $db->q('com_informehidrologico'), 'and');
    	$query->where('published = ' . $db->q('1'));
	
	
		
		
		//var_dump($query);die;
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		
		return $results;
	}

	
	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @throws Exception
	 */
	protected function addToolbar()
	{
		JFactory::getApplication()->input->set('hidemainmenu', true);

		$user  = JFactory::getUser();
		$isNew = ($this->item->id == 0);

		if (isset($this->item->checked_out))
		{
			$checkedOut = !($this->item->checked_out == 0 || $this->item->checked_out == $user->get('id'));
		}
		else
		{
			$checkedOut = false;
		}

		$canDo = CadastrointeressadoHelper::getActions();

		JToolBarHelper::title(JText::_('COM_CADASTROINTERESSADO_TITLE_INTERESSADO'), 'interessado.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create'))))
		{
			JToolBarHelper::apply('interessado.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('interessado.save', 'JTOOLBAR_SAVE');
		}

		if (!$checkedOut && ($canDo->get('core.create')))
		{
			JToolBarHelper::custom('interessado.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create'))
		{
			JToolBarHelper::custom('interessado.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}

		// Button for version control
		if ($this->state->params->get('save_history', 1) && $user->authorise('core.edit')) {
			JToolbarHelper::versions('com_cadastrointeressado.interessado', $this->item->id);
		}

		if (empty($this->item->id))
		{
			JToolBarHelper::cancel('interessado.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			JToolBarHelper::cancel('interessado.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
