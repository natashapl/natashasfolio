<?php
/*
  Plugin Name: Embed Any Document Plus
  Plugin URI: http://awsm.in/embed-any-documents-plus
  Description: Embed Any Document WordPress plugin lets you upload and embed your documents easily in your WordPress website without any additional browser plugins like Flash or Acrobat reader. The plugin lets you choose between Google Docs Viewer and Microsoft Office Online to display your documents. 
  Version: 1.0.1
  Author: Awsm Innovations
  Author URI: http://awsm.in
  License: GPL V3
*/
require_once (dirname(__FILE__) . '/inc/functions.php');
class Awsm_embed
{
    private static $instance = null;
    private $plugin_path;
    private $plugin_url;
    private $plugin_base;
    private $plugin_file;
    private $plugin_version;
    private $settings_slug;
    private $text_domain = 'ead';
    
    /**
     * Creates or returns an instance of this class.
     */
    public static function get_instance() {
        
        // If an instance hasn't been created and set to $instance create an instance and set it to $instance.
        if (null == self::$instance) {
            self::$instance = new self;
        }
        return self::$instance;
    }
    
    /**
     * Initializes the plugin by setting localization, hooks, filters, and administrative functions.
     */
    private function __construct() {
        
        $this->plugin_path = plugin_dir_path(__FILE__);
        $this->plugin_url = plugin_dir_url(__FILE__);
        $this->plugin_base = dirname(plugin_basename(__FILE__));
        $this->plugin_file = __FILE__;
        $this->settings_slug = 'ead-settings';
        $this->plugin_version = '1.0';
        
        load_plugin_textdomain($this->text_domain, false, $this->plugin_base . '/language');
        
        add_action('media_buttons', array($this, 'embedbutton'), 1000);
        
        add_shortcode('embeddoc', array($this, 'embed_shortcode'));
        
        //Admin Settings menu
        add_action('admin_menu', array($this, 'admin_menu'));
        add_action('admin_init', array($this, 'register_eadsettings'));
        
        //Add easy settings link
        add_filter("plugin_action_links_" . plugin_basename(__FILE__), array($this, 'settingslink'));
        
        //ajax validate file url
        add_action('wp_ajax_validateurl', array($this, 'validateurl'));
        add_action('wp_ajax_validateDriveUrl', array($this, 'ValidateDriveUrl'));
        
        //ajax Contact Form
        add_action('wp_ajax_supportform', array($this, 'supportform'));

        add_action('wp_head', array($this, 'private_style'));
        
        //default options
        register_activation_hook($this->plugin_file, array($this, 'ead_defaults'));
        
        $this->run_plugin();
    }
    
    /**
     * Register admin Settings style
     */
    function setting_styles() {
        wp_register_style('embed-settings', plugins_url('css/settings.css', $this->plugin_file), false, $this->plugin_version, 'all');
        wp_enqueue_style('embed-settings');
    }
    
    /**
     * Embed any Docs Button
     */
    public function embedbutton($args = array()) {
        
        // Check user previlage
        if (!current_user_can('edit_posts')) return;
        
        // Prepares button target
        $target = is_string($args) ? $args : 'content';
        
        // Prepare args
        $args = wp_parse_args($args, array('target' => $target, 'text' => __('Add Document', $this->text_domain), 'class' => 'awsm-embed button', 'icon' => plugins_url('images/ead-small.png', __FILE__), 'echo' => true, 'shortcode' => false));
        
        // Prepare EAD icon
        if ($args['icon']) $args['icon'] = '<img src="' . $args['icon'] . '" /> ';
        
        // Print button in media column
        $button = '<a href="javascript:void(0);" class="' . $args['class'] . '" title="' . $args['text'] . '" data-mfp-src="#embed-popup-wrap" data-target="' . $args['target'] . '" >' . $args['icon'] . $args['text'] . '</a>';
        
        // Show generator popup
        add_action('admin_footer', array($this, 'embedpopup'));
        
        // Request assets
        wp_enqueue_media();
        
        //Loads Support css and js
        $this->embed_helper();
        
        // Print/return result
        if ($args['echo']) echo $button;
        return $button;
    }
    
    /**
     * Admin Easy access settings link
     */
    function settingslink($links) {
        $settings_link = '<a href="options-general.php?page=' . $this->settings_slug . '">' . __('Settings', $this->text_domain) . '</a>';
        array_unshift($links, $settings_link);
        return $links;
    }
    
    /**
     * Embed Form popup
     */
    function embedpopup() {
        include ($this->plugin_path . 'inc/popup.php');
    }
    
