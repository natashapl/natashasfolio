<?php
/**
Package: Simply Works Core
Title: Simply Works Core
Update: 04/10/12
Author: Jason Huber
Version: 1.5.8
Description: Functions file 
 */ 
require_once(get_template_directory().'/assets/swc_theme_options.php');

// Added CSS max-width: 660px around line 538 in style.css
$content_width = 660;

/*  New in version 3.0  */
add_theme_support( 'automatic-feed-links' );
// This theme allows users to set a custom background
add_custom_background();
// Make the editor content match the resulting post output in the theme.
add_editor_style();

/* New starting version 2.9 */
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 200, 200, true ); // 200 pixels wide by 200 pixels tall, hard crop mode
add_image_size( 'single-post-thumbnail', 600, 9999 ); // Permalink thumbnail size
/* Top Menu bars   - */
function swc_top_menus() {
	register_nav_menus(
		array(
			'primary-menu' => __( 'Primary Menu', 'simplyworks' ),
			'secondary-menu' => __( 'Secondary Menu', 'simplyworks' )
		)
	);
}
add_action( 'init', 'swc_top_menus' );

// loading of language files if they exist
load_theme_textdomain( 'simplyworks', get_template_directory() . '/languages' );
$locale = get_locale();
$locale_file = get_template_directory() . "/languages/$locale.php";
if ( is_readable( $locale_file ) ) {
	require_once( $locale_file ); }
// Widget Areas //
if ( function_exists('register_sidebar') ) {	    
    
	// Top Ad Area//
    register_sidebar(array('name'=>'Header Ad', 'id' => 'header-ad',
		'description' => __( 'use the TEXT widget to add your code for 486X60 ad space', 'simplyworks' ),'before_widget'=>'<div id="headerad">','after_widget' => '</div>')); 
 
    // Side Blocks  //
	register_sidebar( array('name' => __( 'Sidebar Top', 'simplyworks' ),'id' => 'sidebar-top','description' => __( 'Sidebar 330px wide area', 'simplyworks' ),'before_title' => '<h3>','after_title' => '</h3>',) );
	register_sidebar( array('name' => __( 'Sidebar Left Narrow', 'simplyworks' ),'id' => 'sidebar-bottom-left','description' => __( 'Left narrow sidebar perfect for lists or skyscapre type ads', 'simplyworks' ),'before_title' => '<h4>','after_title' => '</h4>',) );
    register_sidebar( array('name' => __( 'Sidebar Right Narrow', 'simplyworks' ),'id' => 'sidebar-bottom-right','description' => __( 'Right narrow sidebar perfect for lists or skyscapre type ads', 'simplyworks' ),'before_title' => '<h4>','after_title' => '</h4>',) );
  register_sidebar( array('name' => __( 'Sidebar Bottom', 'simplyworks' ),'id' => 'sidebar-bottom','description' => __( 'Sidebar 330px wide area', 'simplyworks' ),'before_title' => '<h3>','after_title' => '</h3>',) );
	
		// Footer Blocks  //
	register_sidebar( array('name' => __( 'Footer Left', 'simplyworks' ),'id' => 'footer-left','before_widget' => '<div class="flinks footleft">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>',) );
	register_sidebar( array('name' => __( 'Footer Center', 'simplyworks' ),'id' => 'footer-center','before_widget' => '<div class="flinks footcenter">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>',) );
	register_sidebar( array('name' => __( 'Footer Right', 'simplyworks' ),'id' => 'footer-right','before_widget' => '<div class="flinks footright">','after_widget' => '</div>','before_title' => '<h3>','after_title' => '</h3>',) );		
}
// * RECOMMENDED: No reference to add_custom_image_header() 
define('HEADER_TEXTCOLOR', '');
define('HEADER_IMAGE', get_stylesheet_directory_uri() . '/images/none.png'); 
define('HEADER_IMAGE_WIDTH',1020); 
define('HEADER_IMAGE_HEIGHT',120); 
define('NO_HEADER_TEXT', true );

function swc_header_style() {
$is_header_image = get_header_image();	
if($is_header_image != NULL) {
?>
<style type="text/css">
#header .wrapper {
background: url(<?php header_image() ?>) no-repeat;
height: 120px;
}
</style>
<?php
	}
}

function swc_admin_header_style() {
?>
<style type="text/css">
#headimg{
background: url(<?php header_image() ?>) no-repeat;
height: <?php echo HEADER_IMAGE_HEIGHT; ?>px;
width:<?php echo HEADER_IMAGE_WIDTH; ?>px;
padding:0 0 0 18px;
}

#headimg h1{
padding-top:40px;
margin: 0;
}
#headimg h1 a{
color:#<?php header_textcolor() ?>;
text-decoration: none;
border-bottom: none;
}
#headimg #desc{
color:#<?php header_textcolor() ?>;
font-size:1em;
margin-top:-0.5em;
}

