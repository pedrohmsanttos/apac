<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AcaodegovernoModelAcaodegovernos extends JModelList
{
	public function __construct($config = array())
	{
		if (empty($config['filter_fields']))
		{
			$config['filter_fields'] = array(
				'id',
				'titulo',
				'subtitulo',
				'published'
			);
		}
 
		parent::__construct($config);
	}
 
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
		// Create the base select statement.
		$query->select('*')
              ->from($db->quoteName('#__acaogoverno'));
 
		return $query;
	}
	
}