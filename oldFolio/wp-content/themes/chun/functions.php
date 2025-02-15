<?php
/**
 * The functions file is used to initialize everything in the theme.  It controls how the theme is loaded and 
 * sets up the supported features, default actions, and default filters.  If making customizations, users 
 * should create a child theme and make changes to its functions.php file (not this one).  Friends don't let 
 * friends modify parent theme files. ;)
 *
 * Child themes should do their setup on the 'after_setup_theme' hook with a priority of 11 if they want to
 * override parent theme features.  Use a priority of 9 if wanting to run before the parent theme.
 *
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU 
 * General Public License as published by the Free Software Foundation; either version 2 of the License, 
 * or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without 
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * You should have received a copy of the GNU General Public License along with this program; if not, write 
 * to the Free Software Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 *
 * @package    Chun
 * @subpackage Functions
 * @version    0.1.2
 * @since      0.1.0
 * @author     Justin Tadlock <justin@justintadlock.com>
 * @copyright  Copyright (c) 2013, Justin Tadlock
 * @link       http://themehybrid.com/themes/chun
 * @license    http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 */

/* Load the core theme framework. */
require_once( trailingslashit( get_template_directory() ) . 'library/hybrid.php' );
new Hybrid();

/* Do theme setup on the 'after_setup_theme' hook. */
add_action( 'after_setup_theme', 'chun_theme_setup' );

/* Load additional libraries a little later. */
add_action( 'after_setup_theme', 'chun_load_libraries', 15 );

/**
 * Theme setup function.  This function adds support for theme features and defines the default theme
 * actions and filters.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function chun_theme_setup() {

	/* Get action/filter hook prefix. */
	$prefix = hybrid_get_prefix();

	/* Add theme support for core framework features. */
	add_theme_support( 'hybrid-core-menus', array( 'primary' ) );
	add_theme_support( 'hybrid-core-sidebars', array( 'primary' ) );
	add_theme_support( 'hybrid-core-widgets' );
	add_theme_support( 'hybrid-core-shortcodes' );
	add_theme_support( 'hybrid-core-template-hierarchy' );
	add_theme_support( 'hybrid-core-scripts', array( 'comment-reply' ) );
	add_theme_support( 'hybrid-core-styles', array( '25px', 'gallery', 'parent', 'style' ) );

	/* Add theme support for framework extensions. */
	add_theme_support( 'theme-layouts', array( '1c', '2c-l', '2c-r' ), array( 'default' => '2c-l' ) );
	add_theme_support( 'post-stylesheets' );
	add_theme_support( 'loop-pagination' );
	add_theme_support( 'get-the-image' );
	add_theme_support( 'breadcrumb-trail' );
	add_theme_support( 'cleaner-gallery' );

	/* Add theme support for some included libraries. */
	add_theme_support( 'theme-fonts',   array( 'callback' => 'chun_register_fonts', 'customizer' => true ) );
	add_theme_support( 'color-palette', array( 'callback' => 'chun_register_colors' ) );

	/* Add theme support for WordPress features. */
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'custom-background', array( 'wp-head-callback' => 'chun_custom_background_callback' ) );
	add_theme_support( 
		'post-formats', 
		array( 'aside', 'audio', 'chat', 'image', 'gallery', 'link', 'quote', 'status', 'video' ) 
	);

	/* Handle content width for embeds and images. */
	hybrid_set_content_width( 650 );
	add_filter( 'embed_defaults', 'chun_embed_defaults' );

	/* Add custom image sizes. */
	add_action( 'init', 'chun_register_image_sizes' );

	/* Add custom menus. */
	add_action( 'init', 'chun_register_menus', 11 );

	/* Filter the sidebar widgets. */
	add_filter( 'sidebars_widgets', 'chun_disable_sidebars' );
	add_action( 'template_redirect', 'chun_one_column' );

	/* Add classes to the comments pagination. */
	add_filter( 'previous_comments_link_attributes', 'chun_previous_comments_link_attributes' );
	add_filter( 'next_comments_link_attributes', 'chun_next_comments_link_attributes' );

	/* Wrap embeds with some custom HTML to handle responsive layout. */
	add_filter( 'embed_handler_html', 'chun_embed_html' );
	add_filter( 'embed_oembed_html',  'chun_embed_html' );

	/* Ignore some selectors for the Color Palette extension in the theme customizer. */
	add_filter( 'color_palette_preview_js_ignore', 'chun_cp_preview_js_ignore', 10, 3 );

	/* Testing out some early Hybrid Core 1.6 proposed changes. */
	add_filter( "{$prefix}_sidebar_defaults", 'chun_sidebar_defaults' );
	add_filter( 'cleaner_gallery_defaults',   'chun_gallery_defaults' );
	add_filter( 'the_content', 'chun_post_format_tools_aside_infinity', 9 );
}

