<?php
// No direct access
defined('_JEXEC') or die('Restricted access');
 
class RelacionadoTableRelacionado extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__relacionado', 'id', $db);
	}
}