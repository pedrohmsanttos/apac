<?php 
defined('_JEXEC') or die;
class ModSecretariaHelper
{ 
	public static function getPublishedItems()
    {
        $db = JFactory::getDbo(); 

        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__secretaria'));
        $query->where('published = 1');
         
        $db->setQuery($query);

        return $db->loadObjectList();
    }
}