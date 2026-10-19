<?php
/**
 * Styles, scripts and head tags.
 *
 * @package N0KMO_LCARS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue front-end styles and scripts.
 */
function n0kmo_lcars_scripts() {
	$uri = get_template_directory_uri();

	wp_enqueue_style( 'n0kmo-lcars-tokens', $uri . '/assets/css/tokens.css', array(), N0KMO_LCARS_VERSION );
	wp_enqueue_style( 'n0kmo-lcars', $uri . '/assets/css/lcars.css', array( 'n0kmo-lcars-tokens' ), N0KMO_LCARS_VERSION );
	wp_enqueue_style( 'n0kmo-lcars-content', $uri . '/assets/css/content.css', array( 'n0kmo-lcars' ), N0KMO_LCARS_VERSION );
	$last_style = 'n0kmo-lcars-content';

	if ( n0kmo_lcars_elementor_active() ) {
		wp_enqueue_style( 'n0kmo-lcars-elementor', $uri . '/assets/css/elementor.css', array( $last_style ), N0KMO_LCARS_VERSION );
		$last_style = 'n0kmo-lcars-elementor';
	}

	if ( is_child_theme() ) {
		wp_enqueue_style( 'n0kmo-lcars-child', get_stylesheet_uri(), array( $last_style ), wp_get_theme()->get( 'Version' ) );
	}

	wp_enqueue_script(
		'n0kmo-lcars',
		$uri . '/assets/js/lcars.js',
		array(),
		N0KMO_LCARS_VERSION,
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
	wp_add_inline_script(
		'n0kmo-lcars',
		'window.n0kmoLcars = ' . wp_json_encode( array( 'sounds' => n0kmo_lcars_option( 'sounds' ) ) ) . ';',
		'before'
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'n0kmo_lcars_scripts' );

/**
 * Swap the no-js class on <html> for js before anything renders.
 */
function n0kmo_lcars_js_class() {
	wp_print_inline_script_tag( "document.documentElement.className = document.documentElement.className.replace( /\\bno-js\\b/, 'js' );" );
}
add_action( 'wp_head', 'n0kmo_lcars_js_class', 0 );

/**
 * Preload the Latin subset of Antonio to avoid a flash of fallback text.
 */
function n0kmo_lcars_preload_font() {
	printf(
		'<link rel="preload" href="%s" as="font" type="font/woff2" crossorigin>' . "\n",
		esc_url( get_template_directory_uri() . '/assets/fonts/antonio/antonio-latin-wght-normal.woff2' )
	);
}
add_action( 'wp_head', 'n0kmo_lcars_preload_font', 1 );

/**
 * Add a pingback discovery header on single posts that accept pingbacks.
 */
function n0kmo_lcars_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">' . "\n", esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'n0kmo_lcars_pingback_header' );
