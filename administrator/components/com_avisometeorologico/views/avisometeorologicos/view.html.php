<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisometeorologicoViewAvisometeorologicos extends JViewLegacy
{

	function display($tpl = null)
	{
		$app = JFactory::getApplication();
		$context = "avisometeorologico.list.admin.avisometeorologico";

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
		AvisometeorologicoHelper::addSubmenu('avisometeorologicos');

 		$this->addToolBar();


		parent::display($tpl);
		$this->setDocument();
	}

	protected function addToolBar()
	{
		$title = JText::_('Avisos Meteorológicos');

		if ($this->pagination->total)
		{
			$title .= "<span style='font-size: 0.5em; vertical-align: middle;'>(" . $this->pagination->total . ")</span>";
		}

		// Options button.
	if (JFactory::getUser()->authorise('core.admin', 'com_avisometeorologico'))
	{
		JToolBarHelper::preferences('com_avisometeorologico');
	}

		JToolBarHelper::title($title, 'list-2');
		JToolBarHelper::addNew('avisometeorologico.add', 'Adicionar');
		JToolBarHelper::trash('avisometeorologicos.trash', 'Apagar');
		JToolBarHelper::publish('avisometeorologicos.publish', 'Publicar', true);
		JToolBarHelper::unpublish('avisometeorologicos.unpublish', 'Despublicar', true);
		JToolBarHelper::custom('avisometeorologicos.enviarEmail', 'enviarEmail.png', 'enviarEmail_f2.png', 'Enviar Email', true);
		JToolBarHelper::custom('avisometeorologicos.gerarPDF', 'gerarPDF.png', false, 'Gerar PDF', true);
	}
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Avisos Meteorológicos - Administração'));
	}
}
