<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class SecretariaViewSecretarias extends JViewLegacy
{
	function display($tpl = null)
	{
		// Get application
		$app = JFactory::getApplication();
		$context = "secretaria.list.admin.secretaria";

		// Set the submenu
		SecretariaHelper::addSubmenu('secretarias');

		// Get data from the model
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		$this->state			= $this->get('State');
		$this->filter_order 	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'greeting', 'cmd');
		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
		$this->filterForm    	= $this->get('FilterForm');
		$this->activeFilters 	= $this->get('ActiveFilters');

		// Check for errors.
		// if (count($errors = $this->get('Errors')))
		// {
		// 	JError::raiseError(500, implode('<br />', $errors));
		//
		// 	return false;
		// }

 		$this->sidebar = JHtmlSidebar::render();
 		$this->addToolBar();

		// Display the template
		parent::display($tpl);
		$this->setDocument();
	}

	protected function addToolBar()
	{
		$title = JText::_('Secretarias');

		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'> (" . $this->pagination->total . ")</span>";
		}

		JToolBarHelper::title($title, 'list-2');
		JToolBarHelper::addNew('secretaria.add', 'Adicionar');
      	JToolBarHelper::deleteList('Excluir Secretaria(s)?','secretarias.delete', 'Apagar');
		JToolBarHelper::publish('secretarias.publish', 'Publicar', true);
		JToolBarHelper::unpublish('secretarias.unpublish', 'Despublicar', true);
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Secretarias - Administração'));
	}
}
