<?php
/**
 * Admin dashboard simplifications for a single-shop-owner WooCommerce site:
 * fewer irrelevant menu items, and land on the product list after login
 * instead of the generic WordPress dashboard.
 *
 * @package NuviraShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Hide the Posts menu — this site has no blog, so it's just clutter.
 * WooCommerce's own menus (Products, Orders, ...) use different slugs and
 * are unaffected.
 */
add_action(
	'admin_menu',
	function () {
		remove_menu_page( 'edit.php' );
	},
	999
);

/**
 * Send admins/shop managers straight to the product list after logging in.
 *
 * @param string           $redirect_to           Default redirect URL.
 * @param string           $requested_redirect_to  Requested redirect URL, if any.
 * @param WP_User|WP_Error $user                   Logged-in user object.
 * @return string
 */
add_filter(
	'login_redirect',
	function ( $redirect_to, $requested_redirect_to, $user ) {
		$is_default_redirect = empty( $requested_redirect_to ) || untrailingslashit( $requested_redirect_to ) === untrailingslashit( admin_url() );

		if ( ! $is_default_redirect || ! ( $user instanceof WP_User ) ) {
			return $redirect_to;
		}

		if ( array_intersect( array( 'administrator', 'shop_manager' ), $user->roles ) ) {
			return admin_url( 'edit.php?post_type=product' );
		}

		return $redirect_to;
	},
	10,
	3
);
