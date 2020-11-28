<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Licitacoes
 * @author     Pedro Santos <phmsanttos@gmail.com>
 * @copyright  2018 Pedro Santos
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Licitacoes model.
 *
 * @since  1.6
 */
class LicitacoesModelLicitacao extends JModelAdmin
{
	/**
	 * @var      string    The prefix to use with controller messages.
	 * @since    1.6
	 */
	protected $text_prefix = 'COM_LICITACOES';

	/**
	 * @var   	string  	Alias to manage history control
	 * @since   3.2
	 */
	public $typeAlias = 'com_licitacoes.licitacao';

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
	public function getTable($type = 'Licitacao', $prefix = 'LicitacoesTable', $config = array())
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
                    'com_licitacoes.licitacao', 'licitacao',
                    array('control' => 'jform',
                            'load_data' => $loadData
                    )
            );

            

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
		$data = JFactory::getApplication()->getUserState('com_licitacoes.edit.licitacao.data', array());

		if (empty($data))
		{
			if ($this->item === null)
			{
				$this->item = $this->getItem();
			}

			$data = $this->item;
                        

			// Support for multiple or not foreign key field: publicado
			$array = array();

			foreach ((array) $data->publicado as $value)
			{
				if (!is_array($value))
				{
					$array[] = $value;
				}
			}
			if(!empty($array)){

			$data->publicado = $array;
			}

			// Support for multiple or not foreign key field: modalidade
			$array = array();

			foreach ((array) $data->modalidade as $value)
			{
				if (!is_array($value))
				{
					$array[] = $value;
				}
			}
			if(!empty($array)){

			$data->modalidade = $array;
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
            
            if ($item = parent::getItem($pk))
            {
                // Do any procesing on fields here if needed
            }

            return $item;
            
	}

	/**
	 * Method to duplicate an Licitacao
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
		if (!$user->authorise('core.create', 'com_licitacoes'))
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
				$db->setQuery('SELECT MAX(ordering) FROM #__licitacoes');
				$max             = $db->loadResult();
				$table->ordering = $max + 1;
			}
		}
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
		$query->where('a.licitacoes = \'1\' AND a.situacao = \'1\' ');
         
		$db->setQuery($query);

		$interessados = $db->loadObjectList();

		return $interessados;
	}

	public function enviarEmail($pks)
	{

		$return = array();

		$interessados = $this->getInteressados();

		if(!empty($interessados)){
			$html = $this->layoutEmail($pks);

			if(empty($pks)){
				$return['tipo'] 	= 'erro';
				$return['mensagem'] = 'ID não pode ser vazio!';
			}else{
				try {
					$db = JFactory::getDbo();

					foreach($interessados as $interessado){

						$html = str_replace("!#ID_INTERESSADO#!", $interessado->id, $html);

						$item_email = new stdClass();
						$item_email->nome 			= $interessado->nome;
						$item_email->email 			= $interessado->email; 
						$item_email->conteudo		= $html;	
						$item_email->id_usuario		= JFactory::getUser()->id;
						$item_email->id_item		= $pks[0];
						$item_email->tipo_item		= "LICITACAO";
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

	protected function layoutEmail($pks, $pdf = null)
	{	

		$html = "";

		if(empty($pks)) return $html;

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		//clean sql injection
		$id    = $db->escape($pks[0]);

		// Select the required fields from the table.
		$query->select($this->getState('list.select', 'DISTINCT a.*'));
		$query->from('#__licitacoes AS a');
                
		// Join over the users for the checked out user
		$query->select("uc.name AS uEditor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");

		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');

		// Join over the user field 'modified_by'
		$query->select('modified_by.name AS modified_by');
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');

		$query->select('modalidade_licitacao.nome AS nome_modalidade');
		$query->join('LEFT', '#__modalidade_licitacao AS modalidade_licitacao ON modalidade_licitacao.id::varchar  = a.modalidade');
        
		$query->where("a.id =".$id);
		$db->setQuery($query);

		
		if(!empty($db->loadObjectList()[0])){
		
			$licitacao = $db->loadObjectList()[0];

			
			$urlSite = str_replace("administrator/", "", JURI::base());

			$titulo = $informe->titulo;


			$urlDescadastrar = $urlSite . "component/interessadonosite/?id=!#ID_INTERESSADO#!";
			
			$linkDescadastrar = '<a href="'. $urlDescadastrar .'">Caso não queira mais receber esse e-mail, clique aqui para descadastrar-se</a>';

			$urlLogo = $this->getLogo();

			$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head></head><body><style></style><table class="tg" style="border:none;border-collapse:collapse;border-color:#9ABAD9;border-spacing:0;table-layout:fixed;width:100%"><tbody><tr><th class="tg-xldj" style="background-color:#E7BB03;border-color:inherit;border-style:solid;border-width:0;color:#fff;font-family:Arial,sans-serif;font-size:14px;font-weight:400;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"><span style="font-weight:700">LICITAÇÃO: !#TITULO#!</span></th></tr><tr><td class="tg-xldj" style="background-color:white;border-color:inherit;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:justify;word-break:normal">!#DESCRICAO#!</td></tr><tr><td class="tg-xldj" style="background-color:white;border-color:inherit;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:center;word-break:normal"><img src="!#LOGO#!"></td></tr><tr><td class="tg-xldj" style="background-color:white;border-color:inherit;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"></td></tr><tr><td class="tg-c3ow" style="background-color:white;border-color:inherit;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:center;vertical-align:top;word-break:normal">!#DESCADASTRAR#!</td></tr></tbody></table></body></html>';
			

			$html = str_replace("!#LOGO#!",$urlLogo,$html);
			$html = str_replace("!#TITULO#!",$licitacao->titulo,$html);
			$html = str_replace("!#DESCRICAO#!",$licitacao->resumo,$html);
			$html = str_replace("!#DESCADASTRAR#!",$linkDescadastrar,$html);
			
		}

		

		return $html;
	}
}
