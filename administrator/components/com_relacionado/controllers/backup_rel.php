<?php 

for ($i=0; $i < count($files['name']['arquivo']); $i++) {

	    $filename = $files['name']['arquivo'][$i];
	    $file_ext = JFile::getExt($files['name']['arquivo'][$i]);
	    $filename = JFile::makeSafe($files['name']['arquivo'][$i]);
	    $filename_tmp = $files['tmp_name']['arquivo'][$i];
	    $current_timestmp  = getdate()[0];

	    if ( $filename != '' ) {

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

	    }

	  }