/**
 * Loads some additional PHP scripts into the theme for usage.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function chun_load_libraries() {
	require_once( trailingslashit( get_template_directory() ) . 'inc/color-palette.php' );
	require_once( trailingslashit( get_template_directory() ) . 'inc/theme-fonts.php' );
}

/**
 * Registers custom nav menus for this theme.  The only extra menu is the 'Portfolio' menu.  It is only 
 * added if the 'portfolio_item' post type exists.  This is to be used with the 'CPT: Portfolio' plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function chun_register_menus() {

	if ( post_type_exists( 'portfolio_item' ) )
		register_nav_menu( 'portfolio', esc_html__( 'Portfolio', 'chun' ) );
}

/**
 * Registers custom image sizes for the theme.  The 'portfolio-large' size is only added if the user has 
 * installed the 'CPT: Portfolio' plugin.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function chun_register_image_sizes() {

	/* Size: 'post-thumbnail' */
	set_post_thumbnail_size( 160, 120, true );

	/* For the CPT: Portfolio plugin. */
	if ( post_type_exists( 'portfolio_item' ) )
		add_image_size( 'portfolio-large', 650, 488, true );
}

/**
 * Wraps embeds with <div class="embed-wrap"> to help in making videos responsive.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function chun_embed_html( $html ) {

	if ( in_the_loop() && has_post_format( 'video' ) && preg_match( '/(<embed|object|iframe)/', $html ) )
		$html = '<div class="embed-wrap">' . $html . '</div>';

	return $html;
}

/**
 * Function for deciding which pages should have a one-column layout.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function chun_one_column() {

	if ( !is_active_sidebar( 'primary' ) && !is_active_sidebar( 'secondary' ) )
		add_filter( 'theme_mod_theme_layout', 'chun_theme_layout_one_column' );

	elseif ( is_attachment() && wp_attachment_is_image() && 'default' == get_post_layout( get_queried_object_id() ) )
		add_filter( 'theme_mod_theme_layout', 'chun_theme_layout_one_column' );

	elseif ( is_post_type_archive( 'portfolio_item' ) || is_tax( 'portfolio' ) )
		add_filter( 'theme_mod_theme_layout', 'chun_theme_layout_one_column' );
}

/**
 * Filters 'get_theme_layout' by returning 'layout-1c'.
 *
 * @since  0.1.0
 * @param  string $layout The layout of the current page.
 * @return string
 */
function chun_theme_layout_one_column( $layout ) {
	return '1c';
}

/**
 * Disables sidebars if viewing a one-column page.
 *
 * @since  0.1.0
 * @param  array $sidebars_widgets A multidimensional array of sidebars and widgets.
 * @return array $sidebars_widgets
 */
function chun_disable_sidebars( $sidebars_widgets ) {
	global $wp_customize;

	$customize = ( is_object( $wp_customize ) && $wp_customize->is_preview() ) ? true : false;

	if ( !is_admin() && !$customize && '1c' == get_theme_mod( 'theme_layout' ) )
		$sidebars_widgets['primary'] = false;

	return $sidebars_widgets;
}

