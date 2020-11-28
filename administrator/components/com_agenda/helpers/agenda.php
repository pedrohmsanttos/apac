<?php
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

abstract class AgendaHelper extends JHelperContent
{
	
 
	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(
			JText::_('Agendas'),
			'index.php?option=com_agenda',
			$submenu == 'agendas'
		);
 
		JHtmlSidebar::addEntry(
			JText::_('Categorias'),
			'index.php?option=com_categories&view=categories&extension=com_agenda',
			$submenu == 'categories'
		);
 
		// Set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-helloworld ' .
										'{background-image: url(../media/com_helloworld/images/tux-48x48.png);}');
		if ($submenu == 'agendas') 
		{
			$document->setTitle(JText::_('Agendas'));
		}
	}
}