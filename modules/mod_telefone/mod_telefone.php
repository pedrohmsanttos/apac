<?php
// No direct access
defined('_JEXEC') or die;

require_once 'helper.php';

$telefoneHelper = new ModTelefoneHelper;
//$telefones  = $telefoneHelper::getPublishedItems();
$categorias = $telefoneHelper::getCategories();

require JModuleHelper::getLayoutPath('mod_telefone');
