<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisoViewAviso extends JViewLegacy
{

	protected $form = null;

	function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

		// if (count($errors = $this->get('Errors')))
		// {
		// 	JError::raiseError(500, implode('<br />', $errors));
		// 	return false;
		// }

 		$this->addToolBar();
		parent::display($tpl);
		$this->setDocument();
	}

	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;
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

		JToolbarHelper::title($title, 'list-3');
		JToolbarHelper::save('aviso.save');
		JToolbarHelper::cancel(
			'aviso.cancel',
			$isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE'
		);
	}
	protected function setDocument()
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('Avisos - Incluir') :
                JText::_('Avisos - Editar'));
	}

}
