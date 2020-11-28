<?php 
// No direct access
defined('_JEXEC') or die;
class ModListagemapatrabalhoHelper
{ 
	function montaLinkAcessibilidade($categId,$categAlias,$artId,$artAlias)
	{
	    // exemplo: descubra-pernambuco/34-descubra-pernambuco/30-cultura
	    return 'governo'.'/'.$categId.'-'.$categAlias.'/'.$artId.'-'.$artAlias;
	}

	 function getArticle($id)
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

	 function getArticles($id)
	{
		if(empty($id)) return '';

		$categ= self::getCategory($id);

	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);
	     
	    $query->select($db->quoteName(array('id', 'title', 'introtext','catid','alias')));
	    $query->from($db->quoteName('#__content'));
	    $query->where($db->quoteName('publish_up').' <= now() and '.$db->quoteName('publish_down').' >= now() and '.'catid='.$id);
	     
	    $db->setQuery($query);
	     
	    $articlesList = $db->loadObjectList();

		foreach ($articlesList as $article) {
			$article->link = self::montaLinkAcessibilidade($article->catid,$categ->alias,$article->id,$article->alias);
		}

	    return $articlesList;
	}

	function getCategory($id)
	    {
	        $db = JFactory::getDbo();
	        $query = $db->getQuery(true);
	         
	        $query->select($db->quoteName(array('id', 'title','alias','description','params','parent_id')));
	        $query->from($db->quoteName('#__categories'));
	        $query->where('id='.$id);
	         
	        $db->setQuery($query);
	         
	        $categoryList = $db->loadObjectList();
	        
	        return $categoryList[0];
	    }

}