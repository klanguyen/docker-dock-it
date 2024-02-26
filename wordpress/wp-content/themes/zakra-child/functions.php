<?php
/**
 * Zakra-child Theme functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package zakra-child
 */

add_action( 'wp_enqueue_scripts', 'zakra_parent_theme_enqueue_styles' );

/**
 * Enqueue scripts and styles.
 */
function zakra_parent_theme_enqueue_styles() {
	wp_enqueue_style( 'zakra-style', get_template_directory_uri() . '/style.css' );
	wp_enqueue_style( 'zakra-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		[ 'zakra-style' ]
	);
}
