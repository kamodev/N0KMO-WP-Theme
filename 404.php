<?php
/**
 * Not-found template.
 *
 * @package N0KMO_LCARS
 */

get_header();
?>

<main id="primary" class="site-main">

	<section class="error-404 not-found">
		<header class="page-header">
			<p class="lcars-text-bar lcars-text-bar--alert"><?php esc_html_e( 'Error', 'n0kmo-lcars' ); ?></p>
			<span class="lcars-error-code" aria-hidden="true">404</span>
			<h1 class="page-title"><?php esc_html_e( 'Sector not found', 'n0kmo-lcars' ); ?></h1>
		</header>

		<div class="page-content">
			<p><?php esc_html_e( 'The record you requested is not in the library computer. It may have been moved or deleted, or the address may be mistyped. Try a search instead.', 'n0kmo-lcars' ); ?></p>
			<?php get_search_form(); ?>
			<p><a class="lcars-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Return to main screen', 'n0kmo-lcars' ); ?></a></p>
		</div>
	</section>

</main>

<?php
get_footer();
