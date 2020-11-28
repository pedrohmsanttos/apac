<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class avisohidrologicoViewregioes extends JViewLegacy
{

	protected $form = null;
	protected $data = null;
	protected $f = null;
	protected $setores = [];

	function display($tpl = null)
	{
		// Get data from the model
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

		$requests = JFactory::getApplication()->input;
		$this->f      = $requests->get('f', '', 'string');
		$this->data   = $requests->get('data', '', 'string');

		self::cahngeSetor($this->f, $this->data);

		$fim_date   = new DateTime($this->manipulaData($this->fim));
		$agora_date = new DateTime();
		$agora_date = $agora_date->format('Y-m-d H:i:s');

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('*');
		$query->from($db->quoteName('#__regioes'));

		$db->setQuery($query);

		$this->setores = $db->loadObjectList();

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

 		JToolBarHelper::title('Aviso Hidrologico - Regiões', 'list-2');
		JToolbarHelper::back('Voltar', 'index.php?option=com_avisohidrologico');

	}

	public static function cahngeSetor($f, $data){
		if($f === 'add'){
			try {
				$db = JFactory::getDbo();
				$query = $db->getQuery(true);
				$query->insert($db->quoteName('#__regioes'));
				$query->columns(array('title'));
				$query->values($db->quote($data));
			  
				$db->setQuery($query);
				$result = $db->execute();
				echo "<script>";
				echo 	"window.location.href = 'index.php?option=com_avisohidrologico&view=regioes";
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

				$query->delete($db->quoteName('#__regioes'));
				$query->where($conditions);

				$db->setQuery($query);

				$result = $db->execute();
				echo "<script>";
				echo 	"window.location.href = 'index.php?option=com_avisohidrologico&view=regioes";
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
		$document->setTitle(JText::_('Aviso Hidrologico - Regiões'));
	}


}