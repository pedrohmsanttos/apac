<?php defined('_JEXEC') or die('Restricted access');

function getBlacklist($alias)
{

  if(empty($alias)) return '';
  $alias = strtolower($alias->title);

  if($alias == "administrator") return '';
  // $alias = substr($alias, 0, 4);
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('id');
  $query->from($db->quoteName('#__categories'));
  $query->where($db->quoteName('path')." not LIKE '$alias%' and extension =".$db->quote('com_avisometeorologico'));
  $db->setQuery($query);
  $blacklist_itens = $db->loadObjectList();

  $blacklist = array();

  foreach ($blacklist_itens as $blacklist_obj) {
    array_push($blacklist,$blacklist_obj->id);
  }

  return $blacklist;
}

function getGroupAlias($id)
{

  if(empty($id)) return '';
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('title');
  $query->from($db->quoteName('#__usergroups'));
  $query->where("id = $id");
  $db->setQuery($query);
  $alias = $db->loadObjectList()[0];
  return $alias;
}

function js_array($array)
{
    $temp = array_map('js_str', $array);
    return '[' . implode(',', $temp) . ']';
}

function getAnexosById($id){

  if(empty($id)) return '';
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('*');
  $query->from($db->quoteName('#__avisometeorologico_anexo'));
  $query->where("id_aviso = $id");
  $db->setQuery($query);
  $anexos = $db->loadObjectList();
  return $anexos;

}

function getUsernameById($id)
{
  return JFactory::getUser($youruserid)->get('username');
}

 function preparaData($str)
{
  //2017-07-20 19:58:59
  if(empty($str)) return '';
  $arrStr = explode(" ", $str);
  $hora = str_replace(":", ":", $arrStr[1]);
  $hora = substr($hora, 0, 5);
  $data = explode('-', $arrStr[0]);
  return "$data[2]/$data[1]/$data[0] $hora";
}

function return_bytes($val)
{
    $val  = trim($val);

    $last = strtolower($val[strlen($val)-1]);
    $val  = substr($val, 0, -1); // necessary since PHP 7.1; otherwise optional

    switch($last) {
        // The 'G' modifier is available since PHP 5.1.0
        case 'g':
            $val *= 1024;
        case 'm':
            $val *= 1024;
        case 'k':
            $val *= 1024;
    }

    return $val;
}
