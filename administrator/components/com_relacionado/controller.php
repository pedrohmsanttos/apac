<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
class RelacionadoController extends JControllerLegacy
{
	protected $default_view = 'Relacionados';
	public function __construct()
	{ 
		if (JFactory::getApplication()->input->get('view') == "relacionados"){ 
			JFactory::getApplication()->redirect("index.php?option=com_relacionado&view=$this->default_view");
		} else { 
			parent::__construct(); 
		} 
	}
}