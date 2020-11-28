<?php

defined('_JEXEC') or die('Restricted access');
 
class SecretarioControllerSecretarios extends JControllerAdmin
{

	public function getModel($name = 'Secretario', $prefix = 'SecretarioModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
}