<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';

$prefeituraHelper = new ModPrefeituraHelper();

$letras = $prefeituraHelper::getLetras();
$mesorregioes = $prefeituraHelper::getMesorregioesAtivas();

require JModuleHelper::getLayoutPath('mod_prefeitura');
