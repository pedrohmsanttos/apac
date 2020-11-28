<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

function issCategory($catid, $extension)
{
	if ($extension =="__modalidade_licitacao") {
		
		$db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('count(*)');
	    $query->from($db->quoteName('#__modalidade_licitacao'));
	    $query->where('ativo=1 AND id='.$db->quote($catid));
	    $db->setQuery($query);
	    $categoryList = $db->loadObjectList();
		
	} else {

		$db = JFactory::getDbo();
	    $query = $db->getQuery(true);

	    $query->select('count(*)');
	    $query->from($db->quoteName('#__categories'));
	    $query->where('published=1 AND id='.$db->quote($catid). ' AND extension='.$db->quote($extension));
	    $db->setQuery($query);
	    $categoryList = $db->loadObjectList();

	}

	// $a = $categoryList[0]->count;
	// var_dump($a);die();
    return $categoryList[0]->count;
}

function buscaPorIdCategoria($catid,$busca,$ordem,$filtro){
	$db    = JFactory::getDbo();
	$query = $db->getQuery(true);

	$query->select($db->quoteName(array('id','featured', 'title', 'alias', 'introtext','catid','state','created','modified')));
	$query->from($db->quoteName('#__content'));

	$amanha     = new JDate('now +1 day', new DateTimeZone('America/Recife'));
	$ontem      = new JDate('now -1 day', new DateTimeZone('America/Recife'));
	$mesPassado = new JDate('now -1 mouth', new DateTimeZone('America/Recife'));
	$agora      = JFactory::getDate('now', new DateTimeZone('America/Recife')); // 2016-08-23 15:01:14

	if(! empty($filtro)) {
		switch ($filtro) {
			case 'ontem':
					$query->where('created between '.$db->quote( $ontem ).' and '.$db->quote($agora).' ');
					break;
			case 'ultimas_semanas':
					$query->where('created between '.$db->quote( $mesPassado ).' and '.$db->quote($agora).' ');
						break;
			case 'ultimo_mes':
					$query->where('created <= '.$db->quote( $mesPassado ).' ');
						break;
		}
	}

	if(!empty($catid) && $busca == '') {

			$query->where('introtext like '.$db->quote('%'.$busca.'%'));
			$query->where('state=1');
			$query->where('catid='.$catid);

    } elseif($busca != ''){

			$query->where('introtext like '.$db->quote( '%'.$busca.'%'));
			$query->where('state=1');

    }

	if(! empty($ordem)) {

		switch ($ordem) {
			case 'relevancia':
				$query->order('featured ASC');
				break;

			case 'recente':
				$query->order('created ASC');
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
	$query->where('arquivo LIKE ' . $search.'  ','OR');
	$query->where('descricao LIKE ' . $search.'  ','OR');
	$query->where('titulo LIKE ' . $search.'  ');

	$query->order('id ASC');

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
	$query->where('titulo LIKE ' . $search.'  ','OR');
	$query->where('local LIKE ' . $search.'  ','OR');
	$query->where('descricao LIKE ' . $search.'  ');

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
    $query->where('id='.(int)$id);

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
    if(empty($page))  $page  = 3;
	if(empty($limit)) $limit = 2;
	
	if(count($yourDataArray) <= $limit && $page > 1){
		return array();
	}

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

function getTagsById($tag_id)
{
	//select artigos.id, artigos.catid, artigos.title, artigos.introtext from mk9xj_content as artigos INNER JOIN mk9xj_contentitem_tag_map as tagmap ON artigos.id = tagmap.content_item_id where tagmap.tag_id = 2
  if(empty($tag_id)) return array();
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select(array('artigos.id',
									 'artigos.catid as catid',
									 'artigos.title',
									 'artigos.featured',
									 'artigos.alias',
									 'artigos.state',
									 'artigos.created',
									 'artigos.modified',
									 'artigos.introtext'))
    ->from($db->quoteName('#__content', 'artigos'))
    ->join('INNER', $db->quoteName('#__contentitem_tag_map', 'tagmap') . ' ON (' . $db->quoteName('artigos.id') . ' = ' . $db->quoteName('tagmap.content_item_id') . ')')
    ->where($db->quoteName('tagmap.tag_id') . ' = '.$tag_id)
    ->order($db->quoteName('artigos.title') . ' ASC');
  $db->setQuery($query);
  $results = $db->loadObjectList();
  return $results;
}

function getModalidadeLicitacao($extension)
{
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select($db->quoteName(array('id','nome')));
    $query->from($db->quoteName('#__modalidade_licitacao'));
    $query->where('ativo=1');
		$query->order($db->quoteName('nome') . 'ASC');

    $db->setQuery($query);
    $categoryList = $db->loadObjectList();

    return $db->loadObjectList();
}

function getBuscaCategories($extension)
{
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select($db->quoteName(array('id','title')));
    $query->from($db->quoteName('#__categories'));
    $query->where('published=1 and extension='.$db->quote($extension));
		$query->group('extension,id');
		$query->order($db->quoteName('title') . 'ASC');

    $db->setQuery($query);
    $categoryList = $db->loadObjectList();

    return $db->loadObjectList();
}

function getAvisosMeteorologicoByCatId($catid,$busca,$de,$para)
{
	
    if($catid != '' && isset($catid)){
		$ret = issCategory($catid, 'com_avisometeorologico');
		if($ret == 0) return array();
	}

	if(!empty($busca) && $busca == '')	$busca = '*';

	$db = JFactory::getDbo();
	$db->escape(trim($busca));
	$query = "select a.id, a.titulo as title, created, a.validade as modified, tipo, descricao from #__avisometeorologico as a where (".$db->quoteName('titulo') .' ILIKE ' . $db->quote('%'.$busca.'%');
	$query .= " OR ".$db->quoteName('conteudo') .' ILIKE ' . $db->quote('%'.$busca.'%').'  ';
	$query .= " OR ".$db->quoteName('identificador') .' ILIKE ' . $db->quote('%'.$busca.'%').'  )';
	$query .= " AND published = 1 ";
	
    
    if(!empty($de) && !empty($para)) {

      	$agora_date = new DateTime();
		$para_date  = new DateTime(manipulaData($para, 1));

		if($agora_date < $para_date) {

			$para = $agora_date->format('Y-m-d H:i:s');
			$de   = manipulaData($de);
			$query.= " and inicio between '$de' and '$para'";

		} else {

			$para = manipulaData($para, 1);
			$de   = manipulaData($de);
			$query.= " and inicio between '$de' and '$para'";

		}
    }

	if(!empty($catid)) $query .= " and ".$db->quoteName('tipo').' = '.$catid;
	
	// por ordem
	$query .= 'ORDER BY created DESC';
	//var_dump($query);die();
    $db->setQuery($query);
    $results = $db->loadObjectList();

    return $results;
}

// function getAvisosMeteorologicoByCatId($catid,$busca,$de,$para)
// {
//
//     if(empty($busca)) return array();
//
//     $db = JFactory::getDbo();
//     // aviso
//     $query = $db->getQuery(true);
//     $query->select($db->quoteName(array('a.id')));
//     $query->select($db->quoteName('a.titulo','title'));
//     $query->select($db->quoteName(array('created')));
//     $query->select($db->quoteName('a.validade','modified'));
//
//     $query->from($db->quoteName('#__avisometeorologico','a'));
//
// 		$query->where($db->quoteName('titulo') .' ILIKE ' . $db->quote('%'.$busca.'%').'  ','OR');
// 		$query->where($db->quoteName('conteudo') .' ILIKE ' . $db->quote('%'.$busca.'%').'  ','OR');
// 		$query->where($db->quoteName('identificador') .' ILIKE ' . $db->quote('%'.$busca.'%').'  ');
//
//     if(!empty($catid)) :
//       $query->where($db->quoteName('tipo').' = '.$catid);
//     endif;
//
// 		if(!empty($de) && !empty($para))
// 		{
//       $agora_date = new DateTime();
// 			$para_date  = new DateTime(manipulaData($para));
//
// 			if($agora_date < $para_date) {
//
// 				$para = $agora_date->format('Y-m-d H:i:s');
// 				$de   = manipulaData($de);
// 				$query->where("validade between  '$de' and '$para'");
//
// 			} else {
//
// 				$para = manipulaData($para);
// 				$de   = manipulaData($de);
// 				$query->where("validade between  '$de' and '$para'");
//
// 			}
//
// 		}
//
//     $db->setQuery($query);
//     $results = $db->loadObjectList();
//     return $results;
// }

function getAvisosHidrologicoByCatId($catid,$busca,$de,$para)
{
	if($catid != '' && isset($catid)){
		$ret = issCategory($catid, 'com_avisohidrologico');
		if($ret == 0) return array();
	}

	if(!empty($busca) && $busca == '')	$busca = '*';
	
    $db = JFactory::getDbo();
    // aviso
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('a.id')));
    $query->select($db->quoteName('a.titulo','title'));
	$query->select($db->quoteName(array('created')));
	$query->select($db->quoteName(array('tipo')));
    $query->select($db->quoteName('a.validade','modified'));

    $query->from($db->quoteName('#__avisohidrologico','a'));

	$busca = $db->escape(trim($busca));
	$query->where('published=1');
	/*
	$query->where($db->quoteName('titulo') .' ILIKE ' . $db->quote('%'.$busca.'%').'  ','OR');
	$query->where($db->quoteName('conteudo') .' ILIKE ' . $db->quote('%'.$busca.'%').'  ','OR');
	$query->where($db->quoteName('identificador') .' ILIKE ' . $db->quote('%'.$busca.'%'));
	*/
	$query->where('('.$db->quoteName('titulo').' ILIKE '.$db->quote('%'.$busca.'%').' OR '.$db->quoteName('conteudo').' ILIKE '.$db->quote('%'.$busca.'%').' OR '.$db->quoteName('identificador').' ILIKE '.$db->quote('%'.$busca.'%').')');
	
	if(!empty($catid) || $catid != 0){
      $query->where($db->quoteName('tipo').' = '.$catid);
    }

	if(!empty($de) && !empty($para))
	{
      	$agora_date = new DateTime();
		$para_date  = new DateTime(manipulaData($para));

		if($agora_date < $para_date) {
			$para = $agora_date->format('Y-m-d H:i:s');
			$de   = manipulaData($de);
			$query->where("inicio between  '$de' and '$para'");
		} else {
			$para = manipulaData($para, 1);
			$de   = manipulaData($de);
			$query->where("inicio between  '$de' and '$para'");
		}
	}

	// por ordem
	$query->order('created DESC');
	//var_dump($query->__toString());die();
    $db->setQuery($query);
    $results = $db->loadObjectList();
    return $results;
}

function getInformeHidrologicoByCatId($catid,$busca,$de,$para)
{
	if($catid != '' && isset($catid)){
		$ret = issCategory($catid, 'com_informehidrologico');
		if($ret == 0) return array();
	}

	if(!empty($busca) && $busca == '')	$busca = '*';
	
    $db = JFactory::getDbo();
    // aviso
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('a.id')));
    $query->select($db->quoteName('a.titulo','title'));
	$query->select($db->quoteName(array('a.tipo')));
	$query->select($db->quoteName('a.state'));
	$query->select($db->quoteName('a.arquivo'));
	$query->select($db->quoteName('a.checked_out_time'));
	$query->select($db->quoteName('a.publicacao'));

    $query->from($db->quoteName('#__informehidrologico','a'));

	$busca = $db->escape(trim($busca));
	$query->where('a.state=1');
	/*
	$query->where($db->quoteName('titulo') .' ILIKE ' . $db->quote('%'.$busca.'%').'  ','OR');
	$query->where($db->quoteName('conteudo') .' ILIKE ' . $db->quote('%'.$busca.'%').'  ','OR');
	$query->where($db->quoteName('identificador') .' ILIKE ' . $db->quote('%'.$busca.'%'));
	*/
	$query->where('('.$db->quoteName('titulo').' ILIKE '.$db->quote('%'.$busca.'%').' OR '.$db->quoteName('observacao').' ILIKE '.$db->quote('%'.$busca.'%').' OR '.$db->quoteName('tags').' ILIKE '.$db->quote('%'.$busca.'%').')');
	
	if(!empty($catid) || $catid != 0){
      $query->where($db->quoteName('tipo').' = \''.$catid.'\'');
    }

	if(!empty($de) && !empty($para))
	{
      	$agora_date = new DateTime();
		//$para_date  = new DateTime(manipulaData($para));
		$para_date  = new DateTime(manipulaData($para, 1));

		if($agora_date < $para_date) {
			$para = $agora_date->format('Y-m-d H:i:s');
			$agora_date->add(new DateInterval('P10D'));
			$de   = manipulaData($de);
			$query->where("publicacao between  '$de' and '$para'");
		} else {
			$para = manipulaData($para, 1);
			$de   = manipulaData($de);
			$query->where("publicacao between  '$de' and '$para'");
		}
	}

	
	$query->order('checked_out_time DESC');
	

    $db->setQuery($query);
    $results = $db->loadObjectList();
    return $results;
}

