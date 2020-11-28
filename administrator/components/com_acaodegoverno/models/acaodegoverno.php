<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AcaodegovernoModelAcaodegoverno extends JModelAdmin
{
	
	public function getTable($type = 'Acaodegoverno', $prefix = 'AcaodegovernoTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_acaodegoverno.acaodegoverno',
			'acaodegoverno',
			array(
				'control' => 'jform',
				'load_data' => $loadData
			)
		);
 
		if (empty($form))
		{
			return false;
		}
 
		return $form;
	}
 
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_acaodegoverno.edit.acaodegoverno.data',
			array()
		);
 
		if (empty($data))
		{
			$data = $this->getItem();
		}
 
		return $data;
	}
}