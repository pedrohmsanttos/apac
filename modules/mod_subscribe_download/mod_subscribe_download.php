<?php
/**
  # mod_subscribe_download - Subscribe for download
  # @version		2.0
  # ------------------------------------------------------------------------
* @copyright   Creative Networks Protocol Inc. DBA www.cnpintegrations.com
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 * @author      CNP Integrations <> http://www.cnpintegrations.com
  ------------------------------------------------------------------------- 
  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
  */
  
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Module class sfx
$moduleclass_sfx = htmlspecialchars($params->get('moduleclass_sfx'));

$document = JFactory::getDocument();
//Add stylesheet to document
$document->addStyleSheet(JURI::base() . 'modules/mod_subscribe_download/tmpl/css/style.css');

JHTML::_('behavior.modal');

$items = array();
$items['image_filename'] = $params->get('image_filename');
$items['url_download'] = $params->get('url_download');
$items['term_article'] = (int)$params->get('term_article');

require(JModuleHelper::getLayoutPath('mod_subscribe_download'));