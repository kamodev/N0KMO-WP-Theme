<?php
/**
 * Search results template.
 *
 * @package N0KMO_LCARS
 */

get_header();
?>

<main id="primary" class="site-main">

	<header class="page-header">
		<p class="lcars-text-bar"><?php esc_html_e( 'Library search', 'n0kmo-lcars' ); ?></p>
		<h1 class="page-title">
			<?php
			printf(
				/* translators: %s: Search query. */
				esc_html__( 'Results for: %s', 'n0kmo-lcars' ),
				'<span>' . esc_html( get_search_query( false ) ) . '</span>'
			);
			?>
		</h1>
		<?php if ( have_posts() ) : ?>
			<p class="lcars-result-count">
				<?php
				$n0kmo_lcars_found = (int) $wp_query->found_posts;
				printf(
					/* translators: %s: Number of search results. */
					esc_html( _n( '%s record located', '%s records located', $n0kmo_lcars_found, 'n0kmo-lcars' ) ),
					esc_html( number_format_i18n( $n0kmo_lcars_found ) )
				);
				?>
			</p>
		<?php endif; ?>
	</header>

	<?php
	if ( have_posts() ) :
		while ( have_posts() ) :
			the_post();
			get_template_part( 'template-parts/content', 'search' );
		endwhile;

		n0kmo_lcars_pagination();
	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;
	?>

</main>

<?php
get_sidebar();
get_footer();
