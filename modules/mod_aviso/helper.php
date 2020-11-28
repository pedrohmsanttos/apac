<?php
defined('_JEXEC') or die;

class ModAvisoHelper
{
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
     $query->where("extension = ".$db->quote('com_aviso')." and published = 1",'OR');
     $query->where("extension = ".$db->quote('com_avisometeorologico')." and published = 1",'OR');
     $query->where("extension = ".$db->quote('com_avisohidrologico')." and published = 1");
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

  // Add selec ording query
  public static function getAvisosMeteorologicoItems($id)
  {
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);
      $query->select('*');
      $query->from($db->quoteName('#__avisometeorologico'));
      if(!empty($id)){
        $query->where("published = 1 and tipo=".$id, 'AND');
      } else {
        $query->where("published = 1", 'AND');
      }
      $query->where("inicio < now() AND validade > now()  ");
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
      $query->where("inicio < now() AND validade > now()  ");
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
      $query->where("inicio < now() AND validade > now()  ");
      $query->where("ordering = 0", 'AND');
      
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
      $query->where("inicio < now() AND validade > now()  ");
      $query->where("ordering = 0", 'AND');
      
      $db->setQuery($query);
      return $db->loadObjectList();
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