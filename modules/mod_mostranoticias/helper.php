<?php
class ModMostraNoticiasHelper
{
    public static function getArticlesByCategory($id , $order = 'data')
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

        $query->select(array('a.*'));
        $query->from($db->quoteName('#__content', 'a'));
        $query->where('state = 1 and featured =1 and catid IN ('.$catidFilhos.')');
        
        // escolher a ordenação
        if($order == 'data'){
            $query->order('created DESC');
        }else{
            $query->order('ordering DESC');
        }
        
        //var_dump($query->__toString());die();
        $db->setQuery($query);

        $articlesList = $db->loadObjectList();
        return $articlesList;
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
    public static function getCategoryChildrenIds($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title','alias','description','params','path','parent_id')));
        $query->from($db->quoteName('#__categories'));
        $ids = implode(",", $id);
        if(is_array($id)){
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
}
