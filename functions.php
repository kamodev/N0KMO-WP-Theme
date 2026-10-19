<?php
/**
 * N0KMO LCARS functions and definitions.
 *
 * @package N0KMO_LCARS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'N0KMO_LCARS_VERSION', '1.1.0' );

require get_template_directory() . '/inc/options.php';
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/enqueue.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/block-editor.php';
require get_template_directory() . '/inc/elementor.php';
