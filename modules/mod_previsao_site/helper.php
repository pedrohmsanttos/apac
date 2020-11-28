<?php
// No direct access
defined('_JEXEC') or die;

class ModPrevisaoSiteHelper
{   
	public static function getMesorregioesAtivas()
    {
		$db = JFactory::getDbo(); 
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->quoteName('#__previsaodotempo_mesorregiao'));
        $query->where("state = 1");
         
        $db->setQuery($query);

		$mesorregioes = $db->loadObjectList();
         
		return $mesorregioes;
    }
    
}