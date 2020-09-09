<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Dan
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function dan_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Add class if we're viewing the Customizer for easier styling of theme options.
	if ( is_customize_preview() ) {
		$classes[] = 'dan-customizer';
	}

	// Add class on front page.
	if ( is_front_page() && 'posts' !== get_option( 'show_on_front' ) ) {
		$classes[] = 'dan-front-page';
	}

	// Add a class if there is a custom header.
	if ( has_header_image() ) {
		$classes[] = 'has-header-image';
	}

	// Add a class if there is a custom header video.
	if ( has_header_video() ) {
		$classes[] = 'has-header-video';
	}

	// Add class if sidebar is used.
	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page() ) {
		$classes[] = 'has-sidebar';
	}

	// Get the colorscheme or the default if there isn't one.
	$colors = dan_sanitize_colorscheme( get_theme_mod( 'colorscheme', 'gray' ) );
	$classes[] = 'colors-' . $colors;

	return $classes;
}
add_filter( 'body_class', 'dan_body_classes' );

/**
 * Add a pingback url auto-discovery header for singularly identifiable articles.
 */
function dan_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'dan_pingback_header' );
