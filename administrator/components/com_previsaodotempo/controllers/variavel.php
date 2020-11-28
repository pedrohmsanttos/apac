<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Previsao controller class.
 *
 * @since  1.6
 */
class PrevisaodotempoControllerVariavel extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'variavel';
		parent::__construct();
	}

	public function save($key = null, $urlVar = null) 
	{
		$return = parent::save($key, $urlVar);
		$this->setRedirect('index.php?option=com_previsaodotempo&view=variaveis');
		return $return;
	}
}
