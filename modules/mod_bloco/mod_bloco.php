<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';
JHtml::_('jquery.framework', false);
JFactory::getDocument()->addScript('modules/mod_bloco/tmpl/js/simpleLightbox.min.js');
JFactory::getDocument()->addScript('modules/mod_bloco/tmpl/js/mod_bloco.js');
JFactory::getDocument()->addStyleSheet('modules/mod_bloco/tmpl/css/simpleLightbox.min.css');


$blocoHelper = new ModBlocoHelper;

$arquivos = $blocoHelper::getArquivosByCatId($params->get('categoria_1'));

require JModuleHelper::getLayoutPath('mod_bloco');
