<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class PrevisaodotempoViewvalores extends JViewLegacy
{

	protected $form      = null;
	protected $variavel  = null;
	protected $valor     = null;
	protected $f         = null;
	protected $valores   = [];
	protected $variaveis = [];

	function display($tpl = null)
	{
		// Get data from the model
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

		$requests = JFactory::getApplication()->input;
		$this->variavel = $requests->get('variavel', '', 'int');
		$this->valor    = $requests->get('valor', '', 'string');
		$this->f        = $requests->get('f', '', 'string');

		self::cahngeSetor($this->f, $this->variavel, $this->valor);
		$this->variaveis = self::getVariaveis();
		
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('a.id, a.valor');
		$query->from('#__previsaodotempo_variavel_valor as a');

		// Join over the user field 'id_variavel'
		$query->select('v.nome AS variavel');
		$query->join('LEFT', '#__previsaodotempo_variavel AS v ON v.id = a.id_variavel');

		$db->setQuery($query);

		$this->valores = $db->loadObjectList();

		PrevisaodotempoHelper::addSubmenu('valores');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode('<br />', $errors));
			return false;
		}

 		$this->addToolBar();

		// Display the template
		parent::display($tpl);

		// Set the document
		$this->setDocument();
	}

	protected function manipulaData($str)
	{
		if(empty($str)) return '';
			$pieces = explode("/", $str);
		return $pieces[2].'-'.$pieces[1].'-'.$pieces[0].' 00:00';
	}

	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;

		$input->set('hidemainmenu', true);

 		JToolBarHelper::title('Previsão do tempo - Variaveis - Valores', 'list-2');
		JToolbarHelper::back('Voltar', 'index.php?option=com_previsaodotempo&view=variaveis');

	}

	public static function getVariaveis(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*')
			->from('#__previsaodotempo_variavel as a')
			->where($db->quoteName('state') . ' = 1');
		$db->setQuery($query);

		return $db->loadObjectList();
	}

	public static function cahngeSetor($f, $v_id, $data){
		if($f === 'add'){
			try {
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->insert($db->quoteName('#__previsaodotempo_variavel_valor'));
				$query->columns(array('id_variavel', 'valor', 'checked_out', 'checked_out_time', 'created_by'));
				$query->values(implode(',', array($v_id,  $db->quote($data), $db->quote(JFactory::getUser()->id), $db->quote('NOW()'), $db->quote(JFactory::getUser()->id) )));
				
				$db->setQuery($query);
				$result = $db->execute();
				echo "<script>";
				echo 	"window.location.href = 'index.php?option=com_previsaodotempo&view=valores";
				echo "</script>";
			} catch (Exception $e) {
				echo 'Exceção capturada: ',  $e->getMessage(), "\n";
				// echo new JResponseJson($resultado, $e->getMessage(),true);
			}
		}else{
			try {
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);

				// delete all custom keys for user 1001.
				$conditions = array(
					$db->quoteName('id') . ' = ' . (int) $data
				);

				$query->delete($db->quoteName('#__previsaodotempo_variavel_valor'));
				$query->where($conditions);
				
				$db->setQuery($query);

				$result = $db->execute();
				echo "<script>";
				echo 	"window.location.href = 'index.php?option=com_previsaodotempo&view=valores";
				echo "</script>";
			} catch (Exception $e) {
				echo 'Exceção capturada: ',  $e->getMessage(), "\n";
				// echo new JResponseJson($resultado, $e->getMessage(),true);
			}
		}
	}

	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Previsão do tempo - Variaveis - Valores'));
	}


}