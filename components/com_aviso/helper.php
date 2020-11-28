<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

function getAvisoById($id,$catid)
{

    if(empty($id)) return array();

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    //clean sql injection
    $id    = $db->escape($id);
    $catid = $db->escape($catid);

    //$query->select('*');
    //$query->from($db->quoteName('#__avisohidrologico'));
    $query->select('MAX(a.conteudo) as conteudo, MAX(a.published) as "published", MAX(c.published) as "CatPublished", MAX(a.id) as "rg", MAX(a.titulo) as "titulo", MAX(a.inicio) as "inicio", MAX(a.validade) as "validade", MAX(a.identificador) as "identificador", MAX(a.created) as created')
        ->from($db->quoteName('#__avisometeorologico', 'a'));
    $query->where("a.published = 1 AND a.id =".$id." AND a.tipo=".$catid);
    $query->select('MAX("c"."title") AS "category_title"')
        ->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON c.id = a.tipo');
    $query->select('array_to_string(array_agg("r"."title"), \',\') AS "regioes"')
        ->join('LEFT', $db->quoteName('#__regioes', 'r') . ' ON r.id = any(string_to_array(a.regioes, \',\')::int[])');
    $query->group($db->quoteName('a.id'));
    //$query->where($db->quoteName('#__avisohidrologico').'.published=1 and '.$db->quoteName('#__avisohidrologico').'.id='.$id.' and '.$db->quoteName('#__avisohidrologico').'.tipo='.$catid);

    $db->setQuery($query);
    return $db->loadObjectList()[0];
}

function getAvisoHidrologicoById($id,$catid)
{

    if(empty($id)) return array();

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    //$query->select('*');
    //$query->from($db->quoteName('#__avisohidrologico'));
    $query->select('MAX(a.conteudo) as conteudo, MAX(a.published) as "published", MAX(c.published) as "CatPublished", MAX(a.id) as "rg", MAX(a.titulo) as "titulo", MAX(a.inicio) as "inicio", MAX(a.validade) as "validade", MAX(a.identificador) as "identificador", MAX(a.created) as created')
        ->from($db->quoteName('#__avisohidrologico', 'a'));
    $query->where("a.published = 1 AND a.id =".$id." AND a.tipo=".$catid);
    $query->select('MAX("c"."title") AS "category_title"')
        ->join('LEFT', $db->quoteName('#__categories', 'c') . ' ON c.id = a.tipo');
    $query->select('array_to_string(array_agg("r"."title"), \',\') AS "regioes"')
        ->join('LEFT', $db->quoteName('#__regioes', 'r') . ' ON r.id = any(string_to_array(a.regioes, \',\')::int[])');
    $query->group($db->quoteName('a.id'));
    //$query->where($db->quoteName('#__avisohidrologico').'.published=1 and '.$db->quoteName('#__avisohidrologico').'.id='.$id.' and '.$db->quoteName('#__avisohidrologico').'.tipo='.$catid);

    $db->setQuery($query);
    return $db->loadObjectList()[0];
}

function getArquivosByCatId2($id)
{

    if(empty($id)) return array();

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select('*');
    $query->from($db->quoteName('#__arquivo'));
    $query->where('catid='.$id);

    $db->setQuery($query);
    return $db->loadObjectList();
}


function getCategoryById2($id)
{

		if(empty($id)) return array();

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select('*');
    $query->from($db->quoteName('#__categories'));
    $query->where('id='.$id);

    $db->setQuery($query);
    return $db->loadObjectList()[0];
}

function preparaData2($str)
{
	//2017-07-20 19:58:59
	if(empty($str)) return '';
	$arrStr = explode(" ", $str);
	$hora = str_replace(":", "h", $arrStr[1]);
	$hora = substr($hora, 0, 5);
	$data = explode('-', $arrStr[0]);
	return array("$data[2]/$data[1]/$data[0]", "$hora");
}

function setTituloPagina2($titulo,$subtitulo,$mostraMenu)
{
    $saida_script = " document.addEventListener('DOMContentLoaded',function(){
            document.getElementById('titulo-pagina').innerHTML = '$titulo';
            document.getElementById('subtitulo-pagina').innerHTML  = '$subtitulo'; });";

    echo '<script>'.$saida_script.'</script>';

    if(empty($mostraMenu)){
        JFactory::getDocument()->addStyleDeclaration('#menu-governo{display:none}');
        echo '<style>#menu-governo{display:none}</style>';
    }

    JFactory::getDocument()->addScriptDeclaration($saida_script);
}

function isValid($id)
{
    //função depreciada
    
	if(empty($id)) return false;
	$db = JFactory::getDbo();
	$query = $db->getQuery(true);
	$query->select('*');
	$query->from($db->quoteName('#__aviso'));
	$query->where("inicio < now() and validade > now() and id = $id");
	$db->setQuery($query);
	$result = $db->loadObjectList();

	if(!empty($result)){
		return true;
	} else{
		return false;
	}
}

function isValidAvisoMeteorologico($id,$catid)
{
    if(empty($id)) return false;
    
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from($db->quoteName('#__avisometeorologico'));

    $query->where('id='.$id);
    $query->where('tipo='.$catid);
    $query->where('now() < validade');

    $db->setQuery($query);
    $result = $db->loadObjectList();

    if(!empty($result)){
        return true;
    } else{
        return false;
    }
}

function isValidAvisoHidrologico($id,$catid)
{
    if(empty($id)) return false;

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from($db->quoteName('#__avisohidrologico'));

    $query->where('id='.$id);
    $query->where('tipo='.$catid);
    $query->where('now() < validade');

    $db->setQuery($query);
    $result = $db->loadObjectList();

    if(!empty($result)){
        return true;
    } else{
        return false;
    }
}

function getAnexosMeteorologicosByAvisoId($id,$catid)
{

	if(empty($id)) return array();

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select('*');
    $query->from($db->quoteName('#__avisometeorologico_anexo'));
    $query->where('id_aviso='.$id);

    $db->setQuery($query);
    return $db->loadObjectList();
}

function getAnexosHidrologicosByAvisoId($id)
{

	if(empty($id)) return array();

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select('*');
    $query->from($db->quoteName('#__avisohidrologico_anexo'));
    $query->where('id_aviso='.$id);

    $db->setQuery($query);
    return $db->loadObjectList();
}
