<?php
define('_JEXEC', 1);
define('JPATH_BASE', '../../../../../../');

require_once JPATH_BASE . 'includes/defines.php';
require_once JPATH_BASE . 'includes/framework.php';

$app = JFactory::getApplication('site');
$doc = JFactory::getDocument();
$requests = JFactory::getApplication()->input;

$titulo = $requests->get('titulo','','string');
$result['find'] = false;

$resultMsg = 'Arquivo não encontrado.';

$app->setHeader('Content-Type', 'application/json', true)->sendHeaders();

if(!empty($titulo))
{

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from($db->quoteName('#__relacionado_anexo'));
    $query->where("titulo = '$titulo'");
    $db->setQuery($query);
    $anexos = $db->loadObjectList();

    if(!empty($anexos)){
    	$result['find'] = true;
		$resultMsg = 'Titulo já encontrado';
    }

}

echo new JResponseJson($result, $resultMsg);
