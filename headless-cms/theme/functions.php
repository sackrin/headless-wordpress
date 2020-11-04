<?php

// Load Composer’s autoloader
require_once(__DIR__ . '/vendor/autoload.php');

function headless_setup()
{
  // Hide the admin bar
  show_admin_bar(false);
  // REMOVE WP EMOJI
  remove_action('wp_head', 'print_emoji_detection_script', 7);
  remove_action('wp_print_styles', 'print_emoji_styles');
  remove_action('admin_print_scripts', 'print_emoji_detection_script');
  remove_action('admin_print_styles', 'print_emoji_styles');
  // Initialise the provider util classes
  \Utils\Provider::init();
  // Initialise various supporting post types
  \App\Page\Provider::init();
  \App\Shared\Provider::init();
}

add_action('init', 'headless_setup');

/**
 * Admin Menu Hook
 * Use this to configure what wordpress menu items you want to show/hide
 */
function headless_admin()
{
  // Configure these depending on what you want to show/hide
  remove_menu_page('edit-comments.php');
  remove_menu_page('upload.php');
  //remove_menu_page( 'edit.php' );
  //remove_menu_page( 'tools.php' );
  //remove_menu_page( 'plugins.php' );
  //remove_menu_page( 'themes.php' );
}

add_action('admin_menu', 'headless_admin');

function headless_deregister_scripts()
{
  wp_deregister_script('wp-embed');
}

add_action('wp_footer', 'headless_deregister_scripts');

function headless_remove_wp_block_library_css()
{
  wp_dequeue_style('wp-block-library');
  wp_dequeue_style('wp-block-library-theme');
  wp_dequeue_style('wc-block-style'); // Remove WooCommerce block CSS
}

add_action('wp_enqueue_scripts', 'headless_remove_wp_block_library_css', 100);
