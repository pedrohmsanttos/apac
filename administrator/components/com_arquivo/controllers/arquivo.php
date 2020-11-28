<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class ArquivoControllerArquivo extends JControllerForm
{
    public function save($data = array(), $key = 'id')
  {

   jimport('joomla.filesystem.file');

   $jinput = JFactory::getApplication()->input;
   $upload_dir = JPATH_ROOT.DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.'media'.DIRECTORY_SEPARATOR;

   $data  = $jinput->get('jform', null, 'raw');
   $file = $_FILES['jform'];
   $file_ext = JFile::getExt($file['name']['arquivo']);
   $filename = JFile::makeSafe($file['name']['arquivo']);
   $filename_tmp = $file['tmp_name']['arquivo'];
   $current_timestmp  = getdate()[0];

   JRequest::setVar('jform', $data, 'post');


   if ( $filename != '' ) {

       $filepath = JPath::clean($upload_dir);
       if (JFile::upload($filename_tmp, $filepath.$current_timestmp.'_'.$filename)) {
             $data['arquivo'] = $current_timestmp.'_'.$filename;
       } else {
             JError::raiseError(500, 'Erro ao fazer o upload do arquivo.');
       }
   }

    $arqCrllr = new ArquivoControllerArquivo();
// var_dump($data);die;
    if(empty($data['id'])){
      unset($data['id']);
      $arqCrllr::insertData($data);
    } else{
      // var_dump($data);die;
      $arqCrllr::updateData($data);
    }

    return $return;
  }

  public function insertData($arr)
  {

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $columns = array('published',
                     'titulo',
                     'descricao',
                     'arquivo',
                     'formato',
                     'link',
                     'linkonly',
                     'catid',
                     'created');

    $values = array($arr['published'],
                    $db->quote($arr['titulo']),
                    $db->quote($arr['descricao']),
                    $db->quote($arr['arquivo']),
                    $db->quote($arr['formato']),
                    $db->quote($arr['link']),
                    $db->quote($arr['linkonly']),
                    $arr['catid'],
                    'NOW()'
                    );

    $query
        ->insert($db->quoteName('#__arquivo'))
        ->columns($db->quoteName($columns))
        ->values(implode(',', $values));

    $db->setQuery($query);
    $db->execute();

    $url = JRoute::_('index.php?option=com_arquivo&view=arquivos');
    JFactory::getApplication()->enqueueMessage('Cadastrado com sucesso!');
    JFactory::getApplication()->redirect($url);
  }

   public function updateData($arr)
  {

    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $fields = array(
        $db->quoteName('published') . " = ". $arr['published'],
        $db->quoteName('titulo') . " =  ". $db->quote($arr['titulo']),
        $db->quoteName('descricao') . " =  ". $db->quote($arr['descricao']),
        $db->quoteName('arquivo') . " =  ". $db->quote($arr['arquivo']),
        $db->quoteName('formato') . " =  ". $db->quote($arr['formato']),
        $db->quoteName('link') . " =  ". $db->quote($arr['link']),
        $db->quoteName('linkonly') . " =  ". $db->quote($arr['linkonly']),
        $db->quoteName('catid') . " = ". $arr['catid']
    );

    // $conditions = array($db->quoteName('id') . ' = '. $arr['id']);
    $conditions = array('id'.' = '. $arr['id']);

    $query->update($db->quoteName('#__arquivo'))->set($fields)->where($conditions);
    $db->setQuery($query);
    $db->execute();

    $url = JRoute::_('index.php?option=com_arquivo&view=arquivos');
    JFactory::getApplication()->enqueueMessage('Editado com sucesso!');
    JFactory::getApplication()->redirect($url);
  }
}
