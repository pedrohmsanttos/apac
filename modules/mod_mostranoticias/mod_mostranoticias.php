<?php
// No direct access
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';

$idCategorias = $params->get('catid');
$tipo         = $params->get('tipo');
$titulo       = $params->get('titulo');
$contagem     = $params->get('contagem');
$order        = $params->get('ordenacao');
$contador     = 1;

$ultimasNoticias = ModMostraNoticiasHelper::getArticlesByCategory($idCategorias, $order);

require JModuleHelper::getLayoutPath('mod_mostranoticias');
