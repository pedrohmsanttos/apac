<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
 
class PrefeituraTablePrefeitura extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__prefeitura', 'id', $db);
	}
}