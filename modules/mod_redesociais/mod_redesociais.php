<?php
defined('_JEXEC') or die;
require_once('helper.php');

$doc = JFactory::getDocument();
$doc->addStyleSheet('modules/mod_redesociais/tmpl/css/mod_redesociais.css');

$redesSociais = ModRedesSociasHelper::getParams();

require JModuleHelper::getLayoutPath('mod_redesociais');
