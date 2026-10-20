<?php
/**
 * Customizer: the "LCARS Interface" section and live preview hooks.
 *
 * @package N0KMO_LCARS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Customizer settings and controls.
 *
 * @param WP_Customize_Manager $wp_customize Customizer manager.
 */
function n0kmo_lcars_customize_register( $wp_customize ) {
	$defaults = n0kmo_lcars_option_defaults();

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	$wp_customize->add_section(
		'n0kmo_lcars_interface',
		array(
			'title'       => __( 'LCARS Interface', 'n0kmo-lcars' ),
			'description' => __( 'Colour scheme, header readouts and footer credits.', 'n0kmo-lcars' ),
			'priority'    => 30,
		)
	);

	$wp_customize->add_setting(
		'n0kmo_lcars_color_scheme',
		array(
			'default'           => $defaults['color_scheme'],
			'sanitize_callback' => 'n0kmo_lcars_sanitize_color_scheme',
		)
	);
	$wp_customize->add_control(
		'n0kmo_lcars_color_scheme',
		array(
			'label'   => __( 'Colour scheme', 'n0kmo-lcars' ),
			'section' => 'n0kmo_lcars_interface',
			'type'    => 'select',
			'choices' => n0kmo_lcars_color_schemes(),
		)
	);

	$wp_customize->add_setting(
		'n0kmo_lcars_frame_side',
		array(
			'default'           => $defaults['frame_side'],
			'sanitize_callback' => 'n0kmo_lcars_sanitize_frame_side',
		)
	);
	$wp_customize->add_control(
		'n0kmo_lcars_frame_side',
		array(
			'label'       => __( 'Frame side', 'n0kmo-lcars' ),
			'description' => __( 'Which side of the page the frame column, its elbows and the side panel menu sit on. The whole frame is mirrored.', 'n0kmo-lcars' ),
			'section'     => 'n0kmo_lcars_interface',
			'type'        => 'radio',
			'choices'     => n0kmo_lcars_frame_sides(),
		)
	);

	$text_settings = array(
		'panel_label' => array(
			'label'       => __( 'Corner panel label', 'n0kmo-lcars' ),
			'description' => __( 'Text on the top-left panel, which links to the home page.', 'n0kmo-lcars' ),
		),
		'banner_text' => array(
			'label'       => __( 'Banner text', 'n0kmo-lcars' ),
			'description' => __( 'Large header text. Leave empty to use the site title.', 'n0kmo-lcars' ),
		),
	);

	foreach ( $text_settings as $key => $control ) {
		$wp_customize->add_setting(
			'n0kmo_lcars_' . $key,
			array(
				'default'           => $defaults[ $key ],
				'sanitize_callback' => 'sanitize_text_field',
				'transport'         => 'postMessage',
			)
		);
		$wp_customize->add_control(
			'n0kmo_lcars_' . $key,
			array_merge(
				$control,
				array(
					'section' => 'n0kmo_lcars_interface',
					'type'    => 'text',
				)
			)
		);
	}

	$checkboxes = array(
		'show_cascade'  => __( 'Show the animated data cascade in the header', 'n0kmo-lcars' ),
		'show_clock'    => __( 'Show a live UTC clock in the header', 'n0kmo-lcars' ),
		'show_stardate' => __( 'Show stardates in the header and on posts', 'n0kmo-lcars' ),
		'slashed_zero'  => __( 'Slash zeros in the banner, so a callsign like N0KMO does not read as NOKMO', 'n0kmo-lcars' ),
		'sounds'        => __( 'Play LCARS chirps when buttons are pressed', 'n0kmo-lcars' ),
		'readable_font' => __( 'Use a standard sans-serif font for long-form text', 'n0kmo-lcars' ),
		'show_credit'   => __( 'Show the theme credit in the footer', 'n0kmo-lcars' ),
	);

	foreach ( $checkboxes as $key => $label ) {
		$wp_customize->add_setting(
			'n0kmo_lcars_' . $key,
			array(
				'default'           => $defaults[ $key ],
				'sanitize_callback' => 'n0kmo_lcars_sanitize_checkbox',
			)
		);
		$wp_customize->add_control(
			'n0kmo_lcars_' . $key,
			array(
				'label'   => $label,
				'section' => 'n0kmo_lcars_interface',
				'type'    => 'checkbox',
			)
		);
	}

	$wp_customize->add_setting(
		'n0kmo_lcars_footer_text',
		array(
			'default'           => $defaults['footer_text'],
			'sanitize_callback' => 'wp_kses_post',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'n0kmo_lcars_footer_text',
		array(
			'label'       => __( 'Footer copyright text', 'n0kmo-lcars' ),
			'description' => __( 'Basic HTML is allowed; {year} becomes the current year. Leave empty for the default.', 'n0kmo-lcars' ),
			'section'     => 'n0kmo_lcars_interface',
			'type'        => 'textarea',
		)
	);

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'n0kmo_lcars_banner',
			array(
				'selector'            => '.banner .site-title a',
				'settings'            => array( 'blogname', 'n0kmo_lcars_banner_text' ),
				'container_inclusive' => false,
				'render_callback'     => 'n0kmo_lcars_customize_partial_banner',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'            => '.site-description__text',
				'container_inclusive' => false,
				'render_callback'     => 'n0kmo_lcars_customize_partial_blogdescription',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'n0kmo_lcars_panel_label',
			array(
				'selector'            => '.panel-1',
				'container_inclusive' => false,
				'render_callback'     => 'n0kmo_lcars_customize_partial_panel_label',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'n0kmo_lcars_footer_text',
			array(
				'selector'            => '.site-copyright',
				'container_inclusive' => false,
				'render_callback'     => 'n0kmo_lcars_customize_partial_footer_text',
			)
		);
	}
}
add_action( 'customize_register', 'n0kmo_lcars_customize_register' );

/**
 * Sanitize the colour scheme choice.
 *
 * @param string $value Submitted value.
 * @return string
 */
function n0kmo_lcars_sanitize_color_scheme( $value ) {
	return is_string( $value ) && array_key_exists( $value, n0kmo_lcars_color_schemes() ) ? $value : 'classic';
}

/**
 * Sanitize the frame side choice.
 *
 * @param string $value Submitted value.
 * @return string
 */
function n0kmo_lcars_sanitize_frame_side( $value ) {
	return is_string( $value ) && array_key_exists( $value, n0kmo_lcars_frame_sides() ) ? $value : 'left';
}

/**
 * Sanitize a checkbox value.
 *
 * @param mixed $checked Submitted value.
 * @return bool
 */
function n0kmo_lcars_sanitize_checkbox( $checked ) {
	return ! empty( $checked );
}

/**
 * Selective refresh: banner text.
 *
 * @return string
 */
function n0kmo_lcars_customize_partial_banner() {
	return n0kmo_lcars_banner_html();
}

/**
 * Selective refresh: tagline.
 *
 * @return string
 */
function n0kmo_lcars_customize_partial_blogdescription() {
	return esc_html( get_bloginfo( 'description', 'display' ) );
}

/**
 * Selective refresh: corner panel label.
 *
 * @return string
 */
function n0kmo_lcars_customize_partial_panel_label() {
	return esc_html( n0kmo_lcars_option( 'panel_label' ) ) . '<span class="screen-reader-text"> ' . esc_html__( 'Home', 'n0kmo-lcars' ) . '</span>';
}

/**
 * Selective refresh: footer copyright text.
 *
 * @return string
 */
function n0kmo_lcars_customize_partial_footer_text() {
	return wp_kses_post( n0kmo_lcars_footer_text() );
}
