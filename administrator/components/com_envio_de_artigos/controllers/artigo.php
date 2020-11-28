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

jimport('joomla.application.component.controllerform');

/**
 * Envio_de_artigos detail controller
 */
class Envio_de_artigosControllerArtigo extends JControllerForm
{
    function __construct()
    {
        $this->view_list = 'artigos';
        parent::__construct();
    }
}
