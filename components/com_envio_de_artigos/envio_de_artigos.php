<?php
/**
 * @version     1.0.0
 * @package     com_envio_de_artigos_1.0.0
 * @copyright   Copyright (C) 2018. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Matheus Felipe <matheus.felipe@inhalt.com.br> - https://www.developer-url.com
 */

// No direct access
defined('_JEXEC') or die;

// Register class prefix
JLoader::registerPrefix('Envio_de_artigos', JPATH_COMPONENT);

// Load the controller
jimport('joomla.application.component.controller');

$controller	= JControllerLegacy::getInstance('Envio_de_artigos');
$controller->execute(JFactory::getApplication()->input->get('task'));
$controller->redirect();
