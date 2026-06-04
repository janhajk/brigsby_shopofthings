<?php
/**
 * Startseite – Zahlen / Statistiken (blaue Box)
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$items = (array) $fp['stats_items'];
if ( empty( $items ) ) { return; }
?>
<section class="sot-stats">
    <div class="hgrid">
        <div class="stats-box">
            <?php if ( ! empty( $fp['stats_heading'] ) ) : ?><h2><?php echo esc_html( $fp['stats_heading'] ); ?></h2><?php endif; ?>
            <div class="stats-grid">
                <?php foreach ( $items as $s ) : ?>
                    <div class="stat">
                        <span class="number"><?php echo esc_html( $s['number'] ?? '' ); ?></span>
                        <p><?php echo esc_html( $s['label'] ?? '' ); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
