<?php
/**
 * Template tags used by the theme's templates.
 *
 * @package N0KMO_LCARS
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Convert a Unix timestamp to a TNG-style stardate.
 *
 * Uses a common fan convention: 1987, the year The Next Generation premiered
 * with stardates in the 41000s, is stardate 41000, and each calendar year adds
 * 1000. Keep in step with stardate() in assets/js/lcars.js.
 *
 * @param int|null $timestamp Unix timestamp, defaults to now.
 * @return string Stardate with one decimal place, e.g. "80795.2".
 */
function n0kmo_lcars_stardate( $timestamp = null ) {
	$timestamp = null === $timestamp ? time() : (int) $timestamp;
	$year      = (int) gmdate( 'Y', $timestamp );
	$start     = gmmktime( 0, 0, 0, 1, 1, $year );
	$end       = gmmktime( 0, 0, 0, 1, 1, $year + 1 );
	$stardate  = 41000 + ( $year - 1987 ) * 1000 + ( ( $timestamp - $start ) / ( $end - $start ) ) * 1000;

	return number_format( floor( $stardate * 10 ) / 10, 1, '.', '' );
}

/**
 * A stable six-digit code for a decorative panel, unique to this site.
 *
 * @param int $panel Panel number.
 * @return string
 */
function n0kmo_lcars_panel_code( $panel ) {
	return str_pad( (string) ( crc32( home_url() . '|panel|' . $panel ) % 1000000 ), 6, '0', STR_PAD_LEFT );
}

/**
 * Text shown large in the header banner.
 *
 * @return string
 */
function n0kmo_lcars_banner_text() {
	$text = trim( (string) n0kmo_lcars_option( 'banner_text' ) );

	return '' !== $text ? $text : get_bloginfo( 'name', 'display' );
}

/**
 * Banner text as HTML, with zeros marked up for the slashed-zero style.
 *
 * Antonio has no slashed zero, and in a callsign such as N0KMO a plain zero
 * reads as the letter O. Each zero is wrapped in a span that CSS draws a slash
 * through; the text itself is unchanged for copying, search and screen
 * readers.
 *
 * @return string Escaped HTML.
 */
function n0kmo_lcars_banner_html() {
	$text = esc_html( n0kmo_lcars_banner_text() );

	if ( ! n0kmo_lcars_option( 'slashed_zero' ) ) {
		return $text;
	}

	// Skip character references such as &#039; so they stay intact.
	return preg_replace( '/&#?[a-z0-9]+;(*SKIP)(*FAIL)|0/i', '<span class="lcars-zero">0</span>', $text );
}

/**
 * Print the banner title: <h1> on the blog front page, <p> elsewhere.
 */
function n0kmo_lcars_site_title() {
	$tag = is_front_page() && is_home() ? 'h1' : 'p';

	printf(
		'<%1$s class="site-title"><a href="%2$s" rel="home">%3$s</a></%1$s>',
		tag_escape( $tag ),
		esc_url( home_url( '/' ) ),
		n0kmo_lcars_banner_html() // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped in n0kmo_lcars_banner_html().
	);
}

/**
 * Print the tagline line under the banner, with the stardate readout.
 */
function n0kmo_lcars_site_description() {
	$description   = get_bloginfo( 'description', 'display' );
	$show_stardate = n0kmo_lcars_option( 'show_stardate' );

	if ( ! $description && ! $show_stardate && ! is_customize_preview() ) {
		return;
	}

	echo '<p class="site-description">';

	if ( $description || is_customize_preview() ) {
		echo '<span class="site-description__text">' . esc_html( $description ) . '</span>';
	}

	if ( $show_stardate ) {
		printf(
			'%1$s<span class="lcars-stardate-readout">%2$s <span data-lcars-stardate>%3$s</span></span>',
			$description ? ' <span aria-hidden="true">&bull;</span> ' : '',
			esc_html__( 'Stardate', 'n0kmo-lcars' ),
			esc_html( n0kmo_lcars_stardate() )
		);
	}

	echo '</p>';
}

/**
 * Print the UTC clock (or a panel code) for the top elbow panel.
 */
function n0kmo_lcars_panel_2_readout() {
	if ( ! n0kmo_lcars_option( 'show_clock' ) ) {
		printf( '<span class="lcars-panel__label">02<span class="hop">-%s</span></span>', esc_html( n0kmo_lcars_panel_code( 2 ) ) );
		return;
	}

	$now = time();

	printf(
		'<span class="lcars-clock"><span class="lcars-clock__zone">%1$s</span> <time class="lcars-clock__time" data-lcars-clock datetime="%2$s"><span class="lcars-clock__hm">%3$s</span><span class="lcars-clock__s hop">:%4$s</span></time></span>',
		esc_html__( 'UTC', 'n0kmo-lcars' ),
		esc_attr( gmdate( 'c', $now ) ),
		esc_html( gmdate( 'H:i', $now ) ),
		esc_html( gmdate( 's', $now ) )
	);
}

