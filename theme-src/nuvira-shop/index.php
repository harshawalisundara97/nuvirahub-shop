<?php
/**
 * Fallback template — required by WordPress; handles anything without a
 * more specific template (posts, search results, archives).
 *
 * @package NuviraShop
 */

get_header();
?>

<main class="ns-section ns-container" id="ns-main-content">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : ?>
			<?php the_post(); ?>
			<article style="margin-bottom:2rem;">
				<h2 style="font-family:var(--ns-font-display);font-weight:800;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p><?php esc_html_e( 'Nothing here yet.', 'nuvira-shop' ); ?></p>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
