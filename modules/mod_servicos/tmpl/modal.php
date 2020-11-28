<?php 
define( '_JEXEC', 1 ); 
define( '_VALID_MOS', 1 ); 
define( 'JPATH_BASE', realpath(dirname(__FILE__).'/../../..' ));
define( 'DS', DIRECTORY_SEPARATOR ); 
require_once ( JPATH_BASE .DS.'includes'.DS.'defines.php' ); 
require_once ( JPATH_BASE .DS.'includes'.DS.'framework.php' ); 
$mainframe =& JFactory::getApplication('site'); 
$mainframe->initialise(); 

$app = JFactory::getApplication('site');
require_once '../helper.php';

$aba_selecionada = $_REQUEST['aba'];

$servicos = ModServicosHelper::getModal($aba_selecionada);

echo $servicos;

