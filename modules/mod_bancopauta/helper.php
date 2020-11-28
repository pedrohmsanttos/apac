<?php defined('_JEXEC') or die;
class ModBancoPautaHelper
{   
	public static function getPalacioAgenda($catid)
	{
		if(empty($catid)) return '';

	    $db = JFactory::getDbo(); 
	    $query = $db->getQuery(true);

	    $query->select('*');
	    $query->from($db->quoteName('#__agenda', 'a'));
	    $query->join('INNER', $db->quoteName('#__categories', 'c') . ' ON (' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('c.id') . ')');
	    $query->where($db->quoteName('c.path') . ' LIKE \'banco-de-pautas/palacio\' AND a.published = 1 AND a.data >= now()');
	    $query->group($db->quoteName("a.data") . 'ASC');
	     
	    $db->setQuery($query);
	     
	    $results = $db->loadObjectList();
	    
	    return $results;
	}
	public static function getSecretariaAgenda($catid)
	{
		if(empty($catid)) return '';

	    $db = JFactory::getDbo(); 
	    $query = $db->getQuery(true);

	    $query->select('*');
	    $query->from($db->quoteName('#__agenda', 'a'));
	    $query->join('INNER', $db->quoteName('#__categories', 'c') . ' ON (' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('c.id') . ')');
	    $query->where($db->quoteName('c.path') . ' LIKE \'banco-de-pautas/secretarias\' AND a.published = 1 AND a.data >= now()');
	    $query->group($db->quoteName("a.data") . 'ASC');
	     
	    $db->setQuery($query);
	     
	    $results = $db->loadObjectList();
	    
	    return $results;
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
		return array("$data[2]","$Mes/$ano", "$hora"."min");
	}
	public static function paginacao($yourDataArray,$page,$limit)
	{
	    if(empty($page)) $page = 3;
	    if(empty($limit)) $limit = 2;
	    
	    // $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
	    $total = count( $yourDataArray ); //total items in array    
	    $totalPages = ceil( $total/ $limit ); //calculate total pages
	    $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
	    $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
	    $offset = ($page - 1) * $limit;
	    if( $offset < 0 ) $offset = 0;

	    $yourDataArray = array_slice( $yourDataArray, $offset, $limit );

	    $saida = new stdClass();
	    $saida->vetor = $yourDataArray;
	    $saida->total_paginas = $totalPages;
	   return $saida;
	}
}

function mudaParamUrl($url, $assign) {
	list($var,$val) = explode("=",$assign);
	if(!strpos($url,"?")) {
	   $res = "$url?$assign";
	} else {
	   list($base,$vars) = explode("?",$url);
	   //if the vars dont include the one given
	   if(!strpos($vars,$var)) {
	       $res = "$url&$assign";
	   } else {
	       $res = preg_replace("/$var=[a-zA-Z0-9_]*(&|$)/",$assign."&",$url);
	       $res = preg_replace("/&$/","",$res); //remove possible & at the end
	   }
	}
	return $res;
}