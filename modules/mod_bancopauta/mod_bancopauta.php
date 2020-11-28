<?php
// No direct access
defined('_JEXEC') or die;

require_once 'helper.php';

$bancoPautaHelper = new ModBancoPautaHelper;

$redirectUrl = $_SERVER['REDIRECT_URL'];

$palacio  	 = $bancoPautaHelper::getPalacioAgenda($params->get('catid'));
$secretaria  = $bancoPautaHelper::getSecretariaAgenda($params->get('catid'));

JFactory::getDocument()->addStyleDeclaration('.list-agenda__item__content{width:100% !important}');

require JModuleHelper::getLayoutPath('mod_bancopauta');