function getInformeMeteorologicoByCatId($catid,$busca,$de,$para)
{
	if($catid != '' && isset($catid)){
		$ret = issCategory($catid, 'com_informemeteorologico');
		if($ret == 0) return array();
	}

	if(!empty($busca) && $busca == '')	$busca = '*';
	
    $db = JFactory::getDbo();
    // aviso
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('a.id')));
    $query->select($db->quoteName('a.titulo','title'));
	$query->select($db->quoteName(array('tipo')));
	$query->select($db->quoteName('a.state'));
	$query->select($db->quoteName('a.arquivo'));
	$query->select($db->quoteName('a.checked_out_time'));
	$query->select($db->quoteName('a.publicacao'));

    $query->from($db->quoteName('#__informemeteorologico','a'));

	$busca = $db->escape(trim($busca));
	$query->where('state=1');
	/*
	$query->where($db->quoteName('titulo') .' ILIKE ' . $db->quote('%'.$busca.'%').'  ','OR');
	$query->where($db->quoteName('conteudo') .' ILIKE ' . $db->quote('%'.$busca.'%').'  ','OR');
	$query->where($db->quoteName('identificador') .' ILIKE ' . $db->quote('%'.$busca.'%'));
	*/
	$query->where('('.$db->quoteName('titulo').' ILIKE '.$db->quote('%'.$busca.'%').' OR '.$db->quoteName('observacao').' ILIKE '.$db->quote('%'.$busca.'%').' OR '.$db->quoteName('tags').' ILIKE '.$db->quote('%'.$busca.'%').')');
	
	if(!empty($catid) || $catid != 0){
		$query->where($db->quoteName('tipo').' = \''.$catid.'\'');
    }

	if(!empty($de) && !empty($para))
	{
      	$agora_date = new DateTime();
		//$para_date  = new DateTime(manipulaData($para));
		$para_date  = new DateTime(manipulaData($para, 1));

		if($agora_date < $para_date) {
			$para = $agora_date->format('Y-m-d H:i:s');
			$agora_date->add(new DateInterval('P10D'));
			$de   = manipulaData($de);
			$query->where("publicacao between  '$de' and '$para'");
		} else {
			$para = manipulaData($para, 1);
			$de   = manipulaData($de);
			$query->where("publicacao between  '$de' and '$para'");
		}
	}

	
	$query->order('checked_out_time DESC');
	
    $db->setQuery($query);
    $results = $db->loadObjectList();
    return $results;
}

