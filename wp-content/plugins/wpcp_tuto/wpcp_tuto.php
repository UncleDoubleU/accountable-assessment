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
          'wpcp_product',
          array(
               'labels' => array(
                    'name' => __('Products', 'textdomain'),
                    'singular_name' => __('Product', 'textdomain'),
               ),
               'description' => 'creating a post type called product, which is identitfied in the database as wpcp_product',
               'public' => true,
               'has_archive' => true,
          )
     );
}
add_action('init', 'wpcp_custom_post_type');
