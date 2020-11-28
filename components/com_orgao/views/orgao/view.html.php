<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class OrgaoViewOrgao extends JViewLegacy
{
	function display($tpl = null)
	{
		$this->msg = 'Hello World';
		parent::display($tpl);
	}
}