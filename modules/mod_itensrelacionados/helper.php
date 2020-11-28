<?php
defined('_JEXEC') or die;

class ModItensRelacionadosHelper
{
	public static function getArquivoItems($catid)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__arquivo'));
        $query->where('published = 1 AND catid = '.$catid);
        $db->setQuery($query);
        return $db->loadObjectList();
    }

		public static function getArticlesItems($catid)
	    {
	        $db = JFactory::getDbo();
	        $query = $db->getQuery(true);
	        $query->select('*');
	        $query->from($db->quoteName('#__content'));
	        $query->where('state = 1 AND catid = '.$catid);
	        $db->setQuery($query);
	        return $db->loadObjectList();
	    }

		public static function getAvisoItems()
	    {
	        $db = JFactory::getDbo();
	        $query = $db->getQuery(true);
	        $query->select('*');
	        $query->from($db->quoteName('#__aviso'));
	        $query->where('published = 1');
	        $db->setQuery($query);
	        return $db->loadObjectList();
	    }

    public static function getArticle($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'title', 'introtext','catid','alias')));
        $query->from($db->quoteName('#__content'));
        $query->where('id='.$id);
        $db->setQuery($query);
        $articlesList = $db->loadObjectList();
        return $articlesList[0];
    }

    public static function getCategoryById($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'title','alias','description','params','parent_id')));
        $query->from($db->quoteName('#__categories'));
        $query->where('id='.$id);
        $db->setQuery($query);
        $categoryList = $db->loadObjectList();
        $prms = json_decode($categoryList[0]->params);
        return $categoryList[0];
    }

		function formataData($str)
		{
			if(empty($str)) return '';

			$arrStr = explode(" ", $str);
			$hora = str_replace(":", "h", $arrStr[1]);
			$hora = substr($hora, 0, 5);
			$data = explode('-', $arrStr[0]);

			if($data[1] == '01') $Mes = 'JAN';
			if($data[1] == '02') $Mes = 'FEV';
			if($data[1] == '03') $Mes = 'MAR';
			if($data[1] == '04') $Mes = 'ABR';
			if($data[1] == '05') $Mes = 'MAI';
			if($data[1] == '06') $Mes = 'JUN';
			if($data[1] == '07') $Mes = 'JUL';
			if($data[1] == '08') $Mes = 'AGO';
			if($data[1] == '09') $Mes = 'SET';
			if($data[1] == '10') $Mes = 'OUT';
			if($data[1] == '11') $Mes = 'NOV';
			if($data[1] == '12') $Mes = 'DEZ';

			$ano = substr($data[0], 2,4);

			// retorna um array de dia, mes/ano, e hora.
			return "$data[2] "." $Mes/$ano ". " $hora "."min";
		}
}
