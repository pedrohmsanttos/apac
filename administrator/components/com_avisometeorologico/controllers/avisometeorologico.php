<?php defined('_JEXEC') or die('Restricted access');

class AvisometeorologicoControllerAvisometeorologico extends JControllerForm
{

  public function save($data = array(), $key = 'id')
{

   $jinput = JFactory::getApplication()->input;
   $data   = $jinput->get('jform', null, 'raw');
   $avisometeorologicoCrllr = new AvisometeorologicoControllerAvisometeorologico();

    //file upload
   $uploadedFiles = $avisometeorologicoCrllr::makeUpload($_FILES['jform']);
   JRequest::setVar('jform', $data, 'post');
    
    if(empty($data['titulo'])          ||
       empty($data['tipo'])            ||
       empty($data['inicio'])          ||
       empty($data['conteudo'])        ||
       $data['conteudo'] == ''  ||
       empty($data['validade'])):

      $url = JRoute::_('index.php?option=com_avisometeorologico&view=avisometeorologico&layout=edit');
      JError::raiseError(500, 'Campos obrigatórios não preenchidos.');
      JFactory::getApplication()->redirect($url);

    elseif(strtotime($data['inicio']) > strtotime($data['validade'])):

      $url = JRoute::_('index.php?option=com_avisohidrologico&view=avisohidrologico&layout=edit');
      JError::raiseError(500, 'Data de inicio não pode ser menor que a validade.');
      JFactory::getApplication()->redirect($url);

    else:

        if(empty($data['id']))
        {

          unset($data['id']);
          $data['arquivo'] = $uploadedFiles;
          $avisometeorologicoCrllr::insertData($data);

          $url = JRoute::_('index.php?option=com_avisometeorologico&view=avisometeorologicos');
          JFactory::getApplication()->enqueueMessage('Cadastrado com sucesso!');
          JFactory::getApplication()->redirect($url);

        } else {

          $data['arquivo'] = $uploadedFiles;
          $avisometeorologicoCrllr::updateData($data);

          $url = JRoute::_('index.php?option=com_avisometeorologico&view=avisometeorologicos');
          JFactory::getApplication()->enqueueMessage('Editado com sucesso!');
          JFactory::getApplication()->redirect($url);

        }

    endif;

    return $return;
}

public function insertData($arr)
{
  $user = JFactory::getUser();
  $arr['ordering'] = (empty($arr['ordering'])) ? 0 : $arr['ordering'];
  $avisometeorologicoCrllr = new AvisometeorologicoControllerAvisometeorologico();
  $identificador_gerado    = $avisometeorologicoCrllr::generateIdentificador();


  $db    = JFactory::getDbo();
  $query = $db->getQuery(true);

  if(empty($arr['inicio'])){
    $arr['inicio'] = date("Y-m-d H:i:s");
  }

  if(empty($arr['validade'])){
    $arr['validade'] = date("Y-m-d H:i:s");
  }

  if(empty($arr['ordering']) || $arr['ordering'] == ''){
    $arr['ordering'] = 0;
  }

  $id_aviso = $avisometeorologicoCrllr::getAvisoLastId();

  $columns = array('published',
                   'titulo',
                   'tipo',
                   'associados',
                   'ordering',
                   'identificador',
                   'conteudo',
                   'tags',
                   'validade',
                   'inicio',
                   'descricao',
                   'created',
                   'regioes',
                  'user_id');

  $values = array($arr['published'],
                  $db->quote($arr['titulo']),
                  $db->quote($arr['tipo']),
                  $db->quote($arr['associados']),
                  $db->quote($arr['ordering']),
                  $db->quote($identificador_gerado),
                  $db->quote($arr['conteudo']),
                  $db->quote(implode(",",$arr['tags'])),
                  $db->quote($arr['validade']),
                  $db->quote($arr['inicio']),
                  $db->quote(substr($arr['descricao'], 0, 999)),
                  'NOW()',
                  $db->quote(implode(",",$arr['regioes'])),
                  $db->quote($user->id)
                  );

  $query->insert($db->quoteName('#__avisometeorologico'))
        ->columns($db->quoteName($columns))
        ->values(implode(',', $values));

  $db->setQuery($query);
  $db->execute();

  $contador = 0;

  foreach ($arr['arquivo'] as $arquivo_item) {

    $anexo['arquivo']  = $arquivo_item['arquivo'];
    $anexo['id_aviso'] = (int) $id_aviso + 1;
    $anexo['id_user']  = (int) JFactory::getUser()->get( 'id' );
    $anexo['titulo']   = @$arr['titulos'][$contador];
    if(empty($anexo['titulo'])) $anexo['titulo'] = $arquivo_item['arquivo'];
    $contador++;

    $avisometeorologicoCrllr->addAnexo($anexo);

  }


}

