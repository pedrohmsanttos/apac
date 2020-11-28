<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_prefeitura
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Prefeitura component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 *
 * @since   1.6
 */
abstract class PrefeituraHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @return Bool
	 */
 
	public static function addSubmenu($submenu) 
	{
		JHtmlSidebar::addEntry(
			JText::_('Prefeituras'),
			'index.php?option=com_prefeitura',
			$submenu == 'prefeituras'
		);
 
		JHtmlSidebar::addEntry(
			JText::_('Categorias ou Mesorregiões'),
			'index.php?option=com_categories&view=categories&extension=com_prefeitura',
			$submenu == 'categories'
		);
 
		// Set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-prefeitura ' .
										'{background-image: url(../media/com_prefeitura/images/tux-48x48.png);}');
		if ($submenu == 'categories') 
		{
			$document->setTitle(JText::_('Categoria de Prefeituras'));
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