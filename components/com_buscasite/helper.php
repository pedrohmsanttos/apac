<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

function buscaPorIdCategoria($catid,$busca,$ordem,$filtro){

	$db = JFactory::getDbo();
	$query = $db->getQuery(true);

	$query->select($db->quoteName(array('id','featured', 'title', 'alias', 'introtext','catid','state','created','modified')));
	$query->from($db->quoteName('#__content'));
	$query->where('state=1');

	$amanha = new JDate('now +1 day', new DateTimeZone('America/Recife'));
	$ontem  = new JDate('now -1 day', new DateTimeZone('America/Recife'));
	$mesPassado = new JDate('now -1 mouth', new DateTimeZone('America/Recife'));
	$agora = JFactory::getDate('now', new DateTimeZone('America/Recife')); // 2016-08-23 15:01:14


	if(! empty($filtro)) {
		switch ($filtro) {
			case 'ontem':
					$query->where('created between '.$db->quote( $ontem ).' and '.$db->quote($agora).' ');
					break;
			case 'ultimas_semanas':
					$query->where('created between '.$db->quote( $mesPassado ).' and '.$db->quote($agora).' ');
						break;
			case 'ultimo_mes':
					$query->where('created between '.$db->quote( $mesPassado ).' and '.$db->quote($agora).' ');
						break;
		}
	}

	/*

	if($busca != '') {

		$bsc = 'introtext ilike '.$db->quote('%'.$busca.'%').' '.' or ';
		$bsc .= 'title ilike '.$db->quote('%'.$busca.'%').' '.' or ';
		$bsc .= 'alias ilike '.$db->quote('%'.$busca.'%').' ';

		$query->where($bsc);

		if(!empty($catid)){
			$query->where('catid='.$catid);
		}

	}

	*/

	if($busca != '') {

		$busca_array = explode(" ",$busca);

		$bsc = '(';

		foreach ($busca_array as $busca_single) {

			$bsc .= 'introtext ilike '.$db->quote('%'.$busca_single.'%').' '.' or ';
			$bsc .= 'title ilike '.$db->quote('%'.$busca_single.'%').' '.' or ';
			$bsc .= 'alias ilike '.$db->quote('%'.$busca_single.'%').' and ';

		}

		$bsc = substr($bsc, 0, -4); // remove last and
		$bsc .= ')';
		$query->where($bsc, 'AND');


		if(!empty($catid)){
			$query->where('catid='.$catid);
		}

	}

	if(! empty($ordem)) {

		switch ($ordem) {
			case 'relevancia':
				$query->order('featured ASC');
				break;

			case 'recente':
				$query->order('created DESC');
				break;

			case 'alfabetica':
				$query->order('title ASC');
				break;
			default:
				$query->order('title ASC');
				break;
		}

	}

	$db->setQuery($query);
	$results = $db->loadObjectList();
	return $results;
}

function buscaArquivo($busca,$ordem){

	if(empty($busca)) return '';

	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('*');
	$query->from($db->quoteName('#__arquivo'));
	$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($busca), true) . '%'));
	$query->where('arquivo ILIKE ' . $search.'  ');

	if(! empty($ordem)) {

		switch ($ordem) {
			case 'relevancia':
				$query->order('id ASC');
				break;

			case 'recente':
				$query->order('id ASC');
				break;

			case 'alfabetica':
				$query->order('titulo ASC');
				break;
			default:
				$query->order('titulo ASC');
				break;
		}

	}

	$db->setQuery($query);
	$results = $db->loadObjectList();

	return $results;
}

