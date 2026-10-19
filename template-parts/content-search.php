<?php
/**
 * A search result. Pages and posts share this layout.
 *
 * @package N0KMO_LCARS
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'lcars-record' ); ?>>
	<header class="entry-header">
		<p class="lcars-text-bar"><?php n0kmo_lcars_record_label(); ?></p>
		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
		<?php n0kmo_lcars_entry_meta(); ?>
	</header>

	<div class="entry-summary">
		<?php the_excerpt(); ?>
	</div>

	<footer class="entry-footer">
		<?php n0kmo_lcars_read_more_button(); ?>
	</footer>
</article>
