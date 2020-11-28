<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ServicoViewServico extends JViewLegacy
{

	protected $form = null;
	
	function display($tpl = null)
	{
		// Get data from the model
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
	
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
 
			return false;
		}
 		
 		$this->addToolBar();
 		
		// Display the template
		parent::display($tpl);
 
		// Set the document
		$this->setDocument();
	}

	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;
 
		// Hide Joomla Administrator Main menu
		$input->set('hidemainmenu', true);
 
		$isNew = ($this->item->id == 0);
 
		if ($isNew)
		{
			$title = JText::_('Incluir');
		}
		else
		{
			$title = JText::_('Editar');
		}
 
		
 		//JToolBarHelper::title('Serviços', 'list-2');
		JToolbarHelper::title($title, 'list-3');
		JToolbarHelper::save('servico.save');
		JToolbarHelper::cancel(
			'servico.cancel',
			$isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE'
		);
	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument() 
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('Serviços - Incluir') :
                JText::_('Serviços - Editar'));
	}
	
}