    /**
     * Register admin scripts
     */
    function embed_helper() {
        wp_register_style('magnific-popup', plugins_url('css/magnific-popup.css', $this->plugin_file), false, '0.9.9', 'all');
        wp_register_style('embed-css', plugins_url('css/embed.css', $this->plugin_file), false, $this->plugin_version, 'all');
        wp_register_script('magnific-popup', plugins_url('js/magnific-popup.js', $this->plugin_file), array('jquery'), '0.9.9', true);
        wp_register_script('embed', plugins_url('js/embed.js', $this->plugin_file), array('jquery'), $this->plugin_version, true);
        wp_localize_script('embed', 'emebeder', $this->embedJSdata());
        wp_enqueue_style('magnific-popup');
        wp_enqueue_script('magnific-popup');
        wp_enqueue_style('embed-css');
        if (get_option('ead_drivekey') && get_option('ead_driveClient')) 
        	wp_enqueue_script('gapi', 'https://apis.google.com/js/api.js', '', $this->plugin_version, true);
        if (get_option('ead_dropbox')) 
        	wp_enqueue_script('ead-dropbox', 'https://www.dropbox.com/static/api/2/dropins.js', '', $this->plugin_version, true);
        if (get_option('ead_box')) 
        	wp_enqueue_script('ead-box', 'https://app.box.com/js/static/select.js', '', $this->plugin_version, true);
        wp_enqueue_script('embed');
    }
    
    /**
     * Localize array
     */
    function embedJSdata() {
        $jsdata 	= array(
        				'height' 		=> 	get_option('ead_height', '500px'),
        				'width' 		=> 	get_option('ead_width', '100%'), 
        				'download' 		=> 	get_option('ead_download', 'none'), 
        				'provider' 		=> 	get_option('ead_provider', 'google'), 
        				'ajaxurl' 		=> 	admin_url('admin-ajax.php'), 
        				'validtypes' 	=> 	ead_validembedtypes(), 
        				'msextension' 	=> 	ead_validextensions('ms'), 
        				'drextension'	=> 	ead_validextensions('all'),
        				'nocontent' 	=> 	__('Nothing to insert', $this->text_domain), 
        				'addurl' 		=> 	__('Add URL', $this->text_domain), 
        				'verify' 		=> 	__('Verifying...', $this->text_domain), 
        				'nopublic' 		=> 	__('The document you have chosen is a not public.', $this->text_domain) . __(' Only the owner and explicitly shared collaborators will be able to view it.', $this->text_domain), 
        				'nomicrosoft' 	=> 	__('No Microsoft', $this->text_domain), 'driveapiKey' => false, 
        				'driveclientId' => 	false,
        				'boxapikey' 	=> 	false, 'DropboxApi' => false,);
        if (get_option('ead_drivekey')  && 	get_option('ead_driveClient')) {
            $jsdata['driveapiKey'] 		= 	get_option('ead_drivekey');
            $jsdata['driveclientId'] 	= 	get_option('ead_driveClient');
        }
        if (get_option('ead_dropbox')) 
        	$jsdata['DropboxApi'] 		= 	get_option('ead_dropbox');
        if (get_option('ead_box')) 
        	$jsdata['boxapikey'] 		= 	get_option('ead_box');
        return $jsdata;
    }
    
    /**
     * Shortcode Functionality
     */
    function embed_shortcode($atts) {
        $embed = "";
        $durl = "";
        $default_width = ead_sanitize_dims(get_option('ead_width', '100%'));
        $default_height = ead_sanitize_dims(get_option('ead_height', '500px'));
        $default_provider = get_option('ead_provider', 'google');
        $default_download = get_option('ead_download', 'none');
        $show = false;
        extract(shortcode_atts(array('url' => '', 'drive' => '', 'width' => $default_width, 'height' => $default_height, 'language' => 'en', 'viewer' => $default_provider, 'download' => $default_download), $atts));
        
        if ($url):
            $filedata = wp_remote_head($url);
            $durl = '';
            $privatefile = '';
            if (ead_allowdownload($viewer)) if ($download == 'alluser' or $download == 'all') {
                $show = true;
            } elseif ($download == 'logged' AND is_user_logged_in()) {
                $show = true;
            }
            if ($show) {
                $filesize = 0;
                $url = esc_url($url, array('http', 'https'));
                
                if (isset($filedata['headers']['content-length'])) {
                    $filesize = ead_human_filesize($filedata['headers']['content-length']);
                } else {
                    $filesize = 0;
                }
                $fileHtml = '';
                if ($filesize) $fileHtml = ' [' . $filesize . ']';
                $durl = '<p class="embed_download"><a href="' . $url . '" download >' . __('Download', 'ead') . $fileHtml . ' </a></p>';
            }
            
            $url = esc_url($url, array('http', 'https'));
            $providerList = array('google', 'microsoft', 'drive', 'box');
            if (!in_array($viewer, $providerList)) $viewer = 'google';
            switch ($viewer) {
                case 'google':
                    $embedsrc = '//docs.google.com/viewer?url=%1$s&embedded=true&hl=%2$s';
                    $iframe = sprintf($embedsrc, urlencode($url), esc_attr($language));
                    break;

                case 'microsoft':
                    $embedsrc = '//view.officeapps.live.com/op/embed.aspx?src=%1$s';
                    $iframe = sprintf($embedsrc, urlencode($url));
                    break;

                case 'drive':
                    $iframe = $url;
                    $privatefile = $this->privatefilecheck($filedata);
                    break;

                case 'box':
                    $iframe = ead_boxembed($url);
                    $privatefile = $this->privatefilecheck($filedata);
                    break;
            }
            $style = 'style="width:%1$s; height:%2$s; border: none;"';
            $stylelink = sprintf($style, ead_sanitize_dims($width), ead_sanitize_dims($height));
            $iframe = '<iframe src="' . $iframe . '" ' . $stylelink . '></iframe>';
            $show = false;
            $embed = '<div class="ead-document">' . $iframe . $privatefile . $durl . '</div>';
        else:
            $embed = __('No Url Found', 'ead');
        endif;
        return $embed;
    }
    
