<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class contatoViewrelatorio extends JViewLegacy
{

	protected $form = null;
	protected $statusname = [];
	protected $inicio = null;
	protected $fim = null;
	protected $init = null;
	protected $end = null;
	protected $status = null;
	protected $setores = [];
	protected $setor = 0;
	protected $tipo = 1; 

	function display($tpl = null)
	{
		// Get data from the model
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

		$requests = JFactory::getApplication()->input;
		$this->inicio   = $requests->get('inicio', '', 'string');
		$this->fim      = $requests->get('fim', '', 'string');
		$this->status   = $requests->get('status', '0', 'string');
		$this->setor    = $requests->get('setor', '', 'string');
		$this->tipo     = $requests->get('tipo', '0', 'string');
		$this->init     = $_GET['inicio'];
		$this->end     = $_GET['fim'];
		$this->setores  = $this->getSetores();

		$fim_date   = new DateTime($this->manipulaData($this->fim, 1));
		$ini_date   = new DateTime($this->manipulaData($this->inicio));
		$agora_date = new DateTime();
		$agora_date = $agora_date->format('Y-m-d H:i:s');

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		if($this->tipo == '1'){
			$query->select('count(id) as quantidade,status');
		}else{
			$query->select('count(setor) as quantidade,setor');
		}
		$query->from($db->quoteName('#__contato'));


		if($this->inicio == '' && $this->fim == ''){
			$this->inicio = $agora_date;
			$query->where("created < '".$this->inicio."'");
		} else if( (strtotime($agora_date) < strtotime($fim_date)) || (strtotime($fim_date) < strtotime($ini_date)) ) {
			// data fora do range
			$this->fim = $agora_date->format('Y-m-d H:i:s');
			$this->inicio = $this->manipulaData($this->inicio);
			$query->where("created between  '". $this->inicio ."' and '" . $this->fim ."'");
		} else if($this->inicio != '' && $this->fim == '') {
			$this->fim    = $agora_date;
			$this->inicio = $this->manipulaData($this->inicio);
			$query->where("created between  '". $this->inicio ."' and '" . $this->fim ."'");
		}else if($this->inicio == '' && $this->fim != '') {
			$this->fim    = $this->manipulaData($this->fim, 1);
			$query->where("created < '".$this->fim."'");
		}else if($this->inicio != '' && $this->fim != '') {
			$this->fim    = $this->manipulaData($this->fim, 1);
			$this->inicio = $this->manipulaData($this->inicio);
			$query->where("created between  '". $this->inicio ."' and '" . $this->fim ."'");
		}

		if(isset($this->status) && $this->tipo == '1' && $this->status != 0){
			$query->where("status = ". (int) $this->status);
		}

		if( $this->setor != '0' && $this->tipo == '2') {
			$query->where("setor LIKE '". $this->setor ."%'");
		}

		if($this->tipo == '1'){
			$query->group('status');
		}else{
			$query->group('setor');
		}
		
		$db->setQuery($query);

		$this->item = $db->loadObjectList();

		$this->statusname = array(
			1    => "Recebida",
			2    => "Encaminhada para setor responsável",
			3    => "Respondida ao cidadão",
			4    => "Respondida - solicitação não faz parte das atribuições da Apac",
			5    => "Solicitação não respondida",
			6    => "Spam"
		);

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

	protected function manipulaData($str, $dias = 0)
	{
		if(empty($str)) return '';
		$pieces = explode("/", $str);
		$dia    = (int)$pieces[0];
		$mes    = (int)$pieces[1];
		$ano    = $pieces[2];
		$ultimo_dia = (int)date("t", mktime(0,0,0,$pieces[1],'01',$pieces[2]));
		if($ultimo_dia >= (int)($dia+$dias) ){
			$dia = (int)$dia+$dias;
		}else if($mes+1 <= 12){
			$mes = $mes + 1;
			$dia = 1;
		}else{
			$ano +=1;
		}
		$data = $ano.'-'.$mes.'-'.$dia.' 00:00';
		return $data;
	}

	protected function getSetores(){
		$db = JFactory::getDbo();
		$query = $db->getQuery(true);
		$query->select('id, nome');
		$query->from($db->quoteName('#__contato_setor'));

		$db->setQuery($query);

		$setores = $db->loadObjectList();

		return $setores;
	}

	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;

		$input->set('hidemainmenu', true);

 		JToolBarHelper::title('Fale Conosco - Relatório', 'list-2');
		JToolbarHelper::back('Voltar', 'index.php?option=com_contato');

	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Fale Conosco - Relatórios'));
	}


}