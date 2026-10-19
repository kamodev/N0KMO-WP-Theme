<?php
/**
 * Single post template.
 *
 * @package N0KMO_LCARS
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'single' );

		if ( 'post' === get_post_type() ) {
			the_post_navigation(
				array(
					'prev_text' => '<span class="nav-subtitle">' . esc_html__( 'Previous record', 'n0kmo-lcars' ) . '</span> <span class="nav-title">%title</span>',
					'next_text' => '<span class="nav-subtitle">' . esc_html__( 'Next record', 'n0kmo-lcars' ) . '</span> <span class="nav-title">%title</span>',
				)
			);
		}

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>

</main>

<?php
get_sidebar();
get_footer();
