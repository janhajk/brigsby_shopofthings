<?php
/**
 * Startseite – Warum ShopOfThings?
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$items = (array) $fp['why_items'];
if ( empty( $items ) ) { return; }
?>
<section class="sot-why-us">
    <div class="hgrid">
        <?php if ( ! empty( $fp['why_heading'] ) ) : ?><h2><?php echo esc_html( $fp['why_heading'] ); ?></h2><?php endif; ?>

        <div class="why-grid">
            <?php foreach ( $items as $w ) : ?>
                <div class="why-item">
                    <?php if ( ! empty( $w['icon'] ) ) : ?><span class="icon"><?php echo esc_html( $w['icon'] ); ?></span><?php endif; ?>
                    <?php if ( ! empty( $w['title'] ) ) : ?><h3><?php echo esc_html( $w['title'] ); ?></h3><?php endif; ?>
                    <?php if ( ! empty( $w['text'] ) ) : ?><p><?php echo esc_html( $w['text'] ); ?></p><?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
