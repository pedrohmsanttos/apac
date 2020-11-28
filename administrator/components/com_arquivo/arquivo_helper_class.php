<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_arquivo
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * Arquivo component helper.
 *
 * @param   string  $submenu  The name of the active view.
 *
 * @return  void
 *
 * @since   1.6
 */
abstract class ArquivoHelper extends JHelperContent
{
	/**
	 * Configure the Linkbar.
	 *
	 * @return Bool
	 */

	public static function addSubmenu($submenu)
	{
		JHtmlSidebar::addEntry(
			JText::_('Arquivos'),
			'index.php?option=com_arquivo',
			$submenu == 'arquivos'
		);

		JHtmlSidebar::addEntry(
			JText::_('Categorias'),
			'index.php?option=com_categories&view=categories&extension=com_arquivo',
			$submenu == 'categories'
		);

		JHtmlSidebar::addEntry(
			JText::_('Upload de Arquivos'),
			'index.php?option=com_media&folder=media',
			$submenu == 'categories'
		);

		// Set some global property
		$document = JFactory::getDocument();
		$document->addStyleDeclaration('.icon-48-arquivo ' .
										'{background-image: url(../media/com_arquivo/images/tux-48x48.png);}');
		if ($submenu == 'categories')
		{
			$document->setTitle(JText::_('Categoria de Arquivos'));
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

	public static function getSubCategoryTitleById($id)
	{
		$db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('title');
	    $query->from($db->quoteName('#__categories'));
	    $query->where("parent_id = $id");

	    $db->setQuery($query);

	    $results = $db->loadObjectList();
	    return $results[0];
	}
	public static function getFiletypeNameByIdType($id){
		$out = "";
		switch ($id) {
			case '1':
				$out = 'Audio';
				break;

			case '2':
				$out = 'Video';
				break;

			case '3':
				$out = 'Imagem';
				break;

			case '4':
				$out = 'Documento';
				break;

			default:
				$out = 'Documento';
				break;
		}

		return $out;
	}
}
