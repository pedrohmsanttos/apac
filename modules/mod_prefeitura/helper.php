<?php
// No direct access
defined('_JEXEC') or die;

class ModPrefeituraHelper
{   

    public static function getMesorregioesAtivas()
    {

		$db = JFactory::getDbo(); 
        $query = $db->getQuery(true);

        $query->select('*');
        $query->from($db->quoteName('#__categories'));
        $query->where("extension = ".$db->quote('com_prefeitura'));
         
        $db->setQuery($query);

		$mesorregioes = $db->loadObjectList();

		if(! empty($mesorregioes)){
			foreach ($mesorregioes as $mesorregiao) {
				$mesorregiao->prefeituras = self::getPrefeiturasPelaCategoria($mesorregiao->id);
			}
		}
         
		return $mesorregioes;
	}
	
	
	
    public static function getPrefeiturasPelaCategoria($catid)
    {

		$db = JFactory::getDbo(); 

        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__prefeitura'));
        $query->where("catid = $catid ");
         
        $db->setQuery($query);
         
		return $db->loadObjectList();
	}

	public static function getPrefeiturasPelaLetraInicial($letraInicial)
    {

		$db = JFactory::getDbo(); 
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__prefeitura'));
  		$query->where("nome like ".$db->quote(strtolower($letraInicial)."%"),'OR');
  		$query->where("nome like ".$db->quote(strtolower($letraInicial))."%");
        
        $db->setQuery($query);
         
		return $db->loadObjectList();
	}

    public static function getLetras(){
		return array('a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','v','w','x','y','z');
	}	
}