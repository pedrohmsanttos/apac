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
//defined('_JEXEC') or die('Restricted access');
if ($_POST['email']) {
    $fs = fopen('emails.csv', 'a');
    fputcsv($fs, array($_POST['email'].';'));
    fclose($fs);
}
    echo 'ok';
?>
