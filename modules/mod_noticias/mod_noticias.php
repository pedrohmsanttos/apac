<?php
// No direct access
defined('_JEXEC') or die;
require_once('helper.php');

$catPaiId  = ModNoticiasHelper::getParams()->categoria;
$subCatIds = ModNoticiasHelper::getSubCategoryChildrenIds($catPaiId);

$noticias = array();

foreach ($subCatIds as $sbCatId ) {
	foreach (ModNoticiasHelper::getActiveArticlesByCatId($sbCatId->id) as $arts ) {
		array_push($noticias, $arts);
	}
}

require JModuleHelper::getLayoutPath('mod_noticias');
