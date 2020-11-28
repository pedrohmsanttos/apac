<?php

/**
 * @version    CVS: 1.0.0
 * @package    Com_Previsaodotempo
 * @author     Matheus Felipe <matheus.felipe@inhalt.com.br>
 * @copyright  2018 Inhalt
 * @license    GNU General Public License versão 2 ou posterior; consulte o arquivo License. txt
 */

// No direct access
defined('_JEXEC') or die;

jimport('joomla.application.component.controllerform');

/**
 * Previsao controller class.
 *
 * @since  1.6
 */
class PrevisaodotempoControllerPrevisao extends JControllerForm
{
	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'previsoes';
		parent::__construct();
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
		$checkin = property_exists($table, $table->getColumnAlias('checked_out'));
		$context = "$this->option.edit.$this->context";
		$task = $this->getTask();
		
		$currentDtaValida  = explode(' ', $data['datavlida']);
		$data['datavlida'] = DateTime::createFromFormat('d/m/Y', $currentDtaValida[0])->format('Y-m-d');
		$data['horario']   = $currentDtaValida[1];
		$icones = $this->input->post->get('icones', '', 'ARRAY');
		
		if(is_array($icones)){
			$icones = explode(',', $icones[0]);
		}

		$data['mesorregioes'] = json_encode(
			array(
				'IntensidadeDoVento' => $this->input->post->get('IntensidadeDoVento', '', 'ARRAY'),
				'mesorregiao' => $this->input->post->get('mesorregioes', '', 'ARRAY'),
				'RotaDoVento' => $this->input->post->get('RotaDoVento', '', 'ARRAY'),
				'nebulosidade' => $this->input->post->get('nebulosidade', '', 'ARRAY'),
				'TiposDeChuva' => $this->input->post->get('TiposDeChuva', '', 'ARRAY'),
				'DistribuicaoDaChuva' => $this->input->post->get('DistribuicaoDaChuva', '', 'ARRAY'),
				'PeriodoDaChuva' => $this->input->post->get('PeriodoDaChuva', '', 'ARRAY'),
				'IntensidadeDaChuva' => $this->input->post->get('IntensidadeDaChuva', '', 'ARRAY'),
				'icone' => $icones,
				'temMin' => $this->input->post->get('temMin', '', 'ARRAY'),
				'temMax' => $this->input->post->get('temMax', '', 'ARRAY'),
				'umiMin' => $this->input->post->get('umiMin', '', 'ARRAY'),
				'umiMax' => $this->input->post->get('umiMax', '', 'ARRAY')
			)
		);

		$data['valores'] = json_encode(explode(',', $this->input->post->get('valores', '', 'RAW')));

		if ($task != 'save2copy') {
			$valida = self::getPrevisaoDia($data['tipo'], $data['datavlida'], $data['id']);
			if (count($valida) > 0) {
				$url = JRoute::_('index.php?option=com_previsaodotempo&view=previsao&layout=edit');
				JError::raiseError(500, 'Previsão já cadastrada!');
				JFactory::getApplication()->redirect($url);
			}
		} 

		$array['checked_update_time'] = 'NOW()';

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
		// The save2copy task needs to be handled slightly differently.
		if ($task === 'save2copy') {
			$data['datavlida'] = '01-01-1970';
			$data['checked_update_time'] = 'NOW()';
			$data['checked_out_time'] = 'NOW()';
			$data[$key] = 0;
			$data['associations'] = array();
			$data['state'] = 0;
			$task = 'apply';
		}
		// Access check.
		if (!$this->allowSave($data, $key)) {
			$this->setError(\JText::_('JLIB_APPLICATION_ERROR_SAVE_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(
				\JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_list
						. $this->getRedirectToListAppend(),
					false
				)
			);
			return false;
		}
		// Validate the posted data.
		// Sometimes the form needs some posted data, such as for plugins and modules.
		$form = $model->getForm($data, false);
		if (!$form) {
			$app->enqueueMessage($model->getError(), 'error');
			return false;
		}
		// Send an object which can be modified through the plugin event
		$objData = (object)$data;
		$app->triggerEvent(
			'onContentNormaliseRequestData',
			array($this->option . '.' . $this->context, $objData, $form)
		);
		$data = (array)$objData;
		// Test whether the data is valid.
		$validData = $model->validate($form, $data);
		// Check for validation errors.
		if ($validData === false) {
			// Get the validation messages.
			$errors = $model->getErrors();
			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++) {
				if ($errors[$i] instanceof \Exception) {
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				} else {
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}
			// Save the data in the session.
			$app->setUserState($context . '.data', $data);
			// Redirect back to the edit screen.
			$this->setRedirect(
				\JRoute::_(
					'index.php?option=' . $this->option . '&view=' . $this->view_item
						. $this->getRedirectToItemAppend($recordId, $urlVar),
					false
				)
			);
			return false;
		}
		if (!isset($validData['tags'])) {
			$validData['tags'] = null;
		}

