<?php
// No direct access
defined('_JEXEC') or die;

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('id', 'title', 'alias','parent_id')));
$query->from($db->quoteName('#__categories'));
$query->where("extension like ".$db->quote('com_content')." and published = 1");
$db->setQuery($query);
$categories = $db->loadObjectList();

require JModuleHelper::getLayoutPath('mod_busca');
