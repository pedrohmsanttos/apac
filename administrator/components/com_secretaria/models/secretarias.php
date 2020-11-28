<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class SecretariaModelSecretarias extends JModelList
{
	protected function getListQuery()
	{
		// Initialize variables.
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);
 
		// Create the base select statement.
		$query->select('*')
              ->from($db->quoteName('#__secretaria'));
 
		return $query;
	}
}