<?php
/**
 * The header: document head, the LCARS top frame and the opening of the
 * main frame. The main frame is closed in footer.php.
 *
 * @package N0KMO_LCARS
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> class="no-js">
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'n0kmo-lcars' ); ?></a>

<div id="page" class="site wrap-standard">

	<?php if ( ! n0kmo_lcars_elementor_location( 'header' ) ) : ?>
		<header id="masthead" class="site-header wrap">
			<div class="left-frame-top">
				<a class="panel-1" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html( n0kmo_lcars_option( 'panel_label' ) ); ?><span class="screen-reader-text"> <?php esc_html_e( 'Home', 'n0kmo-lcars' ); ?></span></a>
				<div class="panel-2">
					<?php n0kmo_lcars_panel_2_readout(); ?>
				</div>
			</div>

			<div class="right-frame-top">
				<div class="banner">
					<?php if ( has_custom_logo() ) : ?>
						<div class="site-logo"><?php the_custom_logo(); ?></div>
					<?php endif; ?>
					<div class="site-branding">
						<?php
						n0kmo_lcars_site_title();
						n0kmo_lcars_site_description();
						?>
					</div>
				</div>

				<div class="data-cascade-button-group">
					<?php n0kmo_lcars_data_cascade(); ?>

					<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Main menu', 'n0kmo-lcars' ); ?>">
						<button class="menu-toggle" type="button" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Menu', 'n0kmo-lcars' ); ?></button>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'primary',
								'container'      => false,
								'menu_id'        => 'primary-menu',
								'menu_class'     => 'lcars-nav-buttons',
								'depth'          => 1,
								'fallback_cb'    => 'n0kmo_lcars_primary_menu_fallback',
							)
						);
						?>
					</nav>
				</div>

				<div class="bar-panel first-bar-panel" aria-hidden="true">
					<div class="bar-1"></div>
					<div class="bar-2"></div>
					<div class="bar-3"></div>
					<div class="bar-4"></div>
					<div class="bar-5"></div>
				</div>
			</div>
		</header>
	<?php endif; ?>

	<div id="gap" class="wrap site-frame">
		<div class="left-frame">
			<div class="panel-3" aria-hidden="true"><span class="lcars-panel__label">03<span class="hop">-<?php echo esc_html( n0kmo_lcars_panel_code( 3 ) ); ?></span></span></div>
			<?php n0kmo_lcars_side_panels(); ?>
			<div class="panel-10" aria-hidden="true"></div>
			<a id="topBtn" href="#page" tabindex="-1" aria-hidden="true"><span><span class="hop"><?php esc_html_e( 'Screen', 'n0kmo-lcars' ); ?> </span><?php esc_html_e( 'Top', 'n0kmo-lcars' ); ?></span></a>
		</div>

		<div class="right-frame">
			<div class="bar-panel" aria-hidden="true">
				<div class="bar-6"></div>
				<div class="bar-7"></div>
				<div class="bar-8"></div>
				<div class="bar-9"></div>
				<div class="bar-10"></div>
			</div>

			<div id="content" class="site-content">
