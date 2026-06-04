<?php
/**
 * Startseite – Zielgruppen-Karten
 */
if ( ! defined( 'ABSPATH' ) ) { exit; }
$fp    = sot_fp();
$cards = (array) $fp['zg_cards'];
if ( empty( $cards ) ) { return; }
?>
<section class="sot-target-groups">
    <div class="hgrid">
        <?php if ( ! empty( $fp['zg_heading'] ) ) : ?><h2><?php echo esc_html( $fp['zg_heading'] ); ?></h2><?php endif; ?>
        <?php if ( ! empty( $fp['zg_intro'] ) ) : ?><p class="section-intro"><?php echo esc_html( $fp['zg_intro'] ); ?></p><?php endif; ?>

        <div class="target-cards">
            <?php foreach ( $cards as $c ) : ?>
                <div class="card">
                    <?php if ( ! empty( $c['title'] ) ) : ?><h3><?php echo esc_html( $c['title'] ); ?></h3><?php endif; ?>
                    <?php if ( ! empty( $c['text'] ) ) : ?><p><?php echo esc_html( $c['text'] ); ?></p><?php endif; ?>
                    <?php if ( ! empty( $c['link_text'] ) ) : ?><a href="<?php echo esc_url( $c['url'] ); ?>" class="card-link"><?php echo esc_html( $c['link_text'] ); ?></a><?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
