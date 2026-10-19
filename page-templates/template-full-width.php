<?php
/**
 * Template Name: Full width (no sidebar)
 * Template Post Type: page, post
 *
 * Same as a regular page or post, without the sidebar widget area.
 *
 * @package N0KMO_LCARS
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php
	while ( have_posts() ) :
		the_post();

		get_template_part( 'template-parts/content', 'page' === get_post_type() ? 'page' : 'single' );

		if ( comments_open() || get_comments_number() ) {
			comments_template();
		}
	endwhile;
	?>

</main>

<?php
get_footer();
