<?php
/**
 * Default page template — renders full post content (not an excerpt), so
 * WooCommerce's Cart/Checkout/My Account pages (shortcode or block based)
 * and ordinary WordPress Pages render correctly.
 *
 * @package NuviraShop
 */

get_header();
?>

<main class="ns-section ns-container">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<h1 class="woocommerce-products-header__title"><?php the_title(); ?></h1>
		<?php the_content(); ?>
	<?php endwhile; ?>
</main>

<?php get_footer(); ?>
