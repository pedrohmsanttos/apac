<?php
// No direct access
defined('_JEXEC') or die;

require_once 'helper.php';

$orgaos = ModOrgaoHelper::getPublishedItems();

require JModuleHelper::getLayoutPath('mod_orgao');
