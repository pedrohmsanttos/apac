<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisoController extends JControllerLegacy
{
	protected $default_view = 'Avisos';
	public function __construct()
	{ 
		if (JFactory::getApplication()->input->get('view') == "avisos"){
			JFactory::getApplication()->redirect("index.php?option=com_aviso&view=$this->default_view");
		} else {
			parent::__construct();
		}
	}
}
