<?php
$swc_themename = "Simply Works Core";
$swc_shortname = "swc";
$swc_version = "1.5.8";
$swc_option_group = $swc_shortname.'_theme_option_group';
$swc_option_name = $swc_shortname.'_theme_options';
// Load stylesheet and jscript
add_action('admin_init', 'swc_add_init');
function swc_add_init() {
	$file_dir = get_template_directory_uri();
	wp_enqueue_style("swc_css", $file_dir."/assets/swc_theme_options.css", false, "1.0", "all");
	wp_enqueue_script("swc_script", $file_dir."/assets/swc_theme_options.js", false, "1.0");
}

// Create custom settings menu
add_action('admin_menu', 'swc_create_menu');
function swc_create_menu() {
	global $swc_themename;
	//create new top-level menu
	add_theme_page( __( $swc_themename.' Theme Options', 'simplyworks' ), __( 'Theme Options', 'simplyworks' ), 'edit_theme_options', basename(__FILE__), 'swc_settings_page' );
}

// Register settings
add_action( 'admin_init', 'register_settings' );
function register_settings() {
   global $swc_themename, $swc_shortname, $swc_version, $swc_options, $swc_option_group, $swc_option_name;
  	//register our settings
	register_setting( $swc_option_group, $swc_option_name, 'swc_validate_data');
}

// Sanitize and validates datat. Accepts an array $options_name, return a sanitized array.
function swc_validate_data($swc_option_name) {
	// Selection list with no HTML tags
	$swc_option_name['swc_stylesheet'] =  wp_filter_nohtml_kses($swc_option_name['swc_stylesheet']);
	// Sidebar is either 0 or 1
	$swc_option_name['swc_sidebar'] = ( $swc_option_name['swc_sidebar'] == 1 ? 1 : 0 );
	$swc_option_name['swc_comments'] = ( $swc_option_name['swc_comments'] == 1 ? 1 : 0 );
	$swc_option_name['swc_author'] = ( $swc_option_name['swc_author'] == 1 ? 1 : 0 );
	$swc_option_name['swc_date'] = ( $swc_option_name['swc_date'] == 1 ? 1 : 0 );
	$swc_option_name['swc_filed'] = ( $swc_option_name['swc_filed'] == 1 ? 1 : 0 );
	$swc_option_name['swc_tags'] = ( $swc_option_name['swc_tags'] == 1 ? 1 : 0 );
    // Logo image - No HTML tags - Just image path
	$swc_option_name['swc_logo'] =  wp_filter_nohtml_kses($swc_option_name['swc_logo']);
	// Analytic code - add slashes - there are removed in the header.php call
	$swc_option_name['swc_analytics_code'] =  wp_filter_kses($swc_option_name['swc_analytics_code']);
	return $swc_option_name;
}
//Automatically List StyleSheets in Folder
/////////////////////////////////////////////

$alt_stylesheet_path = TEMPLATEPATH . '/skins/';
$alt_stylesheets = array();

if ( is_dir($alt_stylesheet_path) ) {
    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) { 
        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) {
            if((stristr($alt_stylesheet_file, ".css") !== false) && (stristr($alt_stylesheet_file, "default") == false)){
                $alt_stylesheets[] = $alt_stylesheet_file;
            }
        }    
    }
}
array_unshift($alt_stylesheets, "default.css"); 

