<?php 
defined('_JEXEC') or die;

class ModAcaodeGovernoHelper
{ 
	public static function getPublishedItems()
    {
        $db = JFactory::getDbo(); 

        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__acaogoverno'));
        $query->where('published = 1');
         
        $db->setQuery($query);

        $acaogoverno = $db->loadObjectList();

        // foreach ($acaogovernos as $acaogoverno) {
        //     $acaogoverno->link = self::getLink($acaogoverno->link_detalhamentoacao);
        // }

        return $acaogoverno;

    }


    public static function getLink($id_artigo)
    {
        if(empty($id_artigo)) return '';
        $categId    = self::getArticle($id_artigo)->catid; 
        $artAlias   = self::getArticle($id_artigo)->alias; 
        $categ      = self::getCategoryById($categId);
        $categAlias = self::getCategoryById($categId)->alias; 
        $menuAlias  = "";
        
        if($categ->parent_id != '1'){
            //é uma categoria filha
            $menuAlias = self::getCategoryById($categ->parent_id)->alias;
        }

        // return 'index.php?option=com_content&view=article&id='.$id_artigo.'&catid='.$categId;
        return $menuAlias.'/'.$categId.'-'.$categAlias.'/'.$id_artigo.'-­'.$artAlias;
    }

    public static function getArticle($id)
    {
        if(empty($id)) return array();
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
        if(empty($id)) return array();
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
}