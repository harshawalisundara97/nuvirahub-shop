<?php
/**
 * Shop / category / tag archive — adds the filter sidebar and grid/list
 * toggle around WooCommerce's native loop, result count, ordering and
 * pagination so sorting, filtering and AJAX add-to-cart keep working
 * exactly as WooCommerce expects.
 *
 * Based on WooCommerce core's archive-product.php (see woocommerce/templates/archive-product.php).
 *
 * @package NuviraShop
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header( 'shop' );

/**
 * Hook: woocommerce_before_main_content.
 *
 * @hooked woocommerce_breadcrumb - 20
 */
do_action( 'woocommerce_before_main_content' );
?>

<div class="ns-shop-head">
	<div>
		<h1 class="ns-shop-title"><?php woocommerce_page_title(); ?></h1>
		<?php if ( wc_get_loop_prop( 'total' ) ) : ?>
			<p class="ns-shop-meta">
				<?php
				echo esc_html(
					sprintf(
						/* translators: %s: number of products. */
						_n( '%s product', '%s products', wc_get_loop_prop( 'total' ), 'nuvira-shop' ),
						number_format_i18n( wc_get_loop_prop( 'total' ) )
					)
				);
				?>
			</p>
		<?php endif; ?>
	</div>
	<div class="ns-shop-view-toggle" role="group" aria-label="<?php esc_attr_e( 'Switch layout', 'nuvira-shop' ); ?>">
		<button type="button" class="ns-view-btn is-active" data-view="grid" aria-label="<?php esc_attr_e( 'Grid view', 'nuvira-shop' ); ?>">
			<?php echo nuvira_shop_icon( 'grid' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG. ?>
		</button>
		<button type="button" class="ns-view-btn" data-view="list" aria-label="<?php esc_attr_e( 'List view', 'nuvira-shop' ); ?>">
			<?php echo nuvira_shop_icon( 'list' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- static inline SVG. ?>
		</button>
	</div>
</div>

<div class="ns-shop-layout">
	<aside class="ns-shop-sidebar">
		<?php get_template_part( 'template-parts/shop-filters' ); ?>
	</aside>

	<div class="ns-shop-main">
		<?php if ( woocommerce_product_loop() ) : ?>

			<div class="ns-shop-controls">
				<?php
				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked woocommerce_output_all_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
				?>
			</div>

			<?php
			woocommerce_product_loop_start();

			if ( wc_get_loop_prop( 'total' ) ) {
				while ( have_posts() ) {
					the_post();
					do_action( 'woocommerce_shop_loop' );
					wc_get_template_part( 'content', 'product' );
				}
			}

			woocommerce_product_loop_end();

			/**
			 * Hook: woocommerce_after_shop_loop.
			 *
			 * @hooked woocommerce_pagination - 10
			 */
			do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php else : ?>
			<?php do_action( 'woocommerce_no_products_found' ); ?>
		<?php endif; ?>
	</div>
</div>

<?php
/**
 * Hook: woocommerce_after_main_content.
 */
do_action( 'woocommerce_after_main_content' );

get_footer( 'shop' );
