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
 * View class for a list of Cadastrointeressado.
 *
 * @since  1.6
 */
class CadastrointeressadoViewInteressados extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;


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
		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
        $this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}

		CadastrointeressadoHelper::addSubmenu('interessados');

		$this->addToolbar();

		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function addToolbar()
	{
		$state = $this->get('State');
		$canDo = CadastrointeressadoHelper::getActions();

		JToolBarHelper::title(JText::_('COM_CADASTROINTERESSADO_TITLE_INTERESSADOS'), 'interessados.png');
		

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/interessado';

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('interessado.add', 'ADICIONAR INTERESSADO');

				// if (isset($this->items[0]))
				// {
				// 	JToolbarHelper::custom('interessados.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
				// }
			}
			JToolBarHelper::custom('interessados.gerarCSV', 'gerarCSV.png', false, 'GERAR CSV', true);

			if ($canDo->get('core.edit') && isset($this->items[0]))
			{
				JToolBarHelper::editList('interessado.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom('interessados.publish', 'publish.png', 'publish_f2.png', 'ATIVAR', true);
				JToolBarHelper::custom('interessados.unpublish', 'unpublish.png', 'unpublish_f2.png', 'DESATIVAR', true);		
			}
			elseif (isset($this->items[0]))
			{
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'interessados.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('interessados.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				JToolBarHelper::custom('interessados.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}	
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', 'interessados.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash('interessados.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}	
		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_cadastrointeressado');
		}

		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_cadastrointeressado&view=interessados');
	}

	/**
	 * Method to order fields 
	 *
	 * @return void 
	 */
	protected function getSortFields()
	{
		return array(
			'a.`nome`' => JText::_('COM_CADASTROINTERESSADO_INTERESSADOS_NOME'),
			'a.`data_criacao`' => JText::_('Data de Criação'),
			'a.`pertencegoverno`' => JText::_('Governo'),
			'a.`situacao`' => JText::_('Situação'),
		);
	}

    /**
     * Check if state is set
     *
     * @param   mixed  $state  State
     *
     * @return bool
     */
    public function getState($state)
    {
		return isset($this->state->{$state}) ? $this->state->{$state} : false;
	}
}
