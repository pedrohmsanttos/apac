<?php 
defined('_JEXEC') or die;
class ModOrgaoHelper
{ 
	public static function getPublishedItems()
    {
        $db = JFactory::getDbo(); 

        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__orgao'));
        $query->where('published = 1');
         
        $db->setQuery($query);

        return $db->loadObjectList();
    }
}