<?php
// No direct access
defined('_JEXEC') or die;

$categoria_noticia = $params->get('categoria_noticia');

$db = JFactory::getDbo();
$query = $db->getQuery(true);
$query->select($db->quoteName(array('id', 'title', 'alias','parent_id','path')));
$query->from($db->quoteName('#__categories'));
$query->where("extension like 'com_content' and published = 1");
$query->order('lft ASC');
$db->setQuery($query);
$categories = $db->loadObjectList();
//noticias/9-noticias/seguranca
foreach ($categories as $cat) {

	$catPath = explode('/', $cat->path)[0];

	if($cat->parent_id != '1'){
		$cat->link = $catPath.'/'.$cat->id.'-'.$catPath.'/'.$cat->alias;
	} else {
		$cat->link = $catPath;
	}

}

require JModuleHelper::getLayoutPath('mod_menucategorias');
