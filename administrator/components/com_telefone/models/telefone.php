<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class TelefoneModelTelefone extends JModelAdmin
{
	
	public function getTable($type = 'Telefone', $prefix = 'TelefoneTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_telefone.telefone',
			'telefone',
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
			'com_telefone.edit.telefone.data',
			array()
		);
 
		if (empty($data))
		{
			$data = $this->getItem();
		}
 
		return $data;
	}
}