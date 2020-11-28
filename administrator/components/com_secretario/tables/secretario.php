<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
 

class SecretarioTableSecretario extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__secretario', 'id', $db);
	}
}