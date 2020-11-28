<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
class RelacionadoControllerRelacionados extends JControllerAdmin
{
	public function getModel($name = 'Relacionado', $prefix = 'RelacionadoModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config); 
		return $model;
	}
}