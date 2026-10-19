<?php
/**
 * Title: LCARS status panel
 * Slug: n0kmo-lcars/status-panel
 * Categories: n0kmo-lcars
 * Keywords: lcars, status, panel, frame
 * Description: An elbow-framed panel with a text-bar heading, a short readout and buttons.
 *
 * @package N0KMO_LCARS
 */

?>
<!-- wp:group {"className":"is-style-lcars-frame","layout":{"type":"default"}} -->
<div class="wp-block-group is-style-lcars-frame"><!-- wp:heading {"className":"is-style-lcars-text-bar"} -->
<h2 class="wp-block-heading is-style-lcars-text-bar"><?php echo esc_html_x( 'Station status', 'Pattern heading', 'n0kmo-lcars' ); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph -->
<p><?php echo esc_html_x( 'All systems are operating within normal parameters. Use this panel for a status update, an announcement or a short introduction.', 'Pattern text', 'n0kmo-lcars' ); ?></p>
<!-- /wp:paragraph -->

<!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button"><?php echo esc_html_x( 'Details', 'Pattern button', 'n0kmo-lcars' ); ?></a></div>
<!-- /wp:button -->

<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button"><?php echo esc_html_x( 'Contact', 'Pattern button', 'n0kmo-lcars' ); ?></a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->