/**
 * Print the animated data cascade: columns of numbers in the header.
 *
 * The numbers are derived from a hash rather than a random generator so the
 * markup is the same on every request and safe to cache.
 *
 * @param int $columns Number of columns.
 * @param int $rows    Rows per column.
 */
function n0kmo_lcars_data_cascade( $columns = 22, $rows = 7 ) {
	if ( ! n0kmo_lcars_option( 'show_cascade' ) ) {
		return;
	}

	echo '<div class="data-cascade-wrapper" aria-hidden="true" data-nosnippet>';

	for ( $column = 0; $column < $columns; $column++ ) {
		echo '<div class="data-column">';

		for ( $row = 1; $row <= $rows; $row++ ) {
			$hash   = crc32( 'n0kmo-lcars-cascade-' . $column . '-' . $row );
			$digits = 1 + ( $hash % 6 );
			$number = ( $hash >> 4 ) % (int) pow( 10, $digits );

			printf( '<div class="dc-row-%1$d">%2$d</div>', (int) $row, (int) $number );
		}

		echo '</div>';
	}

	echo '</div>';
}

/**
 * Print the side panels: the "side" menu if assigned, decorative panels if not.
 */
function n0kmo_lcars_side_panels() {
	if ( has_nav_menu( 'side' ) ) {
		printf( '<nav class="side-navigation" aria-label="%s">', esc_attr__( 'Side menu', 'n0kmo-lcars' ) );
		wp_nav_menu(
			array(
				'theme_location' => 'side',
				'container'      => false,
				'menu_class'     => 'lcars-side-panels',
				'depth'          => 2,
			)
		);
		echo '</nav>';
		return;
	}

	echo '<div class="lcars-decor-panels" aria-hidden="true">';

	for ( $panel = 4; $panel <= 9; $panel++ ) {
		printf(
			'<div class="panel-%1$d lcars-panel"><span class="lcars-panel__label">%2$s<span class="hop">-%3$s</span></span></div>',
			(int) $panel,
			esc_html( str_pad( (string) $panel, 2, '0', STR_PAD_LEFT ) ),
			esc_html( n0kmo_lcars_panel_code( $panel ) )
		);
	}

	echo '</div>';
}

/**
 * Print the text-bar label above a post or page title.
 */
function n0kmo_lcars_record_label() {
	if ( is_sticky() && ! is_singular() ) {
		$label = __( 'Priority record', 'n0kmo-lcars' );
	} elseif ( 'page' === get_post_type() ) {
		/* translators: %s: Zero-padded page ID. */
		$label = sprintf( __( 'Library record %s', 'n0kmo-lcars' ), str_pad( (string) get_the_ID(), 4, '0', STR_PAD_LEFT ) );
	} else {
		/* translators: %s: Zero-padded post ID. */
		$label = sprintf( __( 'Log entry %s', 'n0kmo-lcars' ), str_pad( (string) get_the_ID(), 4, '0', STR_PAD_LEFT ) );
	}

	echo esc_html( $label );
}

/**
 * Print the meta pills for a post: date, stardate, author and comments.
 */
function n0kmo_lcars_entry_meta() {
	if ( 'post' !== get_post_type() ) {
		return;
	}

	$time = sprintf(
		'<time class="entry-date published" datetime="%1$s">%2$s</time>',
		esc_attr( get_the_date( DATE_W3C ) ),
		esc_html( get_the_date() )
	);

	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time .= sprintf(
			'<time class="updated screen-reader-text" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);
	}

	echo '<ul class="lcars-pills entry-meta">';

	printf(
		'<li class="lcars-pill posted-on"><span class="screen-reader-text">%1$s</span><a href="%2$s" rel="bookmark">%3$s</a></li>',
		esc_html__( 'Posted on', 'n0kmo-lcars' ),
		esc_url( get_permalink() ),
		$time // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped above.
	);

	if ( n0kmo_lcars_option( 'show_stardate' ) ) {
		printf(
			'<li class="lcars-pill stardate">%1$s %2$s</li>',
			esc_html__( 'Stardate', 'n0kmo-lcars' ),
			esc_html( n0kmo_lcars_stardate( (int) get_post_time( 'U', true ) ) )
		);
	}

	printf(
		'<li class="lcars-pill byline"><span class="screen-reader-text">%1$s</span><span class="author vcard"><a class="url fn n" href="%2$s">%3$s</a></span></li>',
		esc_html__( 'Author', 'n0kmo-lcars' ),
		esc_url( get_author_posts_url( (int) get_the_author_meta( 'ID' ) ) ),
		esc_html( get_the_author() )
	);

	if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<li class="lcars-pill comments-link">';
		comments_popup_link(
			esc_html__( 'Leave a comment', 'n0kmo-lcars' ),
			esc_html__( '1 comment', 'n0kmo-lcars' ),
			/* translators: %: Number of comments. */
			esc_html__( '% comments', 'n0kmo-lcars' )
		);
		echo '</li>';
	}

	echo '</ul>';
}

