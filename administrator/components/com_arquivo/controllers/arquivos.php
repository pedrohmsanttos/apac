<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ArquivoControllerArquivos extends JControllerAdmin
{
	public function getModel($name = 'Arquivo', $prefix = 'ArquivoModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
 
		return $model;
	}
}