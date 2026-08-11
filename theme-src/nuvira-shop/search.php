<?php
/**
 * Search results — reuses the same shell as front-page.php's sections,
 * with a friendly no-results state.
 *
 * @package NuviraShop
 */
get_header();
?>

<main class="ns-section ns-container">
	<?php if ( have_posts() ) : ?>
		<div class="ns-section-head">
			<h1>
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Search results for "%s"', 'nuvira-shop' ),
					esc_html( get_search_query() )
				);
				?>
			</h1>
		</div>
		<?php while ( have_posts() ) : the_post(); ?>
			<article style="margin-bottom:2rem;">
				<h2 style="font-family:var(--ns-font-display);font-style:italic;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<div class="ns-no-results">
			<h1>
				<?php
				printf(
					/* translators: %s: search query */
					esc_html__( 'Nothing turned up for "%s"', 'nuvira-shop' ),
					esc_html( get_search_query() )
				);
				?>
			</h1>
			<p><?php esc_html_e( 'Try a different word, or head back to the shop.', 'nuvira-shop' ); ?></p>
			<?php if ( function_exists( 'wc_get_page_permalink' ) ) : ?>
				<a class="ns-btn ns-btn-accent" href="<?php echo esc_url( wc_get_page_permalink( 'shop' ) ); ?>"><?php esc_html_e( 'Walk the stalls', 'nuvira-shop' ); ?></a>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
