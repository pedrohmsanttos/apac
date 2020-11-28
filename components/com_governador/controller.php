<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
class GovernadorController extends JControllerLegacy
{
	protected $default_view = 'Governadores';
	public function __construct()
	{ 
		if (JFactory::getApplication()->input->get('view') == "governadors"){ 
			JFactory::getApplication()->redirect("index.php?option=com_governador&view=$this->default_view");
		} else { 
			parent::__construct(); 
		} 
	}
}