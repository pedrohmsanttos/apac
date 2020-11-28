<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AgendaViewAgendas extends JViewLegacy
{

	function display($tpl = null)
	{
		// Get application
		$app = JFactory::getApplication();
		$context = "agenda.list.admin.agenda";

		// Set the submenu
		AgendaHelper::addSubmenu('agendas');

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
		$title = JText::_('Agenda');

		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}

		JToolBarHelper::title($title, 'list-2');

		JToolBarHelper::addNew('agenda.add', 'Adicionar');
      	JToolBarHelper::deleteList('Excluir agenda?','agendas.delete', 'Apagar');
		JToolBarHelper::publish('agendas.publish', 'Publicar', true);
		JToolBarHelper::unpublish('agendas.unpublish', 'Despublicar', true);

	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Agenda - Administração'));
	}
}

function str2dataArr($str)
{

	if(empty($str)) return '';

	$arrStr = explode(" ", $str);
	$hora = str_replace(":", "h", $arrStr[1]);
	$hora = substr($hora, 0, 5);
	$data = explode('-', $arrStr[0]);

	return array("$data[2]/$data[1]/$data[0]", "$hora");

}
