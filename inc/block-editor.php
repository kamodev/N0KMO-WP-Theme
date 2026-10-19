<?php
/**
 * Block editor integration: block styles and the pattern category.
 *
 * The CSS for the block styles is in assets/css/content.css. Patterns in the
 * patterns/ directory are registered by WordPress automatically.
 *
 * @package N0KMO_LCARS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register LCARS block style variations.
 */
function n0kmo_lcars_register_block_styles() {
	$styles = array(
		'core/button'    => array(
			'name'  => 'lcars-panel',
			'label' => __( 'LCARS Panel', 'n0kmo-lcars' ),
		),
		'core/heading'   => array(
			'name'  => 'lcars-text-bar',
			'label' => __( 'LCARS Text Bar', 'n0kmo-lcars' ),
		),
		'core/separator' => array(
			'name'  => 'lcars-bar',
			'label' => __( 'LCARS Bar', 'n0kmo-lcars' ),
		),
		'core/group'     => array(
			'name'  => 'lcars-frame',
			'label' => __( 'LCARS Frame', 'n0kmo-lcars' ),
		),
		'core/list'      => array(
			'name'  => 'lcars-list',
			'label' => __( 'LCARS List', 'n0kmo-lcars' ),
		),
	);

	foreach ( $styles as $block => $style ) {
		register_block_style( $block, $style );
	}
}
add_action( 'init', 'n0kmo_lcars_register_block_styles' );

/**
 * Register the "LCARS" block pattern category.
 */
function n0kmo_lcars_register_pattern_category() {
	register_block_pattern_category(
		'n0kmo-lcars',
		array(
			'label'       => __( 'LCARS', 'n0kmo-lcars' ),
			'description' => __( 'LCARS panels, frames and button clusters.', 'n0kmo-lcars' ),
		)
	);
}
add_action( 'init', 'n0kmo_lcars_register_pattern_category' );
