<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

class AvisoTableAviso extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__aviso', 'id', $db);
	}
}
