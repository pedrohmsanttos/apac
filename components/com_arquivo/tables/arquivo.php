<?php
// No direct access
defined('_JEXEC') or die('Restricted access');

class ArquivoTableArquivo extends JTable
{
	function __construct(&$db)
	{
		parent::__construct('#__arquivo', 'id', $db);
	}
}