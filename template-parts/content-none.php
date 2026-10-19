<?php
/**
 * Shown when a query returns no posts.
 *
 * @package N0KMO_LCARS
 */

?>

<section class="no-results not-found">
	<header class="page-header">
		<p class="lcars-text-bar lcars-text-bar--alert"><?php esc_html_e( 'No records found', 'n0kmo-lcars' ); ?></p>
		<?php if ( ! is_search() ) : ?>
			<h2 class="page-title"><?php esc_html_e( 'Nothing here yet', 'n0kmo-lcars' ); ?></h2>
		<?php endif; ?>
	</header>

	<div class="page-content">
		<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
			<p>
				<?php
				printf(
					wp_kses(
						/* translators: %s: Link to the new post screen. */
						__( 'Ready to publish your first log entry? <a href="%s">Get started here</a>.', 'n0kmo-lcars' ),
						array( 'a' => array( 'href' => array() ) )
					),
					esc_url( admin_url( 'post-new.php' ) )
				);
				?>
			</p>
		<?php elseif ( is_search() ) : ?>
			<p><?php esc_html_e( 'No records match those search terms. Try different keywords.', 'n0kmo-lcars' ); ?></p>
			<?php get_search_form(); ?>
		<?php else : ?>
			<p><?php esc_html_e( 'The library computer has no records here. A search may help.', 'n0kmo-lcars' ); ?></p>
			<?php get_search_form(); ?>
		<?php endif; ?>
	</div>
</section>
