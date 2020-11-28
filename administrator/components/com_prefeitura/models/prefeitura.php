<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class PrefeituraModelPrefeitura extends JModelAdmin
{
	public function getTable($type = 'Prefeitura', $prefix = 'PrefeituraTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_prefeitura.prefeitura',
			'prefeitura',
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
			'com_prefeitura.edit.prefeitura.data',
			array()
		);
 
		if (empty($data))
		{
			$data = $this->getItem();
		}
 
		return $data;
	}
}