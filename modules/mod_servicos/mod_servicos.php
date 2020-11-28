<?php
// No direct access
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';
require_once dirname(__FILE__) . '/Mobile_Detect.php';

$detectMob     = new MobileDetect;
$servicosHelper = new ModServicosHelper;
$servicoParams = ModServicosHelper::getParams();
$servicos      = ModServicosHelper::getCategoriasServicosAtivas();

$url = '';
if(! empty($servicoParams->article_id)):
  $article = JControllerLegacy::getInstance('Content')->getModel('Article')->getItem($servicoParams->article_id);
  $url = $article->category_alias.'/'.$article->catid.'-'.$article->category_alias.'/'.$article->id.'-'.$article->alias;
endif;

require JModuleHelper::getLayoutPath('mod_servicos');
