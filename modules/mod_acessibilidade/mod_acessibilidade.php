<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';

//página de acessibilidade
$IdArtigo = $params->get('article');
$IdArtigo_map = $params->get('article_map');
$linkArtigoAcessb = '';
$acessb = new ModAcessibilidadeHelper();

if(! empty($IdArtigo)) {
	$categId    = $acessb::getCategory($acessb::getArticle($IdArtigo)->catid)->id;
	$categAlias = $acessb::getCategory($acessb::getArticle($IdArtigo)->catid)->alias;
	$artId      = $acessb::getArticle($IdArtigo)->id;
	$artAlias   = $acessb::getArticle($IdArtigo)->alias;
	$linkArtigoAcessb = $acessb::montaLinkAcessibilidade($categId,$categAlias,$artId,$artAlias);
}

if(! empty($IdArtigo_map)) {
	$categId    = $acessb::getCategory($acessb::getArticle($IdArtigo_map)->catid)->id;
	$categAlias = $acessb::getCategory($acessb::getArticle($IdArtigo_map)->catid)->alias;
	$artId      = $acessb::getArticle($IdArtigo_map)->id;
	$artAlias   = $acessb::getArticle($IdArtigo_map)->alias;
	$linkArtigoMap = $acessb::montaLinkAcessibilidade($categId,$categAlias,$artId,$artAlias);
}

$redesSociais = $acessb::getParamRedesSociais();

$previsoes = $acessb::getPrevisoes();

require JModuleHelper::getLayoutPath('mod_acessibilidade');
