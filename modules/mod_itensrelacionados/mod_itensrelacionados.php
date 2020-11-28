<?php
defined('_JEXEC') or die; require_once 'helper.php';

$catid  = $params->get('categoria');
$tipo   = $params->get('tipo');
$limite = $params->get('limite');

if(!empty($tipo) || !empty($catid))
{
  /*
  <option value="1">Avisos</option>
  <option value="2">Informes</option>
  <option value="3">Notícias</option>
  <option value="4">licitações</option>
  <option value="5">Arquivos</option>
  */
  switch ($tipo) {
      case 1:
        $itensRelacionados    = ModItensRelacionadosHelper::getAvisoItems($catid);
        $itensRelacionadosCat = new stdClass;
        $itensRelacionadosCat->title = "Avisos";
        break;

      case 3:
        $itensRelacionados    = ModItensRelacionadosHelper::getArticlesItems($catid);
        $itensRelacionadosCat = ModItensRelacionadosHelper::getCategoryById($catid);
        break;

      case 5:
        $itensRelacionados    = ModItensRelacionadosHelper::getArquivoItems($catid);
        $itensRelacionadosCat = ModItensRelacionadosHelper::getCategoryById($catid);
        break;

      default:
        $itensRelacionados    = ModItensRelacionadosHelper::getArquivoItems($catid);
        $itensRelacionadosCat = ModItensRelacionadosHelper::getCategoryById($catid);
        break;

  }

  if(! empty($limite)){
    $limite--;
    if($limite <= 0) $limite = 1;
  } else {
    $limite = 4;
  }

  $itensRelacionados = array_slice($itensRelacionados,0,$limite);
  require JModuleHelper::getLayoutPath('mod_itensrelacionados');
}
