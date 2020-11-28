<?php
defined('_JEXEC') or die;
define('COM_CONTATO_BASE', JUri::base().'components/com_interessadonosite/');
JHtml::_('jquery.framework', false);
require_once 'helper.php';

$doc = JFactory::getDocument();
$doc->addStyleSheet(JURI::root()."components/com_interessadonosite/css/bannerPrevisaoTempo.css");
$doc->addStyleSheet(JURI::root()."components/com_interessadonosite/css/form.css");
$app = JFactory::getApplication();

$jinput = JFactory::getApplication()->input;
$idInteressado = $jinput->get('id');

$interessado = new InteressadoHelper();

$avisosMeteorologicos = $interessado::getAvisosMeteorologicos();
$avisosHidrologicos = $interessado::getAvisosHidrologicos();
$informesMeteorologicos = $interessado::getInformesMeteorologicos();
$informesHidrologicos = $interessado::getInformesHidrologicos();
if (!empty($idInteressado)|| $idInteressado > 0){
    $getInteressado = $interessado::getInteressado($idInteressado); 
    $getInteressado = $getInteressado[0];
}

//var_dump('oi',$getInteressado->nome);die;
$idL=JFactory::getApplication()->input->get('idInteressado');
$requests = JFactory::getApplication()->input;
$task = $requests->get('task', '', 'string');

$resultado = array('result');
header('Content-Type: application/json');

$data['nome']               = $_POST['nome'];
$data['email']              = $_POST['email'];
if (is_null($_POST['noticia'])){$data['noticia'] = '0';}else{$data['noticia'] = $_POST['noticia'];}
if (is_null($_POST['licitacao'])){$data['licitacao'] = '0';}else{$data['licitacao'] = $_POST['licitacao'];}
if (is_null($_POST['previsao_tempo'])){$data['previsao_tempo'] = '0';}else{$data['previsao_tempo'] = $_POST['previsao_tempo'];}
$data['data']               = $_POST['data_criacao'];
$data['situacao']           = $_POST['situacao'];
$data['observacao']           = "Interessado cadastrado pelo site!";
if (is_null($_POST['avisom'])){$avisom = "";}else{$avisom = $_POST['avisom'];}
if (is_null($_POST['informem'])){$informem = "";}else{$informem = $_POST['informem'];}
if (is_null($_POST['avisoh'])){$avisoh = "";}else{$avisoh = $_POST['avisoh'];}
if (is_null($_POST['informeh'])){$informeh = "";}else{$informeh = $_POST['informeh'];}
$data['boletim'] = json_encode(
    array(
        'meteorologia_avisos' => $avisom,
        'meteorologia_informes' => $informem,
        'hidrologia_avisos' => $avisoh,
        'hidrologia_informes' => $informeh
    )
);
//var_dump($idL);die;
if(!empty($data['nome']) || !empty($data['email'])):
    
    $verificacao = $interessado::verificacao($_POST['email']);
    //var_dump($verificacao);die;
        
            try {
                $db    = JFactory::getDbo();
                $query = $db->getQuery(true);
                
                if(empty($idInteressado) || $idInteressado == 0 || $idInteressado == null){
                    if ($verificacao){
                        $columns = array('nome',
                                    'email',
                                    'observacao',
                                    'situacao',
                                    'pertencegoverno',
                                    'boletim',
                                    'state',
                                    'ordering',
                                    'checked_out',
                                    'checked_out_time',
                                    'noticias',
                                    'licitacoes',
                                    'confidencial',
                                    'data_criacao',
                                    'previsao_tempo',
                                    );
                        $values = array($db->quote($data['nome']),
                                        $db->quote($data['email']),
                                        $db->quote($data['observacao']),
                                        $db->quote('1'),
                                        $db->quote("0"),
                                        $db->quote($data['boletim']),
                                        1,
                                        0,
                                        0,
                                        'NOW()',
                                        $db->quote($data['noticia']),
                                        $db->quote($data['licitacao']),
                                        $db->quote("0"),
                                        'NOW()',
                                        $db->quote($data['previsao_tempo']),
                                        );
                        $query->insert($db->quoteName('#__cadastrointeressado'))
                                ->columns($db->quoteName($columns))
                                ->values(implode(',', $values));
                        $db->setQuery($query);
                        $db->query();
                        $resultID = $db->insertid();
                    }
                    else{
                        $app->redirect(JRoute::_('index.php?option=com_interessadonosite', false), 'Erro ao cadastrar Interressado! O email deve ser único!','error');
                        }
                }else{
                    //var_dump($data['situacao']);die;
                    $campos = array($db->quoteName('state') . ' = ' . $db->quote($data['situacao']),
							$db->quoteName('checked_out') . ' = ' . 0,
							$db->quoteName('modified_by') . ' = ' . JFactory::getUser()->get('id'),
							$db->quoteName('nome') . ' = ' . 			$db->quote($data['nome']),
							$db->quoteName('email') . ' = ' . 			$db->quote($data['email']),
							$db->quoteName('observacao') . ' = ' . 		$db->quote($getInteressado->observacao),
							$db->quoteName('situacao') . ' = ' .  		$db->quote($data['situacao']),
							$db->quoteName('pertencegoverno') . ' = ' . $db->quote($getInteressado->pertencegoverno),
							$db->quoteName('boletim') . ' = ' .     	$db->quote($data['boletim']),
							$db->quoteName('noticias') . ' = ' .     	$db->quote($data['noticia']),
							$db->quoteName('licitacoes') . ' = ' . 		$db->quote($data['licitacao']),
							$db->quoteName('confidencial') . ' = ' . 		$db->quote($getInteressado->confidencial),
							$db->quoteName('data_criacao') . ' = ' . 		$db->quote($getInteressado->data_criacao),
							$db->quoteName('previsao_tempo') . ' = ' . 		$db->quote($data['previsao_tempo']),		
							
                        );
                        
                        $conditions = array(
                            $db->quoteName('id') . ' = '. (int)$idInteressado
                        );
                        $query->update($db->quoteName('#__cadastrointeressado'))
                                ->set($campos)
                                ->where($conditions);
                        
                        $db->setQuery($query);

                        $result = $db->execute();
                }
                if ($idInteressado > 0 || !empty($idInteressado)){
                    $app->redirect(JRoute::_('index.php?option=com_interessadonosite&id='.$idInteressado, false), 'Interressado atualizado com sucesso!');
                }else{
                    $app->redirect(JRoute::_('index.php?option=com_interessadonosite', false), 'Interressado cadastrado com sucesso!');
                } 
                
            } catch (Exception $e) {
                echo 'Exceção capturada: ',  $e->getMessage(), "\n";
                // echo new JResponseJson($resultado, $e->getMessage(),true);
                if ($idInteressado > 0 || !empty($idInteressado)){
                    $app->redirect(JRoute::_('index.php?option=com_interessadonosite&id='.$idInteressado, false), 'Erro ao atualizar Interressado!','error');
                }else{
                    $app->redirect(JRoute::_('index.php?option=com_interessadonosite', false), 'Erro ao cadastrar Interressado!','error');
                } 
            }
        
            exit(0);
  
endif;

// Return view
require_once('interessadonosite_view.php');