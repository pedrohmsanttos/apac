<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
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
class PrevisaodotempoViewPrevisao extends JViewLegacy
{
	protected $state;

	protected $item;

	protected $form;

	protected $mesorregioes;

	protected $variaveis;

	protected $icones;

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
		$this->state        = $this->get('State');
		$this->item         = $this->get('Item');
		$this->form         = $this->get('Form');
		$this->mesorregioes = $this->getMesorregioes();
		$this->variaveis    = $this->getVariaveis();
		$this->icones       = $this->getIcones();

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}
		
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Get all mesorregiões
	 *
	 * @param   int  $state  state value
	 *
	 * @return Messoregiões
	 *
	 * @throws Exception
	 */
	public function getMesorregioes($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('*');
		$query->from($db->quoteName('#__previsaodotempo_mesorregiao'));
		if($state)
		{
			$query->where($db->quoteName('state') . ' =  1');
		}
		
		$query->order('ordering ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();
		
		return $results;
	}

	/**
	 * Get all ícones
	 *
	 * @param   int  $state  state value
	 *
	 * @return Icones
	 *
	 * @throws Exception
	 */
	public function getIcones($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user icone table where state or null.
		// Order it by the ordering field.
		$query->select('*');
		$query->from($db->quoteName('#__previsaodotempo_icone'));
		if($state)
		{
			$query->where($db->quoteName('state') . ' =  1');
		}
		
		$query->order('ordering ASC');

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();
		
		return $results;
	}

	/**
	 * Get all variaveis
	 *
	 * @param   int  $state  state value
	 *
	 * @return Variaveis
	 *
	 * @throws Exception
	 */
	public function getVariaveis($state = true)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user variaveis table where state or null.
		// Order it by the ordering field.
		$query->select( 'max("V"."id") as id,' . $db->quoteName('V.nome') );
		//$query->select($db->quoteName(array('user_id', 'profile_key', 'profile_value', 'ordering')));
		$query->from($db->quoteName('#__previsaodotempo_variavel','V'));
		if($state)
		{
			$query->where($db->quoteName('state') . ' =  1');
		}

		$query->select('array_to_string(array_agg("VV"."valor"),\',\') as valores');
		$query->join('LEFT', $db->quoteName('#__previsaodotempo_variavel_valor', 'VV') . ' ON (' . $db->quoteName('V.id') . ' = ' . $db->quoteName('VV.id_variavel') . ')');

		$query->group($db->quoteName('V.nome'));
		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();
		
		for($i = 0; $i <= count($results); ++$i)
		{
			if(strlen($results[$i]->valores) == 0)
			{
				unset($results[$i]);
			}
		}
		
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

		$canDo = PrevisaodotempoHelper::getActions();

		JToolBarHelper::title(JText::_('COM_PREVISAODOTEMPO_TITLE_PREVISAO'), 'previsao.png');

		// If not checked out, can save the item.
		if (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.create'))))
		{
			JToolBarHelper::apply('previsao.apply', 'JTOOLBAR_APPLY');
			JToolBarHelper::save('previsao.save', 'JTOOLBAR_SAVE');
		}

		if (!$checkedOut && ($canDo->get('core.create')))
		{
			JToolBarHelper::custom('previsao.save2new', 'save-new.png', 'save-new_f2.png', 'JTOOLBAR_SAVE_AND_NEW', false);
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create'))
		{
			JToolBarHelper::custom('previsao.save2copy', 'save-copy.png', 'save-copy_f2.png', 'JTOOLBAR_SAVE_AS_COPY', false);
		}

		// Button for version control
		if ($this->state->params->get('save_history', 1) && $user->authorise('core.edit')) {
			JToolbarHelper::versions('com_previsaodotempo.previsao', $this->item->id);
		}

		if (empty($this->item->id))
		{
			JToolBarHelper::cancel('previsao.cancel', 'JTOOLBAR_CANCEL');
		}
		else
		{
			JToolBarHelper::cancel('previsao.cancel', 'JTOOLBAR_CLOSE');
		}
	}
}
