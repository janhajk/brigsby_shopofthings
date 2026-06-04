<?php
/**
 * The Template for displaying product archives, including the main
 * shop page which is a post type archive.
 * @version 8.6.0
 */
?>

<?php get_header( 'shop' ); ?>

<?php
// Standard-Breadcrumb im Content deaktivieren – wir zeigen ihn klein oben im Kopf.
remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

// Template modification Hook
do_action( 'hoot_template_before_content_grid', 'archive-product.php' );
?>

<header class="sot-shop-header">
	<div class="hgrid">
		<?php woocommerce_breadcrumb(); ?>
		<h1 class="sot-shop-title"><?php echo wp_kses_post( woocommerce_page_title( false ) ); ?></h1>
		<?php
		$sot_term = ( is_product_category() || is_product_tag() ) ? get_queried_object() : null;
		if ( $sot_term && ! empty( $sot_term->description ) ) {
			echo '<div class="sot-shop-desc">' . wp_kses_post( wpautop( $sot_term->description ) ) . '</div>';
		}
		?>
	</div>
</header>

<div class="hgrid main-content-grid">

	<?php
	/**
	 * woocommerce_sidebar hook
	 *
	 * @hooked woocommerce_get_sidebar - 10
	 */
	do_action( 'woocommerce_sidebar' );

	?>

	<?php
	// Template modification Hook
	do_action( 'hoot_template_before_main', 'archive-product.php' );
	?>

	<main <?php hybridextend_attr( 'content' ); ?>>

		<?php
		// Template modification Hook
		do_action( 'hoot_template_main_start', 'archive-product.php' );

		/**
		 * woocommerce_before_main_content hook
		 *
		 * removed @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );

		if ( ( function_exists( 'woocommerce_product_loop' ) && woocommerce_product_loop() ) || have_posts() ) :
			?>

			<div id="content-wrap">

				<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );

				woocommerce_product_loop_start();

				if ( !function_exists( 'wc_get_loop_prop' ) || wc_get_loop_prop( 'total' ) ) :
					while ( have_posts() ) : the_post();
						do_action( 'woocommerce_shop_loop' );
						wc_get_template_part( 'content', 'product' );
					endwhile;
				endif;

				woocommerce_product_loop_end();

				// Template modification Hook
				do_action( 'hoot_template_before_loop_nav', 'archive-product.php' );

				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
				?>

			</div><!-- #content-wrap -->

		<?php
		else:

			wc_get_template( 'loop/no-products-found.php' );

		endif;

		/**
		 * woocommerce_after_main_content hook
		 *
		 * removed @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );

		// Template modification Hook
		do_action( 'hoot_template_main_end', 'archive-product.php' );
		?>

	</main><!-- #content -->

	<?php
	// Template modification Hook
	do_action( 'hoot_template_after_main', 'archive-product.php' );

	?>

</div><!-- .hgrid -->

<?php get_footer( 'shop' ); ?>