<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';

$servicoParams = ModServicosHelper::getParams();
$servicos      = ModServicosHelper::getCategoriasPorServicosAtivas();

require JModuleHelper::getLayoutPath('mod_todoservicos');
