<?php

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

function str2dataArr($str)
{

	if(empty($str)) return '';

	$arrStr = explode(" ", $str);
	$hora = str_replace(":", "h", $arrStr[1]);
	$hora = substr($hora, 0, 5);
	$data = explode('-', $arrStr[0]);

	return array("$data[2]/$data[1]/$data[0]", "$hora");

}

function paginacao($yourDataArray,$page,$limit)
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
