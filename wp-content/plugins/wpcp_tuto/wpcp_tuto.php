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

///////////////////////////////////////////// part 2 ///////////////////////////////////////////

function wpcp_display_trav_shortcode()
{
     // using custom loop allows to keep all code relevant to the post within the same file.
     $trav_query = new WP_Query(array(
          'post_type' => 'wpcp_trav_spotlight',
          // to show all posts use -1 
          'posts_per_page' => -1
     ));

     // takes in the echoed values and stores them in a buffer instead of being sent to the browser. while ob_start is active no output is sent from the script, it is stored in internal this avoid sending partial requests that could break the headers.
     // 
     // can use ob_get_level() to find out if an output already been started
     // using ob_get_clean() it is shorter than calling ob_get_content than ob_end_flush to return the content of the output buffer and turn it off. the content is not deleted which keeps it available in 
     ob_start();

     if ($trav_query->have_posts()) {
          echo '<div class="traveler-spolights">';
          // using a while loop because it works perfectly with the truth / false check from the have_post().
          while ($trav_query->have_posts()) {
               // adding the posts found to the global post object and adding helper functions each post this runs once per post as long as ther are post available (if have_posts() is true)
               $trav_query->the_post();

               echo '<h3>' . esc_html(get_the_title()) . '</h3>';
               if (has_post_thumbnail()) {
                    echo get_the_post_thumbnail(get_the_ID(), 'large');
               }
          }

          echo '</div>';
     } else {
          esc_html_e('Sorry, no posts matched your criteria.');
     }

     wp_reset_postdata();

     return ob_get_clean();
}

add_shortcode('traveler_spotlights', 'wpcp_display_trav_shortcode');
