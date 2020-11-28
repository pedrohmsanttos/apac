<?php

defined('_JEXEC') or die;

function getCategorys()
{
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select($db->quoteName(array('id', 'title','alias','description','params','parent_id')));
    $query->from($db->quoteName('#__categories'));
    $query->where('extension=\'com_informehidrologico\' and published = 1');
    $query->order('lft ASC');
    $db->setQuery($query);
    $categoryList = $db->loadObjectList();
    return $categoryList;
}

function mountItensPerCat($id, $limit)
{
    $db = JFactory::getDbo();
    $query = $db->getQuery(true);
    $query->select('*');
    $query->from($db->quoteName('#__informehidrologico'));
    $query->where('tipo=\''.$id.'\' and state = 1');
    $query->setLimit($limit);
    $query->order('publicacao DESC');
    $db->setQuery($query);
    $arquivos = $db->loadObjectList();
    return $arquivos;
}

function getItens($catis, $limit = 4)
{
    if(empty($catis)) return array();

    $arr =  array();
    
    for($index = 0; $index < count($catis); ++$index)
    {
        $ojjTmp          = new stdClass();
        $ojjTmp->id      = $catis[$index]->id;
        $ojjTmp->itens   = mountItensPerCat($catis[$index]->id, $limit);
        $ojjTmp->titulo  = $catis[$index]->title;
        if(count($ojjTmp->itens))   array_push($arr, $ojjTmp);
    }

    return $arr;
}