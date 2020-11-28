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
  $query->where($db->quoteName('path')." not LIKE '$alias%' and extension =".$db->quote('com_avisohidrologico'));
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
