<?php
// No direct access
defined('_JEXEC') or die;
require_once 'helper.php';
JHtml::_('jquery.framework', false);
JFactory::getDocument()->addScript('modules/mod_galeria/tmpl/js/simpleLightbox.min.js');
JFactory::getDocument()->addScript('modules/mod_galeria/tmpl/js/mod_galeria.js');
JFactory::getDocument()->addStyleSheet('modules/mod_galeria/tmpl/css/simpleLightbox.min.css');


$galHelper = new ModGaleriaHelper;


$arquivos_categoria_1 = $galHelper::getArquivosByCatId($params->get('categoria_1'));
$arquivos_categoria_2 = $galHelper::getArquivosByCatId($params->get('categoria_2'));
$arquivos_categoria_3 = $galHelper::getArquivosByCatId($params->get('categoria_3'));

require JModuleHelper::getLayoutPath('mod_galeria');
