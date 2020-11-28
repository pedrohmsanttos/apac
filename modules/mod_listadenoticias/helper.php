<?php
class ModListaDeNoticiasHelper
{

	public static function getParams()
	{
	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select($db->quoteName(array('params')));
	    $query->from($db->quoteName('#__modules'));
	    $query->where('module = '.$db->quote("mod_listadenoticias").' ');

	    $db->setQuery($query);

	    $results = $db->loadObjectList();
	    $params_object = json_decode($results[0]->params);
        
	    return $params_object;
	}

	public static function getArticlesByCategoryId($id)
	{
		$catidFilhos = self::getCategoryChildrenIds($id);

        $qtdVirgulas = substr_count($catidFilhos, ',');
        if($qtdVirgulas == 1) $catidFilhos = str_replace(',', '', $catidFilhos);

	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('c.*,cat.title as cat_title');
	    $query->from($db->quoteName('#__content','c'));
 		$query->join('INNER', $db->quoteName('#__categories', 'cat') . ' ON (' . $db->quoteName('c.catid') . ' = ' . $db->quoteName('cat.id') . ')');
	    $query->where($db->quoteName('c.publish_up').' <= now() and '.$db->quoteName('c.publish_down').' >= now() and '.'state=1 and catid IN('.$catidFilhos.')');

	    $db->setQuery($query);

	    return $db->loadObjectList();

	}

	public static function getCategoryChildrenIds($id)
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);

        $query->select($db->quoteName(array('id', 'title','alias','description','params','path','parent_id')));
        $query->from($db->quoteName('#__categories'));
        $query->where('parent_id IN ('.$id.')');

        $db->setQuery($query);

        $categorias = $db->loadObjectList();
        $total      = count($categorias);
        $contador   = 0;
        if($contador > $total)
            $listaDeIds = $id.',';
        else
            $listaDeIds = $id;
        
        $contador++;
        foreach ($categorias as $categoria) {
            $contador++;
            if($contador > $total){
                $listaDeIds .= $categoria->id;
            } else {
                $listaDeIds .= $categoria->id.',';
            }
        }
        
        return $listaDeIds;
    }

	public static function getCategoryById($id)
	{
	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('*');
	    $query->from($db->quoteName('#__categories'));
	    $query->where('state=1 and id='.$id);

	    $db->setQuery($query);

	    return $db->loadObjectList()[0];

	}
}

function limitaString2($x, $length)
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

function str2dataArr2($str)
{

	if(empty($str)) return '';

	$arrStr = explode(" ", $str);
	$hora = str_replace(":", "h", $arrStr[1]);
	$hora = substr($hora, 0, 5);
	$data = explode('-', $arrStr[0]);

	return array("$data[2]/$data[1]/$data[0]", "$hora");

}

function paginacao2($yourDataArray,$page,$limit)
{
    if(empty($page)) $page = 3;
    if(empty($limit)) $limit = 2;

    // $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
    $total = count( $yourDataArray ); //total items in array
    $totalPages = ceil( $total/ $limit ); //calculate total pages
    $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
    $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
    $offset = ($page - 1) * $limit;
    if( $offset < 0 ) $offset = 0;

    $yourDataArray = array_slice( $yourDataArray, $offset, $limit );

    $saida = new stdClass();
    $saida->vetor = $yourDataArray;
    $saida->total_paginas = $totalPages;
   return $saida;

}
