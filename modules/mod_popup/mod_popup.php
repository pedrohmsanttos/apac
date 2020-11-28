<?php
// No direct access
defined('_JEXEC') or die;

$url_script = JUri::base() . 'modules/mod_popup/tmpl/tingle.min.js';
$url_script_popup = JUri::base() . 'modules/mod_popup/tmpl/popup.js';
$url_stylesheet = JUri::base() . 'modules/mod_popup/tmpl/tingle.min.css';

$html = $params->get('html');
$tempo_indeterminado = $params->get('tempo_indeterminado');
$data_fim = explode(" ",$params->get('data_fim'));

date_default_timezone_set('America/Recife');
$data_atual = date('m/d/Y h:i:s', time());

$datetime1 = new DateTime($data_atual);
$datetime2 = new DateTime($data_fim[0]);
$interval = $datetime1->diff($datetime2);
$diferenca_de_data = $interval->format('%R%a');

if($diferenca_de_data === '-0' || $tempo_indeterminado == 1):
    JFactory::getDocument()->addScriptDeclaration(" var modal_content = '<center>$html</center>';");

    if(! empty($width) && ! empty($height)):
      JFactory::getDocument()->addStyleDeclaration(".tingle-modal-box{width:$width !important;height:$height!important;}");
    endif;

    JFactory::getDocument()->addStyleSheet($url_stylesheet);
    JFactory::getDocument()->addScript($url_script);
    JFactory::getDocument()->addScript($url_script_popup);
    require JModuleHelper::getLayoutPath('mod_popup');
endif;
