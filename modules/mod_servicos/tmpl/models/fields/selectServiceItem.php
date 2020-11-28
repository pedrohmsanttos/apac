<?php
defined('_JEXEC') or die('Restricted access'); 
jimport('joomla.form.formfield');

if(!defined('DS')) define('DS',DIRECTORY_SEPARATOR);

require_once dirname(dirname(dirname(dirname(__FILE__)))).DS.'helper.php';

class JFormFieldSelectServiceItem extends JFormField {
 
	protected $type = 'SelectServiceItem';
	protected $base_files_url = '';
 
	public function getLabel() {
		return '<span>Ítens de aba:</span>';
	}
 
	public function getInput() {
		JHTML::_('behavior.modal');

		$document = JFactory::getDocument();
		$this->base_files_url = JUri::base().'../modules/mod_servicos/tmpl/';
		$aba_selecionada = $this->element['name'];
		
		$document->addStyleSheet($this->base_files_url.'css/basic.css');
		$document->addStyleSheet($this->base_files_url.'css/basic_ie.css');
		$document->addStyleSheet($this->base_files_url.'css/demo.css');

		$document->addScript($this->base_files_url.'js/list.min.js');
		//$document->addScript($this->base_files_url.'js/jquery.simplemodal.js');
		$document->addScript($this->base_files_url.'js/basic.js');
		
		$itensList   = modServicosHelper::getItens();
		$params      = modServicosHelper::getParams();
		$modal	     = modServicosHelper::getModal($aba_selecionada);
		$param_salvo = modServicosHelper::getParamVal($aba_selecionada);
		
		$custom_form = '';
		$custom_form .= $modal;
		
		$custom_form .= '<a class="modal" href="../modules/mod_servicos/tmpl/modal.php?aba='.$aba_selecionada.'"><button id="" data-aba="'.$aba_selecionada.'" 
								class="btn btn-small btn-default edita-aba">
							<span class="icon-apply icon-white"></span>
							Editar
						</button></a>';
		$custom_form .= '<input value="'.$param_salvo.'" type="hidden" name="jform[params]['.$aba_selecionada.']" class="form-control" id="jform[params]['.$aba_selecionada.']">';

		return $custom_form;
	}
}

