<?php
defined('_JEXEC') or die;
define('COM_CONTATO_BASE', JUri::base().'components/com_previsaonosite/');
JHtml::_('jquery.framework', false);
require_once 'helper.php';

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root()."components/com_previsaonosite/css/bannerPrevisaoTempo.css");

//Vars
$largura = $_GET['largura'];
$altura  = $_GET['altura'];
$regioes = $_GET['id_regioes'];

if( count(explode(',', $regioes)) <= 0 || $regioes == null)
{
    $regioes = 1;
}

$previsao = new PrevisaoHelper();


$previsoes   = $previsao::getPrevisoes($regioes);
if ($previsoes[0]->diaTexto =='1970-01-01'){
    $diaprevisao=" ";
}else{
    $diaprevisao = $previsao->getDia($previsoes[0]->diaTexto);
}



// Return view
require_once('previsaonosite_view.php');