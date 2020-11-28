<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ServicoControllerServicos extends JControllerAdmin
{
	public function getModel($name = 'Servico', $prefix = 'ServicoModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
}