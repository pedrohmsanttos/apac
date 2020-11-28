<?php 
class ModNoticiasHelper 
{

	public static function getActiveArticlesByCatId($catid)
	{

		if(empty($catid)) return '';

	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);
	     
	    $query->select($db->quoteName(array('id', 'title', 'introtext','alias','catid','images','created')));
	    $query->from($db->quoteName('#__content'));
	    $query->where($db->quoteName('publish_up').' <= now() and '.$db->quoteName('publish_down').' >= now() and '.'state = 1 and catid='.$catid);
		$query->order('created ASC');
	     
	    $db->setQuery($query);
	     
	    $articlesList = $db->loadObjectList();
	    return $articlesList;
	}

	public static function getParams()
	{
	    $db = JFactory::getDbo(); 
	    $query = $db->getQuery(true);

	    $query->select($db->quoteName(array('params')));
	    $query->from($db->quoteName('#__modules'));
	    $query->where('module = '.$db->quote("mod_noticias").' ');
	     
	    $db->setQuery($query);
	     
	    $results = $db->loadObjectList();
	    $params_object = json_decode($results[0]->params);

	    return $params_object;
	}

	

	public static function getSubCategoryChildrenIds($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
         
        $query->select($db->quoteName(array('id')));
        $query->from($db->quoteName('#__categories'));
        $query->where('parent_id='.$id);
         
        $db->setQuery($query);
         
        $categoryList = $db->loadObjectList();
        return $categoryList;
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

function str2dataArray($str){

	if(empty($str)) return '';

	$arrStr = explode(" ", $str);
	$hora = str_replace(":", "h", $arrStr[1]);
	$hora = substr($hora, 0, 5);
	$data = explode('-', $arrStr[0]);	

	return array("$data[2]/$data[1]/$data[0]", "$hora");

}
//recebe obj do tipo ARTIGO E ID DA CATEGORIA
function getLink($artigo)
{
	$catid = $artigo->catid;
	$categoria = getCategoryById($catid);
	$id_artigo = $artigo->id;

	if($categoria->parent_id == "1") {
    	return 'index.php?option=com_content&view=article&id='.$id_artigo.'&catid='.$catid;
	} else {
		$alias_artigo = $artigo->alias;
    	return $categoria->path.'/'.$id_artigo.'-'.$alias_artigo;
	}

}

function getCategoryById($id)
{
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
     
    $query->select($db->quoteName(array('id', 'title','alias','description','parent_id','path')));
    $query->from($db->quoteName('#__categories'));
    $query->where('id='.$id);
     
    $db->setQuery($query);
     
    $categoryList = $db->loadObjectList();
	$categoryList[0]->link = "index.php?option=com_content&view=category&id=$id";
    return $categoryList[0];
}