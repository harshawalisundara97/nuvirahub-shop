<?php
/**
 * Header — search-forward utility row + category navigation bar.
 *
 * @package NuviraShop
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&family=Caprasimo&display=swap" rel="stylesheet">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="ns-skip-link" href="#ns-main-content"><?php esc_html_e( 'Skip to content', 'nuvira-shop' ); ?></a>

<header class="ns-header">
	<div class="ns-topbar">
		<div class="ns-topbar-inner">
			<span class="ns-topbar-ship">
				<?php echo nuvira_shop_icon( 'truck' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?>
				<?php esc_html_e( 'Free shipping on orders over €45', 'nuvira-shop' ); ?>
			</span>
			<div class="ns-topbar-right">
				<a class="ns-topbar-phone" href="<?php echo esc_url( 'tel:+' . NUVIRA_SHOP_WHATSAPP ); ?>">+94 71 672 2599</a>
				<?php if ( function_exists( 'pll_the_languages' ) ) : ?>
					<div class="ns-lang-switch">
						<?php
						$nuvira_languages = pll_the_languages( array( 'raw' => 1 ) );
						foreach ( (array) $nuvira_languages as $nuvira_language ) :
							?>
							<a class="ns-lang-link<?php echo ! empty( $nuvira_language['current_lang'] ) ? ' is-active' : ''; ?>" href="<?php echo esc_url( $nuvira_language['url'] ); ?>">
								<?php echo esc_html( strtoupper( $nuvira_language['slug'] ) ); ?>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="ns-header-utility">
		<a class="ns-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
			<span class="ns-wordmark">Nuvira</span>
			<span class="ns-wordmark-tag"><?php esc_html_e( 'Shop', 'nuvira-shop' ); ?></span>
		</a>

		<form class="ns-search-form" role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
			<?php echo nuvira_shop_icon( 'search' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?>
			<label class="screen-reader-text" for="ns-search-input"><?php esc_html_e( 'Search products', 'nuvira-shop' ); ?></label>
			<input id="ns-search-input" type="search" name="s" placeholder="<?php esc_attr_e( 'Search products…', 'nuvira-shop' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>">
			<input type="hidden" name="post_type" value="product">
		</form>

		<div class="ns-header-icons">
			<a class="ns-icon-link" href="<?php echo function_exists( 'wc_get_page_permalink' ) ? esc_url( wc_get_page_permalink( 'myaccount' ) ) : '#'; ?>" aria-label="<?php esc_attr_e( 'My account', 'nuvira-shop' ); ?>">
				<?php echo nuvira_shop_icon( 'user' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?>
			</a>
			<a class="ns-icon-link" href="<?php echo function_exists( 'wc_get_account_endpoint_url' ) ? esc_url( wc_get_account_endpoint_url( 'wishlist' ) ) : '#'; ?>" aria-label="<?php esc_attr_e( 'Wishlist', 'nuvira-shop' ); ?>">
				<?php echo nuvira_shop_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?>
				<span class="ns-icon-badge ns-wishlist-count"><?php echo (int) nuvira_shop_wishlist_count(); ?></span>
			</a>
			<a class="ns-cart-pill" href="<?php echo function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '#'; ?>" aria-label="<?php esc_attr_e( 'Cart', 'nuvira-shop' ); ?>">
				<?php echo nuvira_shop_icon( 'cart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?>
				<span class="ns-cart-total"><?php echo wp_kses_post( nuvira_shop_cart_total() ); ?></span>
				<span class="ns-icon-badge ns-cart-count"><?php echo (int) nuvira_shop_cart_count(); ?></span>
			</a>
		</div>
	</div>

	<?php get_template_part( 'template-parts/category-nav' ); ?>
</header>
