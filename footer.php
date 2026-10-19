<?php
/**
 * The footer: closes the content area and the LCARS main frame opened in
 * header.php.
 *
 * @package N0KMO_LCARS
 */

?>
			</div><!-- #content -->

			<footer id="colophon" class="site-footer">
				<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
					<div class="footer-widgets widget-area">
						<?php dynamic_sidebar( 'footer-1' ); ?>
					</div>
				<?php endif; ?>

				<?php if ( has_nav_menu( 'footer' ) ) : ?>
					<nav class="footer-navigation" aria-label="<?php esc_attr_e( 'Footer menu', 'n0kmo-lcars' ); ?>">
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'footer',
								'container'      => false,
								'menu_class'     => 'footer-menu',
								'depth'          => 1,
							)
						);
						?>
					</nav>
				<?php endif; ?>

				<div class="site-info">
					<p class="site-copyright"><?php echo wp_kses_post( n0kmo_lcars_footer_text() ); ?></p>
					<?php if ( n0kmo_lcars_option( 'show_credit' ) ) : ?>
						<p class="site-credit">
							<?php
							printf(
								/* translators: 1: Link to TheLCARS.com. 2: Link to WordPress.org. */
								esc_html__( 'LCARS interface styling inspired by %1$s. Powered by %2$s.', 'n0kmo-lcars' ),
								'<a href="https://www.thelcars.com/">TheLCARS.com</a>',
								'<a href="' . esc_url( __( 'https://wordpress.org/', 'n0kmo-lcars' ) ) . '">WordPress</a>'
							);
							?>
						</p>
					<?php endif; ?>
					<a class="screen-reader-text" href="#page"><?php esc_html_e( 'Back to top', 'n0kmo-lcars' ); ?></a>
				</div>
			</footer>

			<div class="bar-panel last-bar-panel" aria-hidden="true">
				<div class="bar-11"></div>
				<div class="bar-12"></div>
				<div class="bar-13"></div>
				<div class="bar-14"></div>
				<div class="bar-15"></div>
			</div>
		</div><!-- .right-frame -->
	</div><!-- #gap -->

</div><!-- #page -->

<?php wp_footer(); ?>
</body>
</html>
