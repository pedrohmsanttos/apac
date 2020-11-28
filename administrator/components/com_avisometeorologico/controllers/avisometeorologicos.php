<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisometeorologicoControllerAvisometeorologicos extends JControllerAdmin
{
	public function getModel($name = 'Avisometeorologico', $prefix = 'AvisometeorologicoModel', $config = array('ignore_request' => true))
	{
		$model = parent::getModel($name, $prefix, $config);
		return $model;
	}

	public function enviarEmail()
	{

		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');

		JArrayHelper::toInteger($pks);

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$id    = $db->escape($pks[0]);

		$query->select('*')->from($db->quoteName('lista_emails', 'le'))->where("le.id_item = $id AND le.tipo_item = 'AVISO HIDROMETEOROLOGICO'");
		$db->setQuery($query);
		$resultado = $db->loadObjectList();

		if(empty($resultado)){

			$model = $this->getModel();
			$return = $model->enviarEmail($pks);

			
			if($return['tipo'] == "sucesso"){	
				$url = JRoute::_('index.php?option=com_avisometeorologico');
				JFactory::getApplication()->enqueueMessage('O aviso será enviado dentro de alguns minutos!');
				JFactory::getApplication()->redirect($url);
			}else{
				JError::raiseError(500, $return['mensagem']);
				$url = JRoute::_('index.php?option=com_avisometeorologico');
				JFactory::getApplication()->redirect($url);
			}
		}else{
			JError::raiseError(500, 'Esse item já foi enviado por email!');
			$url = JRoute::_('index.php?option=com_avisometeorologico');
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
			$url = JRoute::_('index.php?option=com_avisometeorologico');
			JFactory::getApplication()->enqueueMessage('O arquivo foi gerado com sucesso!');
			JFactory::getApplication()->redirect($url);
		}else{
			JError::raiseError(500, 'Erro ao solicitar geração do PDF!');
			$url = JRoute::_('index.php?option=com_avisometeorologico');
			JFactory::getApplication()->redirect($url);
		}
		
		return true;

	}
}
