<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

class AvisoControllerAviso extends JControllerForm
{

  public function save($data = array(), $key = 'id')
{

    jimport('joomla.filesystem.file');

    $jinput = JFactory::getApplication()->input;
    $data  = $jinput->get('jform', null, 'raw');
    JRequest::setVar('jform', $data, 'post');

    $avisoCrllr = new AvisoControllerAviso();

    if(empty($data['id'])){
      unset($data['id']);
      $avisoCrllr::insertData($data);
    } else{
      $avisoCrllr::updateData($data);
    }

    return $return;
}

public function insertData($arr)
{
  $avisoCrllr = new AvisoControllerAviso();
  $identificador_gerado = $avisoCrllr::generateIdentificador();


  $db    = JFactory::getDbo();
  $query = $db->getQuery(true);

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
                   'regioes');

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
                  $db->quote(implode(",",$arr['regioes']))
                  );

  $query->insert($db->quoteName('#__aviso'))
        ->columns($db->quoteName($columns))
        ->values(implode(',', $values));

  $db->setQuery($query);
  $db->execute();

  $url = JRoute::_('index.php?option=com_aviso&view=avisos');
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
          $db->quoteName('tipo') . " =  ". $db->quote($arr['tipo']),
          $db->quoteName('associados') . " =  ". $db->quote($arr['associados']),
          $db->quoteName('ordering') . " =  ". $db->quote($arr['ordering']),
          $db->quoteName('conteudo') . " =  ". $db->quote($arr['conteudo']),
          $db->quoteName('validade') . " =  ". $db->quote($arr['validade']),
          $db->quoteName('inicio') . " =  ". $db->quote($arr['inicio']),
          $db->quoteName('descricao') . " =  ". $db->quote(substr($arr['descricao'], 0, 999)),
          $db->quoteName('tags') . " =  ". $db->quote(implode(",",$arr['tags'])),
          $db->quoteName('regioes') . " =  ". $db->quote(implode(",",$arr['regioes']))
      );

      $conditions = array($db->quoteName('id') . ' = '. $arr['id']);

      $query->update($db->quoteName('#__aviso'))->set($fields)->where($conditions);
      $db->setQuery($query);
      $db->execute();

      $url = JRoute::_('index.php?option=com_aviso&view=avisos');
      JFactory::getApplication()->enqueueMessage('Editado com sucesso!');
      JFactory::getApplication()->redirect($url);
  }
  public function generateIdentificador()
 {

     $db = JFactory::getDbo();
     $query = $db->getQuery(true);
     $query->select('count(id)');
     $query->from($db->quoteName('#__aviso'));
     $query->where("date_part('year', created) = date_part('year', CURRENT_DATE)");
     $db->setQuery($query);

     $results = $db->loadObjectList();
     $contador = (int) $results[0]->count + 1;


     $contador_com_zeros = str_pad($contador, 4, "0", STR_PAD_LEFT);

     return $contador_com_zeros.'/'.date("Y");
 }

}
