<?php
/*
Package: Simply Works Core
Title: Simply Works Core
Update: 04/10/12
Author: Jason Huber
Version: 1.5.8
Description: Header include file
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes(); ?>>
<head>
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
<title><?php if (is_home()) { esc_attr(bloginfo('name') ); } elseif (is_category() || is_tag()) { single_cat_title(); echo ' &bull; ' ; esc_attr(bloginfo('name')); } elseif (is_single() || is_page()) { single_post_title(); } else { wp_title('',true); } ?></title>
<link rel="stylesheet" href="<?php esc_url(bloginfo( 'stylesheet_url' )); ?>" type="text/css" media="screen" />
<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
<link rel="shortcut icon" href="<?php esc_url(bloginfo('stylesheet_directory')); ?>/favicon.ico" />
<?php if ( is_singular() ) wp_enqueue_script('comment-reply'); ?>
<?php // Retrieve Simply Works Theme Options Data
global $swc_options;
$swc_options = get_option('swc_theme_options');
if ( isset ($swc_options['swc_sidebar']) &&  ($swc_options['swc_sidebar'] == "1") ) { echo "<style type=\"text/css\">#contentarea {float: right; border: 0;}</style>";}
if ( isset ($swc_options['swc_stylesheet']) &&  ($swc_options['swc_stylesheet'] != "default") ) {?>
<?php echo wp_enqueue_style("swc_skin", get_template_directory_uri()."/skins/".$swc_options['swc_stylesheet'].".css", false, '1.0', "screen"); ?>
<?php } ?>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<div id="webpage"><!-- START webpage ID -->
  <div id="header"><!-- START header ID -->
   <div class="wrapper" <?php 
    $is_header_image = get_header_image();
	/// Check to see if the user added a custom image 
   if($is_header_image == NULL) {echo "style=\"height: auto\" ";} ?>><!-- START  wrapper CLASS -->
     <div id="headerleft"><!-- Logo area -->   
<?php if ( isset ($swc_options['swc_logo']) &&  ($swc_options['swc_logo']!="") ) {
?>	
 <div class="logo" <?php // add a little space around the logo WITHOUT a custom header image
   if($is_header_image != NULL) {echo "style=\"padding: 30px 0 0 0;\" ";} ?>><a href="<?php echo home_url(); ?>"><img src="<?php echo esc_attr(strip_tags($swc_options['swc_logo'])); ?>" alt="<?php esc_attr(strip_tags(bloginfo('name'))); ?>"  /></a></div>
 <?php } else { ?>
     <h1><a href="<?php echo home_url(); ?>"> <?php esc_attr(strip_tags(bloginfo('name'))); ?> </a></h1> <span><?php esc_attr(strip_tags(bloginfo('description'))); ?></span>
     <?php } ?>
   </div> <!-- End  logo area -->
<div id="headerright"><!-- START header right ID-->
	<?php // Widget area for user to place image or ad code using Appearence > Widget > Text
	  if (is_active_sidebar('header-ad')) : ?>	 
	      <?php dynamic_sidebar('header-ad'); ?>
      <?php endif; ?> 
   </div> <!-- END  header right ID-->
  <div class="clear"></div>
 </div> <!-- END  wrapper CLASS -->
</div> <!-- END  header ID -->
<?php // Menus only show if user create a menu in Appearence > Menu
if ( function_exists( 'register_nav_menu' ) ) {
	if ( has_nav_menu( 'primary-menu' ) ) { ?>
	<div id="navbar">
       <div class="wrapper">
		 <?php wp_nav_menu( array( 'theme_location' => 'primary-menu', 'fallback_cb' => '') ); ?>
       </div>
	</div>
    <div class="clear"></div>
<?php 
   }
  	if ( has_nav_menu( 'secondary-menu' ) ) { ?>
	<div id="subnav">
       <div class="wrapper">
		<?php wp_nav_menu( array( 'theme_location' => 'secondary-menu', 'fallback_cb' => '') ); ?>
       </div>
	</div>
    <div class="clear"></div>
<?php 
  }
}
?>