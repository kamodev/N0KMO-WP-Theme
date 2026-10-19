<?php
/**
 * Title: LCARS section header
 * Slug: n0kmo-lcars/section-header
 * Categories: n0kmo-lcars
 * Keywords: lcars, heading, intro, separator
 * Description: A text-bar heading, an introduction and a segmented LCARS bar.
 *
 * @package N0KMO_LCARS
 */

?>
<!-- wp:heading {"className":"is-style-lcars-text-bar"} -->
<h2 class="wp-block-heading is-style-lcars-text-bar"><?php echo esc_html_x( 'Mission briefing', 'Pattern heading', 'n0kmo-lcars' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html_x( 'Introduce the section here. Keep it short: a sentence or two on what follows.', 'Pattern text', 'n0kmo-lcars' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:list {"className":"is-style-lcars-list"} -->
<ul class="is-style-lcars-list"><!-- wp:list-item -->
<li><?php echo esc_html_x( 'First objective', 'Pattern list item', 'n0kmo-lcars' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php echo esc_html_x( 'Second objective', 'Pattern list item', 'n0kmo-lcars' ); ?></li>
<!-- /wp:list-item -->

<!-- wp:list-item -->
<li><?php echo esc_html_x( 'Third objective', 'Pattern list item', 'n0kmo-lcars' ); ?></li>
<!-- /wp:list-item --></ul>
<!-- /wp:list -->

<!-- wp:separator {"className":"is-style-lcars-bar"} -->
<hr class="wp-block-separator has-alpha-channel-opacity is-style-lcars-bar"/>
<!-- /wp:separator -->
