<?php
class ModBannerDestaqueSlideshowHelper
{
    public static function getParams()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select($db->quoteName(array('params')));
        $query->from($db->quoteName('#__modules'));
        $query->where('module = '.$db->quote("mod_bannerdestaqueslideshow"));

        $db->setQuery($query);

        $results = $db->loadObjectList();
        $params_object = json_decode($results[0]->params);

        return $params_object;
    }

    public static function getArticles()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title', 'introtext','images','metadesc')));
        $query->from($db->quoteName('#__content'));
        $query->where('state = 1');

        $db->setQuery($query);

        $articlesList = $db->loadObjectList();
        return $articlesList;
    }

     public static function getFeaturedArticles()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title', 'introtext')));
        $query->from($db->quoteName('#__content'));
        $query->where('state = 1 and featured =1');

        $db->setQuery($query);

        $articlesList = $db->loadObjectList();
        return $articlesList;
    }

     public static function getFeaturedArticlesByCategory($id, $order = 'data')
    {
        if(empty($id)) return array();

        $catidFilhos = self::getCategoryChildrenIds($id);

        $qtdVirgulas = substr_count($catidFilhos, ',');
        if($qtdVirgulas == 1) $catidFilhos = str_replace(',', '', $catidFilhos);

        $size = strlen($catidFilhos);
        if(substr($catidFilhos, -1) == ','){
            $catidFilhos = substr($catidFilhos,0, $size-1);
        }

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title', 'introtext','images','metadesc','catid')));
        $query->from($db->quoteName('#__content'));
        $query->where('state = 1 and featured =1 and catid IN ('.$catidFilhos.')');
        
        // escolher a ordenação
        if($order == 'data'){
            $query->order('created DESC');
        }else{
            $query->order('ordering DESC');
        }

        $db->setQuery($query);

        $articlesList = $db->loadObjectList();
        return $articlesList;
    }

     public static function getCategoryChildrenIds($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title','alias','description','params','path','parent_id')));
        $query->from($db->quoteName('#__categories'));
        $ids = implode(",", $id);
        if(is_array($id) && count($id) > 0){
            $query->where('parent_id IN ('. $ids .')');
        }else if(isset($id)){
            $query->where('parent_id = '. $id );    
        }
        
        
        $db->setQuery($query);
        
        $categorias = $db->loadObjectList();
        $listaDeIds = (is_array($id)) ? $ids.',' : $id.',';
        $total      = count($categorias);
        $contador   = 1;

        foreach ($categorias as $categoria ) {
            $contador++;
            if($contador > $total){
                $listaDeIds .= $categoria->id;
            } else {
                $listaDeIds .= $categoria->id.',';
            }
        }
        
        return $listaDeIds;
    }

    public static function getArticle($id)
    {

        if(empty($id)) return '';

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title', 'introtext','catid','images', 'metadesc')));
        $query->from($db->quoteName('#__content'));
        if(is_array($id)){
            $query->where('id IN ('.$id.')');
        }else{
            $query->where('id='.$id);
        }
        

        $db->setQuery($query);

        $articlesList = $db->loadObjectList();
        return $articlesList[0];
    }

    public static function getLastestArticlesFromCategory($catid)
    {

        if(empty($catid)) return '';

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title', 'introtext','catid','images','created')));
        $query->from($db->quoteName('#__content'));
        //$query->where('catid='.$catid);
        if(is_array($catid)){
            $query->where('catid IN ('. implode(",", $catid) .')');
        }else{
            $query->where('catid='.$catid);
        }
        $query->order('created DESC');
        
        $db->setQuery($query);

        $articlesList = $db->loadObjectList();
        return $articlesList[0];
    }

    public static function getCategory($id)
    {
        if(empty($id)) return '';

        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title','alias','description')));
        $query->from($db->quoteName('#__categories'));
        $query->where('id='.$id);
        
        $db->setQuery($query);
        $categoryList = $db->loadObjectList();
        return $categoryList[0];
    }
    function getLink($artId,$cat_alias)
  	{

        if(empty($artId)) return array();
  	    // exemplo: descubra-pernambuco/34-descubra-pernambuco/30-cultura
  		  $db = JFactory::getDbo();
  	    $query = $db->getQuery(true);

  	    $query->select(array('a.alias as article_alias', 'b.id as category_id', 'b.alias as category_alias','b.path as category_path','b.parent_id as category_parent_id'))
  			    ->from($db->quoteName('#__content', 'a'))
  			    ->join('INNER', $db->quoteName('#__categories', 'b') . ' ON (' . $db->quoteName('a.catid') . ' = ' . $db->quoteName('b.id') . ')')
  			    ->where('a.id = '.$artId);
  	    $db->setQuery($query);

  	    $articlesList = $db->loadObjectList();
        
        if(empty($cat_alias)) $cat_alias = $articlesList[0]->category_alias;
  	    //$url = $cat_alias.'/'.$articlesList[0]->category_id.'-'.$articlesList[0]->category_alias.'/'.$artId.'-'.$articlesList[0]->article_alias;
          $url = JUri::base().'index.php?option=com_content&view=article&id='.$artId.'&catid='.$articlesList[0]->category_id;
          return $url;

    }
}