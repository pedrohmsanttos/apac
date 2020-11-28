<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Informehidrologico
 * @author     Matheus Felipe <matheusfelipe.moreira@gmail.com>
 * @copyright  2018 Matheus Felipe
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access.
defined('_JEXEC') or die;

jimport('joomla.application.component.modeladmin');

/**
 * Informehidrologico model.
 *
 * @since  1.6
 */
class InformehidrologicoModelInformehidrologico extends JModelAdmin
{
	/**
	 * @var      string    The prefix to use with controller messages.
	 * @since    1.6
	 */
	protected $text_prefix = 'COM_INFORMEHIDROLOGICO';

	/**
	 * @var   	string  	Alias to manage history control
	 * @since   3.2
	 */
	public $typeAlias = 'com_informehidrologico.informehidrologico';

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
	public function getTable($type = 'Informehidrologico', $prefix = 'InformehidrologicoTable', $config = array())
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
                    'com_informehidrologico.informehidrologico', 'informehidrologico',
                    array('control' => 'jform',
                            'load_data' => $loadData
                    )
            );

            
			if($form->getFieldAttribute('publicacao', 'default') == 'NOW'){
				$form->setFieldAttribute('publicacao', 'default', date('Y-m-d H:i:s'));
			}

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
		$data = JFactory::getApplication()->getUserState('com_informehidrologico.edit.informehidrologico.data', array());

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

			$data->tipo = $array;
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
	 * Method to duplicate an Informehidrologico
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
		if (!$user->authorise('core.create', 'com_informehidrologico'))
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
				
				if (!empty($table->arquivo))
				{
					if (is_array($table->arquivo))
					{
						$table->arquivo = implode(',', $table->arquivo);
					}
				}
				else
				{
					$table->arquivo = '';
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
				$db->setQuery('SELECT MAX(ordering) FROM #__informehidrologico');
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

	protected function getInteressados($id_categoria){
		
		$interessados = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		//Consultando todos que querem receber INFORMES HIDROLOGICOS
		$query->select($this->getState('list.select', 'DISTINCT a.*'));
		$query->from('#__cadastrointeressado AS a');
		$query->where('a.boletim not like \'%hidrologia_informes":""%\' AND a.situacao = \'1\' ');
         
		$db->setQuery($query);
		
		$interessados = $db->loadObjectList();

		$returnInteressados = array();

		foreach($interessados as $interessado){
			$boletim =  json_decode($interessado->boletim);
			if(in_array($id_categoria,$boletim->hidrologia_informes)){
				$returnInteressados[] = $interessado;	
			}
		}	
		
		return $returnInteressados;
	}

	public function enviarEmail($pks)
	{

		$return = array();

		$db = JFactory::getDbo();
		$id    = $db->escape($pks[0]);

		$informe = $this->getInformeBy("a.id =".$id);

		$interessados = $this->getInteressados($informe->id_categoria);

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
						$item_email->tipo_item		= "INFORME HIDROLOGICO";
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

	protected function getInformeBy($where){

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		//clean sql injection
		$id    = $db->escape($pks[0]);

		$query->select($this->getState('list.select', 'DISTINCT a.*'));
		$query->from('#__informehidrologico AS a');
		// Join over the users for the checked out user
		$query->select("uc.name AS uEditor");
		$query->join("LEFT", "#__users AS uc ON uc.id=a.checked_out");
		// Join over the user field 'created_by'
		$query->select('created_by.name AS created_by');
		$query->join('LEFT', '#__users AS created_by ON created_by.id = a.created_by');
		$query->select('c.title AS tipo_categoria');
		$query->select('c.id AS id_categoria');
		$query->join('LEFT', '#__categories AS c ON a.tipo::integer = c.id');
		$query->select(' le.enviado AS "enviado"')
			->join('LEFT', $db->quoteName('lista_emails', 'le') . ' ON a.id = le.id_item');
		// Join over the user field 'modified_by'
		$query->select('modified_by.name AS modified_by');
		$query->join('LEFT', '#__users AS modified_by ON modified_by.id = a.modified_by');
		$query->where($where);

		$query->group($db->quoteName('a.id'));
		$query->group($db->quoteName('le.enviado'));
		$query->group($db->quoteName('c.id'));
		$query->group($db->quoteName('c.title'));
		$query->group($db->quoteName('uc.name'));
		$query->group($db->quoteName('created_by.name'));
		$query->group($db->quoteName('modified_by.name'));

		$db->setQuery($query);

		return $db->loadObjectList()[0];
	}

	protected function layoutEmail($pks, $pdf = null)
	{	

		$html = "";

		if(empty($pks)) return $html;

		$db = JFactory::getDbo();
		$id    = $db->escape($pks[0]);

		$informe = $this->getInformeBy("a.id =".$id);
		
		if(!empty($informe)){
		
			// $informe = $db->loadObjectList()[0];

			$urlSite = str_replace("administrator/", "", JURI::base());

			$titulo = $informe->tipo_categoria . " - " . $informe->titulo;

			$urlArquivo = $urlSite . "uploads/" . $informe->arquivo;
			$tituloArquivo = $informe->arquivo;
			$linkArquivo = '<a href="'.$urlArquivo.'">'.$tituloArquivo.'</a>';

			$urlDescadastrar = $urlSite . "component/interessadonosite/?id=!#ID_INTERESSADO#!";
			
			$linkDescadastrar = '<a href="'. $urlDescadastrar .'">Caso não queira mais receber esse e-mail, clique aqui para descadastrar-se</a>';

			$urlLogo = $this->getLogo();

			$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head></head><body><style></style><table class="tg" style="border:none;border-collapse:collapse;border-color:#9ABAD9;border-spacing:0;table-layout:fixed;width:694px"><tbody><tr><th class="tg-xldj" style="background-color:#E7BB03;border-color:inherit;border-style:solid;border-width:0;color:#fff;font-family:Arial,sans-serif;font-size:14px;font-weight:400;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"><span style="font-weight:700">!#TITULO#!</span></th></tr><tr><td class="tg-xldj" style="background-color:white;border-color:inherit;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"><span style="font-weight:700">Arquivo: </span>!#ANEXO#!</td></tr><tr><td class="tg-xldj" style="background-color:white;border-color:inherit;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"><img src="!#LOGO#!"></td></tr><tr><td class="tg-xldj" style="background-color:white;border-color:inherit;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"></td></tr><tr><td class="tg-c3ow" style="background-color:white;border-color:inherit;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:center;vertical-align:top;word-break:normal">!#DESCADASTRAR#!</td></tr></tbody></table></body></html>';
		
			$anexos = "";

			$html = str_replace("!#LOGO#!",$urlLogo,$html);
			$html = str_replace("!#TITULO#!",$titulo,$html);
			$html = str_replace("!#ANEXO#!",$linkArquivo,$html);
			$html = str_replace("!#DESCADASTRAR#!",$linkDescadastrar,$html);
			
		}

		return $html;
	}
}
