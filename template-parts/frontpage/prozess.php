<?php
/**
 * Startseite – Der Weg zum IoT (Schritte)
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$steps = (array) $fp['pr_steps'];
if ( empty( $steps ) ) { return; }
?>
<section class="sot-process">
    <div class="hgrid">
        <?php if ( ! empty( $fp['pr_heading'] ) ) : ?><h2><?php echo esc_html( $fp['pr_heading'] ); ?></h2><?php endif; ?>
        <?php if ( ! empty( $fp['pr_intro'] ) ) : ?><p class="section-intro"><?php echo esc_html( $fp['pr_intro'] ); ?></p><?php endif; ?>

        <div class="process-steps">
            <?php foreach ( $steps as $i => $s ) : ?>
                <div class="step">
                    <div class="step-number"><?php echo (int) ( $i + 1 ); ?></div>
                    <?php if ( ! empty( $s['title'] ) ) : ?><h3><?php echo esc_html( $s['title'] ); ?></h3><?php endif; ?>
                    <?php if ( ! empty( $s['line1'] ) ) : ?><p class="step-lead"><?php echo esc_html( $s['line1'] ); ?></p><?php endif; ?>
                    <?php if ( ! empty( $s['line2'] ) ) : ?><p><?php echo esc_html( $s['line2'] ); ?></p><?php endif; ?>
                    <?php if ( ! empty( $s['url'] ) ) : ?><a href="<?php echo esc_url( $s['url'] ); ?>">Mehr erfahren →</a><?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
