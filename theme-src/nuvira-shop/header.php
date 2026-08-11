<?php
/**
 * Header — sticky pill nav on a deep teal ground.
 *
 * @package NuviraShop
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="ns-header">
	<div class="ns-header-row">
		<a class="ns-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">Nuvira Shop</a>

		<?php if ( has_nav_menu( 'primary' ) ) : ?>
			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'container'      => false,
				'menu_class'     => 'ns-nav',
			) );
			?>
		<?php else : ?>
			<?php nuvira_shop_fallback_menu(); ?>
		<?php endif; ?>

		<a class="ns-cart-link" href="<?php echo function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '#'; ?>">
			Cart
			<span class="ns-cart-count"><?php echo (int) nuvira_shop_cart_count(); ?></span>
		</a>

		<button class="ns-menu-toggle" type="button" aria-label="Menu">☰</button>
	</div>
</header>
