<?php
/**
 * Comments: the list and the reply form.
 *
 * @package N0KMO_LCARS
 */

if ( post_password_required() ) {
	return;
}
?>

<section id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title lcars-text-bar">
			<?php
			$n0kmo_lcars_comment_count = (int) get_comments_number();
			printf(
				/* translators: %s: Number of comments. */
				esc_html( _n( '%s comment', '%s comments', $n0kmo_lcars_comment_count, 'n0kmo-lcars' ) ),
				esc_html( number_format_i18n( $n0kmo_lcars_comment_count ) )
			);
			?>
		</h2>

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation();

		if ( ! comments_open() ) :
			?>
			<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'n0kmo-lcars' ); ?></p>
			<?php
		endif;
	endif;

	comment_form(
		array(
			'title_reply_before' => '<h2 id="reply-title" class="comment-reply-title lcars-text-bar">',
			'title_reply_after'  => '</h2>',
			'class_submit'       => 'submit lcars-button',
		)
	);
	?>

</section>
