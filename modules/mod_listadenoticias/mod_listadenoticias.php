<?php
// No direct access
defined('_JEXEC') or die;
require_once('helper.php');
$artigosHlp = new ModListaDeNoticiasHelper();

$cat_id = implode(",", $params->get('categoria'));
$artigos = $artigosHlp::getArticlesByCategoryId($cat_id);

$paginaAtual = JFactory::getApplication()->input->get('page',1, 'int');
$paginaAnterior = $paginaAtual - 1;
$paginaProxima = $paginaAtual + 1;
if($paginaAnterior <= 0) $paginaAnterior = 1;

$artigos = paginacao2($artigos,$paginaAtual,3)->vetor;
$totalPagina   = paginacao2($artigos,$paginaAtual,3)->total_paginas;

require JModuleHelper::getLayoutPath('mod_listadenoticias');
