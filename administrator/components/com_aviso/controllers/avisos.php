<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisoControllerAvisos extends JControllerAdmin
{
	public function getModel($name = 'Aviso', $prefix = 'AvisoModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}
}
