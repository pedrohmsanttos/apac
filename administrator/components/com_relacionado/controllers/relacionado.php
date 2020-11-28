<?php

// No direct access to this file
defined('_JEXEC') or die('Restricted access');


class RelacionadoControllerRelacionado extends JControllerForm
{

	 public function save($data = array(), $key = 'id')
	{

	   $jinput = JFactory::getApplication()->input;
	   $data = $jinput->get('jform', null, 'raw');
	   $relacionadoCrllr = new RelacionadoControllerRelacionado();

	    //file upload
	   $uploadedFiles = $relacionadoCrllr::makeUpload($_FILES['jform'],$data);

	   JRequest::setVar('jform', $data, 'post');


	    if(empty($data['titulo']) ||
	       empty($data['artigos'])   ||
	       empty($data)):

	      $url = JRoute::_('index.php?option=com_relacionado&view=relacionado&layout=edit');
	      JError::raiseError(500, 'Campos obrigatórios não preenchidos.');
	      JFactory::getApplication()->redirect($url);

	    else:
			
	        if(empty($data['id']))
	        {
	          unset($data['id']);
			  $data['arquivo'] = $uploadedFiles;
			  //var_dump($data);die();
	          $relacionadoCrllr::insertData($data);

	          $url = JRoute::_('index.php?option=com_relacionado&view=relacionados');
	          JFactory::getApplication()->enqueueMessage('Cadastrado com sucesso!');
	          JFactory::getApplication()->redirect($url);

	        } else {
				$arrFiles = $data['old_arquivos'];
				//var_dump($data);die();
				foreach($arrFiles as $arrValidate){
					if($titulo == ''){
						// JError::raiseError(500, "O campo Arquivo não pode está vazio!");
					}
				}
				$arrMarca = [];
				for($i = 0; $i < count($arrFiles); ++$i)
					$arrMarca[$i] = 0;
				foreach ($uploadedFiles as $arquivo_add) {
					foreach ($arrFiles as $key=>$arquivo_old) {
						$titulo = $arquivo_add['titulo'];
						$termo  = $arquivo_old;

						if(strpos($titulo, $termo) && $arrMarca[$key] == 0){
							$arrFiles[$key] = $titulo;
							$arrMarca[$key] = 1;
						}
					}
				}
				$data['arquivo'] = $arrFiles;
				$relacionadoCrllr::changeData($data['id']);
				$relacionadoCrllr::updateData($data);
  
				$url = JRoute::_('index.php?option=com_relacionado&view=relacionados');
				JFactory::getApplication()->enqueueMessage('Cadastrado com sucesso!');
				JFactory::getApplication()->redirect($url);

	        }

	    endif;

	    return $return;
	}

	public function insertData($arr, $edit = 'not', $id = 0)
	{
		$relacionadoCrllr = new RelacionadoControllerRelacionado();
		
		if($edit == 'not'){
			$db    = JFactory::getDbo();
			$query = $db->getQuery(true);
			$columns = array('published',
							'created',
							'titulo',
							'ordering',
							'user_id',
							'artigos');
			$values = array(1,
							'NOW()',
							$db->quote($arr['titulo']),
							//$db->quote('*'.implode("*",$arr['artigos']).'*')
							$db->quote($arr['ordering']),
							JFactory::getUser()->get('id'),
							$db->quote(implode(",",$arr['artigos']))
							);
			$query->insert($db->quoteName('#__relacionado'))
					->columns($db->quoteName($columns))
					->values(implode(',', $values));
			$db->setQuery($query);
			$db->query();
			$resultID = $db->insertid();
		}
		
		$id_relacionado_ultimo 		= $resultID;
		$contador 					= 0;
		$array_anexos_com_arquivos 	= array(); 
		$array_anexos_total 		= array(); 
		$array_anexos_sem_arquivos 	= array(); 

		foreach ($arr['arquivo'] as $arquivo_item) 
		{
			$anexo['id_relacionado'] = (int) $id_relacionado_ultimo;
			$anexo['id_user']   = (int) JFactory::getUser()->get( 'id' );
			$anexo['titulo']    = @$arr['titulos'][$contador];
			$anexo['parent_id'] = @$arr['parent_id'][$contador];
			$anexo['tipo']      = @$arr['tipo'][$contador];
			$anexo['level_id']  = explode('-',@$arr['nivel'][$contador])[0];
			$anexo['level_parent'] = explode('-',@$arr['nivel'][$contador])[1];
			
			if(@$arr['tipo'][$contador] == 1)
			{
				$anexo['arquivo']  = $arquivo_item;
				
				if(is_array($arquivo_item)) $anexo['arquivo']  = $arquivo_item['titulo'];
			}
			else
			{
				$anexo['arquivo']  = @$arr['url'][$contador];
			}
			
  	    	$contador++;	

			array_push($array_anexos_com_arquivos, $anexo);
			//var_dump($anexo);die();
			$relacionadoCrllr->addAnexo($anexo);
	  	}
	}

