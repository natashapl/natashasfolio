<?php if ( ! defined( 'ABSPATH' ) ) { exit; } ?>
<div class="wrap">
    <h2 class="ead-title"><?php _e('Embed Any Document by AWSM.in',$this->text_domain);?></h2>
    <?php $tab = isset( $_GET['tab'] ) ? $_GET['tab'] : 'general'; ?>
    <h2 class="nav-tab-wrapper">
            <a class="nav-tab <?php echo ead_getactiveMenu($tab,'general');?>" href="<?php echo'options-general.php?page='.$this->settings_slug.'&tab=general';?>" data-tab="general"><?php _e( 'General Settings', $this->text_domain); ?></a>            
            <a class="nav-tab <?php echo ead_getactiveMenu($tab,'cloud');?>" href="<?php echo 'options-general.php?page='.$this->settings_slug.'&tab=cloud';?>" data-tab="ead_cloud"><?php _e( 'Cloud Settings', $this->text_domain); ?></a>
            <a class="nav-tab <?php echo ead_getactiveMenu($tab,'support');?>" href="<?php echo'options-general.php?page='.$this->settings_slug.'&tab=support';?>" data-tab="support"><?php _e( 'Support', $this->text_domain); ?></a>
        </h2>
    <div class="ead-left-wrap">
        
        <div class="ead-tabs">
            <?php if($tab =='general'):?>
            <form method="post" action="options.php">
                <?php settings_fields( 'ead-settings-group' ); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row"><?php _e('Default Size', $this->text_domain); ?></th>
                        <td> 
                         <div class="f-left ead-frame-width"><?php _e('Width', $this->text_domain); ?>    
                         <input type="text" class="small" name="ead_width"  value="<?php echo esc_attr( get_option('ead_width','100%') ); ?>" />   
                         </div>
                         <div class="f-left ead-frame-height">
                         <?php _e('Height', $this->text_domain); ?> 
                         <input type="text" class="small" name="ead_height" value="<?php echo esc_attr( get_option('ead_height','500px') ); ?>" />
                        </div>
                        <div class="clear"></div>
                        <span class="note"><?php _e('Enter values in pixels or percentage (Example: 500px or 100%)', $this->text_domain); ?></span>
                        </td>
                    </tr>
                    <tr valign="top">
                    <th scope="row"><?php _e('Show Download Link',$this->text_domain);?></th>
                    <td>
                       <?php 
                        $downoptions= array('all' => __('For all users',$this->text_domain),'logged' => __('For Logged-in users',$this->text_domain),'none' => __('No Download',$this->text_domain));
                        ead_selectbuilder('ead_download', $downoptions,esc_attr( get_option('ead_download','none'))); 
                        ?> 
                    </td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
            <?php endif;?>
            <?php if($tab =='cloud'):?>
            <form method="post" action="options.php">
            <?php settings_fields( 'ead-cloud-group' ); ?>
            <table class="form-table">
                <ul class="cloudform">
                    <li>
                        <div class="ead-cloud ead-service"> 
                            <img width="40" src="<?php echo $this->plugin_url;?>images/icon-dropbox.png"><span>Dropbox</span></div>
                        <div class="ead-cloud ead-setup"> 
                            <div class="ead-inputholder">
                                <label><?php _e('API Key',$this->text_domain);?></label>
                                <input type="text" name="ead_dropbox"  value="<?php echo esc_attr( get_option('ead_dropbox') ); ?>" />      
                            </div>
                        </div>
                        <div class="ead-cloud ead-config">
                            <ol>
                                <li><a href="https://www.dropbox.com/developers/apps/create?app_type_checked=dropins" target="_blank"><?php _e('Obtain API key',$this->text_domain);?></a></li>
                                <li><a href="http://awsm.in/ead-plus-documentation/#dropboxapi" target="_blank"><?php _e('How to do it ?',$this->text_domain);?></a></li>
                            </ol>
                        </div>
                    </li>
                    <li>
                        <div class="ead-cloud ead-service"> 

                            <img width="40" src="<?php echo $this->plugin_url;?>images/icon-drive.png"><span>Google Drive</span></div>
                        <div class="ead-cloud ead-setup"> 
                            <div class="ead-inputholder">
                                <label><?php _e('Client ID',$this->text_domain);?></label>
                                <input type="text" name="ead_driveClient"  value="<?php echo esc_attr( get_option('ead_driveClient') ); ?>" />       
                            </div>
                             <div class="ead-inputholder">
                                <label><?php _e('API Key',$this->text_domain);?></label>
                                <input type="text" name="ead_drivekey"  value="<?php echo esc_attr( get_option('ead_drivekey') ); ?>" />  
                            </div>
                        </div>
                        <div class="ead-cloud ead-config">
                            <ol>
                                <li><a href="https://console.developers.google.com/project" target="_blank"><?php _e('Obtain Client ID and API Key',$this->text_domain);?></a></li>
                                <li><a href="http://awsm.in/ead-plus-documentation/#driveapi" target="_blank"><?php _e('How to do it ?',$this->text_domain);?></a></li>
                            </ol>
                        </div>
                    </li>
                    <li>
                        <div class="ead-cloud ead-service"> 

                            <img width="60" src="<?php echo $this->plugin_url;?>images/icon-box.png"><span>Box.com</span></div>
                        <div class="ead-cloud ead-setup"> 
                            <div class="ead-inputholder">
                                <label><?php _e('API Key',$this->text_domain);?></label>
                                <input type="text" name="ead_box"  value="<?php echo esc_attr( get_option('ead_box') ); ?>" /> 
                            </div>
                        </div>
                        <div class="ead-cloud ead-config">
                            <ol>
                                <li><a href="https://app.box.com/developers/services/edit/" target="_blank"><?php _e('Obtain API key',$this->text_domain);?></a></li>
                                <li><a href="http://awsm.in/ead-plus-documentation/#boxapi" target="_blank"><?php _e('How to do it ?',$this->text_domain);?></a></li>
                            </ol>
                        </div>
                    </li>
                </ul>
            </table>
            <?php submit_button(); ?>
            </form> 
            <?php endif;?>
            <?php if($tab =='support'):?>
            <div id="embed_message"><p></p></div>
            <div class="col-left">
            <?php  $current_user = wp_get_current_user();   ?>
            <form id="supportform" action="">
                <p>
                    <label><?php _e('Name', $this->text_domain); ?><span class="required">*</span></label>
                    <input type="text" name="site_name"  value="<?php echo  $current_user->display_name; ?>" class="text-input" />
                </p>
                <p>
                    <label><?php _e('Email ID', $this->text_domain); ?><span class="required">*</span></label>
                    <input type="email" name="email_id" value="<?php echo  $current_user->user_email; ?>" class="text-input"/>
                </p>
                <p>
                    <label><?php _e('Issue', $this->text_domain); ?><span class="required">*</span></label>
                    <textarea name="problem"></textarea>
                </p>
                <p class="submit">
                    <input type="submit" name="submit" id="submit" class="button button-primary" value="<?php _e('Submit', $this->text_domain); ?>">
                </p>
            </form>
            </div>
            <div class="col-right">
                <h3>Frequently Reported Issues</h3>
                <p>
                    <strong>1. File not found error in my localhost site.</strong></p>
                    <p>The viewers (Google Docs Viewer and Microsoft Office Online) do not support locally hosted files. <span style="border-bottom: 1px solid;">Your document has to be available online for the viewers to access.</span>
                </p>

                <p>
                    <p><strong>2. Google Docs Viewer shows Bandwidth exceeded or File can't be opened error.</strong></p>
                    <p>The issue is caused by Google Docs Viewer, not the plugin. Google Docs Viewer is a standalone documents viewer which doesn't limit bandwidth. When the problem occurs, usually reloading the page will result in the document loading properly. If it is still not working try changing the viewer to Microsoft Office Online (for MS Office Documents) or upload document to your Google Drive and embed it directly from there.
                </p>
            </div>
            <div class="clear"></div>
            <?php endif;?>
            
        </div>
    </div><!-- .ead-left-wrap -->
    <div class="ead-right-wrap">
        <div class="ead-right-inner">
            <a href="http://awsm.in" target="_blank" title="AWSM Innovations"><img src="http://awsm.in/innovations/ead/logo.png" alt="AWSM!"></a>
            <div class="author-info">
                This plugin is developed <br/>by <a href="http://awsm.in" target="_blank" title="AWSM Innovations">AWSM Innovations.</a>
            </div><!-- .author-info -->
            <ul class="awsm-social">
                <li><a href="https://www.facebook.com/awsminnovations" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-facebook">Facebook</span></a></li>
                <li><a href="https://twitter.com/awsmin" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-twitter">Twitter</span></a></li>
                <li><a href="https://github.com/awsmin" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-github">Github</span></a></li>
                <li><a href="https://www.behance.net/awsmin" target="_blank" title="AWSM Innovations"><span class="awsm-icon awsm-icon-behance">Behance</span></a></li>
            </ul>
        </div>
        <h4>Need help?</h4>
        <ol>
            <li><a href="http://awsm.in/ead-plus-documentation/#embedding" target="_blank" title="How to Embed Documents?"><?php _e('How to Embed Documents?', $this->text_domain); ?></a></li>
            <li><a href="http://awsm.in/ead-plus-documentation/#cloudapi" target="_blank" title="How to Obtain API keys?"><?php _e('How to Obtain API keys?', $this->text_domain); ?></a></li>
            <li><a href="http://awsm.in/ead-plus-documentation/#shortcode" target="_blank" title="Shortcode & Attributes"><?php _e('Shortcode & Attributes', $this->text_domain); ?></a></li>
            <li><a href="http://awsm.in/ead-plus-documentation/#issues" target="_blank" title="Google Docs Viewer issues"><?php _e('Google Docs Viewer issues', $this->text_domain); ?></a></li>
            <li><a href="<?php echo'options-general.php?page='.$this->settings_slug.'&tab=support';?>" data-tab="support" title="Get support"><?php _e('Get support', $this->text_domain); ?></a></li>
        </ol>
    </div><!-- .ead-right-wrap -->
    <div class="clear"></div>
</div><!-- .wrap -->
<script type="text/javascript">
jQuery(document).ready(function ($) {
    $( "#supportform" ).submit(function( event ) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url:"<?php echo get_option('home')?>/wp-admin/admin-ajax.php",
            dataType: 'json',
            data: {  action: 'supportform' , contact :   $("#supportform").serialize()},
            success: function(data)
            {
                supportmessage(data.status,data.message);
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                supportmessage(false,'Request failed');
            }
        }); 
    });
    function supportmessage(status,message){
        if(status){
            $('#embed_message').removeClass('awsm-error').addClass('awsm-updated');
            $('#embed_message p').html(message);
        } else{
            $('#embed_message').removeClass('awsm-updated').addClass('awsm-error');
            $('#embed_message p').html(message);
        }
    }
});
</script>