<?php
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

abstract class SecretariaHelper extends JHelperContent
{
	
 
	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(
			JText::_('Secretarias'),
			'index.php?option=com_secretaria',
			$submenu == 'secretarias'
		);
 
		JHtmlSidebar::addEntry(
			JText::_('Secretários'),
			'index.php?option=com_secretario&view=secretarios&extension=com_secretaria',
			$submenu == 'secretarios'
		);
 
		$document = JFactory::getDocument();
		
		if ($submenu == 'secretarios') 
		{
			$document->setTitle(JText::_('Secretários'));
		}
	}
}