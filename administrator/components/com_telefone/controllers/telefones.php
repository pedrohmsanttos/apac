<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

class TelefoneControllerTelefones extends JControllerAdmin
{

	public function getModel($name = 'Telefone', $prefix = 'TelefoneModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
}