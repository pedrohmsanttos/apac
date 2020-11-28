<?php 
defined('_JEXEC') or die;
class ModTelefoneHelper
{ 
	public static function getPublishedItems($id)
    {
        $db = JFactory::getDbo(); 

        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__telefone'));
        $query->where("published = 1 and catid = $id");
         
        $db->setQuery($query);

        return $db->loadObjectList();
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


    public static function getCategories() 
    {
        $db = JFactory::getDbo(); 
       $query = $db->getQuery(true);

       $query->select('*');
       $query->from($db->quoteName('#__categories'));
       // $query->where("extension = com_telefone and published = 1");
       $query->where("extension = ".$db->quote('com_telefone')." and published = 1");
       $db->setQuery($query);
        
       $results = $db->loadObjectList();
       return $results;
    }


   

}