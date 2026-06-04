<?php
/**
 * Startseite – Der Weg zum IoT (Schritte)
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$steps = (array) $fp['pr_steps'];
?>
<section class="sot-process">
    <div class="hgrid">
        <?php if ( ! empty( $fp['pr_eyebrow'] ) ) : ?><p class="section-eyebrow"><?php echo esc_html( $fp['pr_eyebrow'] ); ?></p><?php endif; ?>
        <?php if ( ! empty( $fp['pr_heading'] ) ) : ?><h2 class="section-statement"><?php echo esc_html( $fp['pr_heading'] ); ?></h2><?php endif; ?>

        <?php if ( ! empty( $steps ) ) : ?>
            <div class="process-steps">
                <?php foreach ( $steps as $i => $s ) : ?>
                    <div class="step">
                        <div class="step-head">
                            <span class="step-number"><?php echo (int) ( $i + 1 ); ?></span>
                            <?php if ( ! empty( $s['title'] ) ) : ?><span class="step-tag"><?php echo esc_html( $s['title'] ); ?></span><?php endif; ?>
                        </div>
                        <?php if ( ! empty( $s['line1'] ) ) : ?><h3><?php echo esc_html( $s['line1'] ); ?></h3><?php endif; ?>
                        <?php if ( ! empty( $s['line2'] ) ) : ?><p><?php echo esc_html( $s['line2'] ); ?></p><?php endif; ?>
                        <?php if ( ! empty( $s['url'] ) ) : ?><a href="<?php echo esc_url( $s['url'] ); ?>" class="step-link">Mehr erfahren →</a><?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