   public function updateData(&$arr)
  {
     $user = JFactory::getUser();
      $avisometeorologicoCrllr = new AvisometeorologicoControllerAvisometeorologico();
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      if(empty($arr['ordering']) || $arr['ordering'] == ''){
        $arr['ordering'] = 0;
      }

      $fields = array(
          $db->quoteName('published') . " = ". $arr['published'],
          $db->quoteName('titulo') . " =  ". $db->quote($arr['titulo']),
          $db->quoteName('tipo') . " =  ". $db->quote($arr['tipo']),
          $db->quoteName('associados') . " =  ". $db->quote($arr['associados']),
          $db->quoteName('ordering') . " =  ". $db->quote($arr['ordering']),
          $db->quoteName('conteudo') . " =  ". $db->quote($arr['conteudo']),
          $db->quoteName('validade') . " =  ". $db->quote($arr['validade']),
          $db->quoteName('inicio') . " =  ". $db->quote($arr['inicio']),
          $db->quoteName('descricao') . " =  ". $db->quote(substr($arr['descricao'], 0, 999)),
          $db->quoteName('tags') . " =  ". $db->quote(implode(",",$arr['tags'])),
          $db->quoteName('regioes') . " =  ". $db->quote(implode(",",$arr['regioes'])),
          $db->quoteName('user_id') . " =  ". $db->quote($user->id)
      );

      $conditions = array($db->quoteName('id') . ' = '. $arr['id']);

      $query->update($db->quoteName('#__avisometeorologico'))->set($fields)->where($conditions);
      $db->setQuery($query);
      $db->execute();

      $contador = 0;

      foreach ($arr['arquivo'] as $arquivo_item) {


        $anexo['arquivo']  = $arquivo_item['arquivo'];
        $anexo['id_aviso'] = (int) $arr['id'];
        $anexo['id_user']  = (int) JFactory::getUser()->get( 'id' );
        $anexo['titulo']   = @$arr['titulos'][$contador];

        if(empty($anexo['titulo'])) $anexo['titulo'] = $arquivo_item['arquivo'];
        $contador++;

        //adiciona os novos
        $avisometeorologicoCrllr->addAnexo($anexo);

      }

      //apaga os velhos
      if(! empty($arr['arquivos_deletados'])) {
        $arquivos_deletados_id_array = explode("*", $arr['arquivos_deletados']);

        foreach ($arquivos_deletados_id_array as $arquivo_deletado_id) {
          $avisometeorologicoCrllr->removeAnexo($arquivo_deletado_id);
        }

      }
       //atualiza os anexos 
      $anexosSalvos = $avisometeorologicoCrllr->getAnexosByIdArray($arr['id']);


      for ($i=0; $i < count($arr['titulo_old']); $i++) { 

        if($arr['titulos'][$i] != $arr['titulo_old'][$i]) {

          $avisometeorologicoCrllr->updateAnexoById($arr['anexo_id'][$i],$arr['titulos'][$i]);

        }
     }

  }

  public function generateIdentificador()
 {
    $firstHidro  = $this->getContadorHidrologicoIdentificador();
    $firstMeteo  = $this->getContadorMeteorologicoIdentificador();
    $v1 = explode("/", $firstHidro);
    $v2 = explode("/", $firstMeteo);
    $contador = $this->getMax($v1[0], $v2[0]);
    $contador++;
    $contador_com_zeros = str_pad($contador, 4, "0", STR_PAD_LEFT);
    return $contador_com_zeros.'/'.date("Y");
 }

  public function getMax($v1, $v2)
  {
    if($v1 < $v2){
      return $v2++;
    }
    
    return $v1++;
  }

