<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';

$rodape_params = ModRodapeHelper::getParams();

$categ1 = ModRodapeHelper::getCategory($rodape_params->categoria_1);
$categ2 = ModRodapeHelper::getCategory($rodape_params->categoria_2);
$categ3 = ModRodapeHelper::getCategory($rodape_params->categoria_3);
$categ4 = ModRodapeHelper::getCategory($rodape_params->categoria_4);
$categ5 = ModRodapeHelper::getCategory($rodape_params->categoria_5);
$categ6 = ModRodapeHelper::getCategory($rodape_params->categoria_6);

$html_endr   = $rodape_params->html_endr;

require JModuleHelper::getLayoutPath('mod_rodape');
