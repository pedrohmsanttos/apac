<?php
// No direct access
defined('_JEXEC') or die;

require_once 'helper.php';


$licitacoesHelper = new ModLicitacoesHelper;

$licitacoes = $licitacoesHelper::getLicitacoes();



//$eventosPassados = $licitacaoHelper::getEventoPassados($params->get('catid'));

JFactory::getDocument()->addStyleDeclaration('.list-licitacoes__item__content{width:100% !important}');

$download = JFactory::getApplication()->input->get('download');
$idL=JFactory::getApplication()->input->get('idLicitacao');
$licitacao = $licitacoesHelper::getLicitacao($idL);


if (isset($idL) || isset($download)){
    if (isset($idL)){
        require JModuleHelper::getLayoutPath('mod_licitacoes',licitacao);
    }
    else if (isset($download)){
        session_start();
        $arquivo = $licitacoesHelper::getArquivo($download);
        //$url = 'http://200.238.107.225'. $arquivo[0]->arquivo
        $url =  $arquivo[0]->arquivo; 
        
        $findme   = 'uploads';
        $pos = strpos($url, $findme);

        if ($pos === false) {
            $url = "\images\media\\" . '/' .$url;
        } 

        $_SESSION["download_licit"]=$url;
        $user = JFactory::getUser();        // Get the user object
	 	$app  = JFactory::getApplication(); // Get the application
        
         if ($user->id != 0){
            $saida = $licitacoesHelper::relatorio($user->id,$download);
            header('location: ' .$_SESSION["download_licit"]  ,false);
         }
	    else{
        // Redirect the user
        $msg = 'You must be logged in to view this content';
        $app->redirect('index.php?option=com_users&view=login');
        //require JModuleHelper::getLayoutPath('mod_licitacoes');
        }
    }
    
}else{
    
    require JModuleHelper::getLayoutPath('mod_licitacoes');
}
?>


