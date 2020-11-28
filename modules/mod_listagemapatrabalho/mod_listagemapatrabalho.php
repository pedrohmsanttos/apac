<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';

$descricao = $params->get('description');
$catid     = $params->get('catid');

$articles = ModListagemapatrabalhoHelper::getArticles($catid);

require JModuleHelper::getLayoutPath('mod_listagemapatrabalho');
