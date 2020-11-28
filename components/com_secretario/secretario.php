<?php
defined('_JEXEC') or die;
require_once 'helper.php';

$doc = JFactory::getDocument();

$requests = JFactory::getApplication()->input;

$id_secretario = $requests->get('id', '', 'int');
$id_sescretaria = $requests->get('secretaria', '', 'int');

$secretario = getSecretario($id_secretario);
$secretaria = getSecretaria($id_sescretaria);



if (empty($secretario)) {
	header("HTTP/1.0 404 Not Found");
} else {
	setTituloPaginaFromComponent('secretarias',$secretaria->titulo);
	require_once 'secretario_view.php';
}
