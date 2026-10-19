<?php
/**
 * The sidebar widget area.
 *
 * @package N0KMO_LCARS
 */

if ( ! n0kmo_lcars_has_sidebar() ) {
	return;
}
?>

<aside id="secondary" class="widget-area" aria-label="<?php esc_attr_e( 'Sidebar', 'n0kmo-lcars' ); ?>">
	<?php dynamic_sidebar( 'sidebar-1' ); ?>
</aside>
