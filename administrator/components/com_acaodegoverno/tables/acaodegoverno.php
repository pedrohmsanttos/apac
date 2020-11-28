<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
 

class AcaodegovernoTableAcaodegoverno extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__acaogoverno', 'id', $db);
	}

	
}