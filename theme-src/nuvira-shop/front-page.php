<?php
/**
 * Homepage — Bazaar Night hero + featured spice pills + product teaser.
 *
 * @package NuviraShop
 */
get_header();
?>

<section class="ns-hero">
	<div class="ns-glow"></div>
	<div class="ns-hero-inner">
		<p class="ns-eyebrow">Open air, Dehiwala</p>
		<h1>Buy it the way the market sells it</h1>
		<p class="ns-lede">Loud stalls, warm light, five spices deep — a shop that feels like walking past the actual counter, not a warehouse aisle.</p>

		<div class="ns-pills">
			<span class="ns-pill ns-c-cinnamon"><span class="ns-dot"></span>Cinnamon</span>
			<span class="ns-pill ns-c-chilli"><span class="ns-dot"></span>Chilli</span>
			<span class="ns-pill ns-c-cardamom"><span class="ns-dot"></span>Cardamom</span>
			<span class="ns-pill ns-c-curryleaf"><span class="ns-dot"></span>Curry leaf</span>
		</div>

		<div style="display:flex;gap:12px;flex-wrap:wrap;">
			<a class="ns-btn ns-btn-accent" href="<?php echo function_exists( 'wc_get_page_permalink' ) ? esc_url( wc_get_page_permalink( 'shop' ) ) : '#'; ?>">Walk the stalls →</a>
			<a class="ns-btn ns-btn-ghost" href="<?php echo esc_url( nuvira_shop_wa_link( 'Hi! I want to ask about spices before ordering.' ) ); ?>">Ask on WhatsApp</a>
		</div>
	</div>
</section>

<?php if ( class_exists( 'WooCommerce' ) ) : ?>
<section class="ns-section">
	<div class="ns-container">
		<div class="ns-section-head">
			<h2>From the counter today</h2>
			<a class="ns-section-link" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>">See everything →</a>
		</div>

		<div class="ns-product-grid">
			<?php
			$featured = wc_get_products( array(
				'status' => 'publish',
				'limit'  => 8,
				'orderby' => 'date',
				'order'   => 'DESC',
			) );
			foreach ( $featured as $product ) :
				?>
				<a class="ns-product-card" href="<?php echo esc_url( $product->get_permalink() ); ?>">
					<div class="ns-product-media">
						<?php echo $product->get_image(); ?>
					</div>
					<div class="ns-product-body">
						<div class="ns-product-title"><?php echo esc_html( $product->get_name() ); ?></div>
						<div class="ns-product-foot">
							<span class="ns-product-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
						</div>
					</div>
				</a>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php get_footer(); ?>
