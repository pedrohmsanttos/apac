<?php
// No direct access
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';
require_once dirname(__FILE__) . '/Mobile_Detect.php';
$document  = JFactory::getDocument();
$detectMob = new Mobile_Detect2;

JHtml::_('jquery.framework', false);
$document->addScript('modules/mod_bdslideshow/tmpl/js/unslider-min.js');
$document->addScript('modules/mod_bdslideshow/tmpl/js/mod_destcarr.js');
$document->addStyleSheet('modules/mod_bdslideshow/tmpl/css/unslider-dots.css');
$document->addStyleSheet('modules/mod_bdslideshow/tmpl/css/unslider.css');

/* Big Banner */
$bigBanner = new StdClass;
$bigBanner->category_id    = $params->get('big_banner_category');
$order                     = $params->get('ordenacao');
$bigBanner->artigos        = modBannerDestaqueSlideshowHelper::getFeaturedArticlesByCategory($bigBanner->category_id, $order);
$bigBanner->category_title = "Notícias";//modBannerDestaqueSlideshowHelper::getCategory($bigBanner->category_id)->title;
$bigBanner->category_alias = "noticias";//modBannerDestaqueSlideshowHelper::getCategory($bigBanner->category_id)->alias;

/* Left Banner*/

$left_banner_article_id          = $params->get('left_banner_article');
$left_banner_article_description = modBannerDestaqueSlideshowHelper::getParams()->left_banner_description;

$left_banner_article          = modBannerDestaqueSlideshowHelper::getLastestArticlesFromCategory($left_banner_article_id);
$left_banner_article->link    = modBannerDestaqueSlideshowHelper::getLink($left_banner_article->id,$bigBanner->category_alias);
$left_banner_article->image   = json_decode($left_banner_article->images)->image_intro;
$left_banner_article_category = modBannerDestaqueSlideshowHelper::getCategory($left_banner_article->catid);
$publish_left_banner          = ($params->get('left_banner_show')) ? 1 : 0;

/* Right Banner*/
$right_banner_article_id          = $params->get('right_banner_article');
$right_banner_article_description = modBannerDestaqueSlideshowHelper::getParams()->right_banner_description;
$right_banner_article_description = modBannerDestaqueSlideshowHelper::getParams()->right_banner_description;
$right_banner_article->catid      = modBannerDestaqueSlideshowHelper::getParams()->catid;

$right_banner_article          = modBannerDestaqueSlideshowHelper::getLastestArticlesFromCategory($right_banner_article_id);
$right_banner_article->link    = modBannerDestaqueSlideshowHelper::getLink($right_banner_article_id,$bigBanner->category_alias);
$right_banner_article->image   = json_decode($right_banner_article->images)->image_intro;
$right_banner_article_category = modBannerDestaqueSlideshowHelper::getCategory($right_banner_article->catid);
$publish_right_banner          = ($params->get('right_banner_show')) ? 1 : 0;

require JModuleHelper::getLayoutPath('mod_bdslideshow');
