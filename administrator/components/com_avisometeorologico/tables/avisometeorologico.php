<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

class AvisometeorologicoTableAvisometeorologico extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__avisometeorologico', 'id', $db);
	}
}
