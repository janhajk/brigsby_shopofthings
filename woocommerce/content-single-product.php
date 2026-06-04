<?php
/**
 * Single product content – ShopOfThings.
 * Grid-Layout: Galerie oben links, Info-Spalte rechts (über beide Reihen),
 * Beschreibung + Details schliessen unter der Galerie an (kein JS-Hack mehr).
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form(); // WPCS: XSS ok.
	return;
}

// Titel steht oben im Seitenkopf (single-product.php) – im Summary nicht doppelt.
remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( '', $product ); ?>>
	<div class="sot-sp">

		<div class="sot-sp-gallery">
			<?php
			/**
			 * @hooked woocommerce_show_product_sale_flash - 10
			 * @hooked woocommerce_show_product_images - 20
			 */
			do_action( 'woocommerce_before_single_product_summary' );
			?>
		</div>

		<div class="summary entry-summary sot-sp-summary">
			<?php
			/**
			 * @hooked woocommerce_template_single_price / rating / excerpt / add-to-cart / meta …
			 */
			do_action( 'woocommerce_single_product_summary' );
			?>
		</div>

		<div class="sot-sp-below">
			<?php
			/**
			 * @hooked woocommerce_output_product_data_tabs (Beschreibung) - 10
			 * @hooked display_custom_attribute_groups (Details/Specs) - 10
			 */
			do_action( 'woocommerce_after_single_product_summary' );
			?>
		</div>

	</div>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
