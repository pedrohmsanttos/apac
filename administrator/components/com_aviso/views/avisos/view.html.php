<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisoViewAvisos extends JViewLegacy
{

	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$context = "aviso.list.admin.aviso";

		$items = $this->get('Items');
	  $state = $this->get('State');

		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filter_order = $app->getUserStateFromRequest($context.'filter_order',
															'filter_order',
															'identificador',
															'cmd');
		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir',
																'filter_order_Dir',
																'asc',
																'cmd');

		$this->filterForm = $this->get('FilterForm');
		$this->activeFilters = $this->get('ActiveFilters');

		$this->sortDirection = $state->get('list.direction');
		$this->sortColumn    = $state->get('list.ordering');


		// if (count($errors = $this->get('Errors')))
		// {
		// 	JError::raiseError(500, implode('<br />', $errors));
		//
		// 	return false;
		// }

		// Set the submenu
		AvisoHelper::addSubmenu('avisos');

 		$this->addToolBar();


		parent::display($tpl);
		$this->setDocument();
	}

	protected function addToolBar()
	{
		$title = JText::_('Avisos');

		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}

		// Options button.
	if (JFactory::getUser()->authorise('core.admin', 'com_aviso'))
	{
		JToolBarHelper::preferences('com_aviso');
	}

		JToolBarHelper::title($title, 'list-2');
		JToolBarHelper::addNew('aviso.add', 'Adicionar');
    JToolBarHelper::deleteList('Excluir aviso?','avisos.delete', 'Apagar');
		JToolBarHelper::publish('avisos.publish', 'Publicar', true);
		JToolBarHelper::unpublish('avisos.unpublish', 'Despublicar', true);

	}
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Avisos - Administração'));
	}
}
