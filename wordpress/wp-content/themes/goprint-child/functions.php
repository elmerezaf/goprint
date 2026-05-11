<?php
/**
 * Go Print Child Theme Core Functions
 *
 * @package goprint-child
 * @author Elmer So
 * @version 1.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Load parent theme styles & child theme custom styles
 */
add_action( 'wp_enqueue_scripts', 'goprint_child_enqueue_assets' );
function goprint_child_enqueue_assets() {

	// Load Parent Theme Style
	wp_enqueue_style(
		'parent-theme-style',
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme()->get( 'Version' )
	);

	// Load Child Theme Custom Style
	wp_enqueue_style(
		'goprint-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'parent-theme-style' ),
		'1.0'
	);
}

/**
 * Register Primary Navigation Menu
 */
add_action( 'init', 'goprint_register_nav_menu' );
function goprint_register_nav_menu() {
    register_nav_menus( array(
        'primary_menu' => 'Primary Header Menu',
    ) );
}