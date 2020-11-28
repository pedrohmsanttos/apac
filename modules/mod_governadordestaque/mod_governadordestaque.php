<?php
// No direct access
defined('_JEXEC') or die;

$linkredesocias = $params->get('linkredesocias');
$conteudo       = $params->get('conteudo');
$dados          = $params->get('dados');
$catid          = $params->get('catid');

if(! empty($catid)){
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);

	$query->select('*');
	$query->from($db->quoteName('#__agenda'));
	$query->where("published = 1 and catid = $catid and data >= now()");
	// $query->group($db->quoteName("data") . 'ASC');
	$query->setLimit(6);

	$db->setQuery($query);
	$agendas = $db->loadObjectList();
}

function formataDataHora($str)
	{
		if(empty($str)) return '';

		$arrStr = explode(" ", $str);
		$hora = str_replace(":", "h", $arrStr[1]);
		$hora = substr($hora, 0, 5);
		$data = explode('-', $arrStr[0]);

		if($data[1] == '01') $mes = 'janeiro';
		if($data[1] == '02') $mes = 'fevereiro';
		if($data[1] == '03') $mes = 'março';
		if($data[1] == '04') $mes = 'abril';
		if($data[1] == '05') $mes = 'maio';
		if($data[1] == '06') $mes = 'junho';
		if($data[1] == '07') $mes = 'julho';
		if($data[1] == '08') $mes = 'agosto';
		if($data[1] == '09') $mes = 'setembro';
		if($data[1] == '10') $mes = 'outubro';
		if($data[1] == '11') $mes = 'novembro';
		if($data[1] == '12') $mes = 'dezembro';

		$ano = substr($data[0], 2,4);
		$dia = $data[2];

		// retorna um array de dia, mes/ano, e hora.
		return array("$dia de $mes de $ano", "$hora"."min");
	}

require JModuleHelper::getLayoutPath('mod_governadordestaque');
