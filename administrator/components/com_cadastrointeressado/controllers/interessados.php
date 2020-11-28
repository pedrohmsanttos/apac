<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Cadastrointeressado
 * @author     Lerisson Freitas <lerisson.freitas@inhalt.com.br>
 * @copyright  2019 Lerisson Freitas
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

use Joomla\Utilities\ArrayHelper;

/**
 * Interessados list controller class.
 *
 * @since  1.6
 */
class CadastrointeressadoControllerInteressados extends JControllerAdmin
{
	/**
	 * Method to clone existing Interessados
	 *
	 * @return void
	 */
	public function duplicate()
	{
		// Check for request forgeries
		Jsession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get id(s)
		$pks = $this->input->post->get('cid', array(), 'array');

		try
		{
			if (empty($pks))
			{
				throw new Exception(JText::_('COM_CADASTROINTERESSADO_NO_ELEMENT_SELECTED'));
			}

			ArrayHelper::toInteger($pks);
			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Jtext::_('COM_CADASTROINTERESSADO_ITEMS_SUCCESS_DUPLICATED'));
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_cadastrointeressado&view=interessados');
	}

	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    Optional. Model name
	 * @param   string  $prefix  Optional. Class prefix
	 * @param   array   $config  Optional. Configuration array for model
	 *
	 * @return  object	The Model
	 *
	 * @since    1.6
	 */
	public function getModel($name = 'interessado', $prefix = 'CadastrointeressadoModel', $config = array())
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));

		return $model;
	}

	/**
	 * Method to save the submitted ordering values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   3.0
	 */
	public function saveOrderAjax()
	{
		// Get the input
		$input = JFactory::getApplication()->input;
		$pks   = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		ArrayHelper::toInteger($pks);
		ArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return)
		{
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}

	public function gerarCSV()
	{

		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');

		JArrayHelper::toInteger($pks);

		
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=interessados.csv');
		header("Pragma: no-cache");
		header("Expires: 0");
		if(empty($pks)) return false;

		$csv = fopen('php://output', 'w');
		fputcsv($csv, array('nome', 'email'));
		foreach ($pks as $pk) { 
			$emails = $this->Email($pk);
			fputcsv($csv,array(utf8_decode ( $emails[0]->nome),$emails[0]->email));
		}
		fclose($csv);
		jexit();
		return true;
		

		
		if(!empty(gerarCSV())){	
			$url = JRoute::_('index.php?option=com_cadastrointeressado');
			JFactory::getApplication()->enqueueMessage('O arquivo foi gerado com sucesso!');
			JFactory::getApplication()->redirect($url);
		}else{
			JError::raiseError(500, 'Erro ao solicitar geração do CSV!');
			$url = JRoute::_('index.php?option=com_cadastrointeressado');
			JFactory::getApplication()->redirect($url);
		}
		
		return true;

	}


	protected function Email($pk)
	{	
		$emails = "";
		if(empty($pk)) return $emails;
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('nome, email');
		$query->from($db->quoteName('#__cadastrointeressado'));
    	$query->where('id = ' . $db->q($pk));
			
		$db->setQuery($query);
		//var_dump($db->loadObjectList());die;
		$emails = $db->loadObjectList();
		
		return $emails;
	}
}
