<?php
/**
 * @version     1.0.0
 * @package     com_envio_de_artigos_1.0.0
 * @copyright   Copyright (C) 2018. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Matheus Felipe <matheus.felipe@inhalt.com.br> - https://www.developer-url.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.view');

/**
 * Envio_de_artigos list view
 */
class Envio_de_artigosViewArtigos extends JViewLegacy
{
	protected $items;
	protected $pagination;
	protected $state;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->user			= JFactory::getUser();
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');

		// Check for errors
		if (count($errors = $this->get('Errors')))
		{
			throw new Exception(implode("\n", $errors));
		}
        
		Envio_de_artigosHelpersBackend::addSubmenu('artigos');

		$this->addToolbar();

		$this->sortFields = $this->getSortFields();

        $this->sidebar = JHtmlSidebar::render();

		// Load the template header here to simplify the template
		$this->loadTemplateHeader();

		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since	1.6
	 */
	protected function addToolbar()
	{
		require_once JPATH_COMPONENT.'/helpers/backend.php';

		$state	= $this->get('State');
		$canDo	= Envio_de_artigosHelpersBackend::getActions($state->get('filter.category_id'));

		JToolBarHelper::title(JText::_('COM_ENVIO_DE_ARTIGOS_TITLE_ARTIGOS'), 'artigos.png');

        //Check if the form exists before showing the add/edit buttons
        $formPath = JPATH_COMPONENT_ADMINISTRATOR.'/views/artigo';

        JToolBarHelper::custom('artigos.enviarEmail', 'enviarEmail.png', 'enviarEmail_f2.png', 'Enviar Email', true);
        //Show trash and delete for components that uses the state field
        // if (isset($this->items[0]->state))
		// {
		//     if ($state->get('filter.state') == -2 && $canDo->get('core.delete'))
		// 	{
		// 	    JToolBarHelper::deleteList('', 'artigos.delete','JTOOLBAR_EMPTY_TRASH');
		// 	    JToolBarHelper::divider();
		//     }
		// 	else if ($canDo->get('core.edit.state'))
		// 	{
		// 	    JToolBarHelper::trash('artigos.trash','JTOOLBAR_TRASH');
		// 	    JToolBarHelper::divider();
		//     }
        // }

		// if ($canDo->get('core.admin'))
		// {
		// 	JToolBarHelper::preferences('com_envio_de_artigos');
		// }
        
        //Set sidebar action - New in 3.0
		JHtmlSidebar::setAction('index.php?option=com_envio_de_artigos&view=artigos');
        
		$this->extra_sidebar = '';
		
		$options = '<option value="1">Enviados</option><option value="0">Não Enviados</option><option value="*">Tudo</option>';
		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			$options
		);
		//JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), "value", "text", $this->state->get('filter.state'), true)
	}

	/**
	 * Get the fields for sorting
	 *
	 * @return	$sortFields		array	An array with the sort fields
	 */
	protected function getSortFields()
	{
		$sortFields = array(
			'a.id' => JText::_('COM_ENVIO_DE_ARTIGOS_HEADING_BACKEND_LIST_ID'),
			'a.created_by' => JText::_('COM_ENVIO_DE_ARTIGOS_ARTIGO_CREATED_BY_LBL'),
			'a.state' => JText::_('COM_ENVIO_DE_ARTIGOS_ARTIGO_STATE_LBL'),
			'a.ordering' => JText::_('COM_ENVIO_DE_ARTIGOS_ARTIGO_ORDERING_LBL'),
			'a.enviado' => JText::_('COM_ENVIO_DE_ARTIGOS_ARTIGO_ENVIADO_LBL'),
			'a.artigo_id' => JText::_('COM_ENVIO_DE_ARTIGOS_ARTIGO_ARTIGO_ID_LBL'),
		);

		return $sortFields;
	}

	/**
	 * Load the template header data here to simplify the template
	 */
	protected function loadTemplateHeader()
	{
		JHtml::addIncludePath(JPATH_COMPONENT . '/helpers/html');

		JHtml::_('bootstrap.tooltip');
		JHtml::_('behavior.multiselect');
		JHtml::_('formbehavior.chosen', 'select');

		$document = JFactory::getDocument();
		$document->addStyleSheet('components/com_envio_de_artigos/assets/css/envio_de_artigos.css');
		$document->addScript('components/com_envio_de_artigos/assets/js/list.js');

		$user = JFactory::getUser();
		$this->listOrder = $this->escape($this->state->get('list.ordering'));
		$this->listDirn = $this->escape($this->state->get('list.direction'));
		$user->authorise('core.edit.state', 'com_envio_de_artigos.category');
		$saveOrder = $this->listOrder == 'a.ordering';

		if ($saveOrder)
		{
			$saveOrderingUrl = 'index.php?option=com_envio_de_artigos&task=artigos.saveOrderAjax&tmpl=component';
			JHtml::_('sortablelist.sortable', 'artigoList', 'adminForm', strtolower($this->listDirn), $saveOrderingUrl);
		}

		$this->saveOrder = $saveOrder;
	}
}
