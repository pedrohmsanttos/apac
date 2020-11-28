<?php
// No direct access
defined('_JEXEC') or die;

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select('id, nome');
$query->from($db->quoteName('#__contato_setor'));

$db->setQuery($query);

$setores = $db->loadObjectList();

JFactory::getDocument()->addScript('modules/mod_contato/tmpl/masked.input.js');
JFactory::getDocument()->addScript('modules/mod_contato/tmpl/mod_contato.js');

$msg1 = $params->get('header_msg1');
$msg2 = $params->get('header_msg2');
$msg3 = $params->get('header_msg3');

if(empty($msg2) || $msg2 == ''){
    $msg2 = 'Registre aqui suas dúvidas, sugestões ou reclamações';
}

if(empty($msg3) || $msg3 == ''){
    $msg3 = 'Fale Conosco';
}


setTituloPagina($msg3,$msg2);

require JModuleHelper::getLayoutPath('mod_contato');
