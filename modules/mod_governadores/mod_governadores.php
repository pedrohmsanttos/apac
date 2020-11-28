<?php
// No direct access
defined('_JEXEC') or die;

$jinput = JFactory::getApplication()->input;
$idArtigo = $jinput->get('id', null, null);
$idCatArtigo = $jinput->get('catid', null, null);

$db = JFactory::getDbo(); 
$query = $db->getQuery(true);

$query->select('*');
$query->from($db->quoteName('#__governador')); 
$db->setQuery($query);
 
$governadores = $db->loadObjectList();


$paginaAtual   = JFactory::getApplication()->input->get('page',1, 'int');
$paginaAnterior = $paginaAtual - 1;
$paginaProxima = $paginaAtual + 1;
if($paginaAnterior <= 0) $paginaAnterior = 1;

$vetorPaginado = paginacao($governadores,$paginaAtual,12)->vetor;
$totalPagina   = paginacao($governadores,$paginaAtual,12)->total_paginas;
 

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

require JModuleHelper::getLayoutPath('mod_governadores');