/**
 * Overwrites the default widths for embeds.  This is especially useful for making sure videos properly
 * expand the full width on video pages.  This function overwrites what the $content_width variable handles
 * with context-based widths.
 *
 * @since  0.1.0
 * @access public
 * @param  array  $args
 * @return array
 */
function chun_embed_defaults( $args ) {

	if ( current_theme_supports( 'theme-layouts' ) && '1c' == get_theme_mod( 'theme_layout' ) )
		$args['width'] = 1000;

	return $args;
}

/**
 * Adds 'class="prev" to the previous comments link.
 *
 * @since  0.1.0
 * @access public
 * @param  string $attributes The previous comments link attributes.
 * @return string
 */
function chun_previous_comments_link_attributes( $attributes ) {
	return $attributes . ' class="prev"';
}

/**
 * Adds 'class="next" to the next comments link.
 *
 * @since  0.1.0
 * @access public
 * @param  string $attributes The next comments link attributes.
 * @return string
 */
function chun_next_comments_link_attributes( $attributes ) {
	return $attributes . ' class="next"';
}

/**
 * Returns a set of image attachment links based on size.
 *
 * @since  0.1.0
 * @access public
 * @return string
 */
function chun_get_image_size_links() {

	/* If not viewing an image attachment page, return. */
	if ( !wp_attachment_is_image( get_the_ID() ) )
		return;

	/* Set up an empty array for the links. */
	$links = array();

	/* Get the intermediate image sizes and add the full size to the array. */
	$sizes = get_intermediate_image_sizes();
	$sizes[] = 'full';

	/* Loop through each of the image sizes. */
	foreach ( $sizes as $size ) {

		/* Get the image source, width, height, and whether it's intermediate. */
		$image = wp_get_attachment_image_src( get_the_ID(), $size );

		/* Add the link to the array if there's an image and if $is_intermediate (4th array value) is true or full size. */
		if ( !empty( $image ) && ( true === $image[3] || 'full' == $size ) )
			$links[] = "<a class='image-size-link' href='" . esc_url( $image[0] ) . "'>{$image[1]} &times; {$image[2]}</a>";
	}

	/* Join the links in a string and return. */
	return join( ' <span class="sep">/</span> ', $links );
}

/**
 * Displays an attachment image's metadata and exif data while viewing a singular attachment page.
 *
 * Note: This function will most likely be restructured completely in the future.  The eventual plan is to 
 * separate each of the elements into an attachment API that can be used across multiple themes.  Keep 
 * this in mind if you plan on using the current filter hooks in this function.
 *
 * @since  0.1.0
 * @access public
 * @return void
 */
