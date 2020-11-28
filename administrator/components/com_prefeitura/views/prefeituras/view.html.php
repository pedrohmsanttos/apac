<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class PrefeituraViewPrefeituras extends JViewLegacy
{

	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$context = "prefeitura.list.admin.prefeitura";

		$this->items = $this->get('Items');
		$this->pagination = $this->get('Pagination');
		$this->state = $this->get('State');
		$this->filter_order 	= $app->getUserStateFromRequest($context.'filter_order', 'filter_order', 'greeting', 'cmd');
		$this->filter_order_Dir = $app->getUserStateFromRequest($context.'filter_order_Dir', 'filter_order_Dir', 'asc', 'cmd');
		$this->filterForm    	= $this->get('FilterForm');
		$this->activeFilters 	= $this->get('ActiveFilters');

		// if (count($errors = $this->get('Errors')))
		// {
		// 	JError::raiseError(500, implode('<br />', $errors));
		//
		// 	return false;
		// }

		PrefeituraHelper::addSubmenu('prefeituras');
		$this->sidebar = JHtmlSidebar::render();
 		$this->addToolBar();

		parent::display($tpl);
		$this->setDocument();
	}

	protected function addToolBar()
	{
		$title = JText::_('Prefeituras');

		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}

		JToolBarHelper::title($title, 'list-2');

		JToolBarHelper::addNew('prefeitura.add', 'Adicionar');
      	JToolBarHelper::deleteList('Excluir Prefeitura?','prefeituras.delete', 'Apagar');
		JToolBarHelper::publish('prefeituras.publish', 'Publicar', true);
		JToolBarHelper::unpublish('prefeituras.unpublish', 'Despublicar', true);

	}


	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Prefeituras - Administração'));
	}
}
