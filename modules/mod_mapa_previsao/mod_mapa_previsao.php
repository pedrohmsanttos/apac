<?php

// var_dump(JURI::root());die;
/**
 * @copyright	Copyright © 2018 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	http://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;
require_once 'helper.php';

$doc = JFactory::getDocument();
/* Available fields: */
// Include assets
$doc->addStyleSheet(JURI::root()."modules/mod_mapa_previsao/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_mapa_previsao/assets/js/script.js");
// $width 			= $params->get("width");

/**
	$db = JFactory::getDBO();
	$db->setQuery("SELECT * FROM #__mod_mapa_previsao where del=0 and module_id=".$module->id);
	$objects = $db->loadAssocList();
*/

$tipo = "1";
if(isset($_GET['tipo'])){
	$tipo = $_GET['tipo'];
}

$hoje = true;

if($tipo == "1"){
	$hoje = true;
}else{
	$hoje = false;
}

  
$mapaPrevisao 	= new ModMapaPrevisaoHelper();
$retornoPrevi 	= $mapaPrevisao::getPrevisaoDia($hoje,true);
$previsoes 		= $retornoPrevi['previsao'];
$erroPrevisao 	= $retornoPrevi['erro'];

try {
    $idUltimoPrevisao = $mapaPrevisao::getPrevisaoDiaHora();
} catch (Exception $e) {
    echo '<center><h1>Desculpe!</h1></center><br>',  $e->getMessage(), "\n";
}
if(!$erroPrevisao && empty($previsoes)){

	// Se não tiver dado erro ao recuperar as mesoregiões e não tiver previsão para o dia ou amanhã
	// Pegar a ultima previsão publicada
	$retornoPrevi 	= $mapaPrevisao::getPrevisaoDia($hoje,true);
	$previsoes 		= $retornoPrevi['previsao'];
	$erroPrevisao 	= $retornoPrevi['erro'];
}

// var_dump($erroPrevisao);die;


// echo ( json_encode(  $previsoes ) );die;

$url = $_SERVER['REQUEST_SCHEME'] . "://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . $_SERVER['REDIRECT_URL'];



require JModuleHelper::getLayoutPath('mod_mapa_previsao', $params->get('layout', 'default'));