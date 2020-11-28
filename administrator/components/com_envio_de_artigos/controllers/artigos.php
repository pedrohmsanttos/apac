<?php
/**
 * @version     1.0.0
 * @package     com_envio_de_artigos_1.0.0
 * @copyright   Copyright (C) 2018. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      Matheus Felipe <matheus.felipe@inhalt.com.br> - https://www.developer-url.com
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controlleradmin');

/**
 * Envio_de_artigos list controller
 */
class Envio_de_artigosControllerArtigos extends JControllerAdmin
{
	/**
	 * Proxy for getModel
	 * @since	1.6
	 */
	public function getModel($name = 'artigo', $prefix = 'Envio_de_artigosModel')
	{
		$model = parent::getModel($name, $prefix, array('ignore_request' => true));
		return $model;
	}
    
	/**
	 * Method to save the submitted ordering values for records via AJAX
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
		JArrayHelper::toInteger($pks);
		JArrayHelper::toInteger($order);

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

	public function enviarEmail()
	{
		$input = JFactory::getApplication()->input;
		$pks = $input->post->get('cid', array(), 'array');
		
		JArrayHelper::toInteger($pks);

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$id    = $db->escape($pks[0]);

		$query->select('*')->from($db->quoteName('lista_emails', 'le'))->where("le.id_item = $id AND le.tipo_item = 'ARTIGO'");
		$db->setQuery($query);
		$resultado = $db->loadObjectList();

		if(empty($resultado)){

			$model = $this->getModel();
			$return = $model->enviarEmail($pks);

			if($return['tipo'] == "sucesso"){	
				$url = JRoute::_('index.php?option=com_envio_de_artigos&view=artigos');
				JFactory::getApplication()->enqueueMessage('O artigo será enviado dentro de alguns segundos!');
				JFactory::getApplication()->redirect($url);
			}else{
				JError::raiseError(500, $return['mensagem']);
				$url = JRoute::_('index.php?option=com_envio_de_artigos');
				JFactory::getApplication()->redirect($url);
			}
		}else{
			JError::raiseError(500, 'Esse item já foi enviado por email!');
			$url = JRoute::_('index.php?option=com_envio_de_artigos');
			JFactory::getApplication()->redirect($url);
		}

		return true;
	}
}
