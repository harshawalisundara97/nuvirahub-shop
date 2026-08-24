<?php
/**
 * 404 — on-brand, points back to the shop rather than a bare WP default.
 *
 * @package NuviraShop
 */

get_header();
?>

<main class="ns-container" id="ns-main-content">
	<div class="ns-404">
		<p class="ns-404-eyebrow"><?php esc_html_e( '404', 'nuvira-shop' ); ?></p>
		<h1><?php esc_html_e( "That page isn't on the shelf", 'nuvira-shop' ); ?></h1>
		<p><?php esc_html_e( "The page you're looking for doesn't exist, or it's moved. Try the shop, or search for what you need.", 'nuvira-shop' ); ?></p>
		<div style="display:flex;gap:12px;flex-wrap:wrap;justify-content:center;">
			<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
				<a class="ns-btn ns-btn-accent" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Walk the stalls →', 'nuvira-shop' ); ?></a>
			<?php endif; ?>
			<a class="ns-btn ns-btn-ghost" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'nuvira-shop' ); ?></a>
		</div>
	</div>
</main>

<?php get_footer(); ?>
