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
				'menu_id'        => 'ns-primary-nav',
			) );
			?>
		<?php else : ?>
			<?php nuvira_shop_fallback_menu(); ?>
		<?php endif; ?>

		<a class="ns-cart-link" href="<?php echo function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '#'; ?>">
			<?php echo nuvira_shop_icon( 'cart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?>
			<span class="ns-cart-count"><?php echo (int) nuvira_shop_cart_count(); ?></span>
		</a>

		<button class="ns-menu-toggle" type="button" aria-label="<?php esc_attr_e( 'Menu', 'nuvira-shop' ); ?>" aria-expanded="false" aria-controls="ns-primary-nav">
			<span class="ns-icon-open"><?php echo nuvira_shop_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?></span>
			<span class="ns-icon-close"><?php echo nuvira_shop_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?></span>
		</button>
	</div>
</header>