function getArquivosByCatId($catid,$busca,$de,$para)
{
	if($catid != '' && isset($catid)){
		$ret = issCategory($catid, 'com_arquivo');
		if($ret == 0) return array();
	}

	if(!empty($busca) && $busca == '')	$busca = '*';

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

	$query->select($db->quoteName(array('a.id')));
	$query->select($db->quoteName('a.titulo','title'));
	$query->select($db->quoteName(array('arquivo')));
	$query->select($db->quoteName(array('catid')));

    $query->from($db->quoteName('#__arquivo','a'));

	if(empty($catid)){
		$query->where('published=1');
	} else {
		$query->where('published=1 and catid='.$db->quote($catid));
	}

	$busca = $db->escape(trim($busca));
	if(!empty($busca) && $busca != ''){
		$query->where('('.$db->quoteName('titulo') .' ILIKE ' .$db->quote('%'.$busca.'%').' OR '.$db->quoteName('descricao') .' ILIKE ' .$db->quote('%'.$busca.'%').')');
	}
	

	if(!empty($de) && !empty($para)){
		$para_date  = new DateTime(manipulaData($para, 1));
		$agora_date = new DateTime();

		if($agora_date < $para_date) {
			$para = $agora_date->format('Y-m-d H:i:s');
			$de   = manipulaData($de);
			$query->where("created between  '$de' and '$para'");
		} else {
			$para = manipulaData($para, 1);
			$de   = manipulaData($de);
			$query->where("created between  '$de' and '$para'");
		}
	}

	// por ordem
	$query->order('created DESC');
	
    $db->setQuery($query);

    $result = $db->loadObjectList();
    return $result;
}

