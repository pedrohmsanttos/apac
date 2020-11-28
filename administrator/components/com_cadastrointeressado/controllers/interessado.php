<?php
/**
 * @version    CVS: 1.0.0
 * @package    Com_Cadastrointeressado
 * @author     Lerisson Freitas <lerisson.freitas@inhalt.com.br>
 * @copyright  2019 Lerisson Freitas
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Interessado controller class.
 *
 * @since  1.6
 */
class CadastrointeressadoControllerInteressado extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'interessados';
		parent::__construct();
	}

	public function verificacao($email)
	{
		// Get a db connection.
		$db = JFactory::getDbo();

		// Create a new query object.
		$query = $db->getQuery(true);

		// Select all records from the user mesorregiao table where state or null.
		// Order it by the ordering field.
		$query->select('id');
		$query->from($db->quoteName('#__cadastrointeressado'));
		$query->where('email = ' . $db->q($email));
    	
		
		
		
		//var_dump($query);die;
		// Reset the query using our newly populated query object.
		$db->setQuery($query);
		
		// Load the results as a list of stdClass objects (see later for more options on retrieving data).
		$results = $db->loadObjectList();

		
		return empty($results);
	}

	

	/**
	 * Method to save a record.
	 *
	 * @param   string  $key     The name of the primary key of the URL variable.
	 * @param   string  $urlVar  The name of the URL variable if different from the primary key (sometimes required to avoid router collisions).
	 *
	 * @return  boolean  True if successful, false otherwise.
	 *
	 * @since   1.6
	 */
	public function save($key = null, $urlVar = null)
	{
		// Check for request forgeries.
		$this->checkToken();
		$app = \JFactory::getApplication();
		$model = $this->getModel();
		$table = $model->getTable();
		$data = $this->input->post->get('jform', array(), 'array');
		$avisom = $this->input->post->get('avisom', '', 'ARRAY');
		$informem = $this->input->post->get('informem', '', 'ARRAY');
		$avisoh = $this->input->post->get('avisoh', '', 'ARRAY');
		$informeh = $this->input->post->get('informeh', '', 'ARRAY');
		$checkin = property_exists($table, $table->getColumnAlias('checked_out'));
		$context = "$this->option.edit.$this->context";
		$task = $this->getTask();
		$data['boletim'] = json_encode(
			array(
				'meteorologia_avisos' => $avisom,
				'meteorologia_informes' => $informem,
				'hidrologia_avisos' => $avisoh,
				'hidrologia_informes' => $informeh
			)
		);
		//var_dump($data);die;

		

		// Determine the name of the primary key for the data.
		if (empty($key)) {
			$key = $table->getKeyName();
		}
		// To avoid data collisions the urlVar may be different from the primary key.
		if (empty($urlVar)) {
			$urlVar = $key;
		}
		$recordId = $this->input->getInt($urlVar);
		// Populate the row id from the session.
		$data[$key] = $recordId;


		try{
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			if(empty($data['id']) || $data['id'] == 0){
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
							'created_by',
							'modified_by',
							'noticias',
							'licitacoes',
							'confidencial',
							'data_criacao',
							'previsao_tempo',
							);
				$values = array($db->quote($data['nome']),
								$db->quote($data['email']),
								$db->quote($data['observacao']),
								$db->quote($data['situacao']),
								$db->quote($data['pertencegoverno']),
								$db->quote($data['boletim']),
								$db->quote($data['situacao']),
								0,
								0,
								'NOW()',
								JFactory::getUser()->get('id'),
								JFactory::getUser()->get('id'),
								$db->quote($data['noticias']),
								$db->quote($data['licitacoes']),
								$db->quote($data['confidencial']),
								'NOW()',
								$db->quote($data['previsao_tempo']),
								);
				$query->insert($db->quoteName('#__cadastrointeressado'))
						->columns($db->quoteName($columns))
						->values(implode(',', $values));
				$db->setQuery($query);
				$db->query();
				$resultID = $db->insertid();
			}else{
				$campos = array($db->quoteName('state') . ' = ' . $db->quote($data['situacao']),
							$db->quoteName('checked_out') . ' = ' . 0,
							$db->quoteName('modified_by') . ' = ' . JFactory::getUser()->get('id'),
							$db->quoteName('nome') . ' = ' . 			$db->quote($data['nome']),
							$db->quoteName('email') . ' = ' . 			$db->quote($data['email']),
							$db->quoteName('observacao') . ' = ' . 		$db->quote($data['observacao']),
							$db->quoteName('situacao') . ' = ' .  		$db->quote($data['situacao']),
							$db->quoteName('pertencegoverno') . ' = ' . $db->quote($data['pertencegoverno']),
							$db->quoteName('boletim') . ' = ' .     	$db->quote($data['boletim']),
							$db->quoteName('noticias') . ' = ' .     	$db->quote($data['noticias']),
							$db->quoteName('licitacoes') . ' = ' . 		$db->quote($data['licitacoes']),
							$db->quoteName('confidencial') . ' = ' . 		$db->quote($data['confidencial']),
							$db->quoteName('data_criacao') . ' = ' . 		$db->quote($data['data_criacao']),
							$db->quoteName('previsao_tempo') . ' = ' . 		$db->quote($data['previsao_tempo']),		
							
						);
				
				$conditions = array(
								$db->quoteName('id') . ' = '. $data['id']
							);
				$query->update($db->quoteName('#__cadastrointeressado'))
						->set($campos)
						->where($conditions);
				
				$db->setQuery($query);

				$result = $db->execute();
			}
			$this->setMessage('Interessado salvo!');
		}catch(Exception $e){
			$this->setMessage('Interessado não salvo!', 'error');
			var_dump($e);
		}
		$id = $resultID;
		if(empty($resultID)){
			$id = $data['id'];
		}

		// Redirect the user and adjust session state based on the chosen task.
	switch ($task) {
		case 'apply':
			// Set the record data in the session.
			$recordId = $model->getState($this->context . '.id');
			$this->holdEditId($context, $recordId);
			$app->setUserState($context . '.data', null);
			//$model->checkout($recordId);
			// Redirect back to the edit screen.
			$this->setRedirect(
				\JRoute::_(
					'index.php?option=com_cadastrointeressado&view=interessado&layout=edit&id='.$id,
					false
				)
			);
			break;
		default:
			// Clear the record id and data from the session.
			$this->releaseEditId($context, $recordId);
			$app->setUserState($context . '.data', null);
			$url = 'index.php?option=com_cadastrointeressado&view=interessados';
			// Check if there is a return value
			$return = $this->input->get('return', null, 'base64');
			if (!is_null($return) && \JUri::isInternal(base64_decode($return))) {
				$url = base64_decode($return);
			}
			// Redirect to the list screen.
			$this->setRedirect(\JRoute::_($url, false));
			break;
		}
		// Invoke the postSave method to allow for the child class to access the model.
		$this->postSaveHook($model, $validData);
		return true;
	}

}
