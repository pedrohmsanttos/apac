<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
class GovernadorControllerGovernadores extends JControllerAdmin
{
	public function getModel($name = 'Governador', $prefix = 'GovernadorModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config); 
		return $model;
	}
}