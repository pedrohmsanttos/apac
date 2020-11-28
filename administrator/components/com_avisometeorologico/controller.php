<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisometeorologicoController extends JControllerLegacy
{
	protected $default_view = 'Avisometeorologicos';
	public function __construct()
	{
		if (JFactory::getApplication()->input->get('view') == "avisometeorologicos"){
			JFactory::getApplication()->redirect("index.php?option=com_avisometeorologico&view=$this->default_view");
		} else {
			parent::__construct();
		}
	}
}
