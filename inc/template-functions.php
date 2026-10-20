<?php
/**
 * Hooks that adjust WordPress output for the theme.
 *
 * @package N0KMO_LCARS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether the current view shows the sidebar widget area.
 *
 * @return bool
 */
function n0kmo_lcars_has_sidebar() {
	$has_sidebar = is_active_sidebar( 'sidebar-1' )
		&& ! is_404()
		&& ! is_page_template( 'page-templates/template-full-width.php' );

	/**
	 * Filters whether the sidebar is shown on the current view.
	 *
	 * @param bool $has_sidebar Whether to show the sidebar.
	 */
	return (bool) apply_filters( 'n0kmo_lcars_has_sidebar', $has_sidebar );
}

/**
 * Add scheme and layout classes to <body>.
 *
 * @param string[] $classes Body classes.
 * @return string[]
 */
function n0kmo_lcars_body_classes( $classes ) {
	$classes[] = 'lcars-scheme-' . sanitize_html_class( n0kmo_lcars_option( 'color_scheme' ) );
	$classes[] = 'lcars-frame-' . sanitize_html_class( n0kmo_lcars_option( 'frame_side' ) );
	$classes[] = n0kmo_lcars_has_sidebar() ? 'has-sidebar' : 'no-sidebar';

	if ( n0kmo_lcars_option( 'readable_font' ) ) {
		$classes[] = 'lcars-readable';
	}

	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	return $classes;
}
add_filter( 'body_class', 'n0kmo_lcars_body_classes' );

/**
 * Archive pages show their type in a text bar above the title, so drop the
 * "Category:" style prefix from the title itself.
 */
add_filter( 'get_the_archive_title_prefix', '__return_empty_string' );

/**
 * Replace the [...] at the end of excerpts with an ellipsis.
 *
 * @param string $more Default "more" string.
 * @return string
 */
function n0kmo_lcars_excerpt_more( $more ) {
	if ( is_admin() ) {
		return $more;
	}

	return '&hellip;';
}
add_filter( 'excerpt_more', 'n0kmo_lcars_excerpt_more' );

/**
 * Add a class to the "Read more" link inside post content.
 *
 * @return string
 */
function n0kmo_lcars_content_more_link() {
	return sprintf(
		'<div class="more-link-container"><a href="%1$s" class="more-link lcars-button">%2$s</a></div>',
		esc_url( get_permalink() . '#more-' . get_the_ID() ),
		wp_kses(
			sprintf(
				/* translators: %s: Post title. Only visible to screen readers. */
				__( 'Continue reading<span class="screen-reader-text"> %s</span>', 'n0kmo-lcars' ),
				get_the_title()
			),
			array( 'span' => array( 'class' => array() ) )
		)
	);
}
add_filter( 'the_content_more_link', 'n0kmo_lcars_content_more_link' );

/**
 * Render the classic tag cloud widget as same-size pills.
 *
 * @param array $args wp_tag_cloud() arguments.
 * @return array
 */
function n0kmo_lcars_tag_cloud_args( $args ) {
	$args['smallest'] = 1;
	$args['largest']  = 1;
	$args['unit']     = 'rem';

	return $args;
}
add_filter( 'widget_tag_cloud_args', 'n0kmo_lcars_tag_cloud_args' );

/**
 * Fallback for the header buttons when no menu is assigned: home plus the
 * top-level pages.
 *
 * @param array $args wp_nav_menu() arguments.
 */
function n0kmo_lcars_primary_menu_fallback( $args ) {
	$pages = get_pages(
		array(
			'parent'       => 0,
			'hierarchical' => false,
			'sort_column'  => 'menu_order,post_title',
			'number'       => 7,
		)
	);

	$items = sprintf(
		'<li class="menu-item%1$s"><a href="%2$s"%3$s>%4$s</a></li>',
		is_front_page() ? ' current-menu-item' : '',
		esc_url( home_url( '/' ) ),
		is_front_page() ? ' aria-current="page"' : '',
		esc_html__( 'Home', 'n0kmo-lcars' )
	);

	foreach ( $pages as $page ) {
		if ( (int) get_option( 'page_on_front' ) === $page->ID ) {
			continue;
		}

		$current = is_page( $page->ID );
		$items  .= sprintf(
			'<li class="menu-item%1$s"><a href="%2$s"%3$s>%4$s</a></li>',
			$current ? ' current-menu-item' : '',
			esc_url( get_permalink( $page ) ),
			$current ? ' aria-current="page"' : '',
			esc_html( get_the_title( $page ) )
		);
	}

	printf(
		'<ul id="%1$s" class="%2$s">%3$s</ul>',
		esc_attr( $args['menu_id'] ),
		esc_attr( $args['menu_class'] ),
		$items // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped while building the list.
	);
}