function chun_image_info() {

	/* Set up some default variables and get the image metadata. */
	$meta = wp_get_attachment_metadata( get_the_ID() );
	$items = array();
	$list = '';

	/* Add the width/height to the $items array. */
	$items['dimensions'] = sprintf( __( '<span class="prep">Dimensions:</span> %s', 'chun' ), '<span class="image-data"><a href="' . esc_url( wp_get_attachment_url() ) . '">' . sprintf( __( '%1$s &#215; %2$s pixels', 'chun' ), $meta['width'], $meta['height'] ) . '</a></span>' );

	/* If a timestamp exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['created_timestamp'] ) )
		$items['created_timestamp'] = sprintf( __( '<span class="prep">Date:</span> %s', 'chun' ), '<span class="image-data">' . date( get_option( 'date_format' ), $meta['image_meta']['created_timestamp'] ) . '</span>' );

	/* If a camera exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['camera'] ) )
		$items['camera'] = sprintf( __( '<span class="prep">Camera:</span> %s', 'chun' ), '<span class="image-data">' . $meta['image_meta']['camera'] . '</span>' );

	/* If an aperture exists, add it to the $items array. */
	if ( !empty( $meta['image_meta']['aperture'] ) )
		$items['aperture'] = sprintf( __( '<span class="prep">Aperture:</span> %s', 'chun' ), '<span class="image-data">' . sprintf( __( 'f/%s', 'chun' ), $meta['image_meta']['aperture'] ) . '</span>' );

	/* If a focal length is set, add it to the $items array. */
	if ( !empty( $meta['image_meta']['focal_length'] ) )
		$items['focal_length'] = sprintf( __( '<span class="prep">Focal Length:</span> %s', 'chun' ), '<span class="image-data">' . sprintf( __( '%s mm', 'chun' ), $meta['image_meta']['focal_length'] ) . '</span>' );

	/* If an ISO is set, add it to the $items array. */
	if ( !empty( $meta['image_meta']['iso'] ) )
		$items['iso'] = sprintf( __( '<span class="prep">ISO:</span> %s', 'chun' ), '<span class="image-data">' . $meta['image_meta']['iso'] . '</span>' );

	/* If a shutter speed is given, format the float into a fraction and add it to the $items array. */
	if ( !empty( $meta['image_meta']['shutter_speed'] ) ) {

		if ( ( 1 / $meta['image_meta']['shutter_speed'] ) > 1 ) {
			$shutter_speed = '1/';

			if ( number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 1 ) ==  number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 0 ) )
				$shutter_speed .= number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 0, '.', '' );
			else
				$shutter_speed .= number_format( ( 1 / $meta['image_meta']['shutter_speed'] ), 1, '.', '' );
		} else {
			$shutter_speed = $meta['image_meta']['shutter_speed'];
		}

		$items['shutter_speed'] = sprintf( __( '<span class="prep">Shutter Speed:</span> %s', 'chun' ), '<span class="image-data">' . sprintf( __( '%s sec', 'chun' ), $shutter_speed ) . '</span>' );
	}

	/* Allow devs to overwrite the array of items. */
	$items = apply_atomic( 'image_info_items', $items );

	/* Loop through the items, wrapping each in an <li> element. */
	foreach ( $items as $item )
		$list .= "<li>{$item}</li>";

	/* Format the HTML output of the function. */
	$output = '<div class="image-info"><h3>' . __( 'Image Info', 'chun' ) . '</h3><ul>' . $list . '</ul></div>';

	/* Display the image info and allow devs to overwrite the final output. */
	echo apply_atomic( 'image_info', $output );
}

/**
 * This is a fix for when a user sets a custom background color with no custom background image.  What 
 * happens is the theme's background image hides the user-selected background color.  If a user selects a 
 * background image, we'll just use the WordPress custom background callback.
 *
 * @since  0.1.0
 * @access public
 * @link   http://core.trac.wordpress.org/ticket/16919
 * @return void
 */
function chun_custom_background_callback() {

	/* Get the background image. */
	$image = get_background_image();

	/* If there's an image, just call the normal WordPress callback. We won't do anything here. */
	if ( !empty( $image ) ) {
		_custom_background_cb();
		return;
	}

	/* Get the background color. */
	$color = get_background_color();

	/* If no background color, return. */
	if ( empty( $color ) )
		return;

	/* Use 'background' instead of 'background-color'. */
	$style = "background: #{$color};";

?>
<style type="text/css">body.custom-background { <?php echo trim( $style ); ?> }</style>
<?php

}

/**
 * Registers custom fonts for the Theme Fonts extension.
 *
 * @since  0.1.0
 * @access public
 * @param  object  $theme_fonts
 * @return void
 */
