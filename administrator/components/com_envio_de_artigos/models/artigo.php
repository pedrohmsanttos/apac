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

jimport('joomla.application.component.modeladmin');

/**
 * Envio_de_artigos model
 */
class Envio_de_artigosModelArtigo extends JModelAdmin
{
	/**
	 * @var		string	The prefix to use with controller messages
	 * @since	1.6
	 */
	protected $text_prefix = 'COM_ENVIO_DE_ARTIGOS';

	/**
	 * Returns a reference to the a Table object, always creating it
	 *
	 * @param	type	The table type to instantiate
	 * @param	string	A prefix for the table class name. Optional
	 * @param	array	Configuration array for model. Optional
	 * @return	JTable	A database object
	 * @since	1.6
	 */
	public function getTable($type = 'artigo', $prefix = 'Envio_de_artigosTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param	array	$data		An optional array of data for the form to interogate
	 * @param	boolean	$loadData	True if the form is to load its own data (default case), false if not
	 * @return	JForm	A JForm object on success, false on failure
	 * @since	1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form
		$form = $this->loadForm('com_envio_de_artigos.artigo', 'artigo', array('control' => 'jform', 'load_data' => $loadData));
		if (empty($form))
		{
			return false;
		}

		return $form;
	}

	/**
	 * Method to get the data that should be injected in the form
	 *
	 * @return	mixed	The data for the form
	 * @since	1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data
		$data = JFactory::getApplication()->getUserState('com_envio_de_artigos.edit.artigo.data', array());

		if (empty($data))
		{
			$data = $this->getItem();
		}

		return $data;
	}

	/**
	 * Prepare and sanitise the table prior to saving
	 *
	 * @since	1.6
	 */
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			if (@$table->ordering === '') {
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__envio_de_artigos');
				$max = $db->loadResult();
				$table->ordering = $max+1;
			}
		}
	}

	public function enviarEmail($pks)
	{

		$return = array();

		$db = JFactory::getDbo();
		$id    = $db->escape($pks[0]);

		$interessados = $this->getInteressados($id);

		if(!empty($interessados)){
			$html = $this->layoutEmail($pks);

			if(empty($pks)){
				$return['tipo'] 	= 'erro';
				$return['mensagem'] = 'ID não pode ser vazio!';
			}else{
				try {
					
					foreach($interessados as $interessado){
						$html = str_replace("!#ID#!",$interessado->id,$html);
						$item_email = new stdClass();
						$item_email->nome 			= $interessado->nome;
						$item_email->email 			= $interessado->email; 
						$item_email->conteudo		= $html;	
						$item_email->id_usuario		= JFactory::getUser()->id;
						$item_email->id_item		= $pks[0];
						$item_email->tipo_item		= "ARTIGO";
						$item_email->data_cadastro	= date("Y-m-d H:i:s");

						$result = $db->insertObject('lista_emails', $item_email);

						if(!$result){
							$return['tipo'] 	= 'erro';
							$return['mensagem'] = 'Erro ao cadastrar emails para envio!';
							
							return $return;
							break;
						}
					}
					
				}catch (Exception $e) {
					echo 'Exceção capturada: ',  $e->getMessage(), "\n";
				}

				if($result){
					$return['tipo'] 	= 'sucesso';
					$return['mensagem'] = 'O aviso será enviado dentro de alguns minutos!';
				}
			} 
		}else{
			$return['tipo'] 	= 'erro';
			$return['mensagem'] = 'Não existem interessados cadastrado para Licitação!';
		}

		
		return $return;
	}

	protected function layoutEmail($pks, $id_interessado,$pdf = null)
	{	

		$html = "";

		if(empty($pks)) return $html;

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		//clean sql injection
		$id    = $db->escape($pks[0]);

		// Select the required fields from the table.
		$query->select($this->getState('list.select', 'DISTINCT a.*'));
		$query->from('#__content AS a');
		$query->where("a.id =".$id);

		$db->setQuery($query);

		
		if(!empty($db->loadObjectList()[0])){
		
			$artigo = $db->loadObjectList()[0];

			
			$urlSite = str_replace("administrator/", "", JURI::base());

			$titulo = $informe->titulo;

			$linkDescadastrar = '<a href="'.$urlSite.'/component/interessadonosite/?id=!#ID#!">Caso não queira mais receber esse e-mail, clique aqui para descadastrar-se</a>';

			$urlLogo = $this->getLogo();

			$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head></head><body><style></style><table align="center" border="0" cellpadding="0" cellspacing="0" width="600"><tbody><tr><td bgcolor="#fff" style="padding:15px 10px 0 10px"><h3><a href="'.$urlSite.'index.php?option=com_content&view=article&id='.$artigo->id.'" style="color:#735D01;text-decoration:none">!#TITULO#!</a></h3></td></tr><tr><td align="center" bgcolor="#fff" style="padding:40px 10px 30px 10px;text-align:justify">!#CONTEUDO#!</td></tr><tr><td bgcolor="#fff"><img src="'.$urlLogo.'" alt="logo" width="600" style="display:block" border="0"></td></tr><tr><td bgcolor="#E7BB03" style="padding:30px 30px 30px 30px;text-align:center;color:#735D01">!#DESCADASTRAR#!</td></tr></tbody></table></body></html>';

			$conteudoFinal = str_replace('<img src="', '<img src="' .$urlSite.'/', $artigo->introtext);

			$html = str_replace("!#LOGO#!",$urlLogo,$html);
			$html = str_replace("!#TITULO#!",$artigo->title,$html);
			$html = str_replace("!#CONTEUDO#!",$artigo->introtext,$html);
			$html = str_replace("!#DESCADASTRAR#!",$linkDescadastrar,$html);
			
		}

		return $html;
	}

	protected function getLogo(){

		$path = JPATH_ROOT . '/images/logo-apac-governo-pequena.jpg';

		// echo $path;die;
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);

		return $base64;
	}

	protected function getInteressados(){
		$interessados = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select($this->getState('list.select', 'DISTINCT a.*'));
		$query->from('#__cadastrointeressado AS a');
		$query->where('a.noticias = \'1\' AND a.situacao = \'1\' AND a.state = \'1\'');
         
		$db->setQuery($query);

		$interessados = $db->loadObjectList();

		return $interessados;
	}
}
