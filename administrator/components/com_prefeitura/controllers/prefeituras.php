<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class PrefeituraControllerPrefeituras extends JControllerAdmin
{
	public function getModel($name = 'Prefeitura', $prefix = 'PrefeituraModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
}