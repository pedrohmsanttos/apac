<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

class AgendaTableAgenda extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__agenda', 'id', $db);
	}
}