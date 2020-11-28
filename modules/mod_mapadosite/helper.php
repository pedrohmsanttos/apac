<?php defined('_JEXEC') or die; 
class ModMapadositeHelper
{   

    public static function getArticlesFromCategories()
    {

		$db = JFactory::getDbo();
        $query = $db->getQuery(true);
         
        $query->select($db->quoteName(array('id', 'title','alias','description','params','parent_id')));
        $query->from($db->quoteName('#__categories'));
		$query->where("extension = ".$db->quote('com_content')." and path not like ". $db->quote('%noticias%') ." ");
        $db->setQuery($query);         
        $categoryList = $db->loadObjectList();
        
		if(! empty($categoryList)){
			foreach ($categoryList as $categoryItem) {
				$categoryItem->articles = self::getArticlesByCatId($categoryItem->id);
			}
		}
        
        return $categoryList;
	}
	function montaLink($categId,$categAlias,$artId,$artAlias)
	{
	    // exemplo: descubra-pernambuco/34-descubra-pernambuco/30-cultura
	    return $categAlias.'/'.$categId.'-'.$categAlias.'/'.$artId.'-'.$artAlias;
	}
	public static function getArticlesByCatId($catid)
	{

		if(empty($catid)) return '';

	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);
	     
	    $query->select($db->quoteName(array('id', 'title', 'introtext','alias','catid','images','created')));
	    $query->from($db->quoteName('#__content'));
	    $query->where('state=1 and catid ='.$catid);
	     
	    $db->setQuery($query);
	     
	    $articlesList = $db->loadObjectList();
	    return $articlesList;
	}

}