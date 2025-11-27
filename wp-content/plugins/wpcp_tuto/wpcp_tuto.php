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
          'wpcp_traveler_spotlight',
          array(
               'labels' => array(
                    // __() function makes code multilingual ready.
                    'name' => __('Traveler Spotlights', 'custpost'),
                    'singular_name' => __('Traveler Spotlight', 'custpost'),
               ),
               'description' => "custom post displaying the traveler's name, photo, short qupte and a link to their full story",
               'public' => true,
               'has_archive' => true,
          )
     );
}
add_action('init', 'wpcp_custom_post_type');

// adding metabox to the admin screen, this is where I can add fields.
function wpcp_add_meta_box()
{
     add_meta_box(
          'wpcp_traveler_fields_box',
          'traveler information',
          'show_traveler_fields',
          'wpcp_traveler_spotlight',
          'normal'
     );
}
add_action('add_meta_boxes', 'add_product_info_box');