function getContentByCatId($catid,$busca,$de,$para)
{
	if($catid != '' && isset($catid))
	{
		$ret = issCategory($catid, 'com_content');
		if($ret == 0) return array();
	}

	if(!empty($busca) && $busca == '')	$busca = '*';

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

	$query->select($db->quoteName(array('a.id')));
	$query->select($db->quoteName('a.title','title'));
	$query->select($db->quoteName(array('created','modified','catid')));
    $query->from($db->quoteName('#__content','a'));

	$query->where('state=1', 'AND');
	if(!empty($catid) && $catid != ''){
		$query->where('catid='.$catid);
	}
	$search = $db->quote('%' .$db->escape(trim($busca)) . '%');
	$query->where('("introtext" ILIKE '.$search.' OR "title" ILIKE '.$search.')');

	if(!empty($de) && !empty($para)){
		$para_date  = new DateTime(manipulaData($para, 1));
		$agora_date = new DateTime();

		if($agora_date < $para_date) {

			$para = $agora_date->format('Y-m-d H:i:s');
			$de   = manipulaData($de);
			$query->where("created between  '$de' and '$para'");

		} else {

			$para = manipulaData($para, 1);
			$de   = manipulaData($de);
			$query->where("created between  '$de' and '$para'");

		}

	}

	// por ordem
	$query->order('created DESC');

    $db->setQuery($query);
    $result = $db->loadObjectList();

    return $result;
}

