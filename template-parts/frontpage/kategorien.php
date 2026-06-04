<?php
/**
 * Startseite – Produkt-Kategorien (WooCommerce [products] Shortcode)
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp = sot_fp();
if ( ! function_exists( 'WC' ) ) { return; }

$count = max( 1, absint( $fp['kat_count'] ) );
$cat   = sanitize_title( $fp['kat_category'] );

$atts = 'columns="4" limit="' . $count . '"';
if ( $cat ) {
    $atts .= ' category="' . esc_attr( $cat ) . '" orderby="menu_order"';
} else {
    $atts .= ' orderby="popularity"';
}
?>
<section class="sot-categories">
    <div class="hgrid">
        <?php if ( ! empty( $fp['kat_heading'] ) ) : ?><h2><?php echo esc_html( $fp['kat_heading'] ); ?></h2><?php endif; ?>
        <?php echo do_shortcode( '[products ' . $atts . ']' ); ?>
    </div>
</section>
