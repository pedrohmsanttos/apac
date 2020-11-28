<?php
// No direct access
defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';

/* Big Banner */
$big_banner_article_id          = modBannerDestaqueHelper::getParams()->big_banner_article;
$big_banner_article_description = modBannerDestaqueHelper::getParams()->big_banner_description;

$big_banner_article             = modBannerDestaqueHelper::getArticle($big_banner_article_id);
$big_banner_article->link       = modBannerDestaqueHelper::getLink($big_banner_article_id);
$big_banner_article->image      = modBannerDestaqueHelper::getParams()->big_banner_image;
$big_banner_article_category    = modBannerDestaqueHelper::getCategory($big_banner_article->catid);

/* Left Banner*/ 

$left_banner_article_id          = modBannerDestaqueHelper::getParams()->left_banner_article;
$left_banner_article_description = modBannerDestaqueHelper::getParams()->left_banner_description;

$left_banner_article             = modBannerDestaqueHelper::getArticle($left_banner_article_id);
$left_banner_article->link       = modBannerDestaqueHelper::getLink($left_banner_article_id);
$left_banner_article->image      = modBannerDestaqueHelper::getParams()->left_banner_image;
$left_banner_article_category    = modBannerDestaqueHelper::getCategory($left_banner_article->catid);
$publish_left_banner             = (modBannerDestaqueHelper::getParams()->left_banner_show) ? 1 : 0;

/* Right Banner*/ 
$right_banner_article_id          = modBannerDestaqueHelper::getParams()->right_banner_article;
$right_banner_article_description = modBannerDestaqueHelper::getParams()->right_banner_description;

$right_banner_article             = modBannerDestaqueHelper::getArticle($right_banner_article_id);
$right_banner_article->link       = modBannerDestaqueHelper::getLink($right_banner_article_id);
$right_banner_article->image      = modBannerDestaqueHelper::getParams()->right_banner_image;
$right_banner_article_category    = modBannerDestaqueHelper::getCategory($right_banner_article->catid);
$publish_right_banner             = (modBannerDestaqueHelper::getParams()->right_banner_show) ? 1 : 0;

require JModuleHelper::getLayoutPath('mod_bannerdestaque');
