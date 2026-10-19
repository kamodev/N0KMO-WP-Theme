<?php
/**
 * The search form.
 *
 * @package N0KMO_LCARS
 */

$n0kmo_lcars_search_id = wp_unique_id( 'search-form-' );
$n0kmo_lcars_aria      = empty( $args['aria_label'] ) ? '' : ' aria-label="' . esc_attr( $args['aria_label'] ) . '"';
?>
<form role="search"<?php echo $n0kmo_lcars_aria; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above. ?> method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<label class="screen-reader-text" for="<?php echo esc_attr( $n0kmo_lcars_search_id ); ?>"><?php echo esc_html_x( 'Search for:', 'label', 'n0kmo-lcars' ); ?></label>
	<input type="search" id="<?php echo esc_attr( $n0kmo_lcars_search_id ); ?>" class="search-field" placeholder="<?php echo esc_attr_x( 'Search the library&hellip;', 'placeholder', 'n0kmo-lcars' ); ?>" value="<?php echo get_search_query(); ?>" name="s">
	<button type="submit" class="search-submit lcars-button"><?php echo esc_html_x( 'Search', 'submit button', 'n0kmo-lcars' ); ?></button>
</form>
