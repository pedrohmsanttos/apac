<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Licitacoes
 * @author     Pedro Santos <phmsanttos@gmail.com>
 * @copyright  2018 Pedro Santos
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Licitacao controller class.
 *
 * @since  1.6
 */
class LicitacoesControllerLicitacao extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'licitacoes';
		parent::__construct();
	}

	public function save($data = array(), $key = 'id')
	{
		
		$jinput = JFactory::getApplication()->input;
		$data   = $jinput->get('jform', null, 'raw');

		 
		$erro = false;
		if(isset($data['titulo_arquivo']) && isset($data['ordering_arquivo'])){
			
			$mensagem = "";
			foreach($data['titulo_arquivo'] as $titulo){
				if( trim($titulo) == ""){
					$erro = true;
					$mensagem .= "Título (arquivo) é obrigatório!<br>";
					break;
				}
			}

			// if(!$erro){
				foreach($data['ordering_arquivo'] as $ordem){
					if( trim($ordem) == ""){
						$erro = true;
						$mensagem .= "Ordem (arquivo) é obrigatório!<br>";
						break;
					}

					if(!is_numeric($ordem)){
						$erro = true;
						$mensagem .= "Ordem (arquivo) tem que ser numérico!<br>";
						break;
					}
				}
			// }

			
		}

		if(!empty($data['ano_processo']) && !is_numeric($data['ano_processo'])){
			$erro = true;
			$mensagem .= "Ano do Processo tem que ser númerico!<br>";
		}

		if(!empty($data['ano_modalidade']) && !is_numeric($data['ano_modalidade'])){
			$erro = true;
			$mensagem .= "Ano da Modalidade tem que ser númerico!<br>";
		}

		if($erro){
			JError::raiseError(500, $mensagem);
			$url = JRoute::_('index.php?option=com_licitacoes&view=licitacoes');
			JFactory::getApplication()->redirect($url);
		}
		


		$licitacaoCrllr = new LicitacoesControllerLicitacao();

    	//file upload
		$uploadedFiles = self::makeUpload($_FILES['jform'], $data);
		
		if(empty($data['id']))
        {
          unset($data['id']);
          $data['arquivo'] = $uploadedFiles;
          $licitacaoCrllr::insertData($data);

          $url = JRoute::_('index.php?option=com_licitacoes&view=licitacoes');
          JFactory::getApplication()->enqueueMessage('Cadastrado com sucesso!');
          JFactory::getApplication()->redirect($url);

        } else {

          $data['arquivo'] = $uploadedFiles;
          $licitacaoCrllr::updateData($data);

          $url = JRoute::_('index.php?option=com_licitacoes&view=licitacoes');
          JFactory::getApplication()->enqueueMessage('Editado com sucesso!');
          JFactory::getApplication()->redirect($url);

        }
	}

	public function updateData(&$arr)
	{
		$user = JFactory::getUser();
		$licitacaoCrllr = new LicitacoesControllerLicitacao();
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		if(empty($arr['ordering']) || $arr['ordering'] == ''){
			$arr['ordering'] = 0;
		}
		$data_licitacao = date("Y-m-d", strtotime( str_replace("/", "-", $arr['data_licitacao']) ));
		$data_publicacao = date("Y-m-d", strtotime( str_replace("/", "-", $arr['data_publicacao']) ));

		$fields = array(
			$db->quoteName('ordering') . " = ". $arr['ordering'],
			$db->quoteName('state') . " =  ". $db->quote($arr['state']),
			$db->quoteName('checked_out_time') . " = NOW() ",
			$db->quoteName('modified_by') . " =  ". $db->quote($arr['modified_by']),
			$db->quoteName('titulo') . " =  ". $db->quote($arr['titulo']),
			$db->quoteName('resumo') . " =  ". $db->quote($arr['resumo']),
			$db->quoteName('data_licitacao') . " =  ". $db->quote($data_licitacao),
			$db->quoteName('numero_processo') . " =  ". $db->quote($arr['numero_processo']),
			$db->quoteName('ano_processo') . " =  ". $db->quote($arr['ano_processo']),
			$db->quoteName('modalidade') . " =  ". $db->quote($arr['modalidade']),
			$db->quoteName('numero_modalidade') . " =  ". $db->quote($arr['numero_modalidade']),
			$db->quoteName('ano_modalidade') . " =  ". $db->quote($arr['ano_modalidade']),
			$db->quoteName('objeto') . " =  ". $db->quote($arr['objeto']),
			$db->quoteName('data_publicacao') . " =  ". $db->quote($data_publicacao),
			
		);

		$conditions = array($db->quoteName('id') . ' = '. $arr['id']);

		$query->update($db->quoteName('#__licitacoes'))->set($fields)->where($conditions);

		// echo $query->__toString();die;

		$db->setQuery($query);
		$db->execute();

		$contador = 0;

		if($db->execute()){
			$arr['tipo'] = array_values($arr['tipo']);
			for ($i=0; $i < count($arr['titulo_arquivo_old']); $i++) { 
				if($arr['titulo_arquivo_old'][$i] != '') {
					self::updateAnexoById($arr['anexo_id'][$i],$arr['titulo_arquivo'][$i], $arr['ordering_arquivo'][$i],  $arr['tipo'][$i]);
				}
			}
			
			foreach ($arr['arquivo'] as $arquivo_item) {
				$anexo['arquivo']  		= $arquivo_item['arquivo'];
				$anexo['id_licitacao']= (int) $arr['id'];
				$anexo['titulo']   		= $arquivo_item['titulo'];
				$anexo['ordering']   	= $arquivo_item['ordem'];
				$anexo['tipo']   		  = $arquivo_item['tipo'];
				$anexo['id_user']   	= (int) JFactory::getUser()->get( 'id' );

				if(empty($anexo['titulo'])) $anexo['titulo'] = $arquivo_item['arquivo'];
				$contador++;

				$licitacaoCrllr::addAnexo($anexo);
			}
		}

		//apaga os velhos
		if(!empty($arr['arquivos_deletados'])) {
			$arquivos_deletados_id_array = explode("*", $arr['arquivos_deletados']);
			
			foreach ($arquivos_deletados_id_array as $arquivo_deletado_id) {
				$licitacaoCrllr::removeAnexo($arquivo_deletado_id);
			}

		}
		//atualiza os anexos 
		$anexosSalvos = $licitacaoCrllr::getAnexosByIdArray($arr['id']);
	}

	function getAnexosByIdArray($id)
	{

		if(empty($id)) return '';
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__arquivos_licitacao'));
		$query->where("id_licitacao = $id");
		$db->setQuery($query);
		$anexos = $db->loadAssocList();
		return $anexos;

	}

	public function removeAnexo($anexo_id)
	{
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$conditions = array(
			$db->quoteName('id') . ' = ' . $anexo_id
		);

		$query->delete($db->quoteName('#__arquivos_licitacao'));
		$query->where($conditions);
		$db->setQuery($query);
		
		$result = $db->execute();
	}

	public static function makeUpload(&$files, $data)
	{

		jimport('joomla.filesystem.file');
		$upload_dir = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR;		

		$anexoFile = array();
		
		for ($i=0; $i <= count($files['name']['arquivo']); $i++) {
			
			$filename = $files['name']['arquivo'][$i];
			$file_ext = JFile::getExt($files['name']['arquivo'][$i]);
			$filename = JFile::makeSafe($files['name']['arquivo'][$i]);
			$filename_tmp = $files['tmp_name']['arquivo'][$i];
			$current_timestmp  = getdate()[0];			

			$tituloArquivo 	= $data['titulo_arquivo'][$i];
			$data_cont = 0;
			if(is_numeric(count($data['titulo_arquivo_old'])) + count($data['titulo_arquivo_old']) > 0){
				$data_cont = count($data['titulo_arquivo_old']);
			}
			$data['tipo'] = array_values($data['tipo']);
			$tipo 		  	= $data['tipo'][$data_cont + $i];
			$ordem 			  = $data['ordering_arquivo'][$i];
			
			if(is_null($tipo)){
				$tipo = '0';
			}
			
			if ( $filename != '' ) {
				
				$filepath = JPath::clean($upload_dir);
				if (JFile::upload($filename_tmp, $filepath.$current_timestmp.'_'.$filename)) {
						
						$user =& JFactory::getUser();
						$userId = $user->get( 'id' );

						$arrayAnexoFile = [
							"titulo"   		=> $tituloArquivo,
							"ordem"   		=> $ordem,
							"arquivo"  		=> $current_timestmp.'_'.$filename,
							"created"  		=> date('Y-m-d H:i:s'),
							"id_licitacao" 	=> "",
							"id_user"  		=> $userId,
							"tipo"     		=> $tipo
						];

						array_push($anexoFile, $arrayAnexoFile);

				} else {
						JError::raiseError(500, 'Erro ao fazer o upload do arquivo.');
						$url = JRoute::_('index.php?option=com_licitacoes&view=licitacoes');
						JFactory::getApplication()->redirect($url);
				}

			}

		}

		return $anexoFile;

	}

	public function insertData($arr)
	{	

		// var_dump($arr);die;
		// die("chegou aq");
		$user = JFactory::getUser();
		$arr['ordering'] = (empty($arr['ordering'])) ? 0 : $arr['ordering'];
		$licitacaoCrllr = new LicitacoesControllerLicitacao();
		
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		if(empty($arr['ordering']) || $arr['ordering'] == ''){
			$arr['ordering'] = 0;
		}

		$id_licitacao = $licitacaoCrllr::getLicitacaoLastId();

		// var_dump($id_licitacao);die;

		$data_licitacao = date("Y-m-d", strtotime( str_replace("/", "-", $arr['data_licitacao']) ));
		$data_publicacao = date("Y-m-d", strtotime( str_replace("/", "-", $arr['data_publicacao']) ));

		$columns = array(
			'ordering',
			'state',
			'checked_out',
			'checked_out_time',
			'created_by',
			'modified_by',
			'titulo',
			'resumo',
			'data_licitacao',
			'numero_processo',
			'ano_processo',
			'modalidade',
			'numero_modalidade',
			'ano_modalidade',
			'objeto',
			'data_publicacao',
			'publicado'
		);

		$values = array(
			$arr['ordering'],
			$arr['state'],
			$db->quote($arr['created_by']),
			'NOW()',
			$db->quote($arr['created_by']),
			$db->quote($arr['modified_by']),
			$db->quote($arr['titulo']),
			$db->quote($arr['resumo']),
			$db->quote($data_licitacao),
			$db->quote($arr['numero_processo']),
			$db->quote($arr['ano_processo']),
			$db->quote($arr['modalidade']),
			$db->quote($arr['numero_modalidade']),
			$db->quote($arr['ano_modalidade']),
			$db->quote($arr['objeto']),
			$db->quote($data_publicacao),
			$arr['state']
		);

		$query->insert($db->quoteName('#__licitacoes'))
				->columns($db->quoteName($columns))
				->values(implode(',', $values));

		// echo $query->__toString();die;

		$db->setQuery($query);
		
		$contador = 0;

		if($db->execute()){
			foreach ($arr['arquivo'] as $arquivo_item) {

				$anexo['arquivo']  		= $arquivo_item['arquivo'];
				$anexo['id_licitacao'] 	= (int) $id_licitacao + 1;
				$anexo['titulo']   		= $arquivo_item['titulo'];
				$anexo['ordering']   	= $arquivo_item['ordem'];
				$anexo['tipo']   		= $arquivo_item['tipo'];
				$anexo['id_user']   	= $arquivo_item['id_user'];
				if(empty($anexo['titulo'])) $anexo['titulo'] = $arquivo_item['arquivo'];
				$contador++;
				

				$licitacaoCrllr::addAnexo($anexo);	
			}
		}

	}

	public function addAnexo($anexo)
	{
		$db    = JFactory::getDbo();
		$query = $db->getQuery(true);

		$columns = array(
			'ordering',
			'state',
			'checked_out',
			'checked_out_time',
			'created_by',
			'modified_by',
			'titulo',
			'arquivo',
			'tipo',
			'id_licitacao'
		);

		$values = array(
			$db->quote($anexo['ordering']),
			1,
			$db->quote($anexo['id_user']),
			'NOW()',
			$db->quote($anexo['id_user']),
			$db->quote($anexo['id_user']),
			$db->quote($anexo['titulo']),
			$db->quote($anexo['arquivo']),
			$db->quote($anexo['tipo']),
			$db->quote($anexo['id_licitacao']),
		);

		$query->insert($db->quoteName('#__arquivos_licitacao'))
				->columns($db->quoteName($columns))
				->values(implode(',', $values));

		$db->setQuery($query);
		$db->execute();
	}

	public function getLicitacaoLastId()
	{

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select("id");
		$query->from($db->quoteName('#__licitacoes'));
		$query->order('id desc');
		$query->group('id');
		$db->setQuery($query);
		$results = $db->loadObjectList();

		return $results[0]->id;
	}

	public static function updateAnexoById($id,$titulo,$ordem,$tipo)
	{
		if(empty($id) || empty($titulo)) return array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$fields = array(
			$db->quoteName('titulo') . " =  ". $db->quote($titulo),
			$db->quoteName('ordering') . " =  ". $db->quote($ordem),
			$db->quoteName('tipo') . " =  ". $db->quote($tipo)
		);

		$conditions = array($db->quoteName('id') . ' = '. $id);
		
		$query->update($db->quoteName('#__arquivos_licitacao'))->set($fields)->where($conditions);
		$db->setQuery($query);

		$db->execute();
	}

	
}
