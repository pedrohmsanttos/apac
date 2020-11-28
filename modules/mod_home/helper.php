<?php
class ModHomeHelper
{   
    public static function isActiveModule($module_title)
    {
        $db = JFactory::getDbo(); 
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('published')));
        $query->from($db->quoteName('#__modules'));
        $query->where("module = ".$db->quote($module_title)." ");         
        $db->setQuery($query);         
        $results = $db->loadObjectList();

        if(empty($results)) {
            return false;
        } else {
            return (bool) $results[0]->published;
        }
    }
    
    public static function loadActiveModule($module_title)
    {
        return (self::isActiveModule($module_title)) ? 
                JModuleHelper::getModule($module_title) : '';
    }

}