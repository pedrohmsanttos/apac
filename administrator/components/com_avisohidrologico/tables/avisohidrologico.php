<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

class AvisohidrologicoTableAvisohidrologico extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__avisohidrologico', 'id', $db);
	}
}
