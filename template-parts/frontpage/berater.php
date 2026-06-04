<?php
/**
 * Startseite – Berater-CTA
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$photo = ! empty( $fp['ber_photo'] ) ? wp_get_attachment_image_url( absint( $fp['ber_photo'] ), 'medium' ) : '';
?>
<section class="sot-berater">
    <div class="hgrid">
        <div class="berater-box">

            <div class="berater-content">
                <?php if ( ! empty( $fp['ber_eyebrow'] ) ) : ?><p class="berater-eyebrow"><?php echo esc_html( $fp['ber_eyebrow'] ); ?></p><?php endif; ?>
                <?php if ( ! empty( $fp['ber_heading'] ) ) : ?><h2><?php echo esc_html( $fp['ber_heading'] ); ?></h2><?php endif; ?>
                <?php if ( ! empty( $fp['ber_btn_text'] ) ) : ?><a class="btn btn-cta-ghost" href="<?php echo esc_url( $fp['ber_btn_url'] ); ?>"><?php echo esc_html( $fp['ber_btn_text'] ); ?></a><?php endif; ?>
            </div>

            <div class="berater-card">
                <div class="berater-photo">
                    <?php if ( $photo ) : ?>
                        <img src="<?php echo esc_url( $photo ); ?>" alt="<?php echo esc_attr( $fp['ber_name'] ); ?>" loading="lazy">
                    <?php else : ?>
                        <span aria-hidden="true">
                            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#9aa6c4" stroke-width="1.5"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 3.6-7 8-7s8 3 8 7"/></svg>
                        </span>
                    <?php endif; ?>
                </div>
                <?php if ( ! empty( $fp['ber_name'] ) ) : ?><div class="berater-name"><?php echo esc_html( $fp['ber_name'] ); ?></div><?php endif; ?>
                <?php if ( ! empty( $fp['ber_role'] ) ) : ?><div class="berater-role"><?php echo esc_html( $fp['ber_role'] ); ?></div><?php endif; ?>
                <?php if ( ! empty( $fp['ber_phone'] ) ) : ?><div class="berater-phone"><a href="tel:<?php echo esc_attr( preg_replace( '/[^0-9+]/', '', $fp['ber_phone'] ) ); ?>"><?php echo esc_html( $fp['ber_phone'] ); ?></a></div><?php endif; ?>
            </div>

        </div>
    </div>
</section>
