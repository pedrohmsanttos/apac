<?php

function setTituloPaginaFromComponent($titulo,$subtitulo,$mostraMenu)
{
    $saida_script = " document.addEventListener('DOMContentLoaded',function(){
            document.getElementById('titulo-pagina').innerHTML = '$titulo';
            document.getElementById('subtitulo-pagina').innerHTML  = '$subtitulo'; });";

    echo '<script>'.$saida_script.'</script>';

    if(empty($mostraMenu)){
        JFactory::getDocument()->addStyleDeclaration('#menu-governo{display:none}');
        echo '<style>#menu-governo{display:none}</style>';
    } 

    JFactory::getDocument()->addScriptDeclaration($saida);
}
function getSecretaria($id){
	$db = JFactory::getDbo(); 
	$query = $db->getQuery(true); 
	$query
	    ->select('*')
	    ->from($db->quoteName('#__secretaria'))
	    ->where("id = $id");   
	 
	$db->setQuery($query);	 
	$results = $db->loadObjectList();
	return $results[0];
}

function getSecretario($id){
	$db = JFactory::getDbo(); 
	$query = $db->getQuery(true);
 	
	$query
    	->select('*')
    	->from($db->quoteName('#__secretario'))
    	->where("id = $id");   
 
	$db->setQuery($query);
	$results = $db->loadObjectList();
	return $results[0];
}