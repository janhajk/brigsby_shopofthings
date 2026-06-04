<?php
/**
 * Startseite – Technologiepartner-Logos
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$logos = (array) $fp['partner_logos'];
?>
<section class="sot-partners">
    <div class="hgrid">
        <?php if ( ! empty( $fp['partner_eyebrow'] ) ) : ?><p class="section-eyebrow"><?php echo esc_html( $fp['partner_eyebrow'] ); ?></p><?php endif; ?>
        <?php if ( ! empty( $fp['partner_heading'] ) ) : ?><h2 class="section-statement"><?php echo esc_html( $fp['partner_heading'] ); ?></h2><?php endif; ?>

        <?php if ( ! empty( $logos ) ) : ?>
            <div class="partner-logos">
                <?php foreach ( $logos as $logo ) :
                    $id = absint( is_array( $logo ) ? ( $logo['id'] ?? 0 ) : $logo );
                    if ( ! $id ) { continue; }
                    $url = is_array( $logo ) ? ( $logo['url'] ?? '' ) : '';
                    $img = wp_get_attachment_image( $id, 'medium', false, array( 'loading' => 'lazy', 'class' => 'partner-logo', 'alt' => '' ) );
                    echo $url ? '<a class="logo-link" href="' . esc_url( $url ) . '">' . $img . '</a>' : $img;
                endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
