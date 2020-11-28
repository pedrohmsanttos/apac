<?php
class ModBannerDestaqueHelper
{
    public static function getParams()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('params')));
        $query->from($db->quoteName('#__modules'));
        $query->where('module = '.$db->quote("mod_bannerdestaque"));

        $db->setQuery($query);

        $results = $db->loadObjectList();
        $params_object = json_decode($results[0]->params);

        return $params_object;
    }

    public static function getArticles()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title', 'introtext')));
        $query->from($db->quoteName('#__content'));
        $query->where('state = 1');

        $db->setQuery($query);

        $articlesList = $db->loadObjectList();
        return $articlesList;
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
    public static function getCategory($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title','alias','description')));
        $query->from($db->quoteName('#__categories'));
        $query->where('id='.$id);

        $db->setQuery($query);

        $categoryList = $db->loadObjectList();
        return $categoryList[0];
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
     public static function getLink($id_artigo)
    {

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
}