   public function updateData($arr)
   {


      $relacionadoCrllr = new RelacionadoControllerRelacionado();
      $db = JFactory::getDbo();
      $query = $db->getQuery(true);

      $fields = array(
          $db->quoteName('titulo') . " =  ". $db->quote($arr['titulo']),
		  $db->quoteName('artigos') . " =  ". $db->quote(implode(",",$arr['artigos'])),
		  $db->quoteName('ordering') . " =  ". $db->quote($arr['ordering'])
          //$db->quoteName('artigos') . " =  ". $db->quote('*'.implode("*",$arr['artigos']).'*')
      );
	  // implode(",",$arr['artigos']) | '*'.implode("*",$arr['artigos']).'*'
      $conditions = array($db->quoteName('id') . ' = '. $arr['id']);

      $query->update($db->quoteName('#__relacionado'))->set($fields)->where($conditions);
      $db->setQuery($query);
      $db->execute();

      //adiciona novos

      $contador=0;

      foreach ($arr['arquivo'] as $arquivo_item) {
		
		$anexo['id_relacionado'] = (int) $arr['id'];
		$anexo['id_user']   = (int) JFactory::getUser()->get( 'id' );
		$anexo['titulo']    = @$arr['titulos'][$contador];
		$anexo['parent_id'] = @$arr['parent_id'][$contador];
		$anexo['tipo']      = @$arr['tipo'][$contador];
		$anexo['level_id']  = explode('-',@$arr['nivel'][$contador])[0];
		$anexo['level_parent'] = explode('-',@$arr['nivel'][$contador])[1];

		if(@$arr['tipo'][$contador] == 1)
		{
			$anexo['arquivo']  = $arquivo_item;

			if(is_array($arquivo_item)) $anexo['arquivo']  = 'Sem arquivo';
		}
		else
		{
			$anexo['arquivo']  = @$arr['url'][$contador];
		}
        
  	    $contador++;
		
  	    $relacionadoCrllr->addAnexo($anexo);

      }

  }

  public function addAnexo($anexo)
{

  try
  {

  	$db    = JFactory::getDbo();
  	$query = $db->getQuery(true);

  	$columns = array('titulo',
    	               'arquivo',
    	               'created',
    	               'id_relacionado',
    	               'parent_id',
    	               'level_id',
    	               'level_parent',
    	               'tipo',
    	               'id_user');

  	$values = array($db->quote($anexo['titulo']),
    	              $db->quote($anexo['arquivo']),
    	              'NOW()',
    	              (int) $anexo['id_relacionado'],
    	              (int) $anexo['parent_id'],
    	              (int) $anexo['level_id'],
    	              (int) $anexo['level_parent'],
    	              (int) $anexo['tipo'],
    	              (int) $anexo['id_user']
  	              );


  	$query->insert($db->quoteName('#__relacionado_anexo'))
    	    ->columns($db->quoteName($columns))
    	    ->values(implode(',', $values));

  	$db->setQuery($query);
  	$db->execute();

  }

  	catch(Exception $e)

  {

  	JError::raiseError(500, $e->getMessage());

  }

}

