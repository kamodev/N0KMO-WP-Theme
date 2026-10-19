<?php
/**
 * Archive template: categories, tags, authors, dates and custom taxonomies.
 *
 * @package N0KMO_LCARS
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php if ( ! n0kmo_lcars_elementor_location( 'archive' ) ) : ?>

		<header class="page-header">
			<p class="lcars-text-bar"><?php echo esc_html( n0kmo_lcars_archive_label() ); ?></p>
			<?php
			the_archive_title( '<h1 class="page-title">', '</h1>' );
			the_archive_description( '<div class="archive-description">', '</div>' );
			?>
		</header>

		<?php
		if ( have_posts() ) :
			while ( have_posts() ) :
				the_post();
				get_template_part( 'template-parts/content', get_post_type() );
			endwhile;

			n0kmo_lcars_pagination();
		else :
			get_template_part( 'template-parts/content', 'none' );
		endif;
		?>

	<?php endif; ?>

</main>

<?php
get_sidebar();
get_footer();
