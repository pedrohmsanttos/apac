<?php
// No direct access
defined('_JEXEC') or die;
$db = JFactory::getDbo(); 
$query = $db->getQuery(true);

$query->select($db->quoteName(array('params')));
$query->from($db->quoteName('#__modules'));
$query->where("module = ".$db->quote('mod_planodefundo')." ");
$db->setQuery($query);
 
$resultados_bg = $db->loadObjectList();
$parametros_bg = json_decode($resultados_bg[0]->params);
$imagem        = (!empty($parametros_bg->imagem)) ? $parametros_bg->imagem : '';
$imagem        = JUri::base().$imagem;

require JModuleHelper::getLayoutPath('mod_planodefundo');