	public function removeAnexo($anexo_id)
	{
	  $db = JFactory::getDbo();
	  $query = $db->getQuery(true);

	  $conditions = array(
	      $db->quoteName('id') . ' = ' . $anexo_id
	  );

	  $query->delete($db->quoteName('#__relacionado_anexo'));
	  $query->where($conditions);
	  $db->setQuery($query);

	  $result = $db->execute();
	}


	public function changeData($id)
	{
	  $db = JFactory::getDbo();
	  $query = $db->getQuery(true);

	  $conditions = array(
	      $db->quoteName('id_relacionado') . ' = ' . $id
	  );

	  $query->delete($db->quoteName('#__relacionado_anexo'));
	  $query->where($conditions);
	  $db->setQuery($query);

	  $result = $db->execute();
	}

	public function makeUpload(&$files,&$data)

	{
	  jimport('joomla.filesystem.file');
	  $upload_dir = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR;

	  $anexoFile = array();

	  // for ($i=0; $i < count($files['name']['arquivo']); $i++) {
	  for ($i=0; $i < count($data['titulos']); $i++) {

	    $filename = $files['name']['arquivo'][$i];
	    $file_ext = JFile::getExt($files['name']['arquivo'][$i]);
	    $filename = JFile::makeSafe($files['name']['arquivo'][$i]);
	    $filename_tmp = $files['tmp_name']['arquivo'][$i];
	    $current_timestmp  = getdate()[0];

	    if ( $filename != '' ) {

	      //adiciona com arquivo

	      $filepath = JPath::clean($upload_dir);
	      if (JFile::upload($filename_tmp, $filepath.$current_timestmp.'_'.$filename)) {

	            $user =& JFactory::getUser();
	            $userId = $user->get( 'id' );

	            $arrayAnexoFile = ["titulo"   => $current_timestmp.'_'.$filename,
	                               "arquivo"  => $current_timestmp.'_'.$filename,
	                               "created"  => date('Y-m-d H:i:s'),
	                               "id_relacionado" => "",
	                               "id_user"  => $userId,
	                               "tipo"     => 1];

	            array_push($anexoFile, $arrayAnexoFile);

	      } else {
	            JError::raiseError(500, 'Erro ao fazer o upload do arquivo.');
	      }

	    } else if(empty($data['id'])) {

	    		//adiciona sem arquivo

	    		$user =& JFactory::getUser();
	            $userId = $user->get( 'id' );

	            $arrayAnexoFile = ["titulo"   => $data['titulos'][$i],
	                               "arquivo"  => 'Sem arquivo',
	                               "created"  => date('Y-m-d H:i:s'),
	                               "id_relacionado" => $data['id'],
	                               "id_user"  => $userId,
	                               "tipo"     => 1];

	            array_push($anexoFile, $arrayAnexoFile);

	    }

	  }


	  return $anexoFile;

	}

 	public function getRelacionadoLastId()
	{

	   $db = JFactory::getDbo();
	   $query = $db->getQuery(true);
	   $query->select("id");
	   $query->from($db->quoteName('#__relacionado'));
	   $query->order('id desc');
	   $query->group('id');
	   $db->setQuery($query);
	   $results = $db->loadObjectList();

	   return $results[0]->id;
	}

	public function getAnexosById($id)
	{

	  if(empty($id)) return '';
	  $db = JFactory::getDbo();
	  $query = $db->getQuery(true);
	  $query->select('*');
	  $query->from($db->quoteName('#__relacionado_anexo'));
	  $query->where("id_relacionado = $id");
	  $db->setQuery($query);
	  $anexos = $db->loadObjectList();
	  return $anexos;

	}

}