<?php
/**
 * Loop Add to Cart – Override: kompaktes Warenkorb-Icon statt langem Text,
 * mit gestyltem Tooltip (.sot-tip). AJAX/Attribute bleiben erhalten.
 *
 * @package WooCommerce\Templates
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product ) {
    return;
}

$sot_class = ( isset( $class ) ? $class : 'button' ) . ' sot-tip sot-cart-btn';
$sot_qty   = isset( $quantity ) ? $quantity : 1;
$sot_attr  = isset( $attributes ) ? wc_implode_html_attributes( $attributes ) : '';
$sot_tip   = wp_strip_all_tags( $product->add_to_cart_text() );

echo apply_filters(
    'woocommerce_loop_add_to_cart_link',
    sprintf(
        '<a href="%s" data-quantity="%s" class="%s" %s data-tooltip="%s"><i class="fas fa-shopping-cart" aria-hidden="true"></i></a>',
        esc_url( $product->add_to_cart_url() ),
        esc_attr( $sot_qty ),
        esc_attr( $sot_class ),
        $sot_attr,
        esc_attr( $sot_tip )
    ),
    $product,
    isset( $args ) ? $args : array()
);