/**
 * Print categories, tags and the edit link below a single post.
 */
function n0kmo_lcars_entry_footer() {
	if ( 'post' === get_post_type() ) {
		$categories = get_the_category_list( '' );

		if ( $categories ) {
			printf(
				'<div class="lcars-taxonomy cat-links"><span class="lcars-taxonomy__label">%1$s</span>%2$s</div>',
				esc_html__( 'Filed under', 'n0kmo-lcars' ),
				$categories // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core output.
			);
		}

		$tags = get_the_tag_list( '<ul class="post-tags"><li>', '</li><li>', '</li></ul>' );

		if ( $tags && ! is_wp_error( $tags ) ) {
			printf(
				'<div class="lcars-taxonomy tags-links"><span class="lcars-taxonomy__label">%1$s</span>%2$s</div>',
				esc_html__( 'Tags', 'n0kmo-lcars' ),
				$tags // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Core output.
			);
		}
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Post title. Only visible to screen readers. */
			esc_html__( 'Edit %s', 'n0kmo-lcars' ),
			'<span class="screen-reader-text">' . esc_html( get_the_title() ) . '</span>'
		)
	);
}

/**
 * Print the featured image: a figure on single views, a link in lists.
 *
 * @param string $size Image size.
 */
function n0kmo_lcars_post_thumbnail( $size = 'large' ) {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}

	if ( is_singular() ) {
		echo '<figure class="post-thumbnail">';
		the_post_thumbnail( $size );
		echo '</figure>';
		return;
	}

	printf( '<a class="post-thumbnail" href="%s" aria-hidden="true" tabindex="-1">', esc_url( get_permalink() ) );
	the_post_thumbnail( $size, array( 'alt' => '' ) );
	echo '</a>';
}

/**
 * Print the "Access record" button at the end of a post summary.
 */
function n0kmo_lcars_read_more_button() {
	printf(
		'<a class="lcars-button" href="%1$s">%2$s<span class="screen-reader-text">: %3$s</span></a>',
		esc_url( get_permalink() ),
		esc_html__( 'Access record', 'n0kmo-lcars' ),
		esc_html( get_the_title() )
	);
}

/**
 * Print numbered pagination for post lists.
 */
function n0kmo_lcars_pagination() {
	the_posts_pagination(
		array(
			'mid_size'  => 2,
			'prev_text' => esc_html__( 'Previous', 'n0kmo-lcars' ),
			'next_text' => esc_html__( 'Next', 'n0kmo-lcars' ),
		)
	);
}

/**
 * Label for the text bar above an archive title.
 *
 * @return string
 */
function n0kmo_lcars_archive_label() {
	if ( is_category() ) {
		return __( 'Category', 'n0kmo-lcars' );
	}

	if ( is_tag() ) {
		return __( 'Tag', 'n0kmo-lcars' );
	}

	if ( is_author() ) {
		return __( 'Personnel file', 'n0kmo-lcars' );
	}

	if ( is_year() || is_month() || is_day() ) {
		return __( 'Chronological index', 'n0kmo-lcars' );
	}

	if ( is_tax() ) {
		$taxonomy = get_taxonomy( get_queried_object()->taxonomy );

		if ( $taxonomy ) {
			return $taxonomy->labels->singular_name;
		}
	}

	if ( is_post_type_archive() ) {
		return __( 'Collection', 'n0kmo-lcars' );
	}

	return __( 'Archive', 'n0kmo-lcars' );
}

/**
 * Footer copyright line. Supports a {year} placeholder in custom text.
 *
 * @return string HTML.
 */
function n0kmo_lcars_footer_text() {
	$text = trim( (string) n0kmo_lcars_option( 'footer_text' ) );

	if ( '' === $text ) {
		/* translators: 1: Current year. 2: Site name. */
		$text = sprintf( __( 'Content copyright &copy; %1$s %2$s', 'n0kmo-lcars' ), '{year}', get_bloginfo( 'name', 'display' ) );
	}

	return str_replace( '{year}', esc_html( wp_date( 'Y' ) ), $text );
}
