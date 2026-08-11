<?php
/**
 * Nuvira Shop theme bootstrap.
 *
 * @package NuviraShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NUVIRA_SHOP_WHATSAPP', '94716722599' );

require get_theme_file_path( '/inc/template-tags.php' );

/**
 * WhatsApp deep link with a URL-encoded pre-filled message.
 *
 * @param string $message Pre-filled message text.
 * @return string wa.me URL.
 */
function nuvira_shop_wa_link( $message ) {
	return 'https://wa.me/' . NUVIRA_SHOP_WHATSAPP . '?text=' . rawurlencode( $message );
}

/**
 * Theme setup — supports, menus, thumbnails.
 */
add_action(
	'after_setup_theme',
	function () {
		load_theme_textdomain( 'nuvira-shop', get_template_directory() . '/languages' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );

		register_nav_menus(
			array(
				'primary' => __( 'Primary Menu', 'nuvira-shop' ),
			)
		);
	}
);

/**
 * Enqueue theme stylesheet.
 */
add_action(
	'wp_enqueue_scripts',
	function () {
		wp_enqueue_style( 'nuvira-shop-style', get_stylesheet_uri(), array(), wp_get_theme()->get( 'Version' ) );
		wp_enqueue_script( 'nuvira-shop-nav', get_theme_file_uri( '/assets/js/nav.js' ), array(), wp_get_theme()->get( 'Version' ), true );
	}
);

/**
 * The theme's own CSS fully styles WooCommerce (shop grid, product page,
 * cart, checkout) — skip enqueuing WooCommerce's bundled frontend
 * stylesheet so its float-based grid and default colors can't fight ours.
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * WooCommerce, when a theme declares `add_theme_support( 'woocommerce' )`,
 * expects the theme to wrap shop/product page content itself via these two
 * hooks instead of relying on WooCommerce's own wrapper markup.
 */
add_action(
	'woocommerce_before_main_content',
	function () {
		echo '<main class="ns-main"><div class="ns-container">';
	}
);
add_action(
	'woocommerce_after_main_content',
	function () {
		echo '</div></main>';
	}
);

/**
 * Cart item count for the header cart pill.
 *
 * @return int
 */
function nuvira_shop_cart_count() {
	if ( ! function_exists( 'WC' ) || ! WC()->cart ) {
		return 0;
	}
	return WC()->cart->get_cart_contents_count();
}

/**
 * Register the default fallback menu when no "Primary Menu" is assigned yet.
 */
function nuvira_shop_fallback_menu() {
	echo '<ul class="ns-nav" id="ns-primary-nav">';
	echo '<li><a href="' . esc_url( home_url( '/' ) ) . '">Home</a></li>';
	if ( function_exists( 'wc_get_page_permalink' ) ) {
		echo '<li><a href="' . esc_url( wc_get_page_permalink( 'shop' ) ) . '">Shop</a></li>';
	}
	echo '</ul>';
}
