<?php
/**
 * Theme options: defaults, colour schemes and a typed getter.
 *
 * Options are stored as theme mods named n0kmo_lcars_{key} and edited in the
 * Customizer (see inc/customizer.php).
 *
 * @package N0KMO_LCARS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default value of every theme option.
 *
 * @return array<string, mixed>
 */
function n0kmo_lcars_option_defaults() {
	return array(
		'color_scheme'  => 'classic',
		'panel_label'   => 'LCARS',
		'banner_text'   => '',
		'show_cascade'  => true,
		'show_clock'    => true,
		'show_stardate' => true,
		'slashed_zero'  => true,
		'sounds'        => false,
		'readable_font' => false,
		'footer_text'   => '',
		'show_credit'   => true,
	);
}

/**
 * Available colour schemes.
 *
 * @return array<string, string> Scheme slug => label.
 */
function n0kmo_lcars_color_schemes() {
	return array(
		'classic'      => __( 'Classic', 'n0kmo-lcars' ),
		'nemesis-blue' => __( 'Nemesis Blue', 'n0kmo-lcars' ),
		'lower-decks'  => __( 'Lower Decks', 'n0kmo-lcars' ),
		'red-alert'    => __( 'Red Alert', 'n0kmo-lcars' ),
	);
}

/**
 * Read a theme option, falling back to its default.
 *
 * @param string $key Option key without the n0kmo_lcars_ prefix.
 * @return mixed
 */
function n0kmo_lcars_option( $key ) {
	$defaults = n0kmo_lcars_option_defaults();
	$default  = isset( $defaults[ $key ] ) ? $defaults[ $key ] : null;
	$value    = get_theme_mod( 'n0kmo_lcars_' . $key, $default );

	if ( 'color_scheme' === $key && ! ( is_string( $value ) && array_key_exists( $value, n0kmo_lcars_color_schemes() ) ) ) {
		return $default;
	}

	if ( is_bool( $default ) ) {
		return (bool) $value;
	}

	return $value;
}