    /**
     * Private file check
     */
    function privatefilecheck($filedata) {
        $privatefile = '';
        if (wp_remote_retrieve_response_code($filedata) != 200) {
            $privatefile = '<div class="ead-private">
 			<div class="ead-lock">
 			<p><img src="' . $this->plugin_url . '/images/icon-lock.png"/></p>
 			<p><strong>' . __('This document is not public.', $this->text_domain) . '</strong><br/>' . __(' Only the owner and explicitly shared collaborators will be able to view it.', $this->text_domain) . '</p>
 			</div><span class="ead-dummy"></span>
 			</div>';
        }
        return $privatefile;
    }
    /**
     * Private File Style
    */
    function private_style(){ 
        echo '<style type="text/css">
            .ead-document{ position:relative;}
            .ead-private{ position:absolute; width: 100%; height: 100%; left:0; top:0; background:rgba(248,237,235,0.8); text-align: center;}
            .ead-lock{ display: inline-block; vertical-align: middle;max-width: 98%;}
            .ead-dummy{ display: inline-block; vertical-align: middle; height:100%; width: 1px;}
        </style>';
     }
    /**
     * Admin menu setup
     */
    public function admin_menu() {
        $eadsettings = add_options_page('Embed Any Document Plus', 'Embed Any Document Plus', 'manage_options', $this->settings_slug, array($this, 'settings_page'));
        add_action('admin_print_styles-' . $eadsettings, array($this, 'setting_styles'));
    }
    /**
     * Admin settings page
     */
    public function settings_page() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        include ($this->plugin_path . 'inc/settings.php');
    }
    
    /**
     * Register Settings
     */
    function register_eadsettings() {
        register_setting('ead-settings-group', 'ead_width', 'ead_sanitize_dims');
        register_setting('ead-settings-group', 'ead_height', 'ead_sanitize_dims');
        register_setting('ead-settings-group', 'ead_download');
        register_setting('ead-settings-group', 'ead_provider');
        register_setting('ead-cloud-group', 'ead_drivekey');
        register_setting('ead-cloud-group', 'ead_driveClient');
        register_setting('ead-cloud-group', 'ead_dropbox');
        register_setting('ead-cloud-group', 'ead_box');
    }
    
    /**
     * Ajax validate file url
     */
    function validateurl() {
        $fileurl = $_POST['furl'];
        echo json_encode(ead_validateurl($fileurl));
        die(0);
    }
    
    /**
     * Ajax validate Drive url
     */
    function ValidateDriveUrl() {
        $fileurl = $_POST['furl'];
        echo json_encode(ead_ValidateDriveUrl($fileurl));
        die(0);
    }
    
    /**
     * Ajax Contact Form
     */
    function supportform() {
        if (!current_user_can('manage_options')) {
            wp_die(__('You do not have sufficient permissions to access this page.'));
        }
        include ($this->plugin_path . 'inc/support-mail.php');
    }
    
    /**
     * Plugin function
     */
    function run_plugin() {
        $this->adminfunctions();
    }
    
    /**
     * Admin Functions init
     */
    function adminfunctions() {
        if (is_admin()) {
            add_filter('upload_mimes', array($this, 'additional_mimes'));
        }
    }
    
    /**
     * Adds additional mimetype for meadi uploader
     */
    function additional_mimes($mimes) {
        return array_merge($mimes, array('svg' => 'image/svg+xml', 'ai' => 'application/postscript',));
    }
    
    /**
     * To get Overlay link
     */
    function providerlink($keys, $id, $provider) {
        if (ead_isproviderApi($keys)) {
            $link = 'options-general.php?page=' . $this->settings_slug . '&tab=cloud';
            $id = "";
            $configure = '<span class="overlay"><strong>' . __('Configure', $this->text_domain) . '</strong><i></i></span>';
            $target = 'target="_blank"';
        } else {
            $configure = '';
            $link = '#';
            $target = "";
        }
        echo '<a href="' . $link . '" id="' . $id . '" ' . $target . '><span><img src="' . $this->plugin_url . 'images/icon-' . strtolower($provider) . '.png" alt="Add From ' . $provider . '" />' . __('Add from ' . $provider, $this->text_domain) . $configure . '</span></a>';
    }
    
    /**
     * To initialize default options
     */
    function ead_defaults() {
        $o = array('ead_width' => '100%', 'ead_height' => '500px', 'ead_download' => 'none', 'ead_provider' => 'google', 'ead_mediainsert' => '1',);
        foreach ($o as $k => $v) {
            if (!get_option($k)) update_option($k, $v);
        }
        return;
    }
}

Awsm_embed::get_instance();