function buscaAgenda($busca,$ordem){

	if(empty($busca)) return '';

	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('*');
	$query->from($db->quoteName('#__agenda'));
	$search = $db->quote('%' . str_replace(' ', '%', $db->escape(trim($busca), true) . '%'));

	$bsc = 'titulo ILIKE ' . $search.' or ';
	$bsc .= 'local ILIKE ' . $search.'  or ';
	$bsc .= 'descricao ILIKE ' . $search.'  ';
	// $query->where('titulo ILIKE ' . $search.'  ','OR');
	// $query->where('local ILIKE ' . $search.'  ','OR');
	// $query->where('descricao ILIKE ' . $search.'  ');

	$query->where($bsc);

	if(! empty($ordem)) {

		switch ($ordem) {
			case 'relevancia':
				$query->order('id ASC');
				break;

			case 'recente':
				$query->order('data ASC');
				break;

			case 'alfabetica':
				$query->order('titulo ASC');
				break;
			default:
				$query->order('titulo ASC');
				break;
		}

	}

	$db->setQuery($query);
	$results = $db->loadObjectList();

	return $results;
}

function str2data($str){

	if(empty($str)) return '';

	$arrStr = explode(" ", $str);
	$hora = str_replace(":", "h", $arrStr[1]);
	$hora = substr($hora, 0, 5);
	$data = explode('-', $arrStr[0]);

	return "$data[2]/$data[1]/$data[0] $hora";

}


function getCategoryById($id)
{
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select($db->quoteName(array('id', 'title','alias','description','params','parent_id','path')));
    $query->from($db->quoteName('#__categories'));
    $query->where('id='.$id);

    $db->setQuery($query);

    $categoryList = $db->loadObjectList();

    $prms = json_decode($categoryList[0]->params);

    return $categoryList[0];
}

function getLink($artigo)
{
	$id_artigo    = $artigo->id;
	$catid        = $artigo->catid;
	$alias_artigo = $artigo->alias;
	$cat_alias    = getCategoryById($catid)->path;

	$link = JUri::base().$cat_alias.'/'.$id_artigo.'-'.$alias_artigo;

	return $link;
}

function getArticle($id)
{
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('id', 'title', 'introtext','catid','alias')));
    $query->from($db->quoteName('#__content'));
    $query->where('id='.$id);
    $db->setQuery($query);

    $articlesList = $db->loadObjectList();
    return $articlesList[0];
}

function setTituloPaginaBusca($titulo,$subtitulo)
{
    $saida_script = " document.addEventListener('DOMContentLoaded',function(){
            document.getElementById('titulo-pagina').innerHTML = '$titulo';
            document.getElementById('subtitulo-pagina').innerHTML  = '$subtitulo'; });";

    echo '<script>'.$saida_script.'</script>';

    JFactory::getDocument()->addScriptDeclaration($saida);
}

function paginacao($yourDataArray,$page,$limit)
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

function mudaParamUrl($url, $assign) {
	list($var,$val) = explode("=",$assign);
	if(!strpos($url,"?")) {
	    $res = "$url?$assign";
	} else {
	    list($base,$vars) = explode("?",$url);
	    //if the vars dont include the one given
	    if(!strpos($vars,$var)) {
	        $res = "$url&$assign";
	    } else {
	        $res = preg_replace("/$var=[a-zA-Z0-9_]*(&|$)/",$assign."&",$url);
	        $res = preg_replace("/&$/","",$res); //remove possible & at the end
	    }
	}
	return $res;
}

function getCategoryLink($id){
	if(empty($id)) return '';

	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select($db->quoteName(array('id', 'title', 'alias','parent_id','path')));
	$query->from($db->quoteName('#__categories'));
	$query->where("id=$id and published = 1");
	$db->setQuery($query);
	$categories = $db->loadObjectList();
	//noticias/9-noticias/seguranca
	// foreach ($categories as $cat) {
		$cat = $categories[0];
		$catPath = explode('/', $cat->path)[0];

		if($cat->parent_id != '1'){
			$cat->link = $catPath.'/'.$cat->id.'-'.$catPath.'/'.$cat->alias;
		} else {
			$cat->link = $catPath;
		}

	// }


	return $cat->link;
}