function chun_register_fonts( $theme_fonts ) {

	/* Add the 'headlines' font setting. */
	$theme_fonts->add_setting(
		array(
			'id'        => 'headlines',
			'label'     => __( 'Headlines', 'chun' ),
			'default'   => 'muli',
			'selectors' => 'h1, h2, h3, h4, h5, h6, th, #menu-primary li a, #menu-portfolio li a, .breadcrumb-trail, .page-links, .loop-pagination, .loop-nav, #respond input[type="submit"], #footer',
		)
	);

	/* Add fonts that users can select for this theme. */

	$theme_fonts->add_font(
		array(
			'handle' => 'trebuchet-font-stack',
			'label'  => __( 'Trebuchet (font stack)', 'chun' ),
			'stack'  => '"Segoe UI", Candara, "Bitstream Vera Sans", "DejaVu Sans", "Bitstream Vera Sans", "Trebuchet MS", Verdana, "Verdana Ref", sans-serif'
		)
	);
	$theme_fonts->add_font(
		array(
			'handle' => 'georgia-font-stack',
			'label'  => __( 'Georgia (font stack)', 'chun' ),
			'stack'  => ' Constantia, "Lucida Bright", Lucidabright, "Lucida Serif", Lucida, "DejaVu Serif", "Bitstream Vera Serif", "Liberation Serif", Georgia, serif',
		)
	);

	$theme_fonts->add_font(
		array(
			'handle' => 'arvo',
			'label'  => __( 'Arvo', 'chun' ),
			'family' => 'Arvo',
			'stack'  => 'Arvo, serif',
			'type'   => 'google'
		)
	);
	$theme_fonts->add_font(
		array(
			'handle' => 'muli',
			'label'  => __( 'Muli', 'chun' ),
			'family' => 'Muli',
			'stack'  => "Muli, sans-serif",
			'type'   => 'google'
		)
	);
	$theme_fonts->add_font(
		array(
			'handle' => 'open-sans',
			'label'  => __( 'Open Sans', 'chun' ),
			'family' => 'Open Sans',
			'stack'  => "'Open Sans', sans-serif",
			'type'   => 'google'
		)
	);
	$theme_fonts->add_font(
		array(
			'handle' => 'open-sans-condensed-700',
			'label'  => __( 'Open Sans Condensed (700)', 'chun' ),
			'family' => 'Open Sans Condensed',
			'weight' => '700',
			'stack'  => "'Open Sans Condensed', sans-serif",
			'type'   => 'google'
		)
	);
}

/**
 * Registers colors for the Color Palette extension.
 *
 * @since  0.1.0
 * @access public
 * @param  object  $color_palette
 * @return void
 */
function chun_register_colors( $color_palette ) {

	/* Add custom colors. */
	$color_palette->add_color(
		array( 'id' => 'primary', 'label' => __( 'Primary Color', 'chun' ), 'default' => 'cb5700' )
	);
	$color_palette->add_color(
		array( 'id' => 'secondary', 'label' => __( 'Secondary Color', 'chun' ), 'default' => '050505' )
	);
	$color_palette->add_color(
		array( 'id' => 'menu_primary_1', 'label' => __( 'Menu Primary #1 Color', 'chun' ), 'default' => '00393e' )
	);
	$color_palette->add_color(
		array( 'id' => 'menu_primary_2', 'label' => __( 'Menu Primary #2 Color', 'chun' ), 'default' => '00666f' )
	);

	/* Add rule sets for colors. */

	$color_palette->add_rule_set(
		'primary',
		array(
			'color'               => 'a, pre, code, .breadcrumb-trail a, .format-link .entry-title a .meta-nav, #respond label .required, #footer a:hover',
			'background-color'    => '#branding, li.comment .comment-reply-link',
			'border-top-color'    => 'body',
			'border-bottom-color' => '.breaadcrumb-trail a:hover, .sticky.hentry, .loop-meta, .page-template-portfolio .hentry.page',
			'border-left-color'   => 'pre'
		)
	);

	$color_palette->add_rule_set(
		'secondary',
		array(
			'color'               => '#site-title a, .entry-title, .entry-title a, .loop-title, #menu-portfolio li.current-cat a, #menu-portfolio li.current-menu-item a, .page-numbers.current',
			'background-color'    => '.breadcrumb-trail, li.comment .comment-reply-link:hover, #footer',
			'border-top-color'    => '.hentry, .loop-meta, .attachment-meta, #comments-template, .page-template-portfolio .hentry.page',
			'border-bottom-color' => 'body'
		)
	);

	$color_palette->add_rule_set(
		'menu_primary_1',
		array(
			'color'            => '#menu-primary li a',
			'background-color' => '#menu-primary li li a:hover, #menu-primary li li:hover > a'
		)
	);

	$color_palette->add_rule_set(
		'menu_primary_2',
		array(
			'color'               => '#menu-primary li a:hover, #menu-primary li:hover > a, #menu-primary li.current-menu-item > a',
			'background-color'    => '#menu-primary li li a',
			'border-bottom-color' => '#menu-primary-items ul li:first-child > a::after',
			'border-right-color'  => '#menu-primary-items ul ul li:first-child a::after'
		)
	);
}

