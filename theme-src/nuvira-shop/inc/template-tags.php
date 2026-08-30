<?php
/**
 * Shared template helpers — product card markup, inline icons, and the
 * WooCommerce filters that unify card design and wire up AJAX add-to-cart.
 *
 * @package NuviraShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Renders a single product card. Used by the homepage teaser and by the
 * WooCommerce content-product.php override, so the shop archive, related
 * products, upsells, and cross-sells all share one design.
 *
 * @param WC_Product $product          Product to render.
 * @param bool       $show_add_to_cart Whether to render the add-to-cart button.
 */
function nuvira_shop_product_card( $product, $show_add_to_cart = true ) {
	if ( ! $product instanceof WC_Product ) {
		return;
	}

	$is_new = strtotime( $product->get_date_created() ) > strtotime( '-30 days' );
	$in_wishlist = nuvira_shop_is_in_wishlist( $product->get_id() );
	?>
	<div class="ns-product-card">
		<a class="ns-product-media" href="<?php echo esc_url( $product->get_permalink() ); ?>">
			<?php echo wp_kses_post( $product->get_image() ); ?>
			<div class="ns-badges">
				<?php if ( $product->is_on_sale() ) : ?>
					<span class="onsale"><?php esc_html_e( 'Sale!', 'nuvira-shop' ); ?></span>
				<?php elseif ( $is_new ) : ?>
					<span class="ns-badge ns-badge-new"><?php esc_html_e( 'New!', 'nuvira-shop' ); ?></span>
				<?php endif; ?>
			</div>
		</a>
		<button
			type="button"
			class="ns-wishlist-toggle<?php echo $in_wishlist ? ' is-active' : ''; ?>"
			data-product-id="<?php echo esc_attr( $product->get_id() ); ?>"
			aria-label="<?php esc_attr_e( 'Add to wishlist', 'nuvira-shop' ); ?>"
			aria-pressed="<?php echo $in_wishlist ? 'true' : 'false'; ?>"
		>
			<?php echo nuvira_shop_icon( 'heart' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?>
		</button>
		<div class="ns-product-body">
			<a class="ns-product-title" href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product->get_name() ); ?></a>
			<?php if ( $product->get_rating_count() > 0 ) : ?>
				<div class="ns-product-rating"><?php echo wp_kses_post( wc_get_rating_html( $product->get_average_rating(), $product->get_rating_count() ) ); ?></div>
			<?php endif; ?>
			<div class="ns-product-foot">
				<span class="ns-product-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
				<?php if ( $show_add_to_cart ) : ?>
					<?php nuvira_shop_loop_add_to_cart( $product ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Renders WooCommerce's own loop add-to-cart link for a given product,
 * temporarily setting the `$product` global it relies on. Kept separate
 * from nuvira_shop_product_card() so the global juggling stays in one place.
 *
 * @param WC_Product $wc_product Product to render the add-to-cart link for.
 */
function nuvira_shop_loop_add_to_cart( $wc_product ) {
	global $product;
	$restore = $product;
	$product = $wc_product; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited -- required by woocommerce_template_loop_add_to_cart().
	woocommerce_template_loop_add_to_cart();
	$product = $restore; // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited
}

/**
 * Swaps WooCommerce's default loop add-to-cart button styling for the
 * theme's round icon button, keeping the AJAX-related classes/attributes
 * WooCommerce needs intact.
 */
add_filter(
	'woocommerce_loop_add_to_cart_link',
	function ( $html, $product ) {
		if ( ! $product->is_type( 'simple' ) ) {
			return $html;
		}
		$html = str_replace( 'class="', 'class="ns-add-to-cart ', $html );
		return preg_replace( '/>[^<]*<\/a>\s*$/', '><span aria-hidden="true">+</span></a>', $html );
	},
	10,
	2
);

/**
 * Adds the theme's grid class to WooCommerce's `<ul class="products">`
 * wrapper so the shop archive, related products, and upsells lay out the
 * same way as the homepage teaser — no loop-start.php/loop-end.php override
 * needed for this alone.
 */
add_filter(
	'woocommerce_product_loop_start',
	function ( $html ) {
		return str_replace( 'class="products', 'class="products ns-product-grid', $html );
	}
);

/**
 * Keeps the header cart count live after an AJAX add-to-cart, by handing
 * wc-cart-fragments.js fresh markup for the `.ns-cart-count` element.
 *
 * @param array $fragments Cart fragments keyed by CSS selector.
 * @return array
 */
add_filter(
	'woocommerce_add_to_cart_fragments',
	function ( $fragments ) {
		ob_start();
		?>
		<span class="ns-icon-badge ns-cart-count"><?php echo (int) nuvira_shop_cart_count(); ?></span>
		<?php
		$fragments['.ns-cart-count'] = ob_get_clean();
		return $fragments;
	}
);

/**
 * Small inline SVG icons, kept out of the template files. Static trusted
 * markup — no user input — so callers echo the return value with a
 * documented phpcs:ignore rather than passing it through esc_html().
 *
 * @param string $name One of 'menu', 'close', 'cart'.
 * @return string SVG markup, or an empty string if $name isn't known.
 */
function nuvira_shop_icon( $name ) {
	$icons = array(
		'menu'         => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>',
		'close'        => '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" aria-hidden="true" focusable="false"><line x1="5" y1="5" x2="19" y2="19"/><line x1="19" y1="5" x2="5" y2="19"/></svg>',
		'cart'         => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>',
		'search'       => '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
		'user'         => '<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>',
		'heart'        => '<svg width="19" height="19" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>',
		'heart-filled' => '<svg width="19" height="19" viewBox="0 0 24 24" fill="currentColor" stroke="none" aria-hidden="true" focusable="false"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.6l-1-1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.6 1-1a5.5 5.5 0 0 0 0-7.8z"/></svg>',
	);

	return isset( $icons[ $name ] ) ? $icons[ $name ] : '';
}
