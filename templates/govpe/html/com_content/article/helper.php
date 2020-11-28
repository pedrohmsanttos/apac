<?php

defined('_JEXEC') or die;

function getArticlesFromBlogCategory()
{
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('a.title,a.id,a.catid')
	    ->from($db->quoteName('#__content', 'a'))
			->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON (' . $db->quoteName('c.id') . ' = ' . $db->quoteName('a.catid') . ')')
			->where($db->quoteName('a.publish_up').' <= now() and '.$db->quoteName('a.publish_down').' >= now() and '.$db->quoteName('c.path') . ' LIKE \'blog%\'','OR')
			->where($db->quoteName('a.publish_up').' <= now() and '.$db->quoteName('a.publish_down').' >= now() and '.$db->quoteName('c.path') . ' LIKE \'noticia%\'','OR')
			->where($db->quoteName('a.publish_up').' <= now() and '.$db->quoteName('a.publish_down').' >= now() and '.$db->quoteName('c.path') . ' LIKE \'descubra%\'')
	    ->order($db->quoteName('a.title') . ' DESC')
		 	->group($db->quoteName('a.catid').','.$db->quoteName('a.title').','.$db->quoteName('a.id'))
			->setLimit('5');
	$db->setQuery($query);
	$newArticleList = $db->loadObjectList();
	return $newArticleList;
}

function getArticleFromBlogCategory($id_article)
{
	if(empty($id_article)) return array();
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('a.title,a.id,a.catid')
	    ->from($db->quoteName('#__content', 'a'))
			->join('INNER', $db->quoteName('#__categories', 'c') . ' ON (' . $db->quoteName('c.id') . ' = ' . $db->quoteName('a.catid') . ')')
			->where($db->quoteName('a.publish_up').' <= now() and '.$db->quoteName('a.publish_down').' >= now() and '.$db->quoteName('c.path') . ' LIKE \'blog%\' and a.id = '.$id_article,'OR')
	    ->where($db->quoteName('a.publish_up').' <= now() and '.$db->quoteName('a.publish_down').' >= now() and '.$db->quoteName('c.path') . ' LIKE \'descubra%\' and a.id = '.$id_article)
	    ->order($db->quoteName('a.title') . ' DESC')
			->group($db->quoteName('a.id').','.$db->quoteName('a.title').','.$db->quoteName('a.catid'))
			->setLimit('5');
	$db->setQuery($query);
	$newArticleList = $db->loadObjectList();
	return $newArticleList[0];
}

function getTagsByArticleId($article_id)
{
  if(empty($article_id)) return array();
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query
    ->select(array('tags.title', 'tags.id'))
    ->from($db->quoteName('#__tags', 'tags'))
    ->join('INNER', $db->quoteName('#__contentitem_tag_map', 'tagmap') . ' ON (' . $db->quoteName('tags.id') . ' = ' . $db->quoteName('tagmap.tag_id') . ')')
    ->where($db->quoteName('tagmap.content_item_id') . ' = '.$article_id)
    ->order($db->quoteName('tags.title') . ' ASC');
  $db->setQuery($query);
  $results = $db->loadObjectList();
  //SELECT tags.title, tags.id FROM `mk9xj_tags` as tags INNER JOIN mk9xj_contentitem_tag_map as tagmap ON tags.id = tagmap.tag_id WHERE tagmap.content_item_id = 65
  return $results;
}

function getRelacionadosByArticleId($article_id)
{
	if(empty($article_id)) return array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select(array('anexo.titulo', 'anexo.id','anexo.arquivo','anexo.level_id','anexo.level_parent'))
	    ->from($db->quoteName('#__relacionado_anexo', 'anexo'))
	    ->join('INNER', $db->quoteName('#__relacionado', 'relacionado') . ' ON (' . $db->quoteName('relacionado.id') . ' = ' . $db->quoteName('anexo.id_relacionado') . ')')
	    ->where($db->quoteName('relacionado.artigos')." LIKE ".$db->quote('%'.'*'.$article_id.'*'.'%'))
	    // ->group($db->quoteName('anexo.level_parent'))
	    // ->group(implode(',', array('anexo.level_parent','anexo.titulo', 'anexo.id','anexo.arquivo','anexo.level_id')))
	    ->order($db->quoteName('anexo.level_id') . ' ASC');
    // echo "<pre>";
    $db->setQuery($query);

    return $db->loadObjectList();
}

