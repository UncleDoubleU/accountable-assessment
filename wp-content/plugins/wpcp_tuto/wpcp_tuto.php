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
     $traveler_link = get_post_meta($post->ID, 'wpcp_trav_link', true);
     // $traveler_image = get_post_meta($post->ID, 'wpcp_trav_img', true);
?>
     <p>
          <label for="wpcp_trav_quote">The traveler's quote</label>
          <textarea
               name="wpcp_trav_quote"
               id="wpcp_trav_quote"
               placeholder="custom quote field"
               maxlength="500"
               style="width:100%; height:100px;">
               <?php echo esc_textarea($traveler_quote); ?>
          </textarea>
     </p>

     <p>
          <label for="wpcp_trav_link">Traveler's link Safe?</label>
          <input
               type="url"
               name="wpcp_trav_link"
               value="<?php echo esc_attr($traveler_link) ?>"
               style="width:100%;" />
     </p>
<?php
}

// sanitising data on save ensures that 
function wpcp_save_trav_postdata($post_id)
{
     if (isset($_POST['wpcp_trav_quote'])) {
          update_post_meta(
               $post_id,
               'wpcp_trav_quote',
               // keeps line breaks and other white spaces.
               sanitize_textarea_field($_POST['wpcp_trav_quote'])
          );
     }

     if (isset($_POST['wpcp_trav_link'])) {
          update_post_meta(
               $post_id,
               'wpcp_trav_link',
               esc_url_raw($_POST['wpcp_trav_link'])
          );
     }
}

add_action('save_post', 'wpcp_save_trav_postdata');
