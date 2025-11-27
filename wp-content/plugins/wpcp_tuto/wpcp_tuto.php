<?php

/**
 * @package Custom Post Type
 */
/*
Plugin Name: custom post type tutorial Alex Mozagba
Plugin URI: alexmozagba.com
Description: creating a custom post type as part of job application test
Version: 0.1.0
Requires PHP: 8.4.11
Author: Alex Mozagba
License: GPLv2 or later
Text Domain: custpost
*/

if (! defined('ABSPATH')) {
     die();
}

function wpcp_custom_post_type()
{
     register_post_type(
          'wpcp_trav_spotlight',
          array(
               'labels' => array(
                    // __() function makes code multilingual ready.
                    'name' => __('Traveler Spotlights', 'custpost'),
                    'singular_name' => __('Traveler Spotlight', 'custpost'),
               ),
               'description' => "custom post displaying the traveler's name, photo, short qupte and a link to their full story",
               'public' => true,
               'has_archive' => true,
               // only show the relevant fields
               'supports' => array('title', 'thumbnail'),
          )
     );
}
add_action('init', 'wpcp_custom_post_type');

// adding metabox, this box is where I can add fields to the custom post.
function wpcp_add_meta_box()
{
     add_meta_box(
          'wpcp_traveler_box',
          __('traveler information', 'custpost'),
          'wpcp_show_traveler_fields',
          'wpcp_trav_spotlight',
          'normal',
     );
}
add_action('add_meta_boxes', 'wpcp_add_meta_box');

// display the fields in the admin screen
function wpcp_show_traveler_fields($post)
{

     $traveler_quote = get_post_meta($post->ID, 'wpcp_trav_quote', true);
     // $traveler_image = get_post_meta();
     // $traveler_link = get_post_meta();
?>
     <p>
          <label for="wpcp_trav_quote">The traveler's quote</label>
          <textarea name="wpcp_trav_quote" id="wpcp_trav_quote" placeholder="custom quote field" maxlength="500" style="width:100%; height:100px;"><?php echo esc_textarea($traveler_quote); ?></textarea>
     </p>
<?php
}

// function wpcp_save_traveler_fields($post_id) {}
