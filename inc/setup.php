<?php
/**
 * Theme setup: supports, menus, widget areas and image sizes.
 *
 * @package N0KMO_LCARS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register theme supports and menus.
 */
function n0kmo_lcars_setup() {
	load_theme_textdomain( 'n0kmo-lcars', get_template_directory() . '/languages' );

	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'n0kmo-lcars-card', 1200, 600, true );

	register_nav_menus(
		array(
			'primary' => esc_html__( 'Header buttons', 'n0kmo-lcars' ),
			'side'    => esc_html__( 'Side frame panels', 'n0kmo-lcars' ),
			'footer'  => esc_html__( 'Footer', 'n0kmo-lcars' ),
		)
	);

	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	add_theme_support(
		'custom-logo',
		array(
			'height'      => 160,
			'width'       => 160,
			'flex-width'  => true,
			'flex-height' => true,
		)
	);

	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style(
		array(
			'assets/css/tokens.css',
			'assets/css/content.css',
			'assets/css/editor.css',
		)
	);
}
add_action( 'after_setup_theme', 'n0kmo_lcars_setup' );

/**
 * Maximum width of embedded media, in pixels.
 *
 * @global int $content_width
 */
function n0kmo_lcars_content_width() {
	// phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- Core expects themes to set this.
	$GLOBALS['content_width'] = apply_filters( 'n0kmo_lcars_content_width', 736 );
}
add_action( 'after_setup_theme', 'n0kmo_lcars_content_width', 0 );

/**
 * Register widget areas.
 */
function n0kmo_lcars_widgets_init() {
	$shared = array(
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	);

	register_sidebar(
		array_merge(
			$shared,
			array(
				'name'        => esc_html__( 'Sidebar', 'n0kmo-lcars' ),
				'id'          => 'sidebar-1',
				'description' => esc_html__( 'Shown beside posts and pages on wide screens and below them on small screens.', 'n0kmo-lcars' ),
			)
		)
	);

	register_sidebar(
		array_merge(
			$shared,
			array(
				'name'        => esc_html__( 'Footer', 'n0kmo-lcars' ),
				'id'          => 'footer-1',
				'description' => esc_html__( 'Shown in columns above the footer credits.', 'n0kmo-lcars' ),
			)
		)
	);
}
add_action( 'widgets_init', 'n0kmo_lcars_widgets_init' );
