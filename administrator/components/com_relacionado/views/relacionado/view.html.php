<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class RelacionadoViewRelacionado extends JViewLegacy
{

	protected $form = null;
	
	function display($tpl = null)
	{
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');
	
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors)); 
			return false;
		}
 		
		JHtml::_('jquery.framework', true, true);
		JHtml::script(Juri::base().'components/com_relacionado/views/relacionado/tmpl/js/js.cookie.js');
 		JHtml::script(Juri::base().'components/com_relacionado/views/relacionado/tmpl/js/jquery.treegrid.js');
		JHtml::script(Juri::base().'components/com_relacionado/views/relacionado/tmpl/js/com_relacionado.js');
		JHtml::_('behavior.multiselect');
 		JHtml::_('formbehavior.chosen', '.artigos');
 		JHtml::stylesheet(Juri::base().'components/com_relacionado/views/relacionado/tmpl/css/jquery.treegrid.css');

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
		JToolbarHelper::save('relacionado.save');
		JToolbarHelper::cancel(
			'relacionado.cancel',
			$isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE'
		);
	}
	protected function setDocument() 
	{
		$isNew = ($this->item->id < 1);
		$document = JFactory::getDocument();
		$document->setTitle($isNew ? JText::_('Relacionados - Incluir') :
                JText::_('Relacionados - Editar'));
	}
	
}