<?php
class ModAconteceHelper
{   
    
    public static function getAconteceOptions($params)
    {
        $parametros = new \stdClass;

        $parametros->titulo_1    = $params->get('titulo_1');
        $parametros->link_1      = $params->get('link_1');
        $parametros->media_1     = $params->get('media_1');
        $parametros->categoria_1 = $params->get('categoria_1');

        $parametros->titulo_2    = $params->get('titulo_2');
        $parametros->link_2      = $params->get('link_2');
        $parametros->media_2     = $params->get('media_2');
        $parametros->categoria_2 = $params->get('categoria_2');

        $parametros->titulo_3    = $params->get('titulo_3');
        $parametros->link_3      = $params->get('link_3');
        $parametros->media_3     = $params->get('media_3');
        $parametros->categoria_3 = $params->get('categoria_3');

        $parametros->titulo_4    = $params->get('titulo_4');
        $parametros->link_4      = $params->get('link_4');
        $parametros->media_4     = $params->get('media_4');
        $parametros->categoria_4 = $params->get('categoria_4');

        //adicionando o titulo da categoria ao objeto de acontece
        $parametros->categoria_1_titulo = self::getCategory($params->get('categoria_1'))->title;
        $parametros->categoria_2_titulo = self::getCategory($params->get('categoria_2'))->title;
        $parametros->categoria_3_titulo = self::getCategory($params->get('categoria_3'))->title;
        $parametros->categoria_4_titulo = self::getCategory($params->get('categoria_4'))->title;
        
        //imagem da categoria 
        $parametros->categoria_1_imagem = self::getCategory($params->get('categoria_1'))->image;
        $parametros->categoria_2_imagem = self::getCategory($params->get('categoria_2'))->image;
        $parametros->categoria_3_imagem = self::getCategory($params->get('categoria_3'))->image;
        $parametros->categoria_4_imagem = self::getCategory($params->get('categoria_4'))->image; 
        
        //link da categoria
        $parametros->categoria_1_link = self::getCategory($params->get('categoria_1'))->link;
        $parametros->categoria_2_link = self::getCategory($params->get('categoria_2'))->link;
        $parametros->categoria_3_link = self::getCategory($params->get('categoria_3'))->link;
        $parametros->categoria_4_link = self::getCategory($params->get('categoria_4'))->link;

        return $parametros;
        
    }

    public static function isVideo($str)
    {
        return strpos($str, '.mp4');
    }
  
    public static function getCategory($id)
    {
        if(empty($id)) return array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
         
        $query->select($db->quoteName(array('id', 'title','alias','description','params','path')));
        $query->from($db->quoteName('#__categories'));
        $query->where('id='.$id);
         
        $db->setQuery($query);
         
        $categoryList = $db->loadObjectList();
        
        $prms = json_decode($categoryList[0]->params);

        $categoryList[0]->image = $prms->image;
        $categoryList[0]->link = 'index.php?option=com_content&view=category&id='.$id;
        
        return $categoryList[0];
    }

      public static function getCategoryChildrenIds($id)
    {
        if(empty($id)) return array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
         
        $query->select($db->quoteName(array('id', 'title','alias','description','params','path','parent_id')));
        $query->from($db->quoteName('#__categories'));
        $query->where('parent_id='.$id);
         
        $db->setQuery($query);
         
        $categorias = $db->loadObjectList();
        $listaDeIds = '';
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

     public static function getLink($id_artigo)
    {
        //$categId = self::getArticle($id_artigo)->catid; 
        return 'index.php?option=com_content&view=article&id='.$id_artigo.'&catid='.$categId;
    }

     public static function getLatestArticles($id_cat)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
         
        $query->select($db->quoteName(array('id', 'title', 'introtext','catid','alias','created')));
        $query->from($db->quoteName('#__content'));
        if(! empty($id_cat)){

            $cat_childrenIds = self::getCategoryChildrenIds($id_cat);
            if(! empty($cat_childrenIds)){
                $query->where('state=1 and catid IN ('.$cat_childrenIds.')');
            } else {
                $query->where('state=1');

            }


        } else {
            $query->where('state=1');

        }

        $query->order('created DESC');

        
        $db->setQuery($query);

         
        return $db->loadObjectList();
    }

    function montaLink($artId,$artAlias,$categId)
    {
        // exemplo: descubra-pernambuco/34-descubra-pernambuco/30-cultura
        $categ = self::getCategory($categId);

        //se catid for id de subtegoria, procular o alias da categoria pai
        $catStrTmp  = explode('/', $categ->path);
        $categAlias = $catStrTmp[0];
        return $categAlias.'/'.$categId.'-'.$categAlias.'/'.$artId.'-'.$artAlias;
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