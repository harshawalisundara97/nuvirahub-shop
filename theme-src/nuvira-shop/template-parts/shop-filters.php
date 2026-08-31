<?php
/**
 * Shop sidebar filters — wraps WooCommerce's own price, category and
 * rating filter widgets (so the actual query-string filtering logic is
 * WooCommerce's, not hand-rolled) plus a simple in-stock toggle and a
 * wholesale/bulk-order card.
 *
 * @package NuviraShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$nuvira_active_filters = array();
if ( isset( $_GET['min_price'] ) || isset( $_GET['max_price'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended -- read-only filter state, no form processed here.
	$nuvira_active_filters[] = array(
		'label' => sprintf(
			'€%s–€%s',
			isset( $_GET['min_price'] ) ? sanitize_text_field( wp_unslash( $_GET['min_price'] ) ) : '0', // phpcs:ignore WordPress.Security.NonceVerification.Recommended
			isset( $_GET['max_price'] ) ? sanitize_text_field( wp_unslash( $_GET['max_price'] ) ) : '' // phpcs:ignore WordPress.Security.NonceVerification.Recommended
		),
		'remove_url' => remove_query_arg( array( 'min_price', 'max_price' ) ),
	);
}
if ( isset( $_GET['nuvira_in_stock'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Recommended
	$nuvira_active_filters[] = array(
		'label'      => __( 'In stock only', 'nuvira-shop' ),
		'remove_url' => remove_query_arg( 'nuvira_in_stock' ),
	);
}
?>
<div class="ns-filters">
	<div class="ns-filters-head">
		<span class="ns-filters-title"><?php echo nuvira_shop_icon( 'sliders' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?><?php esc_html_e( 'Filters', 'nuvira-shop' ); ?></span>
		<?php if ( $nuvira_active_filters ) : ?>
			<a class="ns-filters-clear" href="<?php echo esc_url( remove_query_arg( array( 'min_price', 'max_price', 'nuvira_in_stock', 'rating_filter' ) ) ); ?>"><?php esc_html_e( 'Clear', 'nuvira-shop' ); ?></a>
		<?php endif; ?>
	</div>

	<?php if ( $nuvira_active_filters ) : ?>
		<div class="ns-filter-chips">
			<?php foreach ( $nuvira_active_filters as $chip ) : ?>
				<a class="ns-filter-chip" href="<?php echo esc_url( $chip['remove_url'] ); ?>"><?php echo esc_html( $chip['label'] ); ?> <span aria-hidden="true">&times;</span></a>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>

	<div class="ns-filter-section ns-filter-price">
		<?php
		the_widget(
			'WC_Widget_Price_Filter',
			array( 'title' => __( 'Price', 'nuvira-shop' ) ),
			array(
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '<h4 class="ns-filter-label">',
				'after_title'   => '</h4>',
			)
		);
		?>
	</div>

	<div class="ns-filter-section ns-filter-categories">
		<h4 class="ns-filter-label"><?php esc_html_e( 'Category', 'nuvira-shop' ); ?></h4>
		<?php
		the_widget(
			'WC_Widget_Product_Categories',
			array(
				'count'              => 1,
				'hierarchical'       => 1,
				'show_children_only' => 0,
				'dropdown'           => 0,
			),
			array(
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '<span style="display:none">',
				'after_title'   => '</span>',
			)
		);
		?>
	</div>

	<div class="ns-filter-section">
		<h4 class="ns-filter-label"><?php esc_html_e( 'Availability', 'nuvira-shop' ); ?></h4>
		<a class="ns-toggle-row" href="<?php echo isset( $_GET['nuvira_in_stock'] ) ? esc_url( remove_query_arg( 'nuvira_in_stock' ) ) : esc_url( add_query_arg( 'nuvira_in_stock', '1' ) ); // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>">
			<span><?php esc_html_e( 'In stock only', 'nuvira-shop' ); ?></span>
			<span class="ns-toggle-pill<?php echo isset( $_GET['nuvira_in_stock'] ) ? ' is-on' : ''; ?>" aria-hidden="true"><span class="ns-toggle-knob"></span></span> <?php // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
		</a>
	</div>

	<div class="ns-filter-section ns-filter-rating">
		<h4 class="ns-filter-label"><?php esc_html_e( 'Rating', 'nuvira-shop' ); ?></h4>
		<?php
		the_widget(
			'WC_Widget_Rating_Filter',
			array(),
			array(
				'before_widget' => '',
				'after_widget'  => '',
				'before_title'  => '<span style="display:none">',
				'after_title'   => '</span>',
			)
		);
		?>
	</div>

	<div class="ns-filter-promo">
		<strong><?php esc_html_e( 'Buying in bulk?', 'nuvira-shop' ); ?></strong>
		<p><?php esc_html_e( 'Message us on WhatsApp for wholesale pricing on restaurant or shop-size orders.', 'nuvira-shop' ); ?></p>
		<a class="ns-btn ns-btn-ghost-sage" href="<?php echo esc_url( nuvira_shop_wa_link( __( 'Hi! I want to ask about wholesale pricing for a bulk order.', 'nuvira-shop' ) ) ); ?>"><?php esc_html_e( 'Ask on WhatsApp', 'nuvira-shop' ); ?></a>
	</div>
</div>
