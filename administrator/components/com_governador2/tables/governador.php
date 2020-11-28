<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
 
class GovernadorTableGovernador extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__governador', 'id', $db);
	}
}