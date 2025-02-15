<?php

add_action( 'wp_enqueue_scripts', 'theme_enqueue_styles' );
function theme_enqueue_styles() {
	wp_enqueue_style( 'moesia-bootstrap', get_template_directory_uri() . '/css/bootstrap/bootstrap.min.css', array(), true );
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}

add_action( 'wp_enqueue_scripts', 'moesia_child_scripts' );
function moesia_child_scripts() {
	if ( is_page_template('page_fullwidth.php') ) {
	
		wp_enqueue_script( 'moesia-carousel', get_template_directory_uri() .  '/js/slick.min.js', array( 'jquery' ), true );
					
		wp_enqueue_script( 'moesia-carousel-init', get_template_directory_uri() .  '/js/carousel-init.js', array(), true );

		wp_enqueue_style( 'moesia-pretty-photo', get_template_directory_uri() . '/inc/prettyphoto/css/prettyPhoto.min.css' );

		wp_enqueue_script( 'moesia-pretty-photo-js', get_template_directory_uri() .  '/inc/prettyphoto/js/jquery.prettyPhoto.min.js', array(), true );	

		wp_enqueue_script( 'moesia-pretty-photo-init', get_template_directory_uri() .  '/inc/prettyphoto/js/prettyphoto-init.js', array(), true );
		
		wp_enqueue_script( 'moesia-isotope', get_stylesheet_directory_uri() . '/js/isotope.pkgd.min.js', array('jquery'), true );
		
		wp_enqueue_script( 'moesia-image-loaded', get_stylesheet_directory_uri() . '/js/imagesloaded.pkgd.min.js', array('jquery'), true );
		
		wp_enqueue_script( 'moesia-custom-scripts', get_stylesheet_directory_uri() . '/js/scripts.js', array('jquery'), true );
	}	
}

function moesia_child_widgets() {
	if ( function_exists('siteorigin_panels_activate') ) {
		register_widget( 'Moesia_Projects_Filtered' );
	}
}

function catch_that_image() {
  global $post, $posts;
  $first_img = '';
  ob_start();
  ob_end_clean();
  $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
  $first_img = $matches[1][0];

  if(empty($first_img)) {
    $first_img = "";
  }
  return $first_img;
}

add_action( 'widgets_init', 'moesia_child_widgets', 99 );
require get_stylesheet_directory() . "/widgets/fp-projects-filtered.php";

remove_action('wp_head', 'wp_generator');


// BEGIN ENQUEUE PARENT ACTION
// AUTO GENERATED - Do not modify or remove comment markers above or below:

// END ENQUEUE PARENT ACTION
