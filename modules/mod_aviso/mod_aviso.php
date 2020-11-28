<?php
// No direct access
defined('_JEXEC') or die;

require_once 'helper.php';

$avisoHelper = new ModAvisoHelper;

$avisosZeros = []; 

$avisos            = $avisoHelper::getAvisosMeteorologicoItems('');
$avisosHidro       = $avisoHelper::getAvisosHidrologicoItems('');
$avisosMeteorzeros = $avisoHelper::getAvisosMeteorologicoItemsZeros('');
$avisosHidrozeros  = $avisoHelper::getAvisosHidrologicoItemsZeros('');

foreach ($avisosMeteorzeros as $avisosMeteor_item) {
    array_push($avisosZeros,$avisosMeteor_item);
}

foreach ($avisosHidrozeros as $avisosMeteor_item) {
    array_push($avisosZeros,$avisosMeteor_item);
}

foreach ($avisosHidro as $avisosHidro_item) {
    array_push($avisos,$avisosHidro_item);
}

// ordenando pela ordem
usort($avisos, "intcmp");
// quando a ordem é igual a zero se ordena pela data
usort($avisosZeros, "datacmp");

// inserindo no final os avisos de ordem 0
foreach ($avisosZeros as $avisosHidro_item) {
    array_push($avisos,$avisosHidro_item);
}


if(!empty($avisos) ){ //&& empty($_SESSION["ocultarAvisoPopUp"])
    $_SESSION["ocultarAvisoPopUp"] = 1;
    require JModuleHelper::getLayoutPath('mod_aviso');
}
