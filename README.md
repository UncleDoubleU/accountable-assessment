# WordPress Developer Case Study

## Objective

Build a small feature for a fictional website that demonstrates your ability to work with both the front-end (template, JavaScript, styling) and back-end (PHP, hooks, database) of WordPress, without relying on heavy plugins.

## Time Limit

Maximum 1 hour and 30 minutes.  
Deliver a .zip of the theme. Do not exceed the given time; this is a case study, and the focus is on your thought process.

## Scenario

You’ve joined a small company blog called “WanderFeed”, which publishes travel stories. The team wants to add a “Traveler Spotlight” feature to the homepage.

The feature must:

- Display the latest “Traveler Spotlight” (a custom post type).
- Show the traveler’s name, photo, short quote, and a link to their full story.
- Allow the admin to easily add new spotlights from the WordPress dashboard.

## Requirements

### 1. Custom Post Type

Create a CPT called Traveler Spotlight.

Fields:

- Name (post title)
- Quote (custom field)
- Photo (featured image)

You may use `register_post_type()` and `add_meta_box()` or ACF if preferred.

### 2. Display on Front-End

On the homepage, display:

- The latest Traveler Spotlight
- Including the photo, name, quote, and a “Read Story” link

Style the output cleanly with minimal CSS.  
You may hardcode this into `front-page.php` or use a shortcode `[traveler_spotlight]` that can be placed anywhere.
