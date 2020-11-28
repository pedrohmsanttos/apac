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
class LicitacoesControllerArquivo extends JControllerForm
{



	/**
	 * Constructor
	 *
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->view_list = 'arquivo';
		parent::__construct();
	}

	public function save($data = array(), $key = 'id')
	{

		$arquivo = $_FILES['jform'];
		$jinput = JFactory::getApplication()->input;
		$arquivoCrllr = new LicitacoesControllerArquivo();
		$data = $jinput->get('jform', null, 'raw');
		
		if(isset($data['arquivo_hidden'])){
			$data['arquivo'] = $data['arquivo_hidden'];
		}else{
			$data['arquivo'] = $arquivo['name']['arquivo'];
		}

		if( !empty( trim( $arquivo['name']['arquivo'] ) ) ){
			$licitacao = self::getLicitacaoById($data['id_licitacao']);
			$arquivoSalvo = self::makeUpload($arquivo, $licitacao);
			$data['arquivo'] = $arquivoSalvo;
		}

		$urlRedirect = 'index.php?option=com_licitacoes&view=arquivos';
		
		$app   = \JFactory::getApplication();
		$model = $this->getModel();
		$table = $model->getTable();
		
		 
		$checkin = property_exists($table, $table->getColumnAlias('checked_out'));
		$context = "$this->option.edit.$this->context";
		$task = $this->getTask();

		// Determine the name of the primary key for the data.
		if (empty($key))
		{
			$key = $table->getKeyName();
		}

		// To avoid data collisions the urlVar may be different from the primary key.
		if (empty($urlVar))
		{
			$urlVar = $key;
		}

		$recordId = $this->input->getInt($urlVar);

		// Populate the row id from the session.
		$data[$key] = $recordId;

		// The save2copy task needs to be handled slightly differently.
		if ($task === 'save2copy')
		{
			// Check-in the original row.
			if ($checkin && $model->checkin($data[$key]) === false)
			{
				// Check-in failed. Go back to the item and display a notice.
				$this->setError(\JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
				$this->setMessage($this->getError(), 'error');

				
				$this->setRedirect(
					// \JRoute::_(
					// 	'index.php?option=' . $this->option . '&view=' . $this->view_item
					// 	. $this->getRedirectToItemAppend($recordId, $urlVar), false
					// )
					\JRoute::_(
						$urlRedirect
					)
				);

				return false;
			}

			// Reset the ID, the multilingual associations and then treat the request as for Apply.
			$data[$key] = 0;
			$data['associations'] = array();
			$task = 'apply';
		}

		if (!$this->allowSave($data, $key))
		{
			$this->setError(\JText::_('JLIB_APPLICATION_ERROR_SAVE_NOT_PERMITTED'));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				// \JRoute::_(
				// 	'index.php?option=' . $this->option . '&view=' . $this->view_list
				// 	. $this->getRedirectToListAppend(), false
				// )
				\JRoute::_(
					$urlRedirect
				)
			);

			return false;
		}

		// Validate the posted data.
		// Sometimes the form needs some posted data, such as for plugins and modules.
		$form = $model->getForm($data, false);

		if (!$form)
		{
			$app->enqueueMessage($model->getError(), 'error');

			return false;
		}

		// Send an object which can be modified through the plugin event
		$objData = (object) $data;
		$app->triggerEvent(
			'onContentNormaliseRequestData',
			array($this->option . '.' . $this->context, $objData, $form)
		);
		$data = (array) $objData;

		// Test whether the data is valid.
		$validData = $model->validate($form, $data);

		// Check for validation errors.
		if ($validData === false)
		{
			// Get the validation messages.
			$errors = $model->getErrors();

			// Push up to three validation messages out to the user.
			for ($i = 0, $n = count($errors); $i < $n && $i < 3; $i++)
			{
				if ($errors[$i] instanceof \Exception)
				{
					$app->enqueueMessage($errors[$i]->getMessage(), 'warning');
				}
				else
				{
					$app->enqueueMessage($errors[$i], 'warning');
				}
			}

			// Save the data in the session.
			$app->setUserState($context . '.data', $data);

			
			// Redirect back to the edit screen.
			$this->setRedirect(
				// \JRoute::_(
				// 	'index.php?option=' . $this->option . '&view=' . $this->view_item
				// 	. $this->getRedirectToItemAppend($recordId, $urlVar), false
				// )
				\JRoute::_(
					$urlRedirect
				)
			);

			return false;
		}

		if (!isset($validData['tags']))
		{
			$validData['tags'] = null;
		}

		// Attempt to save the data.
		if (!$model->save($validData))
		{
			
			// Save the data in the session.
			$app->setUserState($context . '.data', $validData);

			// Redirect back to the edit screen.
			$this->setError(\JText::sprintf('JLIB_APPLICATION_ERROR_SAVE_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				// \JRoute::_(
				// 	'index.php?option=' . $this->option . '&view=' . $this->view_item
				// 	. $this->getRedirectToItemAppend($recordId, $urlVar), false
				// )
				\JRoute::_(
					$urlRedirect
				)
			);

			return false;
		}

		// Save succeeded, so check-in the record.
		if ($checkin && $model->checkin($validData[$key]) === false)
		{
			
			// Save the data in the session.
			$app->setUserState($context . '.data', $validData);

			// Check-in failed, so go back to the record and display a notice.
			$this->setError(\JText::sprintf('JLIB_APPLICATION_ERROR_CHECKIN_FAILED', $model->getError()));
			$this->setMessage($this->getError(), 'error');

			$this->setRedirect(
				// \JRoute::_(
				// 	'index.php?option=' . $this->option . '&view=' . $this->view_item
				// 	. $this->getRedirectToItemAppend($recordId, $urlVar), false
				// )
				\JRoute::_(
					$urlRedirect
				)
			);

			return false;
		}

		$langKey = $this->text_prefix . ($recordId === 0 && $app->isClient('site') ? '_SUBMIT' : '') . '_SAVE_SUCCESS';
		$prefix  = \JFactory::getLanguage()->hasKey($langKey) ? $this->text_prefix : 'JLIB_APPLICATION';

		$this->setMessage(\JText::_($prefix . ($recordId === 0 && $app->isClient('site') ? '_SUBMIT' : '') . '_SAVE_SUCCESS'));

		// Redirect the user and adjust session state based on the chosen task.
		switch ($task)
		{
			case 'apply':
				// Set the record data in the session.
				$recordId = $model->getState($this->context . '.id');
				$this->holdEditId($context, $recordId);
				$app->setUserState($context . '.data', null);
				$model->checkout($recordId);

				
				// Redirect back to the edit screen.
				$this->setRedirect(
					// \JRoute::_(
					// 	'index.php?option=' . $this->option . '&view=' . $this->view_item
					// 	. $this->getRedirectToItemAppend($recordId, $urlVar), false
					// )
					\JRoute::_(
						$urlRedirect
					)
				);
				break;

			case 'save2new':
				// Clear the record id and data from the session.
				$this->releaseEditId($context, $recordId);
				$app->setUserState($context . '.data', null);


				
				// Redirect back to the edit screen.
				$this->setRedirect(
					// \JRoute::_(
					// 	'index.php?option=' . $this->option . '&view=' . $this->view_item
					// 	. $this->getRedirectToItemAppend(null, $urlVar), false
					// )
					\JRoute::_(
						$urlRedirect
					)
				);
				break;

			default:
				// Clear the record id and data from the session.
				$this->releaseEditId($context, $recordId);
				$app->setUserState($context . '.data', null);

				
				// $url = 'index.php?option=' . $this->option . '&view=' . $this->view_list
				// 	. $this->getRedirectToListAppend();
				
				$url = $urlRedirect;

				// Check if there is a return value
				$return = $this->input->get('return', null, 'base64');

				if (!is_null($return) && \JUri::isInternal(base64_decode($return)))
				{
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

	// public function makeUpload($fieldName = 'Filedata')
	public function makeUpload($arquivo, $licitacao)
	{

		jimport('joomla.filesystem.file');
		jimport('joomla.filesystem.folder');

		// $fileError = $_FILES[$fieldName]['error'];
		$fileError = $arquivo['error']['arquivo'];

		if ($fileError > 0) 
		{
			switch ($fileError) 
			{
				case 1:
				echo JText::_( 'FILE TO LARGE THAN PHP INI ALLOWS' );die;
				return;

				case 2:
				echo JText::_( 'FILE TO LARGE THAN HTML FORM ALLOWS' );die;
				return;

				case 3:
				echo JText::_( 'ERROR PARTIAL UPLOAD' );die;
				return;

				case 4:
				echo JText::_( 'ERROR NO FILE' );die;
				return;
			}
		}


		$tamanhoMax = self::return_bytes(ini_get('upload_max_filesize'));

		// $fileSize = $_FILES[$fieldName]['size'];
		$fileSize = $arquivo['size']['arquivo'];

		// echo $fileSize;die;	
		if($fileSize > $tamanhoMax)
		{	
			$mensagem = 'FILE BIGGER THAN '. ini_get('upload_max_filesize');
			echo JText::_( $mensagem  );
		}
		
		function sanitizeString($str) {
			$str = preg_replace('/[áàãâä]/ui', 'a', $str);
			$str = preg_replace('/[éèêë]/ui', 'e', $str);
			$str = preg_replace('/[íìîï]/ui', 'i', $str);
			$str = preg_replace('/[óòõôö]/ui', 'o', $str);
			$str = preg_replace('/[úùûü]/ui', 'u', $str);
			$str = preg_replace('/[ç]/ui', 'c', $str);
			// $str = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $str);
			$str = preg_replace('/[^a-z0-9]/i', '_', $str);
			$str = preg_replace('/_+/', '_', $str); // ideia do Bacco :)
			return $str;
		}

		$fileName = $arquivo['name']['arquivo'];
		
		$uploadedFileNameParts = explode('.',$fileName);
		$teste  = sanitizeString($uploadedFileNameParts[0]);
		$teste = substr($teste,0,-1);
		$teste = strtolower($teste);
		
		$uploadedFileExtension = array_pop($uploadedFileNameParts);
		$teste = $teste . ".".$uploadedFileExtension;
		$fileName = $teste;
		
		// $validFileExts = explode(',', 'jpeg,jpg,png,gif');
		$validFileExts = explode(',', 'doc,docx,pdf');

		$extOk = false;

		foreach($validFileExts as $key => $value)
		{
			if( preg_match("/$value/i", $uploadedFileExtension ) )
			{
				$extOk = true;
			}
		}

		if ($extOk == false) 
		{
			echo JText::_( 'INVALID EXTENSION' );die;
				return;
		}
		
		$fileTemp = $arquivo['tmp_name']['arquivo'];

				
		// $imageinfo = getimagesize($fileTemp);
				
		// $okMIMETypes = 'image/jpeg,image/pjpeg,image/png,image/x-png,image/gif';
		// $validFileTypes = explode(",", $okMIMETypes);		

		
		// if( !is_int($imageinfo[0]) || !is_int($imageinfo[1]) ||  !in_array($imageinfo['mime'], $validFileTypes) )
		// {
		// 	echo JText::_( 'INVALID FILETYPE' );
		// 		return;
		// }

		
		// $fileName = preg_replace("/[^A-Za-z0-9]/i", "-", $fileName);
		
		$nomePastaLicitacao = $licitacao->numero_processo . "-" . $licitacao->ano_processo;
		
		$dir = JPATH_SITE.DIRECTORY_SEPARATOR.'uploads'.DIRECTORY_SEPARATOR.'editais';
		$novoDir = $dir . DIRECTORY_SEPARATOR . $nomePastaLicitacao;

		if (!file_exists($novoDir)) {
		    mkdir($novoDir, 0777, true);
		}

		$uploadPath = $novoDir .DIRECTORY_SEPARATOR. $fileName;

		$dirSalvo = str_replace(JPATH_SITE, "", $uploadPath);
		
		$uploadPath = utf8_decode($uploadPath);

		 // echo($uploadPath);die;

		if(!JFile::upload($fileTemp, $uploadPath)) 
		{
			echo JText::_( 'ERROR MOVING FILE' );die;
				return;
		}
		else
		{
			return $dirSalvo;
			// exit(0);
		}
	}

	public function return_bytes($val)
	{
	    $val  = trim($val);

	    if (is_numeric($val))
	        return $val;

	    $last = strtolower($val[strlen($val)-1]);
	    $val  = substr($val, 0, -1); // necessary since PHP 7.1; otherwise optional

	    switch($last) {
	        // The 'G' modifier is available since PHP 5.1.0
	        case 'g':
	            $val *= 1024;
	        case 'm':
	            $val *= 1024;
	        case 'k':
	            $val *= 1024;
	    }

	    return $val;
	}

	public function getLicitacaoById($id)
	{

		$db = JFactory::getDbo(); 
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__licitacoes'));
		$query->where("id = " . $id . "");
		$query->where('state = 1');
		$query->setLimit('1');

		$db->setQuery($query);
		$rows = $db->loadObjectList();

		return $rows[0];

	}

}
