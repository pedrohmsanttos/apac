<?php
// No direct access
defined('_JEXEC') or die;

require_once 'helper.php';

$agendaHelper = new ModAgendaHelper;

$eventosFuturos  = $agendaHelper::getEventoProximos($params->get('catid'));
$eventosPassados = $agendaHelper::getEventoPassados($params->get('catid'));

JFactory::getDocument()->addStyleDeclaration('.list-agenda__item__content{width:100% !important}');

require JModuleHelper::getLayoutPath('mod_agenda');
