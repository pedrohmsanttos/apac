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

jimport('joomla.application.component.modeladmin');

require_once JPATH_COMPONENT . '/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

/**
 * Previsaodotempo model.
 *
 * @since  1.6
 */
class PrevisaodotempoModelPrevisao extends JModelAdmin
{
	/**
	 * @var      string    The prefix to use with controller messages.
	 * @since    1.6
	 */
	protected $text_prefix = 'COM_PREVISAODOTEMPO';

	/**
	 * @var   	string  	Alias to manage history control
	 * @since   3.2
	 */
	public $typeAlias = 'com_previsaodotempo.previsao';

	/**
	 * @var null  Item data
	 * @since  1.6
	 */
	protected $item = null;

        
	/**
	 * Returns a reference to the a Table object, always creating it.
	 *
	 * @param   string  $type    The table type to instantiate
	 * @param   string  $prefix  A prefix for the table class name. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return    JTable    A database object
	 *
	 * @since    1.6
	 */
	public function getTable($type = 'previsao', $prefix = 'PrevisaodotempoTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}

	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      An optional array of data for the form to interogate.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  JForm  A JForm object on success, false on failure
	 *
	 * @since    1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
            // Initialise variables.
            $app = JFactory::getApplication();

            // Get the form.
            $form = $this->loadForm(
                    'com_previsaodotempo.previsao', 'previsao',
                    array('control' => 'jform',
                            'load_data' => $loadData
                    )
            );

            
			//if($form->getFieldAttribute('horario', 'default') == 'NOW'){
				//$form->setFieldAttribute('horario', 'default', date('H:i:s'));
			//}

            if (empty($form))
            {
                return false;
            }

            return $form;
	}

	/**
	 * Method to get the data that should be injected in the form.
	 *
	 * @return   mixed  The data for the form.
	 *
	 * @since    1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState('com_previsaodotempo.edit.previsao.data', array());

		if (empty($data))
		{
			if ($this->item === null)
			{
				$this->item = $this->getItem();
			}

			$data = $this->item;
                        

			// Support for multiple or not foreign key field: tipo
			$array = array();

			foreach ((array) $data->tipo as $value)
			{
				if (!is_array($value))
				{
					$array[] = $value;
				}
			}
			if(!empty($array)){

			$data->tipo = $array;
			}
		}

		return $data;
	}

	/**
	 * Method to get a single record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed    Object on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function getItem($pk = null)
	{
		$pk = (!empty($pk)) ? $pk : (int) $this->getState($this->getName() . '.id');
		$item = $this->getValues($pk);
		
		if ($item)
		{
			// Do any procesing on fields here if needed
			$getDecode = $this->getValores($item->id);
			$currentDtaValida   = explode(' ', $item->datavlida);
			$item->datavlida    = $item->datavlida .' '. $item->horario;
			$item->valores      = json_decode($getDecode->valores);
			$item->mesorregioes = json_decode($getDecode->mesorregioes);
			
			if($currentDtaValida[0] == '1970-01-01')
				$item->datavlida = '';
		}
		
		return $item;    
	}

	public function getValues($id){
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select('*');
		$query->from($db->quoteName('#__previsaodotempo_previsao'));
		$query->where('"id" = '. (int) $id);

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();
		
		if(count($results) > 0)
			return $results[0];
		return false;
	}

	/**
	 * Method to get a valores e moserregiõs decode record.
	 *
	 * @param   integer  $pk  The id of the primary key.
	 *
	 * @return  mixed    Object on success, false on failure.
	 *
	 * @since    1.6
	 */
	public function getValores($pk = null)
	{
        // Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user profile table where key begins with "custom.".
		// Order it by the ordering field.
		$query->select($db->quoteName(array('valores', 'mesorregioes')));
		$query->from($db->quoteName('#__previsaodotempo_previsao'));
		$query->where('id = '. (int) $pk);

		// Reset the query using our newly populated query object.
		$db->setQuery($query);

		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		return $results[0];
	}