function getLicitacaoByCatId($modid_raw,$busca,$de,$para)
{
	// tratamento do id das categorias de licita��o, para evitar conflito nas buscas
	$modid = preg_replace("/[^0-9]/", "", $modid_raw );
	$modid_str = "$modid";

	if(!empty($busca) && $busca == '')	$busca = '*';

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

	$query->select($db->quoteName(array('a.id')));
	$query->select($db->quoteName('a.titulo'));
	$query->select($db->quoteName(array('a.data_publicacao')));
    $query->from($db->quoteName('#__licitacoes','a'));

	$query->where('state=1', 'AND');
	if(!empty($modid_str) && $modid_str != ''){
		$modalidadeid = $db->quote($modid_str);
		$query->where('modalidade='.$modalidadeid);
	}
	$search = $db->quote('%' .$db->escape(trim($busca)) . '%');
	$query->where('("resumo" ILIKE '.$search.' OR "titulo" ILIKE '.$search.')');

	if(!empty($de) && !empty($para)){
		$para_date  = new DateTime(manipulaData($para, 0));
		$agora_date = new DateTime();

		if($agora_date < $para_date) {

			$para = $agora_date->format('Y-m-d H:i:s');
			$de   = manipulaData($de);
			$query->where("data_licitacao between  '$de' and '$para'");

		} else {

			$para = manipulaData($para, 0);
			$de   = manipulaData($de);
			$query->where("data_licitacao between  '$de' and '$para'");

		}

	}

	// por ordem
	$query->order('data_publicacao DESC');

    $db->setQuery($query);
    $result = $db->loadObjectList();

    return $result;
}

function manipulaData($str, $dias = 0)
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


Class Firewall
  {
    public function SecureUris()
      {
          // get the current url
          $inurl = $_SERVER['REQUEST_URI'];
          if (preg_match("#select|update|delete|concat|create|table|union|length|show_table|mysql_list_tables|mysql_list_fields|mysql_list_dbs#i", $inurl))
          {
            exit($this->SecurityWarningTemplate());
          }
           $securityUlrs_url = $_SERVER['QUERY_STRING'];
           if ($securityUlrs_url != '' AND !preg_match("/^[_a-zA-Z0-9-=&]+$/", $securityUlrs_url))
           {
            exit($this->SecurityWarningTemplate());
           }
           return true;
      }

    public function getClean($txt){
        $txt = htmlspecialchars($txt);
        $txt = str_replace("select","5ev1ect",$txt);
        $txt = str_replace("update","upd4tee",$txt);
        $txt = str_replace("insert","1dn5yert",$txt);
        $txt = str_replace("where","w6eere",$txt);
        $txt = str_replace("like","1insk",$txt);
        $txt = str_replace("or","08r",$txt);
        $txt = str_replace("and","4nd",$txt);
        $txt = str_replace("set","5eut",$txt);
        $txt = str_replace("into","1n8t0",$txt);
        $txt = str_replace("'", "", $txt);
        $txt = str_replace(";", "", $txt);
        $txt = str_replace(">", "", $txt);
        $txt = str_replace("<", "", $txt);
        $txt = strip_tags($txt);
        return $txt;
    }

    public function get_ip()
     {
           if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                 $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
           }
           elseif(isset($_SERVER['HTTP_CLIENT_IP'])) {
                 $ip = $_SERVER['HTTP_CLIENT_IP'];
           }
           else {
                 $ip = $_SERVER['REMOTE_ADDR'];
           }
           return $ip;
     }

    public function SecurityWarningTemplate()
      {
        $x = '
        <html>
        <head>
        <title>Access Denied</title>
        </head>
        <body>
        <br>
				<center><h1>Access Denied</h1></center>
        </body>
        </html>';
        return str_replace("{IP}", $this->get_ip(), $x);
	  }
	  
	  	
  }

function cmp($a, $b)
{
	$at = iconv('UTF-8', 'ASCII//TRANSLIT', $a->title);
    $bt = iconv('UTF-8', 'ASCII//TRANSLIT', $b->title);
	return strcmp($at, $bt);
} 
