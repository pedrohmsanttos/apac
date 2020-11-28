<?php

// No direct access
defined('_JEXEC') or die('Restricted access');
 

class TelefoneTableTelefone extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__telefone', 'id', $db);
	}
}