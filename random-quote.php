<?php
/*
Plugin Name: Random Quote on Site
Description: Display a random quote that helps your users see why they should use your service using a shortcode with customizable color and font.
Version: 3.0
Author: Ajayi Raphael Temitope
*/

// Include other files
require_once plugin_dir_path(__FILE__) . 'quote-management.php';
require_once plugin_dir_path(__FILE__) . 'settings.php';
require_once plugin_dir_path(__FILE__) . 'shortcodes.php';
require_once plugin_dir_path(__FILE__) . 'ajax-handling.php';
require_once plugin_dir_path(__FILE__) . 'menu-page-setup.php';
require_once plugin_dir_path(__FILE__) . 'import-export.php';
require_once plugin_dir_path(__FILE__) . 'demo-import.php';
require_once plugin_dir_path(__FILE__) . 'bulk-actions.php';

function enqueue_custom_scripts() {
    wp_enqueue_script('random-quote-script', plugins_url('random-quote-script.js', __FILE__), array('jquery'), '1.0', true);
}
add_action('admin_enqueue_scripts', 'enqueue_custom_scripts');

function enqueue_custom_scripts() {
    wp_enqueue_script('popup-script', plugin_dir_url(__FILE__) . 'includes/js/popup.js', array('jquery'), null, true);
}
add_action('admin_enqueue_scripts', 'enqueue_custom_scripts');

?>


