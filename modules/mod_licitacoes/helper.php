<?php defined('_JEXEC') or die;
class ModLicitacoesHelper
{
	public static function getLicitacoes()
	{
		//if(empty($catid)) return '';

	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('id,titulo, data_licitacao, resumo');
	    $query->from($db->quoteName('#__licitacoes'));
	    // $query->where("published = 1 and catid = $catid and data >= now()");
	    $query->where("state = 1");
	    $query->order($db->quoteName('data_licitacao')."DESC");

	    $db->setQuery($query);

		$results = $db->loadObjectList();
		
		return $results;
	}
	public static function getLicitacao($id)
	{
		if(empty($id)) return '';

	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('id,titulo, data_licitacao, resumo,numero_processo,ano_processo');
	    $query->from($db->quoteName('#__licitacoes'));
	    $query->where("id = $id");
	    $query->order($db->quoteName('data_licitacao')."DESC");

	    $db->setQuery($query);

		$results = $db->loadObjectList();
		
		return $results;
	}
	public static function getArquivos($id)
	{
		if(empty($id)) return '';

	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('id,titulo, arquivo, tipo,id_licitacao');
	    $query->from($db->quoteName('#__arquivos_licitacao'));
		$query->where("id_licitacao = $id");
		$query->order($db->quoteName('ordering')."ASC");
	    //$query->group($db->quoteName('data_licitacao'));

	    $db->setQuery($query);

		$results = $db->loadObjectList();
		
		return $results;
	}

	public static function getArquivo($id)
	{
		
		if(empty($id)) return '';
		
	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('id,titulo, arquivo, tipo,id_licitacao');
	    $query->from($db->quoteName('#__arquivos_licitacao'));
		$query->where("id = $id");
		// $query->order($db->quoteName('ordering')."ASC");
	    //$query->group($db->quoteName('data_licitacao'));

	    $db->setQuery($query);

		$results = $db->loadObjectList();
		
		 return $results;
		
	}

	public static function getDadosUsuario($id)
	{ //134
		// if(empty($id)) return '';

	    $db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('a.id, a.name, a.username, b.value, b.field_id');
		$query->from($db->quoteName('#__users','a'));
		$query->join('INNER', $db->quoteName('#__fields_values', 'b') . ' ON cast (b.item_id as int8) = a.id');
		$query->where("id = $id"."and b.field_id in (1,3,4)");
		$query->order($db->quoteName('b.field_id')."ASC");
	    //$query->group($db->quoteName('data_licitacao'));
		//var_dump($query->__toString());
	    $db->setQuery($query);

		$results = $db->loadObjectList();
		
		return $results;
	}

	public static function paginacao($yourDataArray,$page,$limit)
	{
	    if(empty($page)) $page = 3;
	    if(empty($limit)) $limit = 2;

	    // $page = ! empty( $_GET['page'] ) ? (int) $_GET['page'] : 1;
	    $total = count( $yourDataArray ); //total items in array
	    $totalPages = ceil( $total/ $limit ); //calculate total pages
	    $page = max($page, 1); //get 1 page when $_GET['page'] <= 0
	    $page = min($page, $totalPages); //get last page when $_GET['page'] > $totalPages
	    $offset = ($page - 1) * $limit;
	    if( $offset < 0 ) $offset = 0;

	    $yourDataArray = array_slice( $yourDataArray, $offset, $limit );

	    $saida = new stdClass();
	    $saida->vetor = $yourDataArray;
	    $saida->total_paginas = $totalPages;
	   return $saida;

	}

	
	

	function formataData($str)
	{   
		if(empty($str)) return '';
		$arrStr = explode("-", $str);
		$arrStr = $arrStr[2]."/".$arrStr[1]."/".$arrStr[0];	
		return $arrStr;
	}

	public static function relatorio($userId,$arquivoId)
	{	
	if(empty($userId)|| empty($arquivoId)) return '';
	date_default_timezone_set('America/Sao_Paulo');
	
	$date = date('d/m/Y H:i:s');
	$arquivo = self::getArquivo($arquivoId);
	$idLicit = $arquivo[0]->id_licitacao;
	$licitacao = self::getLicitacao($idLicit);
	$licitacaoNumero = $licitacao[0]->numero_processo;
	$licitacaoAno = $licitacao[0]->ano_processo;
	$licitacaoTitulo = $licitacao[0]->titulo;
	$relatorio = self::getDadosUsuario($userId);
	$nomeRazao = $relatorio[0]->name;
	$docUser = $relatorio[0]->value;
	$tipoUser = $relatorio[1]->value;
	$telefone = $relatorio[2]->value;
	
	$db= JFactory::getDbo();
  	$query = $db->getQuery(true);

	$columns = array('id_licitacao',
					'documento_usuario',
					'numero_processo',
					'ano_processo',
					'nome_razao',
					'data_download',
					'id_users',
					'tipo_users',
					'telefone_users',
					'state',
					'checked_out',
				'checked_out_time',
			'created_by',
		'modified_by');

	$values = array($db->quote($idLicit),
					$db->quote($docUser),
					$db->quote($licitacaoNumero),
					$db->quote($licitacaoAno),
					$db->quote($nomeRazao),
					$db->quote($date),
					$db->quote($userId),
					$db->quote($tipoUser),
					$db->quote($telefone),
					$db->quote(1),
					$db->quote(0),
					$db->quote('NOW()'),
					$db->quote(169),
					$db->quote(169)
				);

	$query->insert($db->quoteName('#__relatorio_licitacao'))
			->columns($db->quoteName($columns))
			->values(implode(',', $values));

	$db->setQuery($query);
	$db->execute();
	}
}