		if ($task == 'save2copy' && $data['id'] == 0) {
			$data['state'] = 0;
			$data['checked_update_time'] = 'NOW()';
		}
		// // Attempt to save the data.
		// if (!$model->save($data)) {
		// 	// Save the data in the session.
		// 	$app->setUserState($context . '.data', $validData);
		// 	// Redirect back to the edit screen.
		// 	$this->setError(\JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
		// 	$this->setMessage($this->getError(), 'error');
		// 	$this->setRedirect(
		// 		\JRoute::_(
		// 			'index.php?option=' . $this->option . '&view=' . $this->view_item
		// 				. $this->getRedirectToItemAppend($recordId, $urlVar),
		// 			false
		// 		)
		// 	);
		// 	return false;
		// }
		// // Save succeeded, so check-in the record.
		// if ($checkin && $model->checkin($validData[$key]) === false) {
		// 	// Save the data in the session.
		// 	$app->setUserState($context . '.data', $validData);
		// 	// Check-in failed, so go back to the record and display a notice.
		// 	$this->setError(\JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
		// 	$this->setMessage($this->getError(), 'error');
		// 	$this->setRedirect(
		// 		\JRoute::_(
		// 			'index.php?option=' . $this->option . '&view=' . $this->view_item
		// 				. $this->getRedirectToItemAppend($recordId, $urlVar),
		// 			false
		// 		)
		// 	);
		// 	return false;
		// }
		// $langKey = $this->text_prefix . ($recordId === 0 && $app->isClient('site') ? '_SUBMIT' : '') . '_SAVE_SUCCESS';
		// $prefix = \JFactory::getLanguage()->hasKey($langKey) ? $this->text_prefix : 'JLIB_APPLICATION';
		//var_dump($data['id']);die();
		try{
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			if(empty($data['id']) || $data['id'] == 0){
				$columns = array('ordering',
							'state',
							'checked_out',
							'checked_out_time',
							'created_by',
							'modified_by',
							'datavlida',
							'tipo',
							'horario',
							'observaes',
							'valores',
							'mesorregioes',
							'checked_update_time');
				$values = array(0,
								$data['state'],
								0,
								'NOW()',
								JFactory::getUser()->get('id'),
								JFactory::getUser()->get('id'),
								$db->quote($data['datavlida']),
								$db->quote($data['tipo']),
								$db->quote($data['horario']),
								$db->quote($data['observaes']),
								$db->quote($data['valores']),
								$db->quote($data['mesorregioes']),
								'NOW()',
								);
				$query->insert($db->quoteName('#__previsaodotempo_previsao'))
						->columns($db->quoteName($columns))
						->values(implode(',', $values));
				$db->setQuery($query);
				$db->query();
				$resultID = $db->insertid();
			}else{
				$campos = array($db->quoteName('state') . ' = ' . $data['state'],
							$db->quoteName('checked_out') . ' = ' . 0,
							$db->quoteName('modified_by') . ' = ' . JFactory::getUser()->get('id'),
							$db->quoteName('datavlida') . ' = ' . $db->quote($data['datavlida']),
							$db->quoteName('tipo') . ' = ' . $db->quote($data['tipo']),
							$db->quoteName('horario') . ' = ' . $db->quote($data['horario']),
							$db->quoteName('observaes') . ' = ' . $db->quote($data['observaes']),
							$db->quoteName('valores') . ' = ' . $db->quote($data['valores']),
							$db->quoteName('mesorregioes') . ' = ' . $db->quote($data['mesorregioes']),
							$db->quoteName('checked_update_time') . ' =' . 'NOW()'
						);
				
				$conditions = array(
								$db->quoteName('id') . ' = '. $data['id']
							);
				$query->update($db->quoteName('#__previsaodotempo_previsao'))
						->set($campos)
						->where($conditions);
				
				$db->setQuery($query);

				$result = $db->execute();
			}
			$this->setMessage('Previsão salva!');
		}catch(Exception $e){
			$this->setMessage('Previsão não salva!', 'error');
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
						'index.php?option=com_previsaodotempo&view=previsao&layout=edit&id='.$id,
						false
					)
				);
				break;
			case 'save2new':
				// Clear the record id and data from the session.
				$this->releaseEditId($context, $recordId);
				$app->setUserState($context . '.data', null);
				// Redirect back to the edit screen.
				$this->setRedirect(
					\JRoute::_(
						'index.php?option=com_previsaodotempo&view=previsao&layout=edit&id='.$id,
						false
					)
				);
				break;
			default:
				// Clear the record id and data from the session.
				$this->releaseEditId($context, $recordId);
				$app->setUserState($context . '.data', null);
				$url = 'index.php?option=com_previsaodotempo&view=previsoes';
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

	public static function getPrevisaoDia($tipo, $data, $id)
	{
		// DB
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$query->select('*');
		$query->from($db->quoteName('#__previsaodotempo_previsao'));
		$query->where('tipo = ' . $db->quote($tipo));
		$query->where('state = 1');
		$query->where('datavlida = ' . $db->quote($data));
		if ($id) {
			$query->where('id <>' . $id);
		}
		$db->setQuery($query);

		$results = $db->loadObjectList();

		return $results;
	}
}
