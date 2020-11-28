<?php
class ModMostraNoticiasHelper
{
    public static function getParams()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('params')));
        $query->from($db->quoteName('#__modules'));
        $query->where('module = '.$db->quoteName("mod_mostranoticias"));
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
        // $query->where('state = 1');
        $db->setQuery($query);
        $articlesList = $db->loadObjectList();
        return $articlesList;
    }
    public static function getArticle($id)
    {
        if(empty($id)) return '';
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'title', 'introtext','catid','alias')));
        $query->from($db->quoteName('#__content'));
        $query->where('id='.$id);
        $query->where('published = 1');
        // $query->where('state = 1');
        $db->setQuery($query);
        $articlesList = $db->loadObjectList();
        return $articlesList[0];
    }
    public static function getCategory($id)
    {
        if(empty($id)) return '';
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__categories'));
        $query->where('id='.$id);
        $query->where('published = 1');
        $db->setQuery($query);
        $categoryList = $db->loadObjectList();
        return $categoryList[0];
    }

     public static function getCategoryById($id)
    {
        if(empty($id)) return '';
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('id', 'title','alias','description','params','parent_id','path')));
        $query->from($db->quoteName('#__categories'));
        $query->where('id='.$id);
        $query->where('published = 1');
        $db->setQuery($query);
        $categoryList = $db->loadObjectList();
        $prms = json_decode($categoryList[0]->params);
        $catPath = explode('/', $categoryList[0]->path)[0];

        if($categoryList[0]->parent_id != '1'){
          $categoryList[0]->link = $catPath.'/'.$categoryList[0]->id.'-'.$catPath.'/'.$categoryList[0]->alias;
        } else {
          $categoryList[0]->link = $catPath;
        }

        return $categoryList[0];
    }
    function getLink($artigo,$idCategoriaNoticia)
    {
       if(empty($artigo) || empty($idCategoriaNoticia)) return '';
        //noticias/13-noticias/49-processos-licitatorios-sao-tema-de-curso
        $categoria = self::getCategory($idCategoriaNoticia);//da categoria pai
        $link = $categoria->alias.'/'.$categoria->id.'-'.$categoria->alias.'/'.$artigo->article_id.'-'.$artigo->alias;
        return $link;
    }
    public static function getArticlesByCategory($id)
    {
      if(empty($id)) return '';
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);
      $query
          ->select(array('a.*', 'b.id', 'b.parent_id'))
          ->select($db->qn('a.id', 'article_id'))
          ->from($db->quoteName('#__content', 'a'))
          ->join('INNER', $db->quoteName('#__categories', 'b') . ' ON (' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('b.id') . ')')
          ->where(' a.state=1 and b.id = '.$id.' or a.state=1 and b.parent_id = '.$id)
          ->order($db->quoteName('a.created') . ' DESC');
      $query->setLimit(4);
      $db->setQuery($query);
      $results = $db->loadObjectList();
      return $results;
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
}
