<?php
/**
 * Startseite – CTA-Banner
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp  = sot_fp();
$img = ! empty( $fp['cta_image'] ) ? wp_get_attachment_image_url( absint( $fp['cta_image'] ), 'large' ) : '';
?>
<section class="sot-cta">
    <div class="hgrid">
        <div class="cta-box">

            <div class="cta-media">
                <?php if ( $img ) : ?>
                    <img src="<?php echo esc_url( $img ); ?>" alt="" loading="lazy">
                <?php else : ?>
                    <span class="cta-media-placeholder" aria-hidden="true">
                        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="#1D2E7C" stroke-width="1.4"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="M3.27 6.96 12 12.01l8.73-5.05M12 22.08V12"/></svg>
                    </span>
                <?php endif; ?>
                <?php if ( ! empty( $fp['cta_badge'] ) ) : ?><span class="cta-badge"><?php echo esc_html( $fp['cta_badge'] ); ?></span><?php endif; ?>
            </div>

            <div class="cta-content">
                <?php if ( ! empty( $fp['cta_heading'] ) ) : ?><h2><?php echo esc_html( $fp['cta_heading'] ); ?></h2><?php endif; ?>
                <?php if ( ! empty( $fp['cta_text'] ) ) : ?><p class="cta-text"><?php echo esc_html( $fp['cta_text'] ); ?></p><?php endif; ?>

                <div class="cta-buttons">
                    <?php if ( ! empty( $fp['cta_btn1_text'] ) ) : ?><a class="btn btn-cta-primary" href="<?php echo esc_url( $fp['cta_btn1_url'] ); ?>"><?php echo esc_html( $fp['cta_btn1_text'] ); ?></a><?php endif; ?>
                    <?php if ( ! empty( $fp['cta_btn2_text'] ) ) : ?><a class="btn btn-cta-ghost" href="<?php echo esc_url( $fp['cta_btn2_url'] ); ?>"><?php echo esc_html( $fp['cta_btn2_text'] ); ?></a><?php endif; ?>
                </div>

                <?php if ( ! empty( $fp['cta_footnote'] ) ) : ?>
                    <p class="cta-footnote">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M8 12.5l2.5 2.5L16 9"/></svg>
                        <?php echo esc_html( $fp['cta_footnote'] ); ?>
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </div>
</section>