/**
 * Filters the 'color_palette_preview_js_ignore' hook with some selectors that should be ignored on the 
 * live preview because they don't need to be overwritten.
 *
 * @since  0.1.0
 * @access public
 * @param  string  $selectors
 * @param  string  $color_id
 * @param  string  $property
 * @return string
 */
function chun_cp_preview_js_ignore( $selectors, $color_id, $property ) {

	if ( 'color' === $property && 'primary' === $color_id )
		$selectors = '#site-title a, .menu a, .entry-title a';

	elseif ( 'color' === $property && 'menu_primary_1' === $color_id )
		$selectors = '#menu-primary li .sub-menu li a, #menu-primary li.current-menu-item li a, #menu-primary li li.current-menu-item > a';

	return $selectors;
}

/* === CPT: PORTFOLIO PLUGIN. === */

	/**
	 * Returns a link to the porfolio item URL if it has been set.
	 *
	 * @since  0.1.0
	 * @access public
	 * @return void
	 */
	function chun_get_portfolio_item_link() {

		$url = get_post_meta( get_the_ID(), 'portfolio_item_url', true );

		if ( !empty( $url ) )
			return '<span class="project-url">' . __( 'Project <abbr title="Uniform Resource Locator">URL</abbr>:', 'chun' ) . ' <a class="portfolio-item-link" href="' . esc_url( $url ) . '">' . $url . '</a></span> ';
	}

/* End CPT: Portfolio section. */

/* === HYBRID CORE 1.6 CHANGES. === 
 *
 * The following changes are slated for Hybrid Core version 1.6 to make it easier for 
 * theme developers to build awesome HTML5 themes.  If you overwrite these via a hook, 
 * keep in mind that you might need to change your code in the next major theme update.
 */

	/**
	 * Sidebar parameter defaults.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array  $defaults
	 * @return array
	 */
	function chun_sidebar_defaults( $defaults ) {

		$defaults = array(
			'before_widget' => '<section id="%1$s" class="widget %2$s widget-%2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>'
		);

		return $defaults;
	}

	/**
	 * Gallery defaults for the Cleaner Gallery extension.
	 *
	 * @since  0.1.0
	 * @access public
	 * @param  array  $defaults
	 * @return array
	 */
	function chun_gallery_defaults( $defaults ) {

		$defaults['size']       = 'post-thumbnail'; // Not for Hybrid Core 1.6.
		$defaults['itemtag']    = 'figure';
		$defaults['icontag']    = 'div';
		$defaults['captiontag'] = 'figcaption';

		return $defaults;
	}

	/**
	 * Adds an infinity character "&#8734;" to the end of the post content on 'aside' posts.  This 
	 * is from version 0.1.1 of the Post Format Tools extension.
	 *
	 * @since  0.1.1
	 * @access public
	 * @param  string $content The post content.
	 * @return string $content
	 */
	function chun_post_format_tools_aside_infinity( $content ) {

		if ( has_post_format( 'aside' ) && !is_singular() )
			$content .= ' <a class="permalink" href="' . get_permalink() . '" title="' . the_title_attribute( array( 'echo' => false ) ) . '">&#8734;</a>';

		return $content;
	}

/* End Hybrid Core 1.6 section. */

?>