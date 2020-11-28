<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 

class SecretariaControllerSecretarias extends JControllerAdmin
{

	public function getModel($name = 'Secretaria', $prefix = 'SecretariaModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
}