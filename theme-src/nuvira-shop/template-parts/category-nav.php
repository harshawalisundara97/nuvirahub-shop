<?php
/**
 * Category navigation bar — populated dynamically from top-level
 * product_cat terms, so it stays in sync with whatever the shop owner
 * sets up in Products → Categories without any menu maintenance.
 *
 * @package NuviraShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'wc_get_page_permalink' ) ) {
	return;
}

$nuvira_categories = get_terms(
	array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => false,
		'parent'     => 0,
	)
);

if ( empty( $nuvira_categories ) || is_wp_error( $nuvira_categories ) ) {
	return;
}

$nuvira_current_term = is_tax( 'product_cat' ) ? get_queried_object() : null;
?>
<nav class="ns-cat-bar" aria-label="<?php esc_attr_e( 'Product categories', 'nuvira-shop' ); ?>">
	<div class="ns-cat-bar-inner">
		<div class="ns-cat-bar-links" id="ns-cat-bar-links">
			<?php foreach ( $nuvira_categories as $nuvira_category ) : ?>
				<a
					href="<?php echo esc_url( get_term_link( $nuvira_category ) ); ?>"
					<?php echo ( $nuvira_current_term && $nuvira_current_term->term_id === $nuvira_category->term_id ) ? 'class="is-active"' : ''; ?>
				>
					<?php echo esc_html( $nuvira_category->name ); ?>
				</a>
			<?php endforeach; ?>
		</div>
		<button class="ns-menu-toggle" type="button" aria-label="<?php esc_attr_e( 'Menu', 'nuvira-shop' ); ?>" aria-expanded="false" aria-controls="ns-cat-bar-links">
			<span class="ns-icon-open"><?php echo nuvira_shop_icon( 'menu' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?></span>
			<span class="ns-icon-close"><?php echo nuvira_shop_icon( 'close' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG, no user input. ?></span>
		</button>
	</div>
</nav>
