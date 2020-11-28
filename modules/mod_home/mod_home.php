<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';

$doc = JFactory::getDocument();
$renderer = $doc->loadRenderer('module');

$module_acontece = ModHomeHelper::loadActiveModule('mod_acontece');
$module_bannerdestaque = ModHomeHelper::loadActiveModule('mod_bannerdestaque');
$module_bannerdestaqueSlideshow = ModHomeHelper::loadActiveModule('mod_bannerdestaqueslideshow');
$module_servicos = ModHomeHelper::loadActiveModule('mod_servicos');

require JModuleHelper::getLayoutPath('mod_home');