 public function getContadorHidrologicoIdentificador()
{
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('identificador');
    $query->from($db->quoteName('#__avisohidrologico'));
    $query->where("date_part('year', created) = date_part('year', CURRENT_DATE)");
    $query->order('id DESC');
    $query->setLimit('1');
    $db->setQuery($query);

    $results = $db->loadObjectList();

    return $results[0]->identificador;
}

public function getContadorMeteorologicoIdentificador()
{

   $db = JFactory::getDbo();

   $query = $db->getQuery(true);
   $query->select('identificador');
   $query->from($db->quoteName('#__avisometeorologico'));
   $query->where("date_part('year', created) = date_part('year', CURRENT_DATE)");
   $query->order('id DESC');
   $query->setLimit('1');
   $db->setQuery($query);

   $results = $db->loadObjectList();

    return $results[0]->identificador;
}

public function addAnexo($anexo)
{
  $db    = JFactory::getDbo();
  $query = $db->getQuery(true);

  $columns = array('titulo',
                   'arquivo',
                   'created',
                   'id_aviso',
                   'tipo',
                   'id_user');

  $values = array($db->quote($anexo['titulo']),
                  $db->quote($anexo['arquivo']),
                  'NOW()',
                  $anexo['id_aviso'],
                  1,
                  $anexo['id_user']
                  );

  $query->insert($db->quoteName('#__avisometeorologico_anexo'))
        ->columns($db->quoteName($columns))
        ->values(implode(',', $values));

  $db->setQuery($query);
  $db->execute();
}

public function removeAnexo($anexo_id)
{
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);

  $conditions = array(
      $db->quoteName('id') . ' = ' . $anexo_id
  );

  $query->delete($db->quoteName('#__avisometeorologico_anexo'));
  $query->where($conditions);
  $db->setQuery($query);

  $result = $db->execute();
}

public function makeUpload(&$files)
{
  jimport('joomla.filesystem.file');
  $upload_dir = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR;

  $anexoFile = array();

  for ($i=0; $i < count($files['name']['arquivo']); $i++) {

    $filename = $files['name']['arquivo'][$i];
    $file_ext = JFile::getExt($files['name']['arquivo'][$i]);
    $filename = JFile::makeSafe($files['name']['arquivo'][$i]);
    $filename_tmp = $files['tmp_name']['arquivo'][$i];
    $current_timestmp  = getdate()[0];

    $tituloArquivo = $data['arquivo'][$i]['titulo'];

    if ( $filename != '' ) {

      $filepath = JPath::clean($upload_dir);
      if (JFile::upload($filename_tmp, $filepath.$current_timestmp.'_'.$filename)) {

            $user =& JFactory::getUser();
            $userId = $user->get( 'id' );

            $arrayAnexoFile = ["titulo"   => $tituloArquivo,
                               "arquivo"  => $current_timestmp.'_'.$filename,
                               "created"  => date('Y-m-d H:i:s'),
                               "id_aviso" => "",
                               "id_user"  => $userId,
                               "tipo"     => 1];

            array_push($anexoFile, $arrayAnexoFile);

      } else {
            JError::raiseError(500, 'Erro ao fazer o upload do arquivo.');
            $url = JRoute::_('index.php?option=com_avisometeorologico&view=avisometeorologicos');
            JFactory::getApplication()->redirect($url);
      }

    }

  }

  return $anexoFile;

}

public function getAvisoLastId()
{

   $db = JFactory::getDbo();
   $query = $db->getQuery(true);
   $query->select("id");
   $query->from($db->quoteName('#__avisometeorologico'));
   $query->order('id desc');
   $query->group('id');
   $db->setQuery($query);
   $results = $db->loadObjectList();

   return $results[0]->id;
}

function getAnexosById($id)
{

  if(empty($id)) return '';
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('*');
  $query->from($db->quoteName('#__avisometeorologico_anexo'));
  $query->where("id_aviso = $id");
  $db->setQuery($query);
  $anexos = $db->loadObjectList();
  return $anexos;

}

function getAnexosByIdArray($id)
{

  if(empty($id)) return '';
  $db = JFactory::getDbo();
  $query = $db->getQuery(true);
  $query->select('*');
  $query->from($db->quoteName('#__avisometeorologico_anexo'));
  $query->where("id_aviso = $id");
  $db->setQuery($query);
  $anexos = $db->loadAssocList();
  return $anexos;

}

function updateAnexoById($id,$titulo)
{
  
  if(empty($id) || empty($titulo)) return array();


  $db = JFactory::getDbo();
  $query = $db->getQuery(true);

  $fields = array(
      $db->quoteName('titulo') . " =  ". $db->quote($titulo)
  );

  $conditions = array($db->quoteName('id') . ' = '. $id);

  $query->update($db->quoteName('#__avisometeorologico_anexo'))->set($fields)->where($conditions);
  $db->setQuery($query);
  $db->execute();

}


}
