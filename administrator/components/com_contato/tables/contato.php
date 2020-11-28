<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
 
class ContatoTableContato extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__contato', 'id', $db);
	}
}