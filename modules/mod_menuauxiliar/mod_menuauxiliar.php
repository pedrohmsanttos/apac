<?php
// No direct access
defined('_JEXEC') or die;

$app   	   = JFactory::getApplication();
$doc       = JFactory::getDocument();
$menus     = @$app->getMenu()->getItems();
$active    = $app->getMenu()->getActive();

require JModuleHelper::getLayoutPath('mod_menuauxiliar');
