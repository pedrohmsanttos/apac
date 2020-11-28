<?php
/**
 * @copyright	Copyright © 2019 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	http://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;
require_once 'helper.php';

$doc = JFactory::getDocument();
/* Available fields:"ip_webservice","porta_webservice", */
// Include assets
JHtml::_('jquery.framework');
$doc->addStyleSheet(JURI::root()."modules/mod_mapa_previsao_municipio/assets/css/style.css");
$doc->addStyleSheet(JURI::root()."modules/mod_mapa_previsao_municipio/assets/css/select2.css");
$doc->addScript(JURI::root()."modules/mod_mapa_previsao_municipio/assets/js/script.js");
$doc->addScript(JURI::root()."modules/mod_mapa_previsao_municipio/assets/js/select2.js");
// $width 			= $params->get("width");

/**
	$db = JFactory::getDBO();
	$db->setQuery("SELECT * FROM #__mod_mapa_previsao_municipio where del=0 and module_id=".$module->id);
	$objects = $db->loadAssocList();
*/

$mapaPrevisaoMunicipio 	= new ModMapaPrevisaoMunicipioHelper();
$dadosWS = array();
$dadosWS['ip_webservice'] 		= $params->get('ip_webservice');
$dadosWS['porta_webservice'] 	= $params->get('porta_webservice');

// var_dump($dadosWS);die;

// $dados = $mapaPrevisaoMunicipio::getPrevisaoByIdMunicipio($dadosWS, '3');

//    echo( json_encode(  $dados )  );die;
// $dados = $mapaPrevisaoMunicipio::getDadosMunicipio($dadosWS); 
$dados = $mapaPrevisaoMunicipio::getPrevisaoMunicipios($dadosWS); 
// $dados->metadados->datas[] = date('d-m-Y');
// $dados->metadados->datas[] = date('d-m-Y',strtotime("+1 day"));
// $dados->metadados->datas[] = date('d-m-Y',strtotime("+2 day"));

// echo json_encode($dados);die;

$diasemana = array('Domingo', 'Segunda-Feira', 'Terça-Feira', 'Quarta-Feira', 'Quinta-Feira', 'Sexta-Feira', 'Sábado');



require JModuleHelper::getLayoutPath('mod_mapa_previsao_municipio', $params->get('layout', 'default'));