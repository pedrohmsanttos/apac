<?php
defined('_JEXEC') or die;
define('COM_CONTATO_BASE', JUri::base().'components/com_contato/');
JHtml::_('jquery.framework', false);
require_once 'helper.php';

$doc = JFactory::getDocument();
// $doc->addScript(COM_CONTATO_BASE.'js/contato.js');

$requests = JFactory::getApplication()->input;
$task = $requests->get('task', '', 'string');

$resultado = array('result');
header('Content-Type: application/json');

$nome     = urldecode($requests->get('nome', '', 'string'));
$email    = urldecode($requests->get('email', '', 'string'));
$setor    = urldecode($requests->get('setor', '', 'string'));
$mensagem = urldecode($requests->get('mensagem', '', 'string'));

if(empty($nome) || empty($email) || empty($mensagem)):
  echo new JResponseJson($resultado,'Por favor, preencha os campos obrigatórios.',true);
  exit(1);
endif;


try {

	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->insert($db->quoteName('#__contato'));
	$query->columns(array('nome', 'mensagem','email','setor','created'));
	$query->values(implode(',', array($db->quote($nome),
									$db->quote($mensagem),
									$db->quote($email),
									$db->quote($setor),   
                    				'now()'
                    ) ));

	$db->setQuery($query);
	$result = $db->execute();

	$data['contact_name']    = $nome;
	$data['contact_subject'] = 'APAC - Formulário de contato';
	$data['contact_message'] = $mensagem; 
	$data['contact_email']   = $email;
	// obj generico para seta email padrão do portal
	$config = JFactory::getConfig();
	$contact = new stdClass();
	$contact->email_to = $config->get('mailfrom');
	$send = _sendEmail($data, $contact, true);
	
	if ( $send !== true ) {
		echo 'Erro ao enviar e-mail: ';
	}/* else {
		echo 'Mail sent';
	}*/

} catch (Exception $e) {
    echo 'Exceção capturada: ',  $e->getMessage(), "\n";
    // echo new JResponseJson($resultado, $e->getMessage(),true);
}


if ($task != 'save' || !empty($e)) {
	//erro
	echo new JResponseJson($resultado,'Erro ao Enviar o mensagem!',true);

} else {
	echo new JResponseJson($resultado,'Mensagem Enviado Com Sucesso!');
}

exit(0);
