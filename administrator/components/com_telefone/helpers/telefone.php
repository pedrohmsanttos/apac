<?php
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

abstract class TelefoneHelper extends JHelperContent
{
	
 
	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(
			JText::_('Telefones'),
			'index.php?option=com_telefone',
			$submenu == 'telefones'
		);
 
		JHtmlSidebar::addEntry(
			JText::_('Categorias'),
			'index.php?option=com_categories&view=categories&extension=com_telefone',
			$submenu == 'categories'
		);
 
		$document = JFactory::getDocument();
		
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_('Categorias'));
		}
	}
}