	/**
	 * Method to duplicate an Previsao
	 *
	 * @param   array  &$pks  An array of primary key IDs.
	 *
	 * @return  boolean  True if successful.
	 *
	 * @throws  Exception
	 */
	public function duplicate(&$pks)
	{
		$user = JFactory::getUser();

		// Access checks.
		if (!$user->authorise('core.create', 'com_previsaodotempo'))
		{
			throw new Exception(JText::_('JERROR_CORE_CREATE_NOT_PERMITTED'));
		}

		$dispatcher = JEventDispatcher::getInstance();
		$context    = $this->option . '.' . $this->name;

		// Include the plugins for the save events.
		JPluginHelper::importPlugin($this->events_map['save']);

		$table = $this->getTable();

		foreach ($pks as $pk)
		{
                    
			if ($table->load($pk, true))
			{
				// Reset the id to create a new record.
				$table->id = 0;

				if (!$table->check())
				{
					throw new Exception($table->getError());
				}
				

				// Trigger the before save event.
				$result = $dispatcher->trigger($this->event_before_save, array($context, &$table, true));

				if (in_array(false, $result, true) || !$table->store())
				{
					throw new Exception($table->getError());
				}

				// Trigger the after save event.
				$dispatcher->trigger($this->event_after_save, array($context, &$table, true));
			}
			else
			{
				throw new Exception($table->getError());
			}
                    
		}

		// Clean cache
		$this->cleanCache();

		return true;
	}

	/**
	 * Prepare and sanitise the table prior to saving.
	 *
	 * @param   JTable  $table  Table Object
	 *
	 * @return void
	 *
	 * @since    1.6
	 */
	protected function prepareTable($table)
	{
		jimport('joomla.filter.output');

		if (empty($table->id))
		{
			// Set ordering to the last item if not set
			if (@$table->ordering === '')
			{
				$db = JFactory::getDbo();
				$db->setQuery('SELECT MAX(ordering) FROM #__previsaodotempo_previsao');
				$max             = $db->loadResult();
				$table->ordering = $max + 1;
			}
		}
	}

	public function save($data)
	{
		if (parent::save($data)) 
		{
			// TODO:
			return true;
		}

		return false;
	}


	public function gerarPDF($pks){

		$html = $this->layoutPDF($pks);
		
		if(empty($pks)) return false;
		
		$dompdf = new Dompdf();
		$dompdf->set_option('isHtml5ParserEnabled', true);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->setBasePath(JPATH_COMPONENT . '/dompdf');
		$dompdf->loadHtml($html);
		$dompdf->render();
		$dompdf->output();

		$filename = 'PREVISAO_'.date('d-m-Y-His').'_'.$pks[0].'.pdf';

		$dompdf->stream($filename);

		return true;
	}

	protected function getInteressados(){
		
		$interessados = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		//Consultando todos que querem receber AVISOS METEOROLOGICOS
		$query->select($this->getState('list.select', 'DISTINCT a.*'));
		$query->from('#__cadastrointeressado AS a');
		$query->where('a.previsao_tempo = \'1\' AND a.situacao = \'1\' ');
         
		$db->setQuery($query);
		
		$interessados = $db->loadObjectList();
	
		return $interessados;
	}

	protected function getLogo(){
		$path = JPATH_ROOT . '/images/logo-apac-governo-pequena.jpg';
		return $this->getBase64Image($path);
	}
	
	protected function getBase64Image($path){
		// echo $path;die;
		$type = pathinfo($path)['extension'];
		
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}

