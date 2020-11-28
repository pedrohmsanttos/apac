<?php defined( '_JEXEC' ) or die;

 function getCategory($id)
{
    if(empty($id)) return array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select($db->quoteName(array('id', 'title','alias','description','params','parent_id')));
    $query->from($db->quoteName('#__categories'));
    $query->where('id='.$id);

    $db->setQuery($query);

    $categoryList = $db->loadObjectList();

    $prms = json_decode($categoryList[0]->params);

    $categoryList[0]->image = $prms->image;
    $categoryList[0]->link = 'index.php?option=com_content&view=category&id='.$id;

    return $categoryList[0];
}

 function getCategoryChildren($id)
{
    if(empty($id)) return array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select($db->quoteName(array('id', 'title','alias','description','params','parent_id')));
    $query->from($db->quoteName('#__categories'));
    $query->where('parent_id='.$id);

    $db->setQuery($query);

    $categoryList = $db->loadObjectList();
    return $categoryList;
}

function getArticlesByCategory($id)
{
    if(empty($id)) return array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select($db->quoteName(array('id', 'title','alias','introtext','catid','state')));
    $query->from($db->quoteName('#__content'));
    $query->where('state=1 and catid='.$id);
    $query->order('ordering ASC');

    $db->setQuery($query);

    $categoryList = $db->loadObjectList();
    return $categoryList;
}

function getArticleById($id)
{
    if(empty($id)) return array();
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);

    $query->select($db->quoteName(array('id', 'title','alias','introtext')));
    $query->from($db->quoteName('#__content'));
    $query->where('id='.$id);

    $db->setQuery($query);

    $categoryList = $db->loadObjectList();
    return $categoryList[0];
}

function setTituloPagina($titulo,$subtitulo,$mostraMenu)
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
