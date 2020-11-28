<?php
class ModRodapeHelper
{
    public static function getParams()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('params')));
        $query->from($db->quoteName('#__modules'));
        $query->where('module = '.$db->quote("mod_rodape").' ');

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

        $query->select($db->quoteName(array('id', 'title', 'introtext','catid')));
        $query->from($db->quoteName('#__content'));
        $query->where('state = 1 an id='.$id);

        $db->setQuery($query);

        $articlesList = $db->loadObjectList();
        return $articlesList[0];
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

        $prms = json_decode($categoryList[0]->params);

        $categoryList[0]->getArticles = array();

        if($categoryList[0]->parent_id == '1') {

            $categoryList[0]->getSubcat   = self::getSubcat($categoryList[0]->id);
            $categoryList[0]->getArticles = self::getArticlesByCategory($categoryList[0]->id);

        } else {

            $categoryList[0]->getSubcat   = self::getSubcat($categoryList[0]->parent_id);
            $categoryList[0]->getArticles = self::getArticlesByCategory($categoryList[0]->parent_id);

        }

        $categoryList[0]->image = $prms->image;
        $categoryList[0]->link = 'index.php?option=com_content&view=category&id='.$id;

        return $categoryList[0];
    }
     public static function getLink($id_artigo)
    {
        $categId = self::getArticle($id_artigo)->catid;
        return 'index.php?option=com_content&view=article&id='.$id_artigo.'&catid='.$categId;
    }

    function getArticlesByCategory($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title','alias','introtext')));
        $query->from($db->quoteName('#__content'));
        $query->where('state = 1 and catid='.$id);

        $db->setQuery($query);

        $categoryList = $db->loadObjectList();

        return $categoryList;
    }

    function getSubcat($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title','alias','description','params','parent_id')));
        $query->from($db->quoteName('#__categories'));
        $query->where('parent_id='.$id);

        $db->setQuery($query);
         
        $categoryList = $db->loadObjectList();

        return $categoryList;
    }

}

function montaLink($categId,$categAlias,$artId,$artAlias)
{
    // exemplo: descubra-pernambuco/34-descubra-pernambuco/30-cultura
    return $categAlias.'/'.$categId.'-'.$categAlias.'/'.$artId.'-'.$artAlias;
}
