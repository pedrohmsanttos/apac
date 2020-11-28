<?php 
defined('_JEXEC') or die;
class ServicosHelper
{ 
	public static function getNomeCategoria($id)
    {
        if (empty($id)){ return '';}
        
        $db = JFactory::getDbo(); 

        $query = $db->getQuery(true);
        $query->select('title');
        $query->from($db->quoteName('#__categories'));
        $query->where("id = $id");
         
        $db->setQuery($query);

        return (! empty($db->loadObjectList()[0]))? $db->loadObjectList()[0] : '' ;
    }
}