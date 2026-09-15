<?php
/**
 * Custom shop-archive filtering that WooCommerce doesn't provide a widget
 * for: the "In stock only" toggle in the filter sidebar.
 *
 * @package NuviraShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'woocommerce_product_query',
	function ( $query ) {
		if ( is_admin() || ! isset( $_GET['nuvira_in_stock'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only GET filter, not a form submission.
			return;
		}
		$meta_query   = $query->get( 'meta_query' ) ?: array(); // phpcs:ignore WordPress.PHP.DisallowShortTernary.Found
		$meta_query[] = array(
			'key'   => '_stock_status',
			'value' => 'instock',
		);
		$query->set( 'meta_query', $meta_query );
	}
);
