<?php
/**
 * @copyright	Copyright © 2018 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	http://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;
require_once ('helper.php');

$doc = JFactory::getDocument();
/* Available fields: */
// Include assets
$doc->addStyleSheet(JURI::root()."modules/mod_informemeteorologico/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_informemeteorologico/assets/js/script.js");
// $width 			= $params->get("width");

$categorias      = getCategorys();
$arrItensinformes = getItens($categorias);

/**
	$db = JFactory::getDBO();
	$db->setQuery("SELECT * FROM #__mod_informemeteorologico where del=0 and module_id=".$module->id);
	$objects = $db->loadAssocList();
*/

require JModuleHelper::getLayoutPath('mod_informemeteorologico', $params->get('layout', 'default'));