<?php
 // No direct access to this file
defined('_JEXEC') or die('Restricted access');

class LicitacoesViewrelatorio extends JViewLegacy
{

	protected $form = null;
	protected $statusname = [];
	protected $processo = null;
	protected $ano = null;
	protected $init = null;
	protected $end = null;
	protected $status = null;
	protected $setores = [];
	protected $tipo = null;

	function display($tpl = null)
	{
		
		// Get data from the model
		$this->form = $this->get('Form');
		$this->item = $this->get('Item');

		$requests = JFactory::getApplication()->input;
		$this->processo 	= $requests->get('processo', '', 'string');
		$this->ano      	= $requests->get('ano', '', 'string');
		$this->tipo     	= $requests->get('tipo', '', 'string');
		$this->documento    = $requests->get('documento', '', 'string');
		$this->nome     	= $requests->get('nome', '', 'string');
		$this->pessoa     	= $requests->get('pessoa', '', 'string');

		$db = JFactory::getDbo();


		if($this->tipo == "2"){

			$query = $db->getQuery(true);

			$query->select('a.documento_usuario, a.nome_razao, a.data_download, l.titulo');
			$query->from('#__relatorio_licitacao as a');

			//$query->select('a.id_licitacao AS licitacao');
			$query->join('LEFT', '#__licitacoes AS l ON l.id = a.id_licitacao');

			if(!empty($this->processo)){
				$query->where("a.numero_processo = '" . $this->processo . "'", "AND");
			}

			
			if(!empty($this->ano)){
				$query->where("a.ano_processo = '" . $this->ano . "'", "AND");
			}

			$query->order('a.id');

		}else{

			$query = $db->getQuery(true);

			$query->select('a.documento_usuario, a.nome_razao, a.tipo_users, a.telefone_users, a.id_users, u."registerDate", MAX(l.titulo) AS titulo');
			$query->from('#__relatorio_licitacao as a');
			$query->join('LEFT', '#__licitacoes AS l ON l.id = a.id_licitacao');
			$query->join('INNER', '#__users AS u ON u.id = a.id_users');
			

			if(!empty($this->processo)){
				$query->where("a.numero_processo = '" . $this->processo . "'", "AND");
			}
			if (!empty($this->documento)) {
				$query->where("a.documento_usuario = '" . $this->documento . "'", "AND");
			}
			if(!empty($this->nome)) {
				$query->where("a.nome_razao Like '%" . $this->nome . "%'", "AND");
			}
			if (!empty($this->pessoa)){
				$query->where("a.tipo_users = '". $this->pessoa . "'");
			}

			
			$query->order('a.id_users');
			$query->group('a.documento_usuario');
			$query->group('a.nome_razao');
			$query->group('a.tipo_users');
			$query->group('a.telefone_users');
			$query->group('a.id_users');
			$query->group('u."registerDate"');

		}

		$db->setQuery($query);
		
		$this->item = $db->loadObjectList();

		
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

	protected function addToolBar()
	{
		$input = JFactory::getApplication()->input;

		$input->set('hidemainmenu', true);

 		JToolBarHelper::title('Licitações - Relatório', 'list-2');
		JToolbarHelper::back('Voltar', 'index.php?option=com_licitacoes');

	}
	/**
	 * Method to set up the document properties
	 *
	 * @return void
	 */
	protected function setDocument()
	{
		$document = JFactory::getDocument();
		$document->setTitle(JText::_('Licitações - Relatórios'));
	}


}