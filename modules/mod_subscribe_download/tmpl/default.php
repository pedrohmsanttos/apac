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
?>
<div class="zjemail">
    <p>
        <img src="<?php echo $items['image_filename'] ?>" />
    </p>
    <p><?php echo JText::_('INTRO_TEXT'); ?></p>     

    <div class="email">
        <label for="email"><?php echo JText::_('EMAIL_LABEL'); ?></label>
        <p><input type="text" name="email" id="email" autocomplete="off" placeholder="Email" width="190px"/></p>
        <span id="error" style="display: none;"></span>
        <p id="cerror">
            <label class="checkbox"><input type="checkbox" name="term" id="term"/>
                <?php if ($items['term_article']): ?>
                    <a class="modal" rel="{handler: 'iframe', size: {x: 660, y: 485}}" href="<?php echo JRoute::_('index.php?option=com_content&view=article&tmpl=component&task=preview&id=' . $items['term_article']); ?>"><?php echo JText::_('TERM_TEXT'); ?></a>
                <?php else: ?>
                    <?php echo JText::_('TERM_TEXT'); ?>
        <?php endif; ?></label>
        </p>
        <p><input type="button" name="download" id="download" value="Download" class="btn"/></p>
    </div>
</div>
<script type="text/javascript">     
    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    };
    
    jQuery(document).ready(function() {        
        jQuery('#download').click(function() {            
            var sEmail = jQuery('#email').val();
            if (jQuery.trim(sEmail).length == 0) {
                jQuery('#error').css('display','');
                jQuery('#error').html('<?php echo JText::_('REQUIRED_TEXT'); ?>');
                jQuery('#email').addClass('ierror');  
                return false;
                e.preventDefault();
            }
            if (validateEmail(sEmail)) {
                jQuery('#error').css('display','none');
                jQuery('#email').removeClass('ierror');  
                
                if (jQuery('#term').is(':checked')==false) {
                    jQuery('#cerror').addClass('chkerror');  
                    return false;
                    e.preventDefault();
                }
                jQuery('#cerror').removeClass('chkerror'); 
                var url = "<?php echo JURI::base(); ?>/modules/mod_subscribe_download/lib/function.php"; // the script where you handle the form input.

                jQuery.ajax({
                    type: "POST",
                    url: url,
                    data: {email:jQuery('#email').val()},
                    success: function(data)
                    {
                        if (data='ok'){
                            
                            var url='<?php echo $items['url_download']; ?>';    
                            window.location.href=url;  
                            jQuery('#email').val('');                            
                        }
                    }
                });

            }
            else {                
                jQuery('#error').css('display','');
                jQuery('#error').html('<?php echo JText::_('INVALID_TEXT'); ?>');
                jQuery('#email').addClass('ierror');
                return false;
                e.preventDefault();
            }          
            
        });
    });
    
</script>