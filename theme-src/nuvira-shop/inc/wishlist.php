<?php
/**
 * Lightweight wishlist — no plugin dependency. Logged-in users get their
 * list stored in usermeta; guests get it in a cookie. Exposed as a
 * "Wishlist" tab under My Account, alongside Orders/Addresses.
 *
 * @package NuviraShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'NUVIRA_SHOP_WISHLIST_COOKIE', 'nuvira_wishlist' );

/**
 * Reads the current visitor's wishlist product IDs.
 *
 * @return int[]
 */
function nuvira_shop_get_wishlist() {
	if ( is_user_logged_in() ) {
		$ids = get_user_meta( get_current_user_id(), '_nuvira_wishlist', true );
		return is_array( $ids ) ? array_map( 'absint', $ids ) : array();
	}

	if ( empty( $_COOKIE[ NUVIRA_SHOP_WISHLIST_COOKIE ] ) ) {
		return array();
	}

	$decoded = json_decode( wp_unslash( $_COOKIE[ NUVIRA_SHOP_WISHLIST_COOKIE ] ), true ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash
	return is_array( $decoded ) ? array_map( 'absint', $decoded ) : array();
}

/**
 * Saves the wishlist for the current visitor.
 *
 * @param int[] $ids Product IDs.
 */
function nuvira_shop_save_wishlist( $ids ) {
	$ids = array_values( array_unique( array_map( 'absint', $ids ) ) );

	if ( is_user_logged_in() ) {
		update_user_meta( get_current_user_id(), '_nuvira_wishlist', $ids );
		return;
	}

	setcookie( NUVIRA_SHOP_WISHLIST_COOKIE, wp_json_encode( $ids ), time() + YEAR_IN_SECONDS, COOKIEPATH ? COOKIEPATH : '/', COOKIE_DOMAIN );
}

/**
 * @param int $product_id Product ID.
 * @return bool
 */
function nuvira_shop_is_in_wishlist( $product_id ) {
	return in_array( (int) $product_id, nuvira_shop_get_wishlist(), true );
}

/**
 * @return int
 */
function nuvira_shop_wishlist_count() {
	return count( nuvira_shop_get_wishlist() );
}

/**
 * AJAX: toggle a product in/out of the wishlist.
 */
function nuvira_shop_ajax_toggle_wishlist() {
	check_ajax_referer( 'nuvira-wishlist', 'nonce' );

	$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
	if ( ! $product_id ) {
		wp_send_json_error();
	}

	$ids = nuvira_shop_get_wishlist();
	$in_wishlist = in_array( $product_id, $ids, true );

	if ( $in_wishlist ) {
		$ids = array_diff( $ids, array( $product_id ) );
	} else {
		$ids[] = $product_id;
	}

	nuvira_shop_save_wishlist( $ids );

	wp_send_json_success(
		array(
			'in_wishlist' => ! $in_wishlist,
			'count'       => count( $ids ),
		)
	);
}
add_action( 'wp_ajax_nuvira_toggle_wishlist', 'nuvira_shop_ajax_toggle_wishlist' );
add_action( 'wp_ajax_nopriv_nuvira_toggle_wishlist', 'nuvira_shop_ajax_toggle_wishlist' );

/**
 * Registers the /my-account/wishlist/ endpoint and its nav item.
 */
add_action(
	'init',
	function () {
		add_rewrite_endpoint( 'wishlist', EP_ROOT | EP_PAGES );
	}
);

add_filter(
	'woocommerce_account_menu_items',
	function ( $items ) {
		$new_items = array();
		foreach ( $items as $key => $label ) {
			$new_items[ $key ] = $label;
			if ( 'orders' === $key ) {
				$new_items['wishlist'] = __( 'Wishlist', 'nuvira-shop' );
			}
		}
		return $new_items;
	}
);

add_action(
	'woocommerce_account_wishlist_endpoint',
	function () {
		$ids = nuvira_shop_get_wishlist();

		if ( empty( $ids ) ) {
			echo '<p>' . esc_html__( 'Nothing saved yet. Tap the heart on any product to add it here.', 'nuvira-shop' ) . '</p>';
			return;
		}

		echo '<div class="ns-product-grid">';
		foreach ( $ids as $id ) {
			$product = wc_get_product( $id );
			if ( $product ) {
				nuvira_shop_product_card( $product, true );
			}
		}
		echo '</div>';
	}
);
