<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';

$avisoHelper  = new ModAvisoListaHelper;
$categoria    = $params->get('categoria');
$mostrarTodos = $params->get('mostratodos');
// numero de avisos por página
$numPorPagina = 5;

// $avisos = $avisoHelper::getAvisoItems($categoria);

$avisosZeros = []; 

if(!empty($mostrarTodos) && $mostrarTodos == '1'){
  // $avisos = $avisoHelper::getAvisoItems('');
  $avisos            = $avisoHelper::getAvisosMeteorologicoItems('');
  $avisosHidro       = $avisoHelper::getAvisosHidrologicoItems('');
  $avisosMeteorzeros = $avisoHelper::getAvisosMeteorologicoItemsZeros('');
  $avisosHidrozeros  = $avisoHelper::getAvisosHidrologicoItemsZeros('');
}else{
  $avisos            = $avisoHelper::getAvisosMeteorologicoItems($categoria);
  $avisosHidro       = $avisoHelper::getAvisosHidrologicoItems($categoria);
  $avisosMeteorzeros = $avisoHelper::getAvisosMeteorologicoItemsZeros($id);
  $avisosHidrozeros  = $avisoHelper::getAvisosHidrologicoItemsZeros($id);
}

foreach ($avisosMeteorzeros as $avisosMeteor_item) {
  array_push($avisosZeros,$avisosMeteor_item);
}

foreach ($avisosHidrozeros as $avisosMeteor_item) {
  array_push($avisosZeros,$avisosMeteor_item);
}

foreach ($avisosHidro as $avisosHidro_item) {
  array_push($avisos,$avisosHidro_item);
}

// ordenando pela ordem
usort($avisos, "intcmp");
// quando a ordem é igual a zero se ordena pela data
usort($avisosZeros, "datacmp");

// inserindo no final os avisos de ordem 0
foreach ($avisosZeros as $avisosHidro_item) {
  array_push($avisos,$avisosHidro_item);
}

/* paginação*/
$jinput        = JFactory::getApplication()->input;
$idPaginaAtual = $jinput->get('id');
$app           = Jfactory::getApplication();
$input         = $app->input;

if ($input->getCmd('option')=='com_content'&& $input->getCmd('view')=='article' )
{
    $cmodel     = JModelLegacy::getInstance('Article', 'ContentModel');
    $catid_page = $cmodel->getItem($app->input->get('id'))->catid;
}

$paginaAtual    = JFactory::getApplication()->input->get('page',1, 'int');
$paginaAnterior = $paginaAtual - 1;
$paginaProxima  = $paginaAtual + 1;
if($paginaAnterior <= 0) $paginaAnterior = 1;
// total de avisos
$total = count($avisos);
// avisos por pagina
$totalPagina = ceil($total/$numPorPagina);

$avisos      = $avisoHelper::paginacao($avisos,$paginaAtual,$numPorPagina)->vetor;
//$totalPagina = $avisoHelper::paginacao($avisos,$total,5)->total_paginas;

/* paginação*/

require JModuleHelper::getLayoutPath('mod_todosavisos');
