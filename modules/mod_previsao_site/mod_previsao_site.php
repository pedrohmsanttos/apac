<?php
/**
 * @copyright	Copyright © 2018 - All rights reserved.
 * @license		GNU General Public License v2.0
 * @generator	http://xdsoft/joomla-module-generator/
 */
defined('_JEXEC') or die;

$doc = JFactory::getDocument();
// Include assets
Jhtml::_('jquery.framework');
$doc->addStyleSheet(JURI::root()."modules/mod_previsao_site/assets/css/style.css");
$doc->addScript(JURI::root()."modules/mod_previsao_site/assets/js/script.js");
// $width 			= $params->get("width");

require_once 'helper.php';

$previsaoSiteHelper = new ModPrevisaoSiteHelper();

$mesorregioes = $previsaoSiteHelper::getMesorregioesAtivas();

require JModuleHelper::getLayoutPath('mod_previsao_site', $params->get('layout', 'default'));