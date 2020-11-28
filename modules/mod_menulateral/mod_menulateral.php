<?php
// No direct access
defined('_JEXEC') or die;

$app   	   = JFactory::getApplication();
$doc       = JFactory::getDocument();
$menus     = @$app->getMenu()->getItems();
$active    = $app->getMenu()->getActive();

$blackList = array();
if(! empty($params->get('esconder'))) {
	$blackList = explode(';',$params->get('esconder'));
}

require JModuleHelper::getLayoutPath('mod_menulateral');
