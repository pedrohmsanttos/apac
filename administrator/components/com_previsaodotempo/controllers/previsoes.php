<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

use Joomla\Utilities\ArrayHelper;

/**
 * Previsoes list controller class.
 *
 * @since  1.6
 */
class PrevisaodotempoControllerPrevisoes extends JControllerAdmin
{

	/**
	 * Method to clone existing Previsoes
	 *
	 * @return void
	 */
	public function duplicate()
	{
		// Check for request forgeries
		Jsession::checkToken() or jexit(JText::_('JINVALID_TOKEN'));

		// Get id(s)
		$pks = $this->input->post->get('cid', array(), 'array');

		try {
			if (empty($pks)) {
				throw new Exception(JText::_('COM_PREVISAODOTEMPO_NO_ELEMENT_SELECTED'));
			}

			ArrayHelper::toInteger($pks);
			$model = $this->getModel();
			$model->duplicate($pks);
			$this->setMessage(Jtext::_('COM_PREVISAODOTEMPO_ITEMS_SUCCESS_DUPLICATED'));
		} catch (Exception $e) {
			JFactory::getApplication()->enqueueMessage($e->getMessage(), 'warning');
		}

		$this->setRedirect('index.php?option=com_previsaodotempo&view=previsoes');
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
	public function getModel($name = 'previsao', $prefix = 'PrevisaodotempoModel', $config = array())
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
		$pks = $input->post->get('cid', array(), 'array');
		$order = $input->post->get('order', array(), 'array');

		// Sanitize the input
		ArrayHelper::toInteger($pks);
		ArrayHelper::toInteger($order);

		// Get the model
		$model = $this->getModel();

		// Save the ordering
		$return = $model->saveorder($pks, $order);

		if ($return) {
			echo "1";
		}

		// Close the application
		JFactory::getApplication()->close();
	}

	public function publish(){
		$app                                    =   JFactory::getApplication();
		$jinput                                 =   JFactory::getApplication()->input;
		$ids                                    =   $jinput->get('cid', '', 'array');
		$task                                   =   $this->getTask();
		$date                                   =   JFactory::getDate();            

		$modelitem                              =   $this->getModel('Previsao');        
		$status                                 = 1;
		/**
		 * set status
		*/
		
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
			
			$query->update($db->quoteName('#__previsaodotempo_previsao'))->set($fields)->where($conditions);
			
			$db->setQuery($query);
			
			$result = $db->execute();
		}

		$this->setRedirect('index.php?option=com_previsaodotempo&view=previsoes');
	}

	/**
	 * Removes an item.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	public function delete()
	{
		// Check for request forgeries
		\JSession::checkToken() or die(\JText::_('JINVALID_TOKEN'));

		// Get items to remove from the request.
		$cid = $this->input->get('cid', array(), 'array');

		if (!is_array($cid) || count($cid) < 1)
		{
			\JLog::add(\JText::_($this->text_prefix . '_NO_ITEM_SELECTED'), \JLog::WARNING, 'jerror');
		}
		else
		{
			foreach($cid as $id){
				$db = JFactory::getDbo();

				$query = $db->getQuery(true);

				// delete all custom keys for user 1001.
				$conditions = array(
					$db->quoteName('id') . ' = ' . (int) $id
				);

				$query->delete($db->quoteName('#__previsaodotempo_previsao'));
				$query->where($conditions);

				$db->setQuery($query);

				$result = $db->execute();
			}
		}

		$this->setRedirect('index.php?option=com_previsaodotempo&view=previsoes');
	}

	public function enviarEmail()
	{
		
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');

		JArrayHelper::toInteger($pks);

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$id    = $db->escape($pks[0]);

		$query->select('*')->from($db->quoteName('#__previsaodotempo_previsao', 'p'))->where("p.id = $id");
		$db->setQuery($query);
		$previsao = $db->loadObjectList()[0];
		
		if($previsao->tipo != "amanha"){
			
			$query->select('*')->from($db->quoteName('lista_emails', 'le'))->where("le.id_item = $id AND le.tipo_item = 'PREVISAO'");
			$db->setQuery($query);
			$resultado = $db->loadObjectList();

			if(empty($resultado)){

				$model = $this->getModel();
				$return = $model->enviarEmail($pks);

				
				if($return['tipo'] == "sucesso"){	
					$url = JRoute::_('index.php?option=com_previsaodotempo');
					JFactory::getApplication()->enqueueMessage('O aviso será enviado dentro de alguns minutos!');
					JFactory::getApplication()->redirect($url);
				}else{
					JError::raiseError(500, $return['mensagem']);
					$url = JRoute::_('index.php?option=com_previsaodotempo');
					JFactory::getApplication()->redirect($url);
				}
			}else{
				JError::raiseError(500, 'Esse item já foi enviado por email!');
				$url = JRoute::_('index.php?option=com_previsaodotempo');
				JFactory::getApplication()->redirect($url);
			}
		}else{
			JError::raiseError(500, 'Previsão do tipo AMANHÃ não pode ser enviada por email!');
			$url = JRoute::_('index.php?option=com_previsaodotempo');
			JFactory::getApplication()->redirect($url);
		}

		
		return true;

	}

	public function gerarPDF()
	{

		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');

		JArrayHelper::toInteger($pks);

		$model = $this->getModel();
		$return = $model->gerarPDF($pks);

		
		if($return){	
			$url = JRoute::_('index.php?option=com_previsaodotempo');
			JFactory::getApplication()->enqueueMessage('O arquivo foi gerado com sucesso!');
			JFactory::getApplication()->redirect($url);
		}else{
			JError::raiseError(500, 'Erro ao solicitar geração do PDF!');
			$url = JRoute::_('index.php?option=com_previsaodotempo');
			JFactory::getApplication()->redirect($url);
		}
		
		return true;

	}
}
