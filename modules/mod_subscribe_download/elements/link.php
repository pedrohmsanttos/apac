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
 
jimport('joomla.form.formfield');
 
class JFormFieldLink extends JFormField {
 
       public function getInput() {
                return '<a href="'.JURI::root().'modules/mod_subscribe_download/lib/emails.csv">'.JText::_('DOWNLOAD_LABEL').'</a>';
        }
}