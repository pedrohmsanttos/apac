<?php
// No direct access
defined('_JEXEC') or die;

$app      = JFactory::getApplication();
$path     = JURI::base(true).'/templates/'.$app->getTemplate().'/images/logo.png';
$base_url = JURI::base(true).'/';
//$path.'images/logo.png'

$url_image = $base_url.$params->get('url_image');
$url_image_mobile = $base_url.$params->get('url_image_mobile');
$html_title = $params->get('html_title');

if(empty($url_image)) $url_image = $path;
if(empty($html_title)) $html_title = 'Governo do estado de<br><span>Pernambuco</span>';

require JModuleHelper::getLayoutPath('mod_logo');
