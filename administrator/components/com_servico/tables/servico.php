<?php

// No direct access
defined('_JEXEC') or die('Restricted access');

class ServicoTableServico extends JTable
{
	
	function __construct(&$db)
	{
		parent::__construct('#__servico', 'id', $db);
	}
}