#desc {
display: none;
}

<?php if ( 'blank' == get_header_textcolor() ) { ?>
#headimg h1, #headimg #desc {
display: none;
}
#headimg h1 a, #headimg #desc {
color:#<?php echo HEADER_TEXTCOLOR ?>;
}
<?php } ?>

</style>
<?php
}
add_custom_image_header('swc_header_style', 'swc_admin_header_style');
//////////////////////////////////
// COMMENTS  moved from comments.php in previous versions - renamed function to be more clear on what it is used for.
function swc_comment_fields($fields) {
$fields['author'] = '<p class="comment-form-author"><input id="author" name="author" value="" aria-required="true" size="30" type="text" /> <span class="required">*</span><label for="author">Name</label></p>';
$fields['email'] = '<p class="comment-form-email"><input id="email" name="email" value="" aria-required="true" size="30" type="text" /> <span class="required">*</span><label for="email">Email</label> </p>';
$fields['url'] = '<p class="comment-form-url"><input id="url" name="url" value="" size="30" type="text" />  <label for="url">Website</label></p> ';
return $fields;
}
add_filter('comment_form_default_fields','swc_comment_fields');

$swc_comment_defaults = array(
	'title_reply'          => __( 'Leave a Reply', 'simplyworks' ),
	'title_reply_to'       => __( 'Leave a Reply to %s', 'simplyworks' ),
	'cancel_reply_link'    => __( 'Cancel Reply', 'simplyworks' ),
	'label_submit'         => __( 'Submit Comment', 'simplyworks' ),
	'comment_notes_after'  => ''
);

//  Most comment custom function //
function swc_list_most_commented() {
  global $wpdb;
  $posts = $wpdb->get_results("SELECT comment_count,ID,post_title,post_status FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , 6");
  foreach ($posts as $post) {
    $postid = $post->ID;
	$title = $post->post_title;
	$commentcount = $post->comment_count;
	$poststatus = $post->post_status;
	if (($commentcount) && ($poststatus = 'publish')) { ?>
      <li><a href="<?php echo get_permalink($postid); ?>" title="<?php echo $title ?>"><?php echo $title ?></a></li> 	
      <?php }
  }
}

// Limit  Charcters 
// NOTE: if the user inputs the <!-- more --> tag < $max_char you will end up 2 read more links
// This should be used in child theme custom home pages with very short character limit of 100 or less
function swc_the_content_limit($max_char, $more_link_text = '(more...)', $stripteaser = 0, $more_file = '') {
    $content = get_the_content($more_link_text, $stripteaser, $more_file);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      echo "<p>";
      echo $content;
      echo "&nbsp;<a href='";
      the_permalink();
      echo "'>".__("Read More", 'simplyworks')." &rarr;</a>";
      echo "</p>";
   } else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "<p>";
        echo $content;
        echo "...";
        echo "&nbsp;<a href='";
        the_permalink();
        echo "'>".$more_link_text."</a>";
        echo "</p>";
   } else {
      echo "<p>";
      echo $content;
      echo "&nbsp;<a href='";
      the_permalink();
      echo "'>".__("Read More", 'simplyworks')." &rarr;</a>";
      echo "</p>";
   }
}

/// theme option to add Google Analytics code the head section
function swc_analytics_check(){
$swc_options = get_option('swc_theme_options');
if( $swc_options['swc_analytics_code'] != '' )
echo "<script type=\"text/javascript\">".stripslashes($swc_options['swc_analytics_code'])."</script>";
}
add_action( 'wp_head', 'swc_analytics_check' );

// Option in 1.5.3 went into an array  - need the user to RE-SAVE there options
if((!get_option('swc_theme_options')) && (get_option('swc_theme_color_selection') || get_option('swc_theme_logo') || get_option('swc_theme_header_code') || get_option('swc_theme_sidebar_selection')) ){
add_action( 'admin_notices', 'swc_custom_error_notice' );

function swc_custom_error_notice(){
  global $current_screen;
  if ( $current_screen->parent_base == 'themes' ) 
   echo '<div class="error"><p>Thank you for upgrading to 1.5.4 - You need to resave your Simply Works Core options. <a href="themes.php?page=swc_theme_options.php">Theme Options</a> </p></div>';
 }
}
// Shortcodes for the Simply Works Core  ///
//  Text Boxes
function swc_text_box($atts, $content = null)
{	
extract(shortcode_atts(array('color'=>'yellow',), $atts));
return '<div class="message ' .$color. ' ">' . do_shortcode($content) . '</div>';
}
add_shortcode('text-box','swc_text_box');
?>