	public function enviarEmail($pks)
	{
		$return = array();

		$db = JFactory::getDbo();
		$id    = $db->escape($pks[0]);

		$interessados = $this->getInteressados();

		if(!empty($interessados)){
			$html = $this->layoutEmail($pks);

			
			if(empty($pks)){
				$return['tipo'] 	= 'erro';
				$return['mensagem'] = 'ID não pode ser vazio!';
			}else{
				try {
					
					foreach($interessados as $interessado){

						$html = str_replace("!#ID_INTERESSADO#!", $interessado->id, $html);

						$item_email = new stdClass();
						$item_email->nome 			= $interessado->nome;
						$item_email->email 			= $interessado->email; 
						$item_email->conteudo		= $html;	
						$item_email->id_usuario		= JFactory::getUser()->id;
						$item_email->id_item		= $pks[0];
						$item_email->tipo_item		= "PREVISAO";
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

	public function comparaOrdem($a, $b)
	{
		return intval($a['mesoregiao']['ordem']) > intval($b['mesoregiao']['ordem']);
	}

	protected function ordenaByOrdem($previsao)
	{
		$arrRetorno = array();
		$arrRetorno = $previsao;
		
		usort($arrRetorno, array('PrevisaodotempoModelPrevisao', 'comparaOrdem'));
		return $arrRetorno;
	}

	protected function getVariaveis($variaveis)
	{
		$todasVariaveis = json_decode($variaveis);

		
		$retornoVariaveis = array();

		if (!empty($todasVariaveis[0])) {
			foreach ($todasVariaveis as $var) {
				$varExplode = explode(";", $var);

				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->select('*');
				$query->from($db->quoteName('#__previsaodotempo_mesorregiao'));
				$query->where("nome = '" . $varExplode[0] . "'");
				$query->where('state = 1');
				$query->setLimit('1');

				$db->setQuery($query);
				$rows = $db->loadObjectList();

				

				$ret = array();
				$ret[$varExplode[1]] = $varExplode[2];

				$retornoVariaveis[$rows[0]->id][] = $ret;

				// echo "<pre>";var_dump($retornoVariaveis);die;
			}
		}

		return $retornoVariaveis;
	}

	protected function getPrevisaoBy($where){

		$retorno = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__previsaodotempo_previsao','a'));

		// $query->where('( a.tipo = ' . $db->quote('hoje–manha') . ' OR a.tipo = ' . $db->quote('hoje–tarde') . ')');
		$query->where($where);

		$query->setLimit('1');
		$query->order('a.id desc'); 

		$db->setQuery($query);

		$results = $db->loadObjectList();

		// echo "<pre>";
		// var_dump($results[0]->datavlida);die;

		$retorno['datavalida'] = $results[0]->datavlida;

		
		if (isset($results) && !empty($results)) {

			foreach ($results as $row) {
				$meso = json_decode($row->mesorregioes);

				if (!empty($meso->mesorregiao)) {

					foreach ($meso->mesorregiao as $chaveMeso => $m) {

						$queryMeso = $db->getQuery(true);
						$queryMeso->select('*');
						$queryMeso->from($db->quoteName('#__previsaodotempo_mesorregiao'));
						$queryMeso->where('id = ' . $m);
						// $queryMeso->where('state = 1');

						$db->setQuery($queryMeso);
						$rowsMeso = $db->loadObjectList();

						$dadosMesoregiao = array();
						foreach ($rowsMeso as $rMeso) {

							$dadosMesoregiao['nome'] = $rMeso->nome;
							$dadosMesoregiao['ordem'] = $rMeso->ordering;

						}

						$prev = array();

						$prev['data_previsao'] 			= $row->datavlida . " " . $row->horario;
						$prev['IntensidadeDoVento'] 	= $meso->IntensidadeDoVento[$chaveMeso];
						$prev['RotaDoVento'] 			= $meso->RotaDoVento[$chaveMeso];
						$prev['nebulosidade'] 			= $meso->nebulosidade[$chaveMeso];
						$prev['TiposDeChuva'] 			= $meso->TiposDeChuva[$chaveMeso];
						$prev['DistribuicaoDaChuva'] 	= $meso->DistribuicaoDaChuva[$chaveMeso];
						$prev['PeriodoDaChuva'] 		= $meso->PeriodoDaChuva[$chaveMeso];
						$prev['IntensidadeDaChuva'] 	= $meso->IntensidadeDaChuva[$chaveMeso];
						$prev['icone'] 					= $meso->icone[$chaveMeso];
						$prev['temMin'] 				= $meso->temMin[$chaveMeso];
						$prev['temMax'] 				= $meso->temMax[$chaveMeso];
						$prev['umiMin'] 				= $meso->umiMin[$chaveMeso];
						$prev['umiMax'] 				= $meso->umiMax[$chaveMeso];
						$prev['icone'] 					= $meso->icone[$chaveMeso];

						$previsao[$m]['previsao'] = $prev;
						// echo "<pre>";var_dump($row->valores);die;
						$variaveis = $this->getVariaveis($row->valores);
						
						// foreach ($variaveis as $chaveVar => $var) {
						// 	$previsao[$chaveVar]['variaveis'] = $var;
						// }
						foreach ($variaveis as $chaveVar => $var) {
							if($chaveVar == $m){
								$previsao[$m]['variaveis'] = $var;
							}
						}

						if($rowsMeso[0]->state == 1){
							$previsao[$m]['mesoregiao'] = $dadosMesoregiao;
							
						}else{
							unset($previsao[$m]);
						}
						
					}

				}
			}

		}	
		
		if (!empty($previsao)) {
			$previsao = $this->ordenaByOrdem($previsao);
		}

		// var_dump($previsao);die;

		$retorno['previsao'] = $previsao;
		return $retorno;
	}

	protected function getTabelaPrevisao($previsao, $amanha){

		$returnPrevisao = array();

		if(!empty($previsao) && !empty($amanha)){

			$tabelaPrevisao = '<table class="table tabela-nova" style="width: 100%"><thead><tr><th colspan="2" class="bg-warning" style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;background-color:#E7BB03;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;color:#745e01;font-weight:700;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top">!#TIPO#!</th></tr></thead><tbody><tr><td class="prevDesc" style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:70%">!#TEXTO_DATA#!</td><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;float:right;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:101%"><img src="!#ICONE#!" height="50" width="50"></td></tr><tr><td colspan="2" style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top"><strong>!#TEXTO_PREVISAO#!</strong></td></tr><tr><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-temperature-high"></i>Temperatura Máxima: !#TEMP_MAX#!</td><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-temperature-low"></i>Temperatura Mínima: !#TEMP_MIN#!</td></tr><tr><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-tint"></i> Umidade Máxima: !#UMI_MAX#!</td><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-tint"></i> Umidade Mínima: !#UMI_MIN#!</td></tr><tr><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-wind"></i> Vento (m/s): !#VENTO#!</td><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-wind"></i> Vento Direção: !#VENTO_DIR#!</td></tr>!#VARIAVEIS#!</tbody></table>';
	
			foreach($previsao['previsao'] as $chave => $prev){
				$previsaoRetorno = array();
				$tabela = array();

				$previsaoRetorno['mesoregiao'] = $previsao['previsao'][$chave]['mesoregiao']['nome'];
			
				$dataHoje = date("d/m/Y", strtotime( str_replace("-","/", $prev['previsao']['data_previsao'])));
				$horasHoje = strtotime($prev['previsao']['data_previsao']);
				$horasHoje =  date('H:i:s', $horasHoje);

				if ($dataHoje == '01/01/1970'){$dataHoje = " - ";}
				
				$dataHoraHoje = $dataHoje . " às " . $horasHoje;
				$textoDataHoraHoje = "Previsão atualizada em $dataHoraHoje";
				
				$textoPrevisaoHoje  = $prev['previsao']['nebulosidade']; 
				$textoPrevisaoHoje .= " ".$prev['previsao']['TiposDeChuva']; 
				$textoPrevisaoHoje .= " ".$prev['previsao']['DistribuicaoDaChuva']; 
				$textoPrevisaoHoje .= " ".$prev['previsao']['PeriodoDaChuva']; 
				if ($prev['previsao']['IntensidadeDaChuva'] == "nenhuma"){
					$textoPrevisaoHoje .= "";
				}else{
					$textoPrevisaoHoje .= " ".$prev['previsao']['IntensidadeDaChuva'].".";
				}
				
				$pathIcone = JPATH_ROOT."/".$prev['previsao']['icone'];
				$iconePrevisao = $this->getBase64Image($pathIcone);
				 
				$tabelaPrevisaoHoje = str_replace("!#TIPO#!", "HOJE", $tabelaPrevisao);
				$tabelaPrevisaoHoje = str_replace("!#TEXTO_DATA#!", $textoDataHoraHoje, $tabelaPrevisaoHoje);
				$tabelaPrevisaoHoje = str_replace("!#ICONE#!", $iconePrevisao, $tabelaPrevisaoHoje);
				$tabelaPrevisaoHoje = str_replace("!#TEXTO_PREVISAO#!", $textoPrevisaoHoje, $tabelaPrevisaoHoje);
				$tabelaPrevisaoHoje = str_replace("!#TEMP_MAX#!", $prev['previsao']['temMax'] . "°C", $tabelaPrevisaoHoje);
				$tabelaPrevisaoHoje = str_replace("!#TEMP_MIN#!", $prev['previsao']['temMin'] . "°C", $tabelaPrevisaoHoje);
				$tabelaPrevisaoHoje = str_replace("!#UMI_MAX#!", $prev['previsao']['umiMax'] . "%", $tabelaPrevisaoHoje);
				$tabelaPrevisaoHoje = str_replace("!#UMI_MIN#!", $prev['previsao']['umiMin'] . "%", $tabelaPrevisaoHoje);
				$tabelaPrevisaoHoje = str_replace("!#VENTO#!", $prev['previsao']['IntensidadeDoVento'], $tabelaPrevisaoHoje);
				$tabelaPrevisaoHoje = str_replace("!#VENTO_DIR#!", $prev['previsao']['RotaDoVento'], $tabelaPrevisaoHoje);

				$variaveisHoje = "";
				$variaveisAmanhaVazio = "";
				
				if(!empty($prev['variaveis'])){

					foreach ($prev['variaveis'] as $item => $valor){
						if(count($prev['variaveis']) == 1){
							$variaveisHoje .= '<tr><td>' . key( $valor ).': '. $valor[key( $valor)].'</td></tr>';
							$variaveisAmanhaVazio .= '<tr><td>&nbsp;</td></tr>';
						}else{
							foreach ($valor as $chave => $val){
								if($aux == 1){
									$variaveisHoje .='<tr>';
									$variaveisAmanhaVazio .='<tr>';
								}
								$variaveisHoje .='<td>' . $chave . ': ' . $val . '</td>';
								$variaveisAmanhaVazio .='<td>&nbsp;</td>';
								if($aux == 2){
									$variaveisHoje .='</tr>';
									$variaveisAmanhaVazio .='</tr>';
									$aux = 1;
								}else{
									$aux++;
								}
								
								
							}
						}

					}
				}

				
				
				// ------------------------------------------------------------------------------------------------------ //

				$prevAmanha = $amanha['previsao'][$chave];

				$dataAmanha = date("d/m/Y", strtotime( str_replace("-","/", $prevAmanha['previsao']['data_previsao'])));
				$horasAmanha = strtotime($prevAmanha['previsao']['data_previsao']);
				$horasAmanha =  date('H:i:s', $horasAmanha);

				if ($dataAmanha == '01/01/1970'){$dataAmanha = " - ";}
				
				$dataHoraAmanha = $dataAmanha . " às " . $horasAmanha;
				$textoDataHoraAmanha = "Previsão atualizada em $dataHoraAmanha";
				
				$textoPrevisaoAmanha  = $prevAmanha['previsao']['nebulosidade']; 
				$textoPrevisaoAmanha .= " ".$prevAmanha['previsao']['TiposDeChuva']; 
				$textoPrevisaoAmanha .= " ".$prevAmanha['previsao']['DistribuicaoDaChuva']; 
				$textoPrevisaoAmanha .= " ".$prevAmanha['previsao']['PeriodoDaChuva']; 
				if ($prev['previsao']['IntensidadeDaChuva'] == "nenhuma"){
					$textoPrevisaoAmanha .= ".";
				}else{
					$textoPrevisaoAmanha .= " ".$prev['previsao']['IntensidadeDaChuva'].".";
				}

				$pathIconeAmanha = JPATH_ROOT."/".$prevAmanha['previsao']['icone'];
				$iconePrevisaoAmanha = $this->getBase64Image($pathIconeAmanha);

				$tabelaPrevisaoAmanha = str_replace("!#TIPO#!", "AMANHÃ", $tabelaPrevisao);
				$tabelaPrevisaoAmanha = str_replace("!#TEXTO_DATA#!", $textoDataHoraHoje, $tabelaPrevisaoAmanha);
				$tabelaPrevisaoAmanha = str_replace("!#ICONE#!", $iconePrevisaoAmanha, $tabelaPrevisaoAmanha);
				$tabelaPrevisaoAmanha = str_replace("!#TEXTO_PREVISAO#!", $textoPrevisaoAmanha, $tabelaPrevisaoAmanha);
				$tabelaPrevisaoAmanha = str_replace("!#TEMP_MAX#!", $prevAmanha['previsao']['temMax'] . "°C", $tabelaPrevisaoAmanha);
				$tabelaPrevisaoAmanha = str_replace("!#TEMP_MIN#!", $prevAmanha['previsao']['temMin'] . "°C", $tabelaPrevisaoAmanha);
				$tabelaPrevisaoAmanha = str_replace("!#UMI_MAX#!", $prevAmanha['previsao']['umiMax'] . "%", $tabelaPrevisaoAmanha);
				$tabelaPrevisaoAmanha = str_replace("!#UMI_MIN#!", $prevAmanha['previsao']['umiMin'] . "%", $tabelaPrevisaoAmanha);
				$tabelaPrevisaoAmanha = str_replace("!#VENTO#!", $prevAmanha['previsao']['IntensidadeDoVento'], $tabelaPrevisaoAmanha);
				$tabelaPrevisaoAmanha = str_replace("!#VENTO_DIR#!", $prevAmanha['previsao']['RotaDoVento'], $tabelaPrevisaoAmanha);


				$variaveisAmanha = ""; 
				$variaveisHojeVazio = "";
				if(!empty($prevAmanha['variaveis'])){

					foreach ($prevAmanha['variaveis'] as $item => $valor){
						if(count($prevAmanha['variaveis']) == 1){
							$variaveisAmanha .= '<tr><td>' . key( $valor ).': '. $valor[key( $valor)].'</td></tr>';
							$variaveisHojeVazio .= '<tr><td>&nbsp;</td></tr>';
						}else{
							foreach ($valor as $chave => $val){
								if($aux == 1){
									$variaveisAmanha .='<tr>';
									$variaveisHojeVazio .='<tr>';
								}
								$variaveisAmanha .='<td>' . $chave . ': ' . $val . '</td>';
								$variaveisHojeVazio .='<td>&nbsp;</td>';
								if($aux == 2){
									$variaveisAmanha .='</tr>';
									$variaveisHojeVazio .='</tr>';
									$aux = 1;
								}else{
									$aux++;
								}
								
								
							}
						}

					}
				}

				if(!empty($variaveisHoje) && empty($variaveisAmanha)){
				
					$tabelaPrevisaoHoje = str_replace("!#VARIAVEIS#!", $variaveisHoje, $tabelaPrevisaoHoje);
					$tabelaPrevisaoAmanha = str_replace("!#VARIAVEIS#!", $variaveisAmanhaVazio, $tabelaPrevisaoAmanha);
				
				}else if(empty($variaveisHoje) && !empty($variaveisAmanha)){
				
					$tabelaPrevisaoHoje = str_replace("!#VARIAVEIS#!", $variaveisHojeVazio, $tabelaPrevisaoHoje);
					$tabelaPrevisaoAmanha = str_replace("!#VARIAVEIS#!", $variaveisAmanha, $tabelaPrevisaoAmanha);
				
				}else if(empty(trim($variaveisHoje)) && empty(trim($variaveisAmanha))){

					$tabelaPrevisaoHoje = str_replace("!#VARIAVEIS#!", "", $tabelaPrevisaoHoje);
					$tabelaPrevisaoAmanha = str_replace("!#VARIAVEIS#!", "", $tabelaPrevisaoAmanha);
				
				}else{
					$tabelaPrevisaoHoje = str_replace("!#VARIAVEIS#!", "", $tabelaPrevisaoHoje);
					$tabelaPrevisaoAmanha = str_replace("!#VARIAVEIS#!", "", $tabelaPrevisaoAmanha);
				}
				
				$previsaoRetorno['previsao'][] = $tabelaPrevisaoHoje;
				$previsaoRetorno['previsao'][] = $tabelaPrevisaoAmanha;

				$returnPrevisao[] = $previsaoRetorno;
				
				
			}

		}

		return $returnPrevisao;
	}

	protected function layoutPDF($pks){

		$html = "";

		if(empty($pks)) return $html;


		$db = JFactory::getDbo();
		$id    = $db->escape($pks[0]);

		$previsao = $this->getPrevisaoBy("a.id =".$id);		

		$date = new DateTime($previsao['datavalida']);
		$intervalo = new DateInterval('P1D');
		$date->add($intervalo);

		$amanha = $this->getPrevisaoBy("a.tipo ='amanha' AND a.datavlida = '". $date->format('Y-m-d') ."' ");
		$imagem = $this->getLogo();
		$html = '<div style="margin: auto;width: 50%;"><img src="' . $imagem . '"></div>';	

		if(!empty($previsao) && !empty($amanha)){

			$retornoPrevi = $this->getTabelaPrevisao($previsao, $amanha);
			
			foreach($retornoPrevi as $chaveRet => $retPrev){
				$html .= '<div style="page-break-after: always;">';
				$html .= '<h3>!#MESOREGIAO#!</h3>';

				$html = str_replace("!#MESOREGIAO#!", $retPrev['mesoregiao'], $html);

				$html .= '<table><tr>';
				$html .= '<td>'.$retPrev['previsao']['0'].'</td>';
				$html .= '<td>'.$retPrev['previsao']['1'].'</td>';
				$html .='</tr></table>';
				$html .= "</div>";
			}


		}

		return $html;
		
	}

	protected function layoutEmail($pks, $pdf = null)
	{	
		$html = "";

		if(empty($pks)) return $html;


		$db = JFactory::getDbo();
		$id    = $db->escape($pks[0]);

		$previsao = $this->getPrevisaoBy("a.id =".$id);

		

		$date = new DateTime($previsao['datavalida']);
		$intervalo = new DateInterval('P1D');
		$date->add($intervalo);

		$amanha = $this->getPrevisaoBy("a.tipo ='amanha' AND a.datavlida = '". $date->format('Y-m-d') ."' ");

		

		$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head></head><body>';	

		if(!empty($previsao) && !empty($amanha)){

			$retornoPrevi = $this->getTabelaPrevisao($previsao, $amanha);

			$imagem = $this->getLogo();
			$html = '<div style="margin: auto;width: 50%;"><img src="' . $imagem . '"></div>';

			$html .= '<table><tbody>';
			
			$tabelaPrevisao = '<table class="table tabela-nova" style="width: 100%"><thead><tr><th colspan="2" class="bg-warning" style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;background-color:#E7BB03;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;color:#745e01;font-weight:700;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top">!#TIPO#!</th></tr></thead><tbody><tr><td class="prevDesc" style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:70%">!#TEXTO_DATA#!</td><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;float:right;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:101%"><img src="!#ICONE#!" height="50" width="50"></td></tr><tr><td colspan="2" style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top"><strong>!#TEXTO_PREVISAO#!</strong></td></tr><tr><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-temperature-high"></i>Temperatura Máxima: !#TEMP_MAX#!</td><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-temperature-low"></i>Temperatura Mínima: !#TEMP_MIN#!</td></tr><tr><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-tint"></i> Umidade Máxima: !#UMI_MAX#!</td><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-tint"></i> Umidade Mínima: !#UMI_MIN#!</td></tr><tr><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-wind"></i> Vento (m/s): !#VENTO#!</td><td style="-o-transition:all .3s ease;-webkit-transition:all .3s ease;border-bottom:1px solid rgba(0,0,0,.12);border-top:0;padding:.4rem;text-align:left;transition:all .3s ease;vertical-align:top;width:50%"><i class="fas fa-wind"></i> Vento Direção: !#VENTO_DIR#!</td></tr>!#VARIAVEIS#!</tbody></table>';
			
			foreach($retornoPrevi as $chaveRet => $retPrev){
				$html .= '<tr><td colspan="2"><h3>!#MESOREGIAO#!</h3></td></tr>';

				$html = str_replace("!#MESOREGIAO#!", $retPrev['mesoregiao'], $html);

				$html .= "<tr>";
				$html .= '<td>'.$retPrev['previsao']['0'].'</td>';
				$html .= '<td>'.$retPrev['previsao']['1'].'</td>';
				$html .= "</tr>";
			}
			

			$urlSite = str_replace("administrator/", "", JURI::base());

			$urlSite .= "component/interessadonosite/?id=!#ID_INTERESSADO#!";

			$descadastrar = '<a href="!#LINK_DESC#!">Caso não queira mais receber esse e-mail, clique aqui para descadastrar-se.</a>';
			$html .= '<tr><td colspan="2" bgcolor="" style="padding: 30px 30px 30px 30px; text-align:center; color:#735D01;">!#CONTEUDO_DESC#!</td><tr>';
			$html .= "</tbody></table></body></html>";

			$descadastrar = str_replace("!#LINK_DESC#!", $urlSite, $descadastrar);
			$html = str_replace("!#CONTEUDO_DESC#!", $descadastrar, $html);


		}

		return $html;

	}
}
