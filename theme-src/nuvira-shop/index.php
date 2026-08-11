<?php
/**
 * Fallback template — required by WordPress; handles anything without a
 * more specific template (posts, search results, archives).
 *
 * @package NuviraShop
 */
get_header();
?>

<main class="ns-section ns-container">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article style="margin-bottom:2rem;">
				<h2 style="font-family:var(--ns-font-display);font-style:italic;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
				<div><?php the_excerpt(); ?></div>
			</article>
		<?php endwhile; ?>
	<?php else : ?>
		<p>Nothing here yet.</p>
	<?php endif; ?>
</main>

<?php get_footer(); ?>
