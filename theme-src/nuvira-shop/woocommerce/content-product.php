<?php
/**
 * Product card in the shop loop — overrides WooCommerce's own
 * content-product.php so the shop archive, related products, upsells,
 * and cross-sells all share the ns-product-card markup used on the
 * homepage teaser, via nuvira_shop_product_card().
 *
 * @package NuviraShop
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}
?>
<li <?php wc_product_class( '', $product ); ?>>
	<?php nuvira_shop_product_card( $product, true ); ?>
</li>
