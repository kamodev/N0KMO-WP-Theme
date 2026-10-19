<?php
/**
 * Elementor and Elementor Pro compatibility.
 *
 * Nothing here changes the site unless Elementor is installed:
 *
 * - Registers the Elementor Pro Theme Builder locations (header, footer,
 *   single and archive). The templates call n0kmo_lcars_elementor_location()
 *   and skip their own markup when a Theme Builder template takes over.
 * - Hides the sidebar on Elementor's Canvas and Full Width page templates and
 *   wherever a Theme Builder single or archive template applies.
 * - Wraps Full Width template content in the <main> landmark the skip link
 *   points to.
 * - Honours Elementor's "Hide Title" page setting by hiding the whole entry
 *   header (text bar and title).
 * - On theme activation, turns off Elementor's default colours and fonts
 *   unless they were already set, so widgets inherit the LCARS palette and
 *   Antonio.
 *
 * assets/css/elementor.css (enqueued in inc/enqueue.php) holds the layout
 * fixes, LCARS defaults for Elementor buttons and the lcars-* helper classes.
 *
 * @package N0KMO_LCARS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Whether Elementor is active.
 *
 * @return bool
 */
function n0kmo_lcars_elementor_active() {
	return (bool) did_action( 'elementor/loaded' );
}

/**
 * Register the core Elementor Pro Theme Builder locations.
 *
 * @param object $manager Elementor Pro locations manager.
 */
function n0kmo_lcars_elementor_register_locations( $manager ) {
	$manager->register_all_core_location();
}
add_action( 'elementor/theme/register_locations', 'n0kmo_lcars_elementor_register_locations' );

/**
 * Render an Elementor Pro Theme Builder location if a template applies.
 *
 * @param string $location "header", "footer", "single" or "archive".
 * @return bool True if Elementor rendered the location, so the theme should
 *              skip its own markup for it.
 */
function n0kmo_lcars_elementor_location( $location ) {
	return function_exists( 'elementor_theme_do_location' ) && elementor_theme_do_location( $location );
}

/**
 * Hide the sidebar where Elementor controls the content area.
 *
 * @param bool $has_sidebar Whether the sidebar is shown.
 * @return bool
 */
function n0kmo_lcars_elementor_has_sidebar( $has_sidebar ) {
	if ( ! $has_sidebar || ! n0kmo_lcars_elementor_active() ) {
		return $has_sidebar;
	}

	if ( is_page_template( array( 'elementor_canvas', 'elementor_header_footer' ) ) ) {
		return false;
	}

	// Elementor Pro: a Theme Builder template is assigned to this view.
	// "exits" (sic) is how Elementor Pro spells this function.
	$location = is_singular() || is_404() ? 'single' : 'archive';
	if ( function_exists( 'elementor_location_exits' ) && elementor_location_exits( $location, true ) ) {
		return false;
	}

	return $has_sidebar;
}
add_filter( 'n0kmo_lcars_has_sidebar', 'n0kmo_lcars_elementor_has_sidebar' );

/**
 * Open the <main> landmark around Elementor Full Width template content.
 */
function n0kmo_lcars_elementor_full_width_open() {
	echo '<main id="primary" class="site-main">';
}
add_action( 'elementor/page_templates/header-footer/before_content', 'n0kmo_lcars_elementor_full_width_open' );

/**
 * Close the <main> landmark opened by n0kmo_lcars_elementor_full_width_open().
 */
function n0kmo_lcars_elementor_full_width_close() {
	echo '</main>';
}
add_action( 'elementor/page_templates/header-footer/after_content', 'n0kmo_lcars_elementor_full_width_close' );

/**
 * Hide the entry header when Elementor's "Hide Title" page setting is on.
 *
 * @param bool $show Whether to show the entry header.
 * @return bool
 */
function n0kmo_lcars_elementor_show_entry_header( $show ) {
	if ( ! $show || ! n0kmo_lcars_elementor_active() || ! class_exists( '\Elementor\Plugin' ) ) {
		return $show;
	}

	$elementor = \Elementor\Plugin::instance();
	$document  = isset( $elementor->documents ) ? $elementor->documents->get( get_the_ID() ) : null;

	if ( $document && 'yes' === $document->get_settings( 'hide_title' ) ) {
		return false;
	}

	return $show;
}
add_filter( 'n0kmo_lcars_show_entry_header', 'n0kmo_lcars_elementor_show_entry_header' );

/**
 * On theme activation, turn off Elementor's default colours and fonts.
 *
 * With them off, Elementor widgets inherit the theme's colours and Antonio
 * instead of Elementor's own defaults. add_option() never overwrites a value
 * that is already set, so an existing choice in Elementor > Settings stands.
 */
function n0kmo_lcars_elementor_defaults() {
	add_option( 'elementor_disable_color_schemes', 'yes' );
	add_option( 'elementor_disable_typography_schemes', 'yes' );
}
add_action( 'after_switch_theme', 'n0kmo_lcars_elementor_defaults' );
