<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
class ContatoControllerContatos extends JControllerAdmin
{
	public function getModel($name = 'Contato', $prefix = 'ContatoModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config); 
		return $model;
	}
}