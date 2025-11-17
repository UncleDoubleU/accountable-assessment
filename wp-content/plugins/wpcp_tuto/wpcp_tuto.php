<?php


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
