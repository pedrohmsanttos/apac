<?php
 
$acao = $_POST['acao'];
$retorno = array();
 
if(trim($acao) == "baixar"){
    $retorno['tipo'] = "success";
    $retorno['url'] = "http://localhost/apac/uploads/editais/36-2018/Manual do usuário.docx";
}
 
echo json_encode($retorno);
die;