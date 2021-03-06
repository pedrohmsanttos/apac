<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ArquivoViewArquivo extends JViewLegacy
{

	protected $form = null;
	protected $items = null;

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


		// $this->items[0]->tags = new JHelperTags;
		// $this->items[0]->tags->getItemTags('com_arquivo.arquivo', $this->items[0]->id);

		// $item->tags = new JHelperTags;
		// $item->tags->getItemTags('com_arquivo.arquivo' , $this->item->id);

		JError::raiseNotice( 100, 'Para ver o arquivo na listagem abaixo é necessário que seja enviado <b><a href="index.php?option=com_media&folder=media">clicando aqui.</a></b>' );
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

 		//JToolBarHelper::title('Arquivos', 'list-2');
		JToolbarHelper::title($title, 'list-3');
		JToolbarHelper::save('arquivo.save');
		JToolbarHelper::cancel(
			'arquivo.cancel',
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
		$document->setTitle($isNew ? JText::_('Arquivos - Incluir') :
                JText::_('Arquivos - Editar'));
	}

}
