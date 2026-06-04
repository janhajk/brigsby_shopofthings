<?php
/**
 * Startseite – Technologiepartner-Logos
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$logos = array_filter( array_map( 'absint', (array) $fp['partner_logos'] ) );
if ( empty( $logos ) ) { return; } // leere Sektion gar nicht ausgeben
?>
<section class="sot-partners">
    <div class="hgrid">
        <?php if ( ! empty( $fp['partner_heading'] ) ) : ?><h2><?php echo esc_html( $fp['partner_heading'] ); ?></h2><?php endif; ?>
        <div class="partner-logos">
            <?php foreach ( $logos as $id ) {
                echo wp_get_attachment_image( $id, 'medium', false, array( 'loading' => 'lazy', 'class' => 'partner-logo', 'alt' => '' ) );
            } ?>
        </div>
    </div>
</section>
