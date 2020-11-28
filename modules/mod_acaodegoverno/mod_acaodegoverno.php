<?php
// No direct access
defined('_JEXEC') or die;

require_once 'helper.php';

$acaogovernos = ModAcaodeGovernoHelper::getPublishedItems();

require JModuleHelper::getLayoutPath('mod_acaodegoverno');
