<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisohidrologicoController extends JControllerLegacy
{
	protected $default_view = 'Avisohidrologicos';
	public function __construct()
	{
		if (JFactory::getApplication()->input->get('view') == "avisohidrologicos"){
			JFactory::getApplication()->redirect("index.php?option=com_avisohidrologico&view=$this->default_view");
		} else {
			parent::__construct();
		}
	}
}
