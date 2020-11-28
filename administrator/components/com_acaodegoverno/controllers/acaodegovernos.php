<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AcaodegovernoControllerAcaodegovernos extends JControllerAdmin
{

	public function getModel($name = 'Acaodegoverno', $prefix = 'AcaodegovernoModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
}