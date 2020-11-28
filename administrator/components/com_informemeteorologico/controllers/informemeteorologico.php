<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_informemeteorologico
 * @author     Matheus Felipe <matheusfelipe.moreira@gmail.com>
 * @copyright  2018 Matheus Felipe
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * informemeteorologico controller class.
 *
 * @since  1.6
 */
class InformemeteorologicoControllerInformemeteorologico extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'informemeteorologicos';
		parent::__construct();
	}
}
