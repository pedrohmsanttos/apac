<?php

define('_JEXEC', 1);   

define('JPATH_BASE', realpath( str_replace("crons", "",dirname(__FILE__))));

require_once JPATH_BASE . '/includes/defines.php';
require_once JPATH_BASE . '/includes/framework.php';
require_once 'helper.php';

try {

	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('*')->from($db->quoteName('lista_emails', 'le'))->where("le.enviado = 0")->setLimit('200');
	$db->setQuery($query);
	
	$aux = 0;
	if(!empty($db->loadObjectList())){
		
		$resultadoLista = $db->loadObjectList();

		foreach($resultadoLista as $lista){
			$data['contact_name']    = $lista->nome;
			$data['contact_subject'] = 'APAC - Aviso';
			$data['contact_message'] = $lista->conteudo; 
			$data['contact_email']   = $lista->email;
			
			$config = JFactory::getConfig();
			$contact = new stdClass();
			$contact->email_to = $config->get('mailfrom');
			
			$send = _sendEmail($data, $contact, true);

			$send = true;
			
			if ( $send !== true ) {
				echo 'Erro ao enviar e-mail: ';
			}else{
				$aux++;

				$object = new stdClass();

				$object->id 		= $lista->id;
				$object->enviado 	= 1;
				$object->data_envio = date("Y-m-d H:i:s");
				
				$result = $db->updateObject('lista_emails', $object, 'id');

				echo "Email enviado $aux: ($lista->nome - $lista->email) <br>";
			}
		}
	}else{
		echo "Não existem emails para enviar!";
	}

} catch (Exception $e) {
    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
}
