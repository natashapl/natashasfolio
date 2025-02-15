<?php
/**
 * Plugin Name: Moesia - Masonry Portfolio
 * Plugin URI: http://athemes.com
 * Description: This plugin adds a shortcode that you can use to display your portfolio in a filterable masonry layout
 * Version: 1.02
 * Author: aThemes
 * License: GPLv2 or later
 */

/*  Copyright 2015  athemes.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined('ABSPATH') ) {
	die('Please do not load this file directly!');
}

/* Load the scripts */
function moesia_masonry_scripts() {
    wp_enqueue_script( 'moesia-isotope', plugin_dir_url( __FILE__ ) . '/lib/js/isotope.min.js', array('jquery'), true );
}
add_action( 'wp_enqueue_scripts', 'moesia_masonry_scripts' );

/* Image size */
function moesia_masonry_images() {
    add_image_size('moesia-mas-thumb', 360, 250);
}
add_action( 'after_setup_theme', 'moesia_masonry_images' );

/* Shortcode function */
function moesia_masonry_shortcode( $atts , $content = null ) {

    extract( shortcode_atts(
        array(
            'posts'         => '8',
            'post_type'     => 'projects',
            'include'       => '',
            'filter'        => 'yes',
            'show_all_text' => 'Show all'
        ), $atts )
    );

    $output = ''; //Start output
    if ($include && $filter == 'yes') {
        $included_terms = explode( ',', $include );
        $included_ids = array();

        foreach( $included_terms as $term ) {
            $term_id = get_term_by( 'slug', $term, 'category')->term_id;
            $included_ids[] = $term_id;
        }

        $id_string = implode( ',', $included_ids );
        $terms = get_terms( 'category', array( 'include' => $id_string ) );

        //Build the filter
        $output .= '<ul class="isotope-filters" id="filters">';
            $output .= '<li><a href="#" data-filter="*">' . $show_all_text .'</a></li>';
            $count = count($terms);
            if ( $count > 0 ){
                foreach ( $terms as $term ) {
                    $output .= "<li><a href='#' data-filter='.".$term->slug."'>" . $term->name . "</a></li>\n";
                }
            } 
        $output .= '</ul>';
    }
    //Build the layout
    $output .= '<div id="isotope-container">';
    $the_query = new WP_Query( array ( 'post_type' => $post_type, 'posts_per_page' => $posts, 'category_name' => $include ) );
    while ( $the_query->have_posts() ):
        $the_query->the_post();
        global $post;
        $id = $post->ID;
        $termsArray = get_the_terms( $id, 'category' );
        $termsString = "";
         
        if ( $termsArray) {
            foreach ( $termsArray as $term ) {
                $termsString .= $term->slug.' ';
            }
        }
        if ( has_post_thumbnail() ) {
            $project_url = get_post_meta( get_the_ID(), 'wpcf-project-link', true );
            if ( $project_url ) :
                $output .= '<div class="isotope-item ' . $termsString . '"><span class="isotope-overlay"></span><a class="iso-link" href="' . esc_url($project_url) . '"><i class="fa fa-angle-double-right"></i></a><a href="' . esc_url($project_url) . '">' . get_the_post_thumbnail($post->ID,'moesia-mas-thumb') . '</a></div>';
            else :
                $output .= '<div class="isotope-item ' . $termsString . '"><span class="isotope-overlay"></span><a class="iso-link" href="' . get_the_permalink() . '"><i class="fa fa-angle-double-right"></i></a><a href="' . get_the_permalink() . '">' . get_the_post_thumbnail($post->ID,'moesia-mas-thumb') . '</a></div>';
            endif;
        }
    endwhile;
    wp_reset_postdata();
    $output .= '</div>';
    return $output;
}
add_shortcode( 'moesia-masonry', 'moesia_masonry_shortcode' );

/* Output the styles */
function moesia_masonry_styles() {
?>
    <style type="text/css">
        .isotope-item {
            width: 25%;
        }
        .isotope-filters {
            display: table;
            padding: 0;
            margin: 30px auto;
            overflow: auto;
        }
        .isotope-filters li {
            list-style: none;
            float: left;
            border: 2px solid #333;
            padding: 5px 10px;
            margin: 5px;
        } 
        .isotope-filters li a {
            color: #333;
        }
        .isotope-container .isotope-item img {
            margin: 0 !important;
        }
        .isotope-item {
            overflow: hidden;
        }
        .isotope-overlay {
            position: absolute;
            display: block;
            width: 100%;
            height: 100%;
            top: 0;
            left: -100%;
            background-color: rgba(0,0,0,0.6);
            -webkit-transition: all 0.3s;
            transition: all 0.3s;
        }
        .iso-link {
            position: absolute;
            top: 0;
            right: -100%;
            font-size: 28px;
            padding: 0 20px;
            color: #fff;
            line-height: 1;
            border-left: 2px solid #fff;
            background-color: rgba(255,255,255,0.4);
            height: 100%;
            -webkit-transition: all 0.3s 0.1s !important;
            transition: all 0.3s 0.1s !important;
            text-align: center;         
        }
        .iso-link:hover {
            color: #333;
        }
        .iso-link .fa {
            position: relative;
            top: 40%;
        }
        .isotope-item:hover .isotope-overlay {
            left: 0;
        }
        .isotope-item:hover .iso-link {
            right: 0;
        }
        @media only screen and (max-width: 699px) {
            .isotope-item {
                width: 50%;
            }          
        }
        @media only screen and (max-width: 420px) {
            .isotope-item {
                width: 100%;
            }          
        }        
    </style>
<?php
}
add_action('wp_footer', 'moesia_masonry_styles');

/* Updates */
require_once('wp-updates-plugin.php');
new WPUpdatesPluginUpdater_894( 'http://wp-updates.com/api/2/plugin', plugin_basename(__FILE__));

add_filter( 'widget_text', 'do_shortcode');