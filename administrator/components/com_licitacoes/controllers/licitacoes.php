<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Licitacoes
 * @author     Pedro Santos <phmsanttos@gmail.com>
 * @copyright  2018 Pedro Santos
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

use Joomla\Utilities\ArrayHelper;

/**
 * Licitacoes list controller class.
 *
 * @since  1.6
 */
class LicitacoesControllerLicitacoes extends JControllerAdmin
{
	/**
	 * Method to clone existing Licitacoes
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
				throw new Exception(JText::_('COM_LICITACOES_NO_ELEMENT_SELECTED'));
			}

			ArrayHelper::toInteger($pks);
			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Jtext::_('COM_LICITACOES_ITEMS_SUCCESS_DUPLICATED'));
		}
		catch (Exception $e)
		{
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_licitacoes&view=licitacoes');
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
	public function getModel($name = 'licitacao', $prefix = 'LicitacoesModel', $config = array())
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


	/**
	 * Method to change the state values for records via AJAX.
	 *
	 * @return  void
	 *
	 * @since   1.0
	 */
	public function publish(){

		$app                                    =   JFactory::getApplication();
		$jinput                                 =   JFactory::getApplication()->input;
		$ids                                    =   $jinput->get('cid', '', 'array');
		$task                                   =   $this->getTask();
		$date                                   =   JFactory::getDate();            

		$modelitem                              =   $this->getModel('Arquivo');        
		$status                                 = 1;
		// set status
		switch($task){
				case 'publish'  :                   
						$status = 1;
				break;          
				case 'unpublish':                   
						$status = 0; 
				break;      
				case 'archive'  :                   
						$status = 2;
				break;      
				case 'trash'    :                
						$status = -2; 
				break;      
		}

		// var_dump($task);die;
		
		foreach($ids as $id){
			$db = JFactory::getDbo();

			$query = $db->getQuery(true);
			
			// Fields to update.
			$fields = array(
				$db->quoteName('state') . ' = ' . (int) $status
			);
			
			// Conditions for which records should be updated.
			$conditions = array(
				$db->quoteName('id') . ' = ' . (int) $id
			);
			
			$query->update($db->quoteName('#__licitacoes'))->set($fields)->where($conditions);
			
			$db->setQuery($query);

			 // echo $query->__toString();die;
			
			$db->execute();
		}
     
		$this->setRedirect('index.php?option=com_licitacoes&view=licitacoes');
		// TODO: Call of print mensage
		// parent::publish();
	}

	public function enviarEmail()
	{

		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');

		JArrayHelper::toInteger($pks);

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$id    = $db->escape($pks[0]);

		$query->select('*')->from($db->quoteName('lista_emails', 'le'))->where("le.id_item = $id AND le.tipo_item = 'LICITACAO'");
		$db->setQuery($query);
		$resultado = $db->loadObjectList();

		if(empty($resultado)){

			$model = $this->getModel();
			$return = $model->enviarEmail($pks);

			
			if($return['tipo'] == "sucesso"){	
				$url = JRoute::_('index.php?option=com_licitacoes');
				JFactory::getApplication()->enqueueMessage('O aviso será enviado dentro de alguns minutos!');
				JFactory::getApplication()->redirect($url);
			}else{
				JError::raiseError(500, $return['mensagem']);
				$url = JRoute::_('index.php?option=com_licitacoes');
				JFactory::getApplication()->redirect($url);
			}
		}else{
			JError::raiseError(500, 'Esse item já foi enviado por email!');
			$url = JRoute::_('index.php?option=com_licitacoes');
			JFactory::getApplication()->redirect($url);
		}

		return true;

	}
}
