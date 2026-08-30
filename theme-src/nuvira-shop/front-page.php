<?php
/**
 * Homepage — hero + category pills + featured product teaser.
 *
 * @package NuviraShop
 */

get_header();

$nuvira_hero_categories = get_terms(
	array(
		'taxonomy'   => 'product_cat',
		'hide_empty' => true,
		'parent'     => 0,
		'number'     => 6,
	)
);
if ( ! is_array( $nuvira_hero_categories ) ) {
	$nuvira_hero_categories = array();
}
?>

<section class="ns-hero" id="ns-main-content">
	<div class="ns-glow"></div>
	<div class="ns-hero-inner">
		<p class="ns-eyebrow"><?php esc_html_e( 'Ceylon spices, sourced direct', 'nuvira-shop' ); ?></p>
		<h1><?php esc_html_e( 'Buy it the way the market sells it', 'nuvira-shop' ); ?></h1>
		<p class="ns-lede"><?php esc_html_e( 'Loud stalls, warm light, five spices deep — a shop that feels like walking past the actual counter, not a warehouse aisle.', 'nuvira-shop' ); ?></p>

		<?php if ( $nuvira_hero_categories ) : ?>
			<div class="ns-pills">
				<?php foreach ( $nuvira_hero_categories as $nuvira_hero_cat ) : ?>
					<a class="ns-pill" href="<?php echo esc_url( get_term_link( $nuvira_hero_cat ) ); ?>"><span class="ns-dot"></span><?php echo esc_html( $nuvira_hero_cat->name ); ?></a>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>

		<div style="display:flex;gap:12px;flex-wrap:wrap;">
			<a class="ns-btn ns-btn-accent" href="<?php echo function_exists( 'wc_get_page_permalink' ) ? esc_url( wc_get_page_permalink( 'shop' ) ) : '#'; ?>"><?php esc_html_e( 'Walk the stalls →', 'nuvira-shop' ); ?></a>
			<a class="ns-btn ns-btn-ghost" href="<?php echo esc_url( nuvira_shop_wa_link( __( "Hi! I want to ask about spices before ordering.", 'nuvira-shop' ) ) ); ?>"><?php esc_html_e( 'Ask on WhatsApp', 'nuvira-shop' ); ?></a>
		</div>
	</div>
</section>

<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<section class="ns-section">
	<div class="ns-container">
		<div class="ns-section-head">
			<h2><?php esc_html_e( 'From the counter today', 'nuvira-shop' ); ?></h2>
			<a class="ns-section-link" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'See everything →', 'nuvira-shop' ); ?></a>
		</div>

		<div class="ns-product-grid">
			<?php
			$featured = wc_get_products(
				array(
					'status'  => 'publish',
					'limit'   => 8,
					'orderby' => 'date',
					'order'   => 'DESC',
				)
			);
			foreach ( $featured as $product ) :
				nuvira_shop_product_card( $product );
			endforeach;
			?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
