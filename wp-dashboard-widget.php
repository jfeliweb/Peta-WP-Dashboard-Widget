<?php
/*
Plugin Name:  Peta WP Dashboard Widget
Plugin URI:   https://jeanfelis.me
Description:  Code Assessment
Version:      1.0
Author:       Jean Felisme
Author URI:   https://jeanfelisme.com/works
License:      GPL2
License URI:  https://www.gnu.org/licenses/gpl-2.0.html
Text Domain:  wp-dashboard-widget
 */

if (!defined('ABSPATH')) {
  exit; // Exit if accessed directly.
}

// Setting up the dashboard widget
add_action('wp_dashboard_setup', 'peta_wp_dashboard_widget');

function peta_wp_dashboard_widget()
{
  global $wp_meta_boxes;

  wp_add_dashboard_widget('custom_help_widget', 'Peta WP Dashboard Widget', 'pw_dashboard_widget', 'peta_wp_dashboard_widget_config_handler');
}
// Add Options
function peta_wp_dashboard_widget_config_handler()
{
// Set Defaults

// Filter by Websites

// Allow amount to display

}
// Display list of from API
function pw_dashboard_widget()
{
// Fetch API into Array 
  $urls = array('https://wordpress.org/wp-json/wp/v2/pages?per_page=5', 'https://wordpress.org/wp-json/wp/v2/posts?per_page=5');
  foreach ($urls as $url) {

    $response = wp_remote_get($url);

    if (is_wp_error($response)) {
      return;
    }

    $posts = json_decode(wp_remote_retrieve_body($response));

    if (empty($posts)) {
      return;
    }

    if (!empty($instance['title'])) {
      echo $args['before_title'] . apply_filters('widget_title', $instance['title'], $instance, $this->id_base) . $args['after_title'];
    }

    if (!empty($posts)) {
      echo '<ul>';
      foreach ($posts as $post) {
        echo '<li><a href="' . $post->link . '">' . $post->title->rendered . '</a></li>';
      }
      echo '</ul>';
    }
  }
}

// Adding Meta Boxes
function wdw_add_custom_box()
{
  $screens = ['post'];
  foreach ($screens as $screen) {
    add_meta_box(
      'plp_box_id',
      'Aprroved by',
      'plp_custom_box_html',
      $screen
    );
  }
}
add_action('add_meta_boxes', 'wdw_add_custom_box');
// Display on Post page
function wdw_custom_box_html($post)
{
  ?>
		<label for="username">Username:</label>
		<input name="username" type="text">
		<label for="timestamp">Time Stamp:</label>
			<input name="timestamp" type="text">
	<?php

}