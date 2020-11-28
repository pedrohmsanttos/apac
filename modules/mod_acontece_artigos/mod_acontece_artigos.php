<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';

$aconteceHelper  = new ModAconteceHelper;
$acontece        = ModAconteceHelper::getAconteceOptions($params);
$categoria_de_noticias = $params->get('categoria_de_noticias');
$ultimasNoticias = ModAconteceHelper::getLatestArticles($categoria_de_noticias);
$boxMax = $params->get('max_box');
$titulo = $params->get('titulo_acontece');

if(empty($boxMax)) $boxMax = 6;

require JModuleHelper::getLayoutPath('mod_acontece_artigos');
