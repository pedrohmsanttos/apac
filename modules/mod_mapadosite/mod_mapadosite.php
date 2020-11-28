<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';
$siteMap = new ModMapadositeHelper();

$listagemDeCategorias = $siteMap::getArticlesFromCategories();

require JModuleHelper::getLayoutPath('mod_mapadosite');
