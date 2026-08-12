<?php
/**
 * Footer.
 *
 * @package NuviraShop
 */

?>
<footer class="ns-footer">
	<div class="ns-container">
		<div class="ns-footer-grid">
			<div>
				<h3>Nuvira Shop</h3>
				<p style="max-width:26em;color:var(--ns-ink-muted);font-size:14px;">
					Ceylon spices and pantry staples, sold the way the market sells them.
					27/2E Pieris Avenue, Kalubowila, Dehiwala, Sri Lanka 10350.
				</p>
			</div>
			<div>
				<h3>Shop</h3>
				<ul>
					<li><a href="<?php echo function_exists( 'wc_get_page_permalink' ) ? esc_url( wc_get_page_permalink( 'shop' ) ) : '#'; ?>">All products</a></li>
					<li><a href="<?php echo function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '#'; ?>">Cart</a></li>
					<li><a href="<?php echo function_exists( 'wc_get_account_endpoint_url' ) ? esc_url( wc_get_page_permalink( 'myaccount' ) ) : '#'; ?>">My account</a></li>
				</ul>
			</div>
			<div>
				<h3>Talk to us</h3>
				<ul>
					<li><a href="<?php echo esc_url( nuvira_shop_wa_link( "Hi! I'd like to ask about an order." ) ); ?>">WhatsApp</a></li>
					<li><a href="mailto:nuvirahub@gmail.com">nuvirahub@gmail.com</a></li>
				</ul>
			</div>
		</div>
		<div class="ns-footer-bottom">
			<span>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> Nuvirahub (Pvt) Ltd</span>
			<span>Part of the Nuvirahub group — <a href="https://nuvirahub.com" style="color:var(--ns-accent);">nuvirahub.com</a></span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
