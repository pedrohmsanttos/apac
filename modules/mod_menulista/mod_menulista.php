<?php
// No direct access
defined('_JEXEC') or die;

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('*');
$query->from($db->quoteName('#__menu'));
$query->where("menutype like ".$db->quote("menulista")." and published = 1");
$query->order('lft ASC');
$db->setQuery($query);
$menus = $db->loadObjectList();

require JModuleHelper::getLayoutPath('mod_menulista');
