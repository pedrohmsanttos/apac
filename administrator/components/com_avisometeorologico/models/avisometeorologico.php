<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

require_once JPATH_COMPONENT . '/dompdf/autoload.inc.php';
use Dompdf\Dompdf;

// echo JPATH_ROOT;die;

class AvisometeorologicoModelAvisometeorologico extends JModelAdmin
{
	/**
	 * Method to get a table object, load it if necessary.
	 *
	 * @param   string  $type    The table name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  JTable  A JTable object
	 *
	 * @since   1.6
	 */
	public function getTable($type = 'Avisometeorologico', $prefix = 'AvisometeorologicoTable', $config = array())
	{
		return JTable::getInstance($type, $prefix, $config);
	}
 
	/**
	 * Method to get the record form.
	 *
	 * @param   array    $data      Data for the form.
	 * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
	 *
	 * @return  mixed    A JForm object on success, false on failure
	 *
	 * @since   1.6
	 */
	public function getForm($data = array(), $loadData = true)
	{
		// Get the form.
		$form = $this->loadForm(
			'com_avisometeorologico.avisometeorologico',
			'avisometeorologico',
			array(
				'control' => 'jform',
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
	 * @return  mixed  The data for the form.
	 *
	 * @since   1.6
	 */
	protected function loadFormData()
	{
		// Check the session for previously entered form data.
		$data = JFactory::getApplication()->getUserState(
			'com_avisometeorologico.edit.avisometeorologico.data',
			array()
		);
 
		if (empty($data))
		{
			$data = $this->getItem();
		}
 
		return $data;
	}

	protected function getLogo(){
		$path = JPATH_ROOT . '/images/logo-apac-governo-pequena.jpg';
		return $this->getBase64Image($path);
	}

	protected function getBase64Image($path){
		// echo $path;die;
		$type = pathinfo($path)['extension'];
		
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		return $base64;
	}

	public function gerarPDF($pks){

		$html = $this->layoutEmail($pks,true);

		if(empty($pks)) return false;
		
		$dompdf = new Dompdf();
		$dompdf->set_option('isHtml5ParserEnabled', true);
		$dompdf->setPaper('A4', 'landscape');
		$dompdf->setBasePath(JPATH_COMPONENT . '/dompdf');
		$dompdf->loadHtml($html);
		$dompdf->render();
		$dompdf->output();

		$filename = 'AVISO_HIDROMETEOROLOGICO_'.date('d-m-Y-His').'_'.$pks[0].'.pdf';

		$dompdf->stream($filename);

		return true;
	}

	protected function getInteressados($id_categoria){
		
		$interessados = array();

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		//Consultando todos que querem receber AVISOS METEOROLOGICOS
		$query->select($this->getState('list.select', 'DISTINCT a.*'));
		$query->from('#__cadastrointeressado AS a');
		$query->where('a.boletim not like \'%meteorologia_avisos":""%\' AND a.situacao = \'1\' ');
         
		$db->setQuery($query);
		
		$interessados = $db->loadObjectList();

		$returnInteressados = array();

		foreach($interessados as $interessado){
			$boletim =  json_decode($interessado->boletim);
			if(in_array($id_categoria,$boletim->meteorologia_avisos)){
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

		$aviso = $this->getAvisoBy("a.id =".$id);

		$interessados = $this->getInteressados($aviso->id_categoria);

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
						$item_email->tipo_item		= "AVISO HIDROMETEOROLOGICO";
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
	
	protected function getAvisoBy($where){

		$novoWhere = str_replace(" ", "", $where);
		$id = str_replace("a.id=", "", trim($novoWhere));

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		$sqlAnx = '(select array_to_string(array_agg("an"."arquivo"), \',\') AS "arquivos" FROM ' . $db->quoteName('#__avisometeorologico_anexo', 'an') . ' where id_aviso = ' . $id . ' ) as "arquivos"';
		
		$sqlTitulo = '(select array_to_string(array_agg("an"."titulo"), \',\') AS "titulo_arquivos" FROM ' . $db->quoteName('#__avisometeorologico_anexo', 'an') . ' where id_aviso = ' . $id . ' ) as "titulo_arquivos"';
		
		$query->select('MAX(a.conteudo) as conteudo, MAX(a.published) as "published", MAX(c.published) as "CatPublished", MAX(a.id) as "rg", MAX(a.titulo) as "titulo", MAX(a.inicio) as "inicio", MAX(a.validade) as "validade", MAX(a.identificador) as "identificador", MAX(a.created) as created')
			->from($db->quoteName('#__avisometeorologico', 'a'));
		$query->where($where);
		$query->select( $sqlAnx  );
		$query->select( $sqlTitulo  );
		$query->select('MAX("c"."title") AS "category_title"')
			->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON c.id = a.tipo');
		$query->select('MAX("c"."id") AS id_categoria');
		$query->select('array_to_string(array_agg("r"."title"), \',\') AS "regioes"')
			->join('LEFT', $db->quoteName('#__regioes', 'r') . ' ON r.id = any(string_to_array(a.regioes, \',\')::int[])');
		$query->group($db->quoteName('a.id'));
			
		$db->setQuery($query);

		return $db->loadObjectList()[0];
	}

	protected function layoutEmail($pks, $pdf = null)
	{	

		
		$html = "";

		if(empty($pks)) return $html;

		$db = JFactory::getDbo();
		$query = $db->getQuery(true);

		//clean sql injection
		$id    = $db->escape($pks[0]);

		$aviso = $this->getAvisoBy("a.id =".$id);
		
		if(!empty($aviso)){

			$urlSite = str_replace("administrator/", "", JURI::base());

			$urlLogo = $this->getLogo();

			$imagem = $this->getLogo();
			
			$imagemLogo = '<div style="margin: auto;width: 50%;"><img src="' . $imagem . '"></div>';

			$html = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head></head><body><style></style>!#LOGO#!<table class="tg" style="border:none;border-collapse:collapse;border-color:#9ABAD9;border-spacing:0;table-layout:fixed;width:100%"><tbody><tr><td colspan="2" style="border-color:#9ABAD9;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;word-break:normal"><img src=""></td></tr><tr><th class="tg-s268" style="background-color:#E7BB03;border-color:#9ABAD9;border-style:solid;border-width:0;color:#fff;font-family:Arial,sans-serif;font-size:14px;font-weight:400;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"><span style="font-weight:700">AVISO HIDROMETEOROLÓGICO !#INDEN#!</span></th><th class="tg-s268" style="background-color:#E7BB03;border-color:#9ABAD9;border-style:solid;border-width:0;color:#fff;font-family:Arial,sans-serif;font-size:14px;font-weight:400;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"></th></tr><tr><td class="tg-s268" style="border-color:#9ABAD9;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"><span style="font-weight:700">Regiões: </span>!#REGIAO#!</td><td class="tg-s268" style="border-color:#9ABAD9;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"></td></tr><tr><td class="tg-s268" style="border-color:#9ABAD9;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"><span style="font-weight:700">Tipo:</span> !#TIPO#! </td><td class="tg-s268" style="border-color:#9ABAD9;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"></td></tr><tr><td class="tg-s268" style="border-color:#9ABAD9;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"><span style="font-weight:700">Publicado:</span>!#PUBLICADO#! | <span style="font-weight:bold">Validade: </span>!#VALIDADE#!</td><td class="tg-s268" style="border-color:#9ABAD9;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"></td></tr><tr><td class="tg-s268" rowspan="2" style="border-color:#9ABAD9;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal">!#CONTEUDO#!</td><td class="tg-y9h6 border" style="background-color:#E7BB03;border:solid 1px #000;border-color:#3166ff;border-style:solid;border-width:0;color:#fff;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;word-break:normal"><span style="font-weight:700">ANEXOS</span></td></tr><tr><td class="tg-73oq border" style="border:solid 1px #000;border-color:#000;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:left;vertical-align:top;word-break:normal">!#ANEXOS#!</td></tr>!#DESCADASTRAR#!</tbody></table></body></html>';
		
			$anexos = "";

			if(!empty($aviso->titulo_arquivos) && !empty($aviso->arquivos) ){
				$arrayTitulos = explode(",", $aviso->titulo_arquivos);
				$arrayArquivos = explode(",", $aviso->arquivos);
				foreach($arrayTitulos as $chave => $titulo){
					$anexos .= '<li><a href="'. $urlSite . "images/media/" . $arrayArquivos[$chave] .'">'. $titulo .'</li>';
				}	
			}else{
				$anexos .= "<li>NÃO EXISTEM ANEXOS</li>";
			}

			if(!$pdf){
				$urlSite = str_replace("administrator/", "", JURI::base());

				$urlSite .= "component/interessadonosite/?id=!#ID_INTERESSADO#!";

				$descadastrar = '<tr><td colspan="2" class="tg-c3ow" style="background-color:white;border-color:inherit;border-style:solid;border-width:0;color:#444;font-family:Arial,sans-serif;font-size:14px;overflow:hidden;padding:3px 20px;text-align:center;vertical-align:top;word-break:normal">!#LINK_DESC#!</td></tr>';
				
				$linkDesc = '<a href="'.$urlSite.'">Caso não queira mais receber esse e-mail, clique aqui para descadastrar-se</a>';

				$descadastrar = str_replace("!#LINK_DESC#!", $linkDesc, $descadastrar);

				$html = str_replace("!#DESCADASTRAR#!",$descadastrar,$html);

			}else{
				$html = str_replace("!#DESCADASTRAR#!","",$html);
			}

			$html = str_replace("!#LOGO#!",$imagemLogo,$html);
			$html = str_replace("!#INDEN#!",$aviso->identificador,$html);
			$html = str_replace("!#REGIAO#!",$aviso->regioes,$html);
			$html = str_replace("!#TIPO#!",$aviso->category_title,$html);
			$html = str_replace("!#PUBLICADO#!",date('d/m/Y H:i:s', strtotime( str_replace("-", "/", $aviso->created) ) ),$html);
			$html = str_replace("!#VALIDADE#!",date('d/m/Y H:i:s', strtotime( str_replace("-", "/", $aviso->validade) ) ),$html);
			$html = str_replace("!#CONTEUDO#!",$aviso->conteudo,$html);
			$html = str_replace("!#ANEXOS#!",$anexos,$html);
			
		}

		return $html;

	}
}