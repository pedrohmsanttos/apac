<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Cadastrointeressado
 * @author     Lerisson Freitas <lerisson.freitas@inhalt.com.br>
 * @copyright  2019 Lerisson Freitas
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */
// No direct access
defined('_JEXEC') or die;

/**
 * Class CadastrointeressadoController
 *
 * @since  1.6
 */
class CadastrointeressadoController extends JControllerLegacy
{
	/**
	 * Method to display a view.
	 *
	 * @param   boolean  $cachable   If true, the view output will be cached
	 * @param   mixed    $urlparams  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return   JController This object to support chaining.
	 *
	 * @since    1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		$view = JFactory::getApplication()->input->getCmd('view', 'interessados');
		JFactory::getApplication()->input->set('view', $view);

		parent::display($cachable, $urlparams);

		return $this;
	}
}
