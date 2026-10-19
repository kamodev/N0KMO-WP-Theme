<?php
/**
 * The main template: the blog index and the fallback for every view.
 *
 * @package N0KMO_LCARS
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php if ( ! n0kmo_lcars_elementor_location( 'archive' ) ) : ?>

		<?php if ( is_home() ) : ?>
			<header class="page-header">
				<?php if ( is_front_page() ) : ?>
					<p class="lcars-text-bar"><?php esc_html_e( 'Latest log entries', 'n0kmo-lcars' ); ?></p>
				<?php else : ?>
					<p class="lcars-text-bar"><?php esc_html_e( 'Log entries', 'n0kmo-lcars' ); ?></p>
					<h1 class="page-title"><?php single_post_title(); ?></h1>
				<?php endif; ?>
			</header>
		<?php endif; ?>

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
