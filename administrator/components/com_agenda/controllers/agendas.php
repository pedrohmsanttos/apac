<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AgendaControllerAgendas extends JControllerAdmin
{
	public function getModel($name = 'Agenda', $prefix = 'AgendaModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
}