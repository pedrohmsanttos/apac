<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once 'helper.php';

$app   = JFactory::getApplication();
$admin = $app->isAdmin();
$qtdResults = 0;

if(! $admin) { // view site

	$jinput = JFactory::getApplication()->input;

	$busca       = '';
	$ordem       = '';
	$filtro      = '';
	$idCategoria = '';

	$busca       = $jinput->get('busca', '', 'html');
	$ordem       = $jinput->get('ordem', '', 'html');
	$tipo        = $jinput->get('tipo', '', 'html');
	$filtro      = $jinput->get('filtro', '', 'html');
	$idCategoria = $jinput->get('catid', '', 'int');
	
	$resultadoBusca = array();

	if(!empty($tipo) && ! empty($busca)){
		// pagina + arquivo
		if(strpos($tipo, 'pagina')){
			$resultadoBusca = buscaPorIdCategoria($idCategoria,$busca,$ordem,$filtro);
		}
		//agenda
		if(strpos($tipo, 'agenda')){
			$resultadoBuscaAgenda = buscaAgenda($busca,$ordem);
		}
		//arquivo
		$resultadoBuscaArq = buscaArquivo($busca,$ordem);
	} elseif(!empty($busca)) {
		$resultadoBusca = buscaPorIdCategoria($idCategoria,$busca,$ordem,$filtro);
	}


	$qtdResults     = count($resultadoBusca);


	//paginação
	$itensPorPagina = 4;

	$totalDeItensDeBusca = count($resultadoBusca) + count($resultadoBuscaArq) + count($resultadoBuscaAgenda);
	$totalPagina = ceil( $totalDeItensDeBusca/ $itensPorPagina ); //calculate total pages

	$paginaAtual = JFactory::getApplication()->input->get('page',1, 'int');
	$paginaAnterior = $paginaAtual - 1;
	$paginaProxima = $paginaAtual + 1;
	if($paginaAnterior <= 0) $paginaAnterior = 1;

	
	$resultadoBusca = paginacao($resultadoBusca,$paginaAtual,$itensPorPagina)->vetor;

	if(!empty($resultadoBuscaArq)){
		$resultadoBuscaArq = paginacao($resultadoBuscaArq,$paginaAtual,$itensPorPagina)->vetor;
	}

	if(!empty($resultadoBuscaAgenda)){
		$resultadoBuscaAgenda = paginacao($resultadoBuscaAgenda,$paginaAtual,$itensPorPagina)->vetor;
	}
 	
    $redirectUrl = $_SERVER['REQUEST_URI'];
	//fim paginação

	setTituloPaginaBusca('Busca','Resultado da Busca por '.$busca);
	require_once('busca_site_view.php');

} // view site
