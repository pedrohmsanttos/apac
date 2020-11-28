<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_informemeteorologico
 * @author     Matheus Felipe <matheusfelipe.moreira@gmail.com>
 * @copyright  2018 Matheus Felipe
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * View class for a list of informemeteorologico.
 *
 * @since  1.6
 */
class InformemeteorologicoViewInformemeteorologicos extends JViewLegacy
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
		//var_dump($this->get('Errors'));die();
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}
		
		InformemeteorologicoHelper::addSubmenu('informemeteorologicos');

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
		$canDo = InformemeteorologicoHelper::getActions();

		JToolBarHelper::title(JText::_('COM_INFORMEMETEOROLOGICO_TITLE_INFORMEMETEOROLOGICOS'), 'informemeteorologicos.png');

		// Check if the form exists before showing the add/edit buttons
		$formPath = JPATH_COMPONENT_ADMINISTRATOR . '/views/informemeteorologico';

		if (file_exists($formPath))
		{
			if ($canDo->get('core.create'))
			{
				JToolBarHelper::addNew('informemeteorologico.add', 'JTOOLBAR_NEW');

				if (isset($this->items[0]))
				{
					JToolbarHelper::custom('informemeteorologicos.duplicate', 'copy.png', 'copy_f2.png', 'JTOOLBAR_DUPLICATE', true);
				}
			}

			if ($canDo->get('core.edit') && isset($this->items[0]))
			{
				JToolBarHelper::editList('informemeteorologico.edit', 'JTOOLBAR_EDIT');
			}
		}

		if ($canDo->get('core.edit.state'))
		{
			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::custom('informemeteorologicos.publish', 'publish.png', 'publish_f2.png', 'JTOOLBAR_PUBLISH', true);
				JToolBarHelper::custom('informemeteorologicos.unpublish', 'unpublish.png', 'unpublish_f2.png', 'JTOOLBAR_UNPUBLISH', true);
			}
			elseif (isset($this->items[0]))
			{
				// If this component does not use state then show a direct delete button as we can not trash
				JToolBarHelper::deleteList('', 'informemeteorologicos.delete', 'JTOOLBAR_DELETE');
			}

			if (isset($this->items[0]->state))
			{
				JToolBarHelper::divider();
				JToolBarHelper::archiveList('informemeteorologicos.archive', 'JTOOLBAR_ARCHIVE');
			}

			if (isset($this->items[0]->checked_out))
			{
				//JToolBarHelper::custom('informemeteorologicos.checkin', 'checkin.png', 'checkin_f2.png', 'JTOOLBAR_CHECKIN', true);
			}
		}

		// Show trash and delete for components that uses the state field
		if (isset($this->items[0]->state))
		{
			if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
			{
				JToolBarHelper::deleteList('', 'informemeteorologicos.delete', 'JTOOLBAR_EMPTY_TRASH');
				JToolBarHelper::divider();
			}
			elseif ($canDo->get('core.edit.state'))
			{
				JToolBarHelper::trash('informemeteorologicos.trash', 'JTOOLBAR_TRASH');
				JToolBarHelper::divider();
			}
		}

		if ($canDo->get('core.admin'))
		{
			JToolBarHelper::preferences('com_informemeteorologico');
		}
		

		JToolBarHelper::custom('informemeteorologicos.enviarEmail', 'enviarEmail.png', 'enviarEmail_f2.png', 'Enviar Email', true);
		
		// Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_informemeteorologico&view=informemeteorologicos');
	}

	/**
	 * Method to order fields 
	 *
	 * @return void 
	 */
	protected function getSortFields()
	{
		return array(
			'a.id' => JText::_('JGRID_HEADING_ID'),
			'a.ordering' => JText::_('JGRID_HEADING_ORDERING'),
			'a.state' => JText::_('JSTATUS'),
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
