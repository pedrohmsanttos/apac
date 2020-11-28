<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once 'helper.php';

$app   = JFactory::getApplication();
$admin = $app->isAdmin();
$qtdResults = 0;

if(! $admin) { // view site

	$id    = JFactory::getApplication()->input->get('id', '', 'int');
	$catid = JFactory::getApplication()->input->get('catid', '', 'int');

	//sql injection 
	$id    = (int) $id;
    $catid = (int) $catid;

    //Meteorologico
	$aviso = getAvisoById($id,$catid);

	//hidrologico
	if(empty($aviso)) $aviso = getAvisoHidrologicoById($id,$catid);


	if(empty($aviso)){
		require_once('aviso_view_erro.php');
	} else {
		

		$categDados = getCategoryById2($aviso->tipo);
		$catTitle   = (empty($categDados->title)) ? '' : $categDados->title ;


		if(isValidAvisoMeteorologico($id,$catid)){
			$avisoExpirado = true;
		} else if(isValidAvisoHidrologico($id,$catid)) {
			$avisoExpirado = true;
		} else {
			$avisoExpirado = false;
		}
		
		$anexosM = getAnexosMeteorologicosByAvisoId($aviso->rg);
		$anexosH = getAnexosHidrologicosByAvisoId($aviso->rg);


		if(! empty($anexosM)){
			$anexos = $anexosM;
		} else {
			$anexos = $anexosH;
		}

		setTituloPagina2($catTitle,$aviso->identificador." - ".$aviso->titulo);
		require_once('aviso_view.php');
	}

} // view site
