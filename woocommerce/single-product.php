<?php
/**
 * The Template for displaying all single products.
 * @version 1.6.4
 */
?>

<?php get_header( 'shop' ); ?>

<?php
// Standard-Breadcrumb im Content deaktivieren – wir zeigen ihn klein oben im Kopf.
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// Template modification Hook
do_action( 'hoot_template_before_content_grid', 'single-product.php' );
?>

<header class="sot-shop-header sot-single-header">
	<div class="hgrid">
		<?php woocommerce_breadcrumb(); ?>
		<h1 class="sot-shop-title"><?php the_title(); ?></h1>
	</div>
</header>

<?php /* Kritisches Single-Product-Layout inline (gewinnt sicher gegen Parent-Theme + Cache) */ ?>
<style id="sot-sp-inline">
.product-hgrid{display:block !important;max-width:1600px !important;margin-left:auto !important;margin-right:auto !important;padding-left:40px !important;padding-right:40px !important;box-sizing:border-box;}
.product-hgrid #content{width:100% !important;max-width:100% !important;float:none !important;margin:0 !important;padding-left:0 !important;padding-right:0 !important;}
.product-hgrid #loop-meta{display:none !important;}
.product-hgrid .sot-sp{display:grid !important;grid-template-columns:minmax(0,2fr) minmax(0,1fr);grid-template-areas:"gallery summary" "below summary";gap:14px 48px;align-items:start;}
.product-hgrid .sot-sp-gallery{grid-area:gallery;}
.product-hgrid .sot-sp-summary{grid-area:summary;}
.product-hgrid .sot-sp-below{grid-area:below;}
.product-hgrid .sot-sp-gallery .woocommerce-product-gallery,
.product-hgrid .sot-sp .woocommerce-product-gallery.images{width:100% !important;float:none !important;margin:0 !important;}
.product-hgrid .summary.sot-sp-summary{width:100% !important;float:none !important;margin:0 !important;}
@media(max-width:900px){.product-hgrid .sot-sp{grid-template-columns:1fr;grid-template-areas:"gallery" "summary" "below";gap:22px;}}
</style>

<div class="hgrid main-content-grid product-hgrid">

	<?php // Sidebar bewusst entfernt – Einzelprodukt nutzt die volle Breite. ?>

	<main <?php hybridextend_attr( 'content' ); ?>>

		<?php
		// Template modification Hook
		do_action( 'hoot_template_main_start', 'single-product.php' );

		/**
		 * woocommerce_before_main_content hook
		 *
		 * removed @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
		?>

		<?php if ( have_posts() ) : ?>

			<?php
			// Dispay Loop Meta in content wrap
			if ( ! hoot_page_header_attop() ) {
				hoot_display_loop_title_content( 'post', 'single-product.php' );
				get_template_part( 'template-parts/loop-meta', 'shop' ); // Loads the template-parts/loop-meta-shop.php template to display Title Area with Meta Info (of the loop)
			}
			?>

			<div id="content-wrap">

				<?php
				// Template modification Hook
				do_action( 'hoot_loop_start', 'single-product.php' );
				?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'single-product' ); ?>

				<?php endwhile; ?>

				<?php
				// Template modification Hook
				do_action( 'hoot_loop_end', 'single-product.php' );
				?>

			</div><!-- #content-wrap -->

			<?php
			// Template modification Hook
			do_action( 'hoot_template_after_content_wrap', 'single-product.php' );
			?>

		<?php else : ?>

			<?php
			// Loads the template-parts/error.php template.
			get_template_part( 'template-parts/error' );
			?>

		<?php endif; ?>

		<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * removed @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );

		// Template modification Hook
		do_action( 'hoot_template_main_end', 'single-product.php' );
		?>

	</main><!-- #content -->

	<?php
	// Template modification Hook
	do_action( 'hoot_template_after_main', 'single-product.php' );
	?>


</div><!-- .hgrid -->

<?php get_footer( 'shop' ); ?>