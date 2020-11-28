<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
abstract class ServicoHelper extends JHelperContent
{
 
	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(
			JText::_('Serviços'),
			'index.php?option=com_servico',
			$submenu == 'servicos'
		);
 
		JHtmlSidebar::addEntry(
			JText::_('Categorias'),
			'index.php?option=com_categories&view=categories&extension=com_servico',
			$submenu == 'categories'
		);
 
		$document = JFactory::getDocument();
		
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_('Categoria de Serviços'));
		}
	}
	
	public static function getCategoryTitleById($id) 
	{
		$db = JFactory::getDbo(); 
	    $query = $db->getQuery(true);

	    $query->select('title');
	    $query->from($db->quoteName('#__categories'));
	    $query->where("id = $id");
	     
	    $db->setQuery($query);
	     
	    $results = $db->loadObjectList();
	    return $results[0];
	}
}