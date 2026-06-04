<?php
/**
 * Startseite – Kunden-Logos
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$logos = (array) $fp['kunden_logos'];
?>
<section class="sot-customers">
    <div class="hgrid">
        <?php if ( ! empty( $fp['kunden_heading'] ) ) : ?><h2><?php echo esc_html( $fp['kunden_heading'] ); ?></h2><?php endif; ?>

        <?php if ( ! empty( $logos ) ) : ?>
            <div class="customer-logos">
                <?php foreach ( $logos as $logo ) :
                    $id = absint( is_array( $logo ) ? ( $logo['id'] ?? 0 ) : $logo );
                    if ( ! $id ) { continue; }
                    $url = is_array( $logo ) ? ( $logo['url'] ?? '' ) : '';
                    $img = wp_get_attachment_image( $id, 'medium', false, array( 'loading' => 'lazy', 'class' => 'customer-logo', 'alt' => '' ) );
                    echo $url ? '<a class="logo-link" href="' . esc_url( $url ) . '">' . $img . '</a>' : $img;
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
