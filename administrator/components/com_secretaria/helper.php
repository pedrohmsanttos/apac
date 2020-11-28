<?php 
defined('_JEXEC') or die;
class SecretarioHelper
{ 
	public static function getNomeSecretario($id)
    {
        if (empty($id)) {
                return '';
        }

        $db = JFactory::getDbo(); 

        $query = $db->getQuery(true);
        $query->select('nome_secretario');
        $query->from($db->quoteName('#__secretario'));
        $query->where("id = $id");
         
        $db->setQuery($query);

        return (! empty($db->loadObjectList()[0]))? $db->loadObjectList()[0] : '' ;
    }

}