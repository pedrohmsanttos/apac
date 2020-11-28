<?php defined( '_JEXEC' ) or die;

require_once 'Mobile_Detect.php';
require_once 'functions.php';


$detect = new Mobile_Detect;

// variables
$app   	   = JFactory::getApplication();
$doc       = JFactory::getDocument();
$menu      = $app->getMenu();
$active    = $app->getMenu()->getActive();


// $itemID=$active->itemid;

// var_dump($itemID,$active);die;
$params    = $app->getParams();
$pageclass = $params->get('pageclass_sfx');
$tpath     = $this->baseurl.'/templates/'.$this->template;

$config    = JFactory::getConfig();
$sitename  = $config->get( 'sitename' );

// page tittle
$active = JFactory::getApplication()->getMenu()->getActive();

if(! empty($active->title)) {
	$pagetitle = $sitename.' - '.$active->title;
	$active_alias = $active->alias;
} else {
	$pagetitle = $sitename;
	$active_alias = '';
}

//flag pra controlar se aparece ou não painel de navegação
$submenu = false;

$input=Jfactory::getApplication()->input;
if($input->getCmd('option')=='com_content'
&& $input->getCmd('view')=='article' && ! empty($input->getInt('id'))){

	$db=JFactory::getDbo();
	$db->setQuery('select catid from #__content where id='.$input->getInt('id'));
	$catid=$db->loadResult();

	$categ = getCategory($catid); //subcateg
	//pegar as categorias filhas
	if($categ->parent_id == '1') {

		$submenu = true;
		$categPai = $categ;
		$categFilhos = getCategoryChildren($catid);

	} else {
		$submenu = false;
		$categPai = getCategory($categ->parent_id);

		$categoriaSemSubMenu = $categPai;

	}

		$categFilhos = getCategoryChildren($categ->id);
		$artigo      = getArticleById($input->getInt('id'));

} else {

	$categoriaSemSubMenu =  $app->getMenu()->getActive();

}


//carrega artigo
$id = $input->getInt('id');
$article = JTable::getInstance('content');
$article->load($id);

$mostraNavegacao = json_decode( $article->attribs)->show_item_navigation;

if($mostraNavegacao == '0'){
	$mostraNavegacao = false;
} elseif($mostraNavegacao == '1') {
	$mostraNavegacao = true;
} else {
	$mostraNavegacao = true;
}

// site description
$sitedescription = $doc->getMetaData("description");

//metakeywords
$sitemetakeywords = $doc->_metaTags["name"]["keywords"];

//base url e site base
$baseurl  = $doc->baseurl;
$sitebase = $doc->base;

//body class
$bodyclass = (($menu->getActive() == $menu->getDefault()) ? ('front') : ('site')).' '.$active_alias.' '.$pageclass;

// generator tag
$this->setGenerator(null);

// template js
// $doc->addScript($tpath.'/js/jquery-3.2.0.min.js');
//carrega jquery com no conflict
JHtml::_('jquery.framework',false);
$doc->addScript($tpath.'/js/logic.js');
// $doc->addScript($tpath.'/js/scripts.js');

// template css
// $doc->addStyleSheet($tpath.'/css/template.css.php');
$doc->addStyleSheet($tpath.'/css/template.css');
$doc->addStyleSheet($tpath.'/css/contrast.css');