function getRelacionadoIdByArticleId($article_id)
{
	if(empty($article_id)) return array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select(array('relacionado.id'))
	    ->from($db->quoteName('#__relacionado_anexo', 'anexo'))
	    ->join('INNER', $db->quoteName('#__relacionado', 'relacionado') . ' ON (' . $db->quoteName('relacionado.id') . ' = ' . $db->quoteName('anexo.id_relacionado') . ')')
		->where($db->quoteName('relacionado.artigos')." LIKE ".$db->quote('%'.$article_id.'%'))
		->group($db->quoteName('relacionado.id'));
	$db->setQuery($query);
	$ids = $db->loadObjectList();
	$ids = implode(', ', array_map(function ($object) { return $object->id; }, $ids));
	return $ids;
}

function ordenar($a, $b)
{
  return ($a->ordering - $b->ordering);
}

class ArquivosHelper
{
	public static function getArquivoItems($catid)
    {
		if(empty($catid)) return array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__arquivo'));
        $query->where('published = 1 AND catid = '.$catid);
        $db->setQuery($query);
        return $db->loadObjectList();
    }

	public static function getArticlesItems($catid)
    {
			  if(empty($catid)) return array();
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__content'));
        $query->where('state = 1 AND catid = '.$catid);
        $db->setQuery($query);
        return $db->loadObjectList();
    }

	public static function getAvisoItems()
    {
        $db = JFactory::getDbo();
        $query = $db->getQuery(true);
        $query->select('*');
        $query->from($db->quoteName('#__aviso'));
        $query->where('published = 1');
        $db->setQuery($query);
        return $db->loadObjectList();
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

		function formataData($str)
		{
			if(empty($str)) return '';

			$arrStr = explode(" ", $str);
			$hora = str_replace(":", "h", $arrStr[1]);
			$hora = substr($hora, 0, 5);
			$data = explode('-', $arrStr[0]);

			if($data[1] == '01') $Mes = 'JAN';
			if($data[1] == '02') $Mes = 'FEV';
			if($data[1] == '03') $Mes = 'MAR';
			if($data[1] == '04') $Mes = 'ABR';
			if($data[1] == '05') $Mes = 'MAI';
			if($data[1] == '06') $Mes = 'JUN';
			if($data[1] == '07') $Mes = 'JUL';
			if($data[1] == '08') $Mes = 'AGO';
			if($data[1] == '09') $Mes = 'SET';
			if($data[1] == '10') $Mes = 'OUT';
			if($data[1] == '11') $Mes = 'NOV';
			if($data[1] == '12') $Mes = 'DEZ';

			$ano = substr($data[0], 2,4);

			// retorna um array de dia, mes/ano, e hora.
			return "$data[2] "." $Mes/$ano ". " $hora "."min";
		}

		function get_string_between($string, $start, $end){
			$ini = strpos($string, $start);
			if ($ini == 0) return '';
			$ini += strlen($start);
			$len = strpos($string, $end, $ini) - $ini;
			return substr($string, $ini, $len);
		}

		function getModuleByTitle($module_title)
		{
			$db = JFactory::getDbo();
			$query = $db->getQuery(true);
			$query->select('*');
			$query->from($db->quoteName('#__modules', 'm'));
			$query->where('m.title = '.$db->quote($module_title));
			$db->setQuery($query);
			$newArticleList = $db->loadObjectList();
			return $newArticleList[0];
		}
}
