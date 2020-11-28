<?php
defined( '_JEXEC' ) or die( 'Restricted access' );
require_once 'helper.php';

$app   = JFactory::getApplication();
$admin = $app->isAdmin();
$qtdResults = 0;

if(!$admin) { // view site

	$jinput = JFactory::getApplication()->input;

	$busca = '';
	$de    = '';
	$para  = '';
	$catid = '';
	$semParametros = false;

	// $busca  = $jinput->get('busca', '', 'html');
	$busca  = $jinput->get('busca', '', 'username');
	$de     = $jinput->get('de', '', 'html');
	$para   = $jinput->get('para', '', 'html');
	$catid  = $jinput->get('catid', '', 'raw');
	// set array result of search
	$resultadoBusca = array();
	$resultadoBuscaInfo = array();
	// get all category
	if (!ctype_digit($catid)){
		$catid_orgn = $catid;
		$catid2 = $catid; 
	}


	$categorias_arquivo = getBuscaCategories('com_arquivo');
	$categorias_licitacao = getModalidadeLicitacao();
	// $categorias_aviso   = getBuscaCategories('com_aviso');
	$categorias_aviso   = array();
	$categorias_infor   = array();
	$categorias_content = getBuscaCategories('com_content');

	$categorias_aviso_hidro  = getBuscaCategories('com_avisohidrologico');
	$categorias_aviso_meteor = getBuscaCategories('com_avisometeorologico');

	$categorias_informe_hidro  = getBuscaCategories('com_informehidrologico');
	$categorias_informe_meteor = getBuscaCategories('com_informemeteorologico');

	if(!empty($categorias_aviso_hidro)){
		foreach ($categorias_aviso_hidro as $categorias_aviso_hidro_item) {
			array_push($categorias_aviso,$categorias_aviso_hidro_item);
		}
	}

	if(!empty($categorias_aviso_meteor)){
		foreach ($categorias_aviso_meteor as $categorias_aviso_meteor_item) {
			array_push($categorias_aviso,$categorias_aviso_meteor_item);
		}
	}

	if(!empty($categorias_informe_hidro)){
		foreach ($categorias_informe_hidro as $categorias_informe_hidro_item) {
			array_push($categorias_infor,$categorias_informe_hidro_item);
		}
	}

	if(!empty($categorias_informe_meteor)){
		foreach ($categorias_informe_meteor as $categorias_informe_meteor_item) {
			array_push($categorias_infor,$categorias_informe_meteor_item);
		}
	}


	if(($busca != '' || $catid != ''))
	{	
		$semParametros = true;

		if ($catid2 != '') {
		$resultadoBuscaLicit = getLicitacaoByCatId($catid2,$busca,$de,$para);
		} else {

		$resultadoBuscaArq = getArquivosByCatId($catid,$busca,$de,$para);
		$resultadoBuscaCnt = getContentByCatId($catid,$busca,$de,$para);
		$resultadoBuscaHidro  = getAvisosHidrologicoByCatId($catid,$busca,$de,$para);
		$resultadoBuscaMeteor = getAvisosMeteorologicoByCatId($catid,$busca,$de,$para);

		$resultadoBuscaInfoHidro  = getInformeHidrologicoByCatId($catid,$busca,$de,$para);
		$resultadoBuscaInfoMeteor = getInformeMeteorologicoByCatId($catid,$busca,$de,$para);
		}
		
		// $resultadoBusca = getAvisosByCatId($catid,$busca,$de,$para);
		// $resultadoBuscaArq = getArquivosByCatId($catid,$busca,$de,$para);
		// $resultadoBuscaCnt = getContentByCatId($catid,$busca,$de,$para);
		// $resultadoBuscaHidro  = getAvisosHidrologicoByCatId($catid,$busca,$de,$para);
		// $resultadoBuscaMeteor = getAvisosMeteorologicoByCatId($catid,$busca,$de,$para);

		// $resultadoBuscaInfoHidro  = getInformeHidrologicoByCatId($catid,$busca,$de,$para);
		// $resultadoBuscaInfoMeteor = getInformeMeteorologicoByCatId($catid,$busca,$de,$para);

		foreach ($resultadoBuscaHidro as $resultadoBuscaHidro_item) {
			array_push($resultadoBusca,$resultadoBuscaHidro_item);
		}

		foreach ($resultadoBuscaMeteor as $resultadoBuscaMeteor_item) {
			array_push($resultadoBusca,$resultadoBuscaMeteor_item);
		}

		foreach ($resultadoBuscaInfoHidro as $resultadoBuscaInfoHidro_item) {
			array_push($resultadoBuscaInfo,$resultadoBuscaInfoHidro_item);
		}

		foreach ($resultadoBuscaInfoMeteor as $resultadoBuscaInfoMeteor_item) {
			array_push($resultadoBuscaInfo,$resultadoBuscaInfoMeteor_item);
		}

		$qtdResults = count($resultadoBusca) + count($resultadoBuscaArq) + count($resultadoBuscaCnt) + count($resultadoBuscaInfo) + count($resultadoBuscaLicit);

		//paginação
		$itensPorPagina = 4;
		$totalDeItensDeBusca = $qtdResults;
		$totalPagina         = ceil( max(count($resultadoBusca), count($resultadoBuscaArq), count($resultadoBuscaCnt), count($resultadoBuscaInfo), count($resultadoBuscaLicit))/ ($itensPorPagina) ); //calculate total pages

		$paginaAtual    = JFactory::getApplication()->input->get('page',1, 'int');
		$paginaAnterior = $paginaAtual - 1;
		$paginaProxima  = $paginaAtual + 1;

		if($paginaAnterior <= 0) $paginaAnterior = 1;
		
		$resultadoBusca    = paginacao($resultadoBusca,$paginaAtual,$itensPorPagina)->vetor;
		$resultadoBuscaArq = paginacao($resultadoBuscaArq,$paginaAtual,$itensPorPagina)->vetor;
		$resultadoBuscaCnt = paginacao($resultadoBuscaCnt,$paginaAtual,$itensPorPagina)->vetor;
		$resultadoBuscaInfo= paginacao($resultadoBuscaInfo,$paginaAtual,$itensPorPagina)->vetor;
		$resultadoBuscaLicit= paginacao($resultadoBuscaLicit,$paginaAtual,$itensPorPagina)->vetor;

		$redirectUrl = $_SERVER['REQUEST_URI'];
		//fim paginação

		setTituloPaginaBusca('Busca Avançada','Resultado da Busca por '.$busca);

		

	}else{
		setTituloPaginaBusca('Busca Avançada','');
	}

	usort($categorias_content, "cmp");
	usort($categorias_arquivo, "cmp");
	usort($categorias_aviso, "cmp");

	require_once('busca_site_view.php');

} // view site
