<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class GovernadorViewGovernadores extends JViewLegacy
{

	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$context = "governador.list.admin.governador";

		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		$this->state			= $this->get('State');
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

 		$this->addToolBar();

		parent::display($tpl);
		$this->setDocument();
	}

	protected function addToolBar()
	{
		$title = JText::_('Governadores');

		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}

		JToolBarHelper::title($title, 'list-2');
		JToolBarHelper::addNew('governador.add', 'Adicionar');
      	JToolBarHelper::deleteList('Excluir governador?','governadores.delete', 'Apagar');
		JToolBarHelper::publish('governadores.publish', 'Publicar', true);
		JToolBarHelper::unpublish('governadores.unpublish', 'Despublicar', true);

	}
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Governadores - Administração'));
	}
}
