<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
 

class SecretariaTableSecretaria extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__secretaria', 'id', $db);
	}
}