// Create theme options
global $swc_options;
$swc_options = array (
//  alt css
array("name" => __('Theme Colors','simplyworks'),
		"type" => "section"),
array("name" => __('Choose a color scheme','simplyworks'),
		"type" => "section-desc"),	
array("type" => "open"),
array("name" => __('Color Scheme','simplyworks'), 
		"desc" => __('Select a color scheme for the theme. ','simplyworks'),
		"id" => "swc_stylesheet",
		"type" => "select",
		"options" => $alt_stylesheets,
		"std" => "default.css"),
array("type" => "close"),

//  Layout Options
array("name" => __('Layout Options','simplyworks'),
		"type" => "section"),
array("name" => __('Move the sidebar','simplyworks'),
		"type" => "section-desc"),	
array("type" => "open"),
array("name" => __('Sidebar','simplyworks'), 
		"desc" => __('Change the position of your sidebar','simplyworks'),
		"id" => "swc_sidebar",
		"type" => "radio",
		"options" => array(array(
			'label' => __( 'Sidebar on the Right', 'simplyworks' ),
			'thumbnail' => get_template_directory_uri() . '/assets/images/sidebar-right.png',
		),array(
			'label' => __( 'Sidebar on the Left', 'simplyworks' ),
			'thumbnail' => get_template_directory_uri() . '/assets/images/sidebar-left.png',
		)),
		"std" => "0"),
array("type" => "close"),

//  Page and Post Options
array("name" => __('Page/Post Options','simplyworks'),
		"type" => "section"),
array("name" => __('Comments, Tag, Author, Date, etc...','simplyworks'),
		"type" => "section-desc"),	
array("type" => "open"),
array("name" => __('Comments','simplyworks'), 
		"desc" => __('Do you want comments available? This will turn of comments site wide and will override any indiviual post or page setting you may have.','simplyworks'),
		"id" => "swc_comments",
		"type" => "radio",
		"options" => array(array(
			'label' => __( 'On', 'simplyworks' ),
			'thumbnail' => 'no-image',
		),array(
			'label' => __( 'Off', 'simplyworks' ),
			'thumbnail' => 'no-image',
		)),
		"std" => "0"),
array("name" => __('Author','simplyworks'), 
		"desc" => __('Display the author on your Posts?','simplyworks'),
		"id" => "swc_author",
		"type" => "radio",
		"options" => array(array(
			'label' => __( 'Yes', 'simplyworks' ),
			'thumbnail' => 'no-image',
		),array(
			'label' => __( 'No', 'simplyworks' ),
			'thumbnail' => 'no-image',
		)),
		"std" => "0"),
array("name" => __('Date','simplyworks'), 
		"desc" => __('Display Post date?','simplyworks'),
		"id" => "swc_date",
		"type" => "radio",
		"options" => array(array(
			'label' => __( 'Yes', 'simplyworks' ),
			'thumbnail' => 'no-image',
		),array(
			'label' => __( 'No', 'simplyworks' ),
			'thumbnail' => 'no-image',
		)),
		"std" => "0"),
array("name" => __('Filed under','simplyworks'), 
		"desc" => __('Display categories with "Filed under:" for Post?','simplyworks'),
		"id" => "swc_filed",
		"type" => "radio",
		"options" => array(array(
			'label' => __( 'Yes', 'simplyworks' ),
			'thumbnail' => 'no-image',
		),array(
			'label' => __( 'No', 'simplyworks' ),
			'thumbnail' => 'no-image',
		)),
		"std" => "0"),
array("name" => __('Tags','simplyworks'), 
		"desc" => __('Display Tags under the Post with "Tags:"?','simplyworks'),
		"id" => "swc_tags",
		"type" => "radio",
		"options" => array(array(
			'label' => __( 'Yes', 'simplyworks' ),
			'thumbnail' => 'no-image',
		),array(
			'label' => __( 'No', 'simplyworks' ),
			'thumbnail' => 'no-image',
		)),
		"std" => "0"),						
array("type" => "close"),

//  Logo Image
array("name" => __('Logo Image','simplyworks'),
		"type" => "section"),
array("name" => __('Add your logo image','simplyworks'),
		"type" => "section-desc"),	
array("type" => "open"),
array("name" => __('Paste image path:','simplyworks'), 
		"desc" => __('<h3> 3 simple steps </h3><p>1) Upload you image using the Media > Add new  <br />2) Copy the File URL  <br />3) Paste image path</p>
<p> Recommended image size is 400 by 120 pixels, but sizes up to 525 pixels wide will work.</p><p> If left blank, your blog title and tag line will display. </p>','simplyworks'),
		"id" => "swc_logo",
		"type" => "text",
		"std" => ""),
array("type" => "close"),

//Analytics Code
array("name" => __('Analytics Code','simplyworks'),
		"type" => "section"),

array("name" => __('Add your analytics tracking code','simplyworks'),
		"type" => "section-desc"),
	
array("type" => "open"),

array("name" => __('Analytics Code','simplyworks'),
		"desc" => __('Add your Google Analytics code','simplyworks'),
		"id" => "swc_analytics_code",
		"type" => "textarea",
		"std" => ""),	

array("type" => "close")
);


function swc_settings_page() {
   global $swc_themename, $swc_shortname, $swc_version, $swc_options, $swc_option_group, $swc_option_name;
?>

<div class="wrap">
<div class="options_wrap">
<?php screen_icon(); ?><h2><?php echo $swc_themename; ?> <?php _e('Theme Options','simplyworks'); ?></h2>

<p class="top-notice"><?php _e('Customize your Simply Works Core Website with these settings. ','simplyworks'); ?></p>


<?php if ( isset ( $_POST['reset'] ) ): ?>
<?php // Delete Settings
global $wpdb, $swc_themename, $swc_shortname, $swc_version, $swc_options, $swc_option_group, $swc_option_name;
delete_option('swc_theme_options');
wp_cache_flush(); ?>
<div class="updated fade"><p><strong><?php _e( $swc_themename. ' options reset.' ); ?></strong></p></div>
<?php elseif ( isset ( $_POST['swc-old-data'] ) ): ?>
<?php // Delete Settings
global $wpdb;
delete_option('swc_theme_color_selection');
delete_option('swc_theme_logo');
delete_option('swc_theme_header_code');
delete_option('swc_theme_sidebar_selection');
wp_cache_flush(); ?>
<div class="updated fade"><p><strong><?php _e( $swc_themename. ' 1.4.8 old version options removed.' ); ?></strong></p></div>
<?php elseif ( isset ($_GET['settings-updated']) && $_GET['settings-updated'] == 'true' ): ?>
<div class="updated fade"><p><strong><?php _e( $swc_themename. ' options saved.' ); ?></strong></p></div>
<?php endif; ?>

<?php if((get_option('swc_theme_options')) && (get_option('swc_theme_color_selection') || get_option('swc_theme_logo') || get_option('swc_theme_header_code') || get_option('swc_theme_sidebar_selection')) ){
add_action( 'admin_notices', 'swc_custom_error_notice' ); ?>
<div class="updated fade">
<form method="post" action="">
<?php _e('Delete old Simply Works Core 1.4.8 data. No reseason to store the old data.','simplyworks') ?>
<input class="button button-secondary" type="submit" name="swc-old-data" value="<?php _e('Clean up database now', 'simplyworks') ?>" />
<input type="hidden" name="action" value="swc-old-data" />
</form>
</div>
<?php } ?>


<form method="post" action="options.php">

<?php settings_fields( $swc_option_group ); ?>

<?php $options = get_option( $swc_option_name ); ?>        

<?php foreach ($swc_options as $value) {
if ( isset($value['id']) ) { $valueid = $value['id'];}
switch ( $value['type'] ) {
case "section":
?>
	<div class="section_wrap">
	<h3 class="section_title"><?php echo $value['name']; ?> 

<?php break; 
case "section-desc":
?>
	<span><?php echo $value['name']; ?></span></h3>
	<div class="section_body">

<?php 
break;
case 'text':
?>

	<div class="options_input options_text">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $swc_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		<input name="<?php echo $swc_option_name.'['.$valueid.']'; ?>" id="<?php echo $swc_option_name.'['.$valueid.']'; ?>" type="<?php echo $value['type']; ?>" value="<?php if ( isset( $options[$valueid]) ){ esc_attr_e($options[$valueid]); } elseif(get_option('swc_theme_logo')) {esc_attr_e(get_option('swc_theme_logo'));} else { esc_attr_e($value['std']); } ?>" />
	</div>

<?php
break;
case 'textarea':
?>
	<div class="options_input options_textarea">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $swc_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		<textarea name="<?php echo $swc_option_name.'['.$valueid.']'; ?>" type="<?php echo $swc_option_name.'['.$valueid.']'; ?>" cols="" rows=""><?php if (isset( $options[$valueid])){ esc_attr_e($options[$valueid]); } elseif(get_option('swc_theme_header_code')) { esc_attr_e(get_option('swc_theme_header_code'));} else { esc_attr_e($value['std']); } ?>
        </textarea>
	</div>

<?php 
break;
case 'select':
?>
	<div class="options_input options_select">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $swc_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		<select name="<?php echo $swc_option_name.'['.$valueid.']'; ?>" id="<?php echo $swc_option_name.'['.$valueid.']'; ?>">
		<?php foreach ($value['options'] as $option) { ?>
		<?php  // need to check for 1.4.8 option
            if(get_option('swc_theme_color_selection')) { ?>
			 <option <?php selected( $option, get_option('swc_theme_color_selection').".css" ); ?>><?php echo $option; ?></option> 
		<?php } else { ?>
			 <option <?php selected( $options[$valueid], $option );?> ><?php echo substr($option, 0, -4); ?></option>
		<?php } ?>		
<?php } ?>
		</select>
	</div>

<?php
break;
case "radio":
?>
	<div class="options_input options_select">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
                <?php //echo "options:".print_r($value)."  ".$value['options']['content-sidebar']['thumbnail']; ?>
		<span class="labels"><label for="<?php echo $swc_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		  <?php 
		 // print_r($value['options']); 
		  foreach ($value['options'] as $key=>$option) { 
			$radio_setting = $options[$valueid];?>
           
			<input type="radio" id="<?php echo $swc_option_name.'['.$valueid.']'; ?>" name="<?php echo $swc_option_name.'['.$valueid.']'; ?>" value="<?php echo $key; ?>" 
           
			<?php
            if($radio_setting != '') {
			checked($key, $options[$valueid]); 
			} else {
			checked($key, $value['std']);
			}
			?> 
            /><?php echo $option['label']; ?><br /><?php if($value['options'][$key]['thumbnail'] != 'no-image') {echo "<img src=\"".$value['options'][$key]['thumbnail']."\" />"; ?><br /><?php } ?>
			<?php } ?>
	</div>

<?php
break;


/*
case "radio":
?>
	<div class="options_input options_select">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<span class="labels"><label for="<?php echo $swc_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label></span>
		  <?php foreach ($value['options'] as $key=>$option) { 
			$radio_setting = $options[$valueid]; ?>
			<input type="radio" id="<?php echo $swc_option_name.'['.$valueid.']'; ?>" name="<?php echo $swc_option_name.'['.$valueid.']'; ?>" value="<?php echo $key; ?>" 
			<?php
			 // need to check for 1.4.8 option
			if(get_option('swc_theme_sidebar_selection') == 'Left') {
			checked($key, 1); 
			} elseif($radio_setting != '') {
			checked($key, $options[$valueid]); 
			} else {
			checked($key, $value['std']);
			}
			?> 
            /><?php echo $option; ?><br />
			<?php } ?>
	</div>

<?php
break;
*/
case "checkbox":
?>
	<div class="options_input options_checkbox">
		<div class="options_desc"><?php echo $value['desc']; ?></div>
		<?php if( isset( $options[$valueid] ) ){ $checked = "checked=\"checked\""; }else{ $checked = "";} ?>
		<input type="checkbox" name="<?php echo $swc_option_name.'['.$valueid.']'; ?>" id="<?php echo $swc_option_name.'['.$valueid.']'; ?>" value="true" <?php echo $checked; ?> />
		<label for="<?php echo $swc_option_name.'['.$valueid.']'; ?>"><?php echo $value['name']; ?></label>
	 </div>

<?php
break;
case "close":
?>

</div><!--section_body-->
</div><!--section_wrap-->
	
<?php 
break;
}
}
?>
	
<div class="section_wrap">
<h3 class="section_title">Shortcodes 
<span>List of available shortcodes</span></h3>
	<div class="section_body" style="padding: 10px;">
		<span class="labels">Text boxes</span>
<p>Syntax: [text-box]  your content [/text-box] <em>(default yellow)</em> </p>

<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #333333; background-color: #ffffdd; border-color: #ffd700;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="green"]  your content [/text-box]</p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #11a322; background-color: #e8f6e9; border-color: #b2e1b7;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="blue"]  your content [/text-box]</p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #2446ad; background-color: #eaedf7; border-color: #b8c3e4;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="purple"]  your content [/text-box]</p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #7b11a3; background-color: #f4e8f6; border-color: #d08ee0;">Wrap the shortcode tags around your content</div>
<p>Syntax: [text-box color="red"]  your content [/text-box]</p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #9e1111; background-color: #f5e8e8; border-color: #dfb2b2;">Wrap the shortcode tags around your content</div>

<p>Syntax: [text-box color="orange"]  your content [/text-box] </p>
<div style="margin: 10px; padding: 10px; background: #fff; border: 1px solid #ddd; overflow:auto; color: #a35211; background-color: #f4e5d3; border-color: #de9860;">Wrap the shortcode tags around your content</div>

</div><!--section_body-->
</div><!--section_wrap-->

<span class="submit">
<input class="button button-primary" type="submit" name="save" value="<?php _e('Save All Changes', 'simplyworks') ?>" />
</span>
</form>

<form method="post" action="">
<span class="button-right" class="submit">
<input class="button button-secondary" type="submit" name="reset" value="<?php _e('Default/Delete Settings', 'simplyworks') ?>" />
<input type="hidden" name="action" value="reset" />
<span><?php _e('Caution: Simply Works Core theme options will be deleted from database. Press if you want the default setting or plan on removing this theme.','simplyworks') ?></span>
</span>
</form>
</div><!--#options-wrap-->

<div class="sidebox">
	<h2>Support Us!</h2>
	<p>You are using <strong><?php echo $swc_themename; ?> <?php echo $swc_version; ?></strong>, a WordPress theme by <a href="http://www.SimplyWorksCore.com">Simply Works Core</a>, Written by <a href="http://www.JasonHuber.net">Jason Huber.</a></p>
	<p>If you find this theme helpful, please send a thank you amount you feel is appropriate.</p>
<form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="VJFEXSVVUGAAQ">
<table>
<tr><td><input type="hidden" name="on0" value="Support Simply Works Core">Support Simply Works Core</td></tr><tr><td><select name="os0">
	<option value="Five Dollars">Five Dollars $5.00</option>
	<option value="Ten Dollars">Ten Dollars $10.00</option>
	<option value="Twenty Dollars">Twenty Dollars $20.00</option>
	<option value="Fifty Dollars">Fifty Dollars $50.00</option>
</select> </td></tr>
</table>
<input type="hidden" name="currency_code" value="USD">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_paynowCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
</form>
	<hr />
	<ul>
	<li><a href="http://www.simplyworkscore.com/">Simply Works Core</a></li>
	<li><a href="http://www.simplyworksweb.com/contact-us/">Contact Simply Works</a></li>
	</ul>
	<p>We do offer FREE support has time permits for this theme.</p>
</div>
</div>
<?php } ?>