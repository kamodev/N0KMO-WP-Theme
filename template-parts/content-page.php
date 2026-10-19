<?php
/**
 * A page.
 *
 * @package N0KMO_LCARS
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'lcars-record lcars-record--page' ); ?>>
	<?php if ( n0kmo_lcars_show_entry_header() ) : ?>
		<header class="entry-header">
			<p class="lcars-text-bar"><?php n0kmo_lcars_record_label(); ?></p>
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</header>
	<?php endif; ?>

	<?php n0kmo_lcars_post_thumbnail(); ?>

	<div class="entry-content">
		<?php
		the_content();

		wp_link_pages(
			array(
				'before' => '<nav class="page-links" aria-label="' . esc_attr__( 'Page', 'n0kmo-lcars' ) . '"><span class="page-links__title">' . esc_html__( 'Pages:', 'n0kmo-lcars' ) . '</span>',
				'after'  => '</nav>',
			)
		);
		?>
	</div>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
			<?php n0kmo_lcars_entry_footer(); ?>
		</footer>
	<?php endif; ?>
</article>
