<?php
class ModAvisoListaHelper
{

	public static function getAvisoItems($id)
  {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);
      $query->select('*');
      $query->from($db->quoteName('#__aviso'));
      if(! empty($id)){
        $query->where("published = 1 and tipo=".$id);
      } else {
        $query->where("published = 1");
      }

      $query->order('created DESC');
      $db->setQuery($query);
      return [];//$db->loadObjectList();
  }

	public static function getAvisosMeteorologicoItems($id)
  {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);
      $query->select('*');
      $query->from($db->quoteName('#__avisometeorologico'));
      if(! empty($id)){
        $query->where("published = 1 and tipo=".$id, 'AND');
      } else {
        $query->where("published = 1", 'AND');
      }
      $query->where("ordering > 0", 'AND');

      $query->order('created DESC');
      $db->setQuery($query);
      return $db->loadObjectList();
  }

	public static function getAvisosHidrologicoItems($id)
  {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);
      $query->select('*');
      $query->from($db->quoteName('#__avisohidrologico'));
      if(! empty($id)){
        $query->where("published = 1 and tipo=".$id);
      } else {
        $query->where("published = 1");
      }
      $query->where("ordering > 0", 'AND');

      $query->order('created DESC');
      $db->setQuery($query);
      return $db->loadObjectList();
  }

  public static function getAvisosMeteorologicoItemsZeros($id)
  {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);
      $query->select('*');
      $query->from($db->quoteName('#__avisometeorologico'));
      if(! empty($id)){
        $query->where("published = 1 and tipo=".$id, 'AND');
      } else {
        $query->where("published = 1", 'AND');
      }
      $query->where("ordering = 0", 'AND');

      $query->order('created DESC');
      $db->setQuery($query);
      return $db->loadObjectList();
  }

	public static function getAvisosHidrologicoItemsZeros($id)
  {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);
      $query->select('*');
      $query->from($db->quoteName('#__avisohidrologico'));
      if(! empty($id)){
        $query->where("published = 1 and tipo=".$id);
      } else {
        $query->where("published = 1");
      }
      $query->where("ordering = 0", 'AND');

      $query->order('created DESC');
      $db->setQuery($query);
      return $db->loadObjectList();
  }

  public static function getCategoryById($id)
  {
     $db = JFactory::getDbo();
     $query = $db->getQuery(true);
     $query->select('*');
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
     $query->where("extension = ".$db->quote('com_aviso')." and published = 1");
     $db->setQuery($query);
     return $db->loadObjectList();
  }

	public static function preparaData($str)
	{
		//2017-07-20 19:58:59
		if(empty($str)) return '';
		$arrStr = explode(" ", $str);
		$hora = str_replace(":", "h", $arrStr[1]);
		$hora = substr($hora, 0, 5);
		$data = explode('-', $arrStr[0]);
		return array("$data[2]/$data[1]/$data[0]", "$hora");
	}

  function paginacao($yourDataArray,$page,$limit)
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

  function str2dataArr($str)
  {

  	if(empty($str)) return '';

  	$arrStr = explode(" ", $str);
  	$hora = str_replace(":", "h", $arrStr[1]);
  	$hora = substr($hora, 0, 5);
  	$data = explode('-', $arrStr[0]);

  	return array("$data[2]/$data[1]/$data[0]", "$hora");

  }


}

function limitaString($x, $length)
{
  if(strlen($x)<=$length)
  {
    return $x;
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    return $y;
  }
}

function intcmp($a, $b)
{
  return ($a->ordering - $b->ordering);
}
  
function datacmp($a, $b)
{
  $ad = date("Ymd",strtotime($a->inicio));
  $bd = date("Ymd",strtotime($b->inicio));
  
  if ($ad == $bd) {
    $timea = date("H:i:s",strtotime($a->inicio));
    $timeb = date("H:i:s",strtotime($b->inicio));
    
    $horaA = explode(':', $timea);
    $horaB = explode(':', $timeb);

    if($horaA[0] > $horaB[0]){
      return -1;
    }else if($horaA[0] < $horaB[0]){
      return 1;
    }else{
      if($horaA[1] > $horaB[1]){
        return -1;
      }else if($horaA[1] < $horaB[1]){
        return 1;
      }else{
        if($horaA[2] > $horaB[2]){
          return -1;
        }else if($horaA[2] < $horaB[2]){
          return 1;
        }else{
          return 0;
        }
      }
    }
  }

  return (strtotime($b->inicio) - strtotime($a->inicio));
}