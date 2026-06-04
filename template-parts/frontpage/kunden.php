<?php
/**
 * Startseite – Kunden-Logos
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$logos = array_filter( array_map( 'absint', (array) $fp['kunden_logos'] ) );
if ( empty( $logos ) ) { return; } // leere Sektion gar nicht ausgeben
?>
<section class="sot-customers">
    <div class="hgrid">
        <?php if ( ! empty( $fp['kunden_heading'] ) ) : ?><h2><?php echo esc_html( $fp['kunden_heading'] ); ?></h2><?php endif; ?>
        <div class="customer-logos">
            <?php foreach ( $logos as $id ) {
                echo wp_get_attachment_image( $id, 'medium', false, array( 'loading' => 'lazy', 'class' => 'customer-logo', 'alt' => '' ) );
            } ?>
        </div>
    </div>
</section>
