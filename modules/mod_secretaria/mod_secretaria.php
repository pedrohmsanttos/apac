<?php
// No direct access
defined('_JEXEC') or die;

require_once 'helper.php';

$secretarias = ModSecretariaHelper::getPublishedItems();

$info_pagina = $params->get('title_section');

require JModuleHelper::getLayoutPath('mod_secretaria');
