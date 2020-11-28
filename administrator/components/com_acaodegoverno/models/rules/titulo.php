<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * Form Rule class for the Joomla Framework.
 */
class JFormRuleTitulo extends JFormRule
{
	protected $regex = '^[^0-9]+$';
}