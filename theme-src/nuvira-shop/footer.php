<?php
/**
 * Footer — collapsible on mobile via native <details>/<summary>, fully
 * open on desktop.
 *
 * @package NuviraShop
 */

?>
<footer class="ns-footer">
	<div class="ns-container">
		<div class="ns-footer-grid">
			<details class="ns-footer-section" open>
				<summary><?php esc_html_e( 'Nuvira Shop', 'nuvira-shop' ); ?></summary>
				<p style="max-width:26em;color:var(--ns-ink-muted);font-size:14px;">
					<?php esc_html_e( 'Ceylon spices and pantry staples, sold the way the market sells them. 27/2E Pieris Avenue, Kalubowila, Dehiwala, Sri Lanka 10350.', 'nuvira-shop' ); ?>
				</p>
			</details>
			<details class="ns-footer-section" open>
				<summary><?php esc_html_e( 'Shop', 'nuvira-shop' ); ?></summary>
				<ul>
					<li><a href="<?php echo function_exists( 'wc_get_page_permalink' ) ? esc_url( wc_get_page_permalink( 'shop' ) ) : '#'; ?>"><?php esc_html_e( 'All products', 'nuvira-shop' ); ?></a></li>
					<li><a href="<?php echo function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '#'; ?>"><?php esc_html_e( 'Cart', 'nuvira-shop' ); ?></a></li>
					<li><a href="<?php echo function_exists( 'wc_get_account_endpoint_url' ) ? esc_url( wc_get_page_permalink( 'myaccount' ) ) : '#'; ?>"><?php esc_html_e( 'My account', 'nuvira-shop' ); ?></a></li>
				</ul>
			</details>
			<details class="ns-footer-section" open>
				<summary><?php esc_html_e( 'Customer care', 'nuvira-shop' ); ?></summary>
				<ul>
					<li><a href="<?php echo esc_url( nuvira_shop_wa_link( __( "Hi! I'd like to ask about an order.", 'nuvira-shop' ) ) ); ?>"><?php esc_html_e( 'WhatsApp', 'nuvira-shop' ); ?></a></li>
					<li><a href="mailto:nuvirahub@gmail.com">nuvirahub@gmail.com</a></li>
				</ul>
			</details>
		</div>
		<div class="ns-footer-bottom">
			<span>
				<?php
				printf(
					/* translators: %s: current year */
					esc_html__( '© %s Nuvirahub (Pvt) Ltd', 'nuvira-shop' ),
					esc_html( gmdate( 'Y' ) )
				);
				?>
			</span>
			<span>
				<?php esc_html_e( 'Part of the Nuvirahub group —', 'nuvira-shop' ); ?>
				<a href="https://nuvirahub.com" style="color:var(--ns-accent);">nuvirahub.com</a>
			</span>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
