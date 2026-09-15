<?php
/**
 * Single-product page additions — wraps the price/stock block in the
 * "price panel" card from the design spec, and adds a static delivery
 * info panel below add-to-cart. Everything else (gallery, variations,
 * AJAX add-to-cart, tabs, related products) stays on WooCommerce's own
 * templates so its JS keeps working untouched.
 *
 * @package NuviraShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action(
	'wp',
	function () {
		// Move the rating row above the price panel (spec: title -> rating -> price panel).
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 8 );
	}
);

add_action( 'woocommerce_single_product_summary', 'nuvira_shop_open_price_panel', 9 );
/**
 * Opens the price-panel wrapper just before price/rating output.
 */
function nuvira_shop_open_price_panel() {
	echo '<div class="ns-price-panel">';
}

add_action( 'woocommerce_single_product_summary', 'nuvira_shop_close_price_panel', 11 );
/**
 * Closes the price-panel wrapper right after the price, before the short
 * description (priority 20) continues outside the panel.
 */
function nuvira_shop_close_price_panel() {
	echo '</div>';
}

add_action( 'woocommerce_single_product_summary', 'nuvira_shop_delivery_panel', 35 );
/**
 * Static delivery/returns info panel, shown after add-to-cart + stock.
 */
function nuvira_shop_delivery_panel() {
	global $product;
	if ( ! $product instanceof WC_Product ) {
		return;
	}
	?>
	<div class="ns-delivery-panel">
		<div class="ns-delivery-row">
			<?php echo nuvira_shop_icon( 'truck' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div>
				<strong><?php esc_html_e( 'Tracked shipping across Latvia', 'nuvira-shop' ); ?></strong>
				<span><?php esc_html_e( 'Dispatched within 48 hours of a confirmed payment.', 'nuvira-shop' ); ?></span>
			</div>
		</div>
		<div class="ns-delivery-row">
			<?php echo nuvira_shop_icon( 'map-pin' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div>
				<strong><?php esc_html_e( 'Message us to arrange pickup', 'nuvira-shop' ); ?></strong>
				<span><?php esc_html_e( 'Local pickup can be arranged on request via WhatsApp.', 'nuvira-shop' ); ?></span>
			</div>
		</div>
		<div class="ns-delivery-row">
			<?php echo nuvira_shop_icon( 'rotate-ccw' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
			<div>
				<strong><?php esc_html_e( '14-day returns', 'nuvira-shop' ); ?></strong>
				<span><?php esc_html_e( 'Unopened items can be returned within 14 days.', 'nuvira-shop' ); ?></span>
			</div>
		</div>
	</div>
	